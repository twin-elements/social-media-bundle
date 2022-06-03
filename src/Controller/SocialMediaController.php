<?php

namespace TwinElements\SocialMediaBundle\Controller;

use TwinElements\AdminBundle\Model\CrudControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use TwinElements\Component\ResponseParameterBuilder\ResponseParameterBuilder;
use TwinElements\SocialMediaBundle\Entity\SocialMedia;
use TwinElements\SocialMediaBundle\Form\SocialMediaType;
use TwinElements\SocialMediaBundle\Security\SocialMediaVoter;
use TwinElements\SortableBundle\SortableResponseParametersPreparer;

/**
 * @Route("socialmedia")
 */
class SocialMediaController extends AbstractController
{

    use CrudControllerTrait;

    /**
     * @Route("/", name="socialmedia_index", methods={"GET"})
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted(SocialMediaVoter::VIEW, new SocialMedia());

        $em = $this->getDoctrine()->getManager();

        $socialMedia = $em->getRepository(SocialMedia::class)->findBy([], ['position' => 'asc']);

        $this->breadcrumbs->setItems([
            'social_media.social_media' => null
        ]);

        $responseParameters = new ResponseParameterBuilder();
        $responseParameters->addParameter('socialMedia', $socialMedia);

        SortableResponseParametersPreparer::prepare($responseParameters, SocialMedia::class);

        return $this->render('@TwinElementsSocialMedia/index.html.twig', $responseParameters->getParameters());
    }

    /**
     * @Route("/new", name="socialmedia_new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $socialMedia = new Socialmedia();
        $this->denyAccessUnlessGranted(SocialMediaVoter::FULL, $socialMedia);

        $form = $this->createForm(SocialMediaType::class, $socialMedia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($socialMedia);
                $em->flush();

                $this->flashes->successMessage($this->adminTranslator->translate('admin.success_operation'));;
                $this->crudLogger->createLog($socialMedia->getId(), $socialMedia->getTitle());

            } catch (\Exception $exception) {
                $this->flashes->errorMessage($exception->getMessage());
                return $this->redirectToRoute('socialmedia_index');
            }

            if ('save' === $form->getClickedButton()->getName()) {
                return $this->redirectToRoute('socialmedia_edit', array('id' => $socialMedia->getId()));
            } else {
                return $this->redirectToRoute('socialmedia_index');
            }
        }

        $this->breadcrumbs->setItems([
            'social_media.social_media' => $this->generateUrl('socialmedia_index'),
            'social_media.add_new_sm_link' => null
        ]);

        return $this->render('@TwinElementsSocialMedia/new.html.twig', array(
            'socialMedia' => $socialMedia,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="socialmedia_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, SocialMedia $socialMedia)
    {
        $this->denyAccessUnlessGranted(SocialMediaVoter::EDIT, $socialMedia);

        $deleteForm = $this->createDeleteForm($socialMedia);
        $editForm = $this->createForm(SocialMediaType::class, $socialMedia);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            try {
                $this->getDoctrine()->getManager()->flush();
                $this->flashes->successMessage($this->adminTranslator->translate('admin.success_operation'));;
                $this->crudLogger->createLog($socialMedia->getId(), $socialMedia->getTitle());

            } catch (\Exception $exception) {
                $this->flashes->errorMessage($exception->getMessage());
            }

            if ('save' === $editForm->getClickedButton()->getName()) {
                return $this->redirectToRoute('socialmedia_edit', array('id' => $socialMedia->getId()));
            } else {
                return $this->redirectToRoute('socialmedia_index');
            }
        }

        $this->breadcrumbs->setItems([
            'social_media.social_media' => $this->generateUrl('socialmedia_index'),
            $socialMedia->getTitle() => null
        ]);

        return $this->render('@TwinElementsSocialMedia/edit.html.twig', array(
            'entity' => $socialMedia,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="socialmedia_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, SocialMedia $socialMedia)
    {
        $this->denyAccessUnlessGranted(SocialMediaVoter::FULL, $socialMedia);

        $form = $this->createDeleteForm($socialMedia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $id = $socialMedia->getId();
                $title = $socialMedia->getTitle();
                $em = $this->getDoctrine()->getManager();
                $em->remove($socialMedia);
                $em->flush();

                $this->crudLogger->createLog($id, $title);
                $this->flashes->successMessage($this->adminTranslator->translate('admin.success_operation'));;

            } catch (\Exception $exception) {
                $this->flashes->errorMessage($exception->getMessage());
            }
        }

        return $this->redirectToRoute('socialmedia_index');
    }

    /**
     * @param SocialMedia $socialMedia The socialMedia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SocialMedia $socialMedia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('socialmedia_delete', array('id' => $socialMedia->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}

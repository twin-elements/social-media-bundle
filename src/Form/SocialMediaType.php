<?php

namespace TwinElements\SocialMediaBundle\Form;

use TwinElements\Component\AdminTranslator\AdminTranslator;
use TwinElements\SocialMediaBundle\Entity\SocialMedia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TwinElements\FormExtensions\Type\SaveButtonsType;
use TwinElements\FormExtensions\Type\ToggleChoiceType;

class SocialMediaType extends AbstractType
{
    /**
     * @var AdminTranslator
     */
    private $translator;

    public function __construct(AdminTranslator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => $this->translator->translate('social_media.name'),
            ])
            ->add('link', TextType::class, [
                'label' => $this->translator->translate('social_media.url'),
            ])
            ->add('className', TextType::class, [
                'label' => $this->translator->translate('social_media.css_classname'),
            ])
            ->add('enable', ToggleChoiceType::class)
            ->add('buttons', SaveButtonsType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => SocialMedia::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_adminbundle_socialmedia';
    }


}

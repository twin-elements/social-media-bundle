<?php

namespace TwinElements\SocialMediaBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use TwinElements\AdminBundle\Entity\AdminUser;
use TwinElements\AdminBundle\Role\AdminUserRole;
use TwinElements\SocialMediaBundle\Entity\SocialMedia;

class SocialMediaVoter extends Voter
{
    const FULL = 'full';
    const VIEW = 'view';
    const EDIT = 'edit';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        return in_array($attribute, [self::FULL, self::VIEW, self::EDIT]) && $subject instanceof SocialMedia;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof AdminUser) {
            return false;
        }

        switch ($attribute) {
            case self::FULL;
                return $this->isFull();

            case self::EDIT;
                return $this->canEdit();

            case self::VIEW;
                return $this->canView();
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function isFull()
    {
        if ($this->security->isGranted(AdminUserRole::ROLE_ADMIN)) {
            return true;
        }

        if ($this->security->isGranted(SocialMediaRoles::ROLE_SOCIAL_MEDIA_FULL)) {
            return true;
        }
    }

    private function canEdit()
    {
        if ($this->isFull()) {
            return true;
        }

        if ($this->security->isGranted(SocialMediaRoles::ROLE_SOCIAL_MEDIA_EDIT)) {
            return true;
        }
    }

    private function canView()
    {
        if ($this->canEdit()) {
            return true;
        }

        if ($this->security->isGranted(SocialMediaRoles::ROLE_SOCIAL_MEDIA_VIEW)) {
            return true;
        }
    }
}

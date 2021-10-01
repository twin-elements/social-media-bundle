<?php

namespace TwinElements\SocialMediaBundle\Security;

use TwinElements\AdminBundle\Role\RoleGroupInterface;

final class SocialMediaRoles implements RoleGroupInterface
{
    const ROLE_SOCIAL_MEDIA_FULL = 'ROLE_SOCIAL_MEDIA_FULL';
    const ROLE_SOCIAL_MEDIA_EDIT = 'ROLE_SOCIAL_MEDIA_EDIT';
    const ROLE_SOCIAL_MEDIA_VIEW = 'ROLE_SOCIAL_MEDIA_VIEW';

    public static function getRoles(): array
    {
        return [self::ROLE_SOCIAL_MEDIA_FULL, self::ROLE_SOCIAL_MEDIA_EDIT, self::ROLE_SOCIAL_MEDIA_VIEW];
    }
}

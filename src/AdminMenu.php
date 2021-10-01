<?php

namespace TwinElements\SocialMediaBundle;

use TwinElements\AdminBundle\Menu\AdminMenuInterface;
use TwinElements\AdminBundle\Menu\MenuItem;

class AdminMenu implements AdminMenuInterface
{
    public function getItems()
    {
        return [
            MenuItem::newInstance('social_media.social_media', 'socialmedia_index', [], 25),
        ];
    }
}

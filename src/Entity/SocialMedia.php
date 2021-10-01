<?php

namespace TwinElements\SocialMediaBundle\Entity;

use TwinElements\AdminBundle\Entity\Traits\EnableInterface;
use TwinElements\AdminBundle\Entity\Traits\EnableTrait;
use TwinElements\AdminBundle\Entity\Traits\IdTrait;
use TwinElements\AdminBundle\Entity\Traits\PositionInterface;
use TwinElements\AdminBundle\Entity\Traits\PositionTrait;
use TwinElements\AdminBundle\Entity\Traits\TitleInterface;
use TwinElements\AdminBundle\Entity\Traits\TitleTrait;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\BlameableInterface;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Blameable\BlameableTrait;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

/**
 * @ORM\Table(name="social_media")
 * @ORM\Entity(repositoryClass="TwinElements\SocialMediaBundle\Repository\SocialMediaRepository")
 */
class SocialMedia implements TitleInterface, EnableInterface, PositionInterface, BlameableInterface, TimestampableInterface
{
    use
        IdTrait,
        TitleTrait,
        TimestampableTrait,
        BlameableTrait,
        PositionTrait,
        EnableTrait;


    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, unique=true)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="className", type="string", length=20, nullable=true, unique=true)
     */
    private $className;

    /**
     * Set link
     *
     * @param string $link
     *
     * @return SocialMedia
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set className
     *
     * @param string $className
     *
     * @return SocialMedia
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * Get className
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }
}

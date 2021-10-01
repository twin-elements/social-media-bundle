<?php

namespace TwinElements\SocialMediaBundle\Repository;

use TwinElements\SocialMediaBundle\Entity\SocialMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

class SocialMediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocialMedia::class);
    }

    /**
     * @return SocialMedia[]
     */
    public function findAll()
    {
        $qb = $this->createQueryBuilder('sm');
        $qb
            ->where('sm.enable = :enable')
            ->andWhere(
                $qb->expr()->isNotNull('sm.link')
            )
            ->setParameter('enable', true)
            ->orderBy('sm.position', 'asc');

        return $qb->getQuery()->getResult();
    }
}

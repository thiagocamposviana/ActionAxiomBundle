<?php

namespace Mugo\ActionAxiomBundle\Repository;

use Mugo\ActionAxiomBundle\Entity\MugoWordSynonym;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MugoWordSynonym|null find($id, $lockMode = null, $lockVersion = null)
 * @method MugoWordSynonym|null findOneBy(array $criteria, array $orderBy = null)
 * @method MugoWordSynonym[]    findAll()
 * @method MugoWordSynonym[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MugoWordSynonymRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MugoWordSynonym::class);
    }

    // /**
    //  * @return MugoWordSynonym[] Returns an array of MugoWordSynonym objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MugoWordSynonym
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

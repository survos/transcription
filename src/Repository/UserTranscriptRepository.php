<?php

namespace App\Repository;

use App\Entity\UserTranscript;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserTranscript|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserTranscript|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserTranscript[]    findAll()
 * @method UserTranscript[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTranscriptRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserTranscript::class);
    }

    // /**
    //  * @return UserTranscript[] Returns an array of UserTranscript objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserTranscript
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

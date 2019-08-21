<?php

namespace App\Repository;

use App\Entity\Transcript;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Transcript|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transcript|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transcript[]    findAll()
 * @method Transcript[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranscriptRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Transcript::class);
    }

    // /**
    //  * @return Transcript[] Returns an array of Transcript objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Transcript
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

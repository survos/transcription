<?php


namespace App\Services;


use Doctrine\ORM\EntityManagerInterface;

class AppService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



}
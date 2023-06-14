<?php

namespace App\Repository;

use App\Entity\AdminDashboard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class AdminDashboardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, AdminDashboard::class);
    }

    public function getDashboardData(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('COUNT(g.id) as grapes')
            ->from('App\Entity\GrapeVariety', 'g')
            ->getQuery()
            ->getOneOrNullResult();
    }
}

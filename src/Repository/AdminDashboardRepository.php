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

    public function getDashboardCountData(): array
    {
        $grapes = $this->entityManager->createQueryBuilder()
            ->select('COUNT(g.id) as grapes')
            ->from('App\Entity\GrapeVariety', 'g')
            ->getQuery()
            ->getOneOrNullResult();

        $wines = $this->entityManager->createQueryBuilder()
            ->select('COUNT(w.id) as wines')
            ->from('App\Entity\Wine', 'w')
            ->getQuery()
            ->getOneOrNullResult();

        $sessions = $this->entityManager->createQueryBuilder()
            ->select('COUNT(s.id) as sessions')
            ->from('App\Entity\Session', 's')
            ->getQuery()
            ->getOneOrNullResult();

        $users = $this->entityManager->createQueryBuilder()
            ->select('COUNT(u.id) as users')
            ->from('App\Entity\User', 'u')
            ->getQuery()
            ->getOneOrNullResult();

        return array_merge($grapes, $users, $wines, $sessions);
    }
}

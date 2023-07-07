<?php

namespace App\Repository;

use App\Entity\Wine;
use App\Search\SearchWineData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wine>
 *
 * @method Wine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wine[]    findAll()
 * @method Wine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wine::class);
    }

    public function save(Wine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Wine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getCount(): int
    {
        return $this->createQueryBuilder('w')
            ->select('COUNT(w.id) as wines')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findSearch(SearchWineData $searchWineData, array $orders = []): array
    {
        $query = $this->createQueryBuilder('w')
            ->select('w')
            ->andWhere('w.enabled = 1');

        if (!empty($searchWineData->getName())) {
            $query = $query
                ->andWhere('w.name LIKE :name')
                ->setParameter('name', "%{$searchWineData->getName()}%");
        }

        if (!empty($searchWineData->getMinPrice())) {
            $query = $query
                ->andWhere('w.price >= :min')
                ->setParameter('min', $searchWineData->getMinPrice());
        }

        if (!empty($searchWineData->getMaxPrice())) {
            $query = $query
                ->andWhere('w.price <= :max')
                ->setParameter('max', $searchWineData->getMaxPrice());
        }

        if (count($searchWineData->getGrapeVarieties()) > 0) {
            $query = $query
                ->andWhere('w.grapeVariety IN (:grapevarieties)')
                ->setParameter('grapevarieties', $searchWineData->getGrapeVarieties());
        }
        if (!empty($orders)) {
            foreach ($orders as $column => $direction) {
                $query = $query
                    ->addOrderBy("w." . trim($column), strtoupper($direction));
            }
        }

        return $query->getQuery()->getResult();
    }

    //    /**
    //     * @return Wine[] Returns an array of Wine objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Wine
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

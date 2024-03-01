<?php

namespace App\Repository;

use App\Entity\PeriodNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PeriodNotification>
 *
 * @method PeriodNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method PeriodNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method PeriodNotification[]    findAll()
 * @method PeriodNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeriodNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PeriodNotification::class);
    }

//    /**
//     * @return PeriodNotification[] Returns an array of PeriodNotification objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PeriodNotification
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

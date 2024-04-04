<?php

namespace App\Repository;

use App\Entity\Notification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notification>
 *
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

//    /**
//     * @return Notification[] Returns an array of Notification objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Notification
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function save(Notification $notification, bool $flush = false)
    {
        $this->getEntityManager()->persist($notification);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function remove(Notification $notification, bool $flush = false): void
    {
        $this->getEntityManager()->remove($notification);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByType(string $type): array
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.type = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult();
    }

    public function findByTypeAndToVals(string $type, array $toVals): array
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.type = :type')
            ->andWhere('n.to_val IN (:toVals)')
            ->setParameter('type', $type)
            ->setParameter('toVals', $toVals)
            ->getQuery()
            ->getResult();
    }

    public function findByReadStatus(bool $isReaded): array
    {
        return $this->createQueryBuilder('n')
            ->where('n.isReaded = :isReaded')
            ->setParameter('isReaded', $isReaded ? 1 : 0)
            ->getQuery()
            ->getResult();
    }

    public function findByReadStatusAndToVal(bool $isReaded, array $toVals): array
    {
        $queryBuilder = $this->createQueryBuilder('n')
            ->andWhere('n.isReaded = :isReaded')
            ->setParameter('isReaded', $isReaded ? 1 : 0);

        if (!empty($toVals)) {
            $queryBuilder
                ->andWhere('n.to_val IN (:toVals)')
                ->setParameter('toVals', $toVals);
        }

        return $queryBuilder->getQuery()->getResult();
    }

}

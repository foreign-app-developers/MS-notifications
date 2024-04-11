<?php

namespace App\Repository;

use App\Entity\UserRequisite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserRequisite>
 *
 * @method UserRequisite|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserRequisite|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserRequisite[]    findAll()
 * @method UserRequisite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRequisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserRequisite::class);
    }
    public function save(UserRequisite $notification, bool $flush = false)
    {
        $this->getEntityManager()->persist($notification);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UserRequisite[] Returns an array of UserRequisite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserRequisite
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

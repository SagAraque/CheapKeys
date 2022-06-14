<?php

namespace App\Repository;

use App\Entity\Orders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Orders>
 *
 * @method Orders|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orders|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orders[]    findAll()
 * @method Orders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orders::class);
    }

    public function add(Orders $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Orders $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllByUser($id)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT o FROM App\Entity\Orders o
             WHERE o.idUser = :id
            '
        )->setParameter('id', $id);

        return $sql;
    }

    public function checkUserGamesSold($id_game, $id_platform, $id_user)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT o FROM App\Entity\Orders o
            JOIN App\Entity\CartProducts cp
            WHERE o.idCart = cp.idCart
            AND o.idUser = :idUser
            AND cp.idPlatform = :idPlatform
            AND cp.idGame = :idGame'
        )->setParameter('idUser', $id_user)
        ->setParameter('idPlatform', $id_platform)
        ->setParameter('idGame', $id_game);

        return $sql->getOneOrNullResult();
    }

//    /**
//     * @return Orders[] Returns an array of Orders objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Orders
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

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
    
    public function getTotalOrders()
    {
        $em = $this -> getEntityManager();
        
        $sql = $em->createQuery('SELECT COUNT(o.idOrder) FROM App\Entity\Orders o');

        return $sql->getArrayResult();
    }

    public function getTotalOrdersSum()
    {
        $em = $this -> getEntityManager();
        
        $sql = $em->createQuery('SELECT SUM(o.orderTotal) FROM App\Entity\Orders o');

        return $sql->getArrayResult();
    }

    public function allOrdersNoQuery()
    {
        $em = $this -> getEntityManager();

        return $em -> createQuery('SELECT o FROM App\Entity\Orders o');
    }
}

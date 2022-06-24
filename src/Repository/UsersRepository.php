<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Users>
 *
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    public function add(Users $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Users $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTotalUsers()
    {
        $em = $this -> getEntityManager();
        
        $sql = $em->createQuery('SELECT COUNT(u.idUser) FROM App\Entity\Users u');

        return $sql->getArrayResult();
    }

    public function allUsersNoQuery($searchValue)
    {
        $em = $this -> getEntityManager();

        $sql = $em -> createQuery(
            'SELECT u FROM App\Entity\Users u
            WHERE u.userName like :name
            OR u.idUser like :id'
        )->setParameter('name', '%'.$searchValue.'%')
        ->setParameter('id', '%'.$searchValue.'%');

        return $sql;
    }

    public function searchUsers($searchValue)
    {
        $em = $this -> getEntityManager();

        $sql = $em -> createQuery(
            'SELECT u FROM App\Entity\Users u
            WHERE u.userName like :name
            OR u.idUser like :id'
        )->setParameter('name', '%'.$searchValue.'%')
        ->setParameter('id', '%'.$searchValue.'%');

        return $sql;
    }


}

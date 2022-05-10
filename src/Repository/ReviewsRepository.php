<?php

namespace App\Repository;

use App\Entity\Reviews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reviews>
 *
 * @method Reviews|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reviews|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reviews[]    findAll()
 * @method Reviews[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reviews::class);
    }

    public function add(Reviews $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reviews $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByGame($id_game)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT r FROM App\Entity\Reviews r
             WHERE r.idGame = :value'
        )->setParameter('value', $id_game);

        return $sql->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function findByGameNoResults($id_game)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT r FROM App\Entity\Reviews r
             WHERE r.idGame = :value'
        )->setParameter('value', $id_game);

        return $sql;
    }
}

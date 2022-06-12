<?php

namespace App\Repository;

use App\Entity\Reviews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;
use Doctrine\ORM\Configuration;
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
        
        $cache = new PhpFilesAdapter('doctrine_queries');
        $config = new Configuration();
        $config -> setQueryCache($cache);
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
        return $this->findByGame($id_game) -> getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
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

    public function findNoResults($user)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT r FROM App\Entity\Reviews r
             WHERE r.idUser = :value'
        )->setParameter('value', $user);

        return $sql;
    }

    public function checkUserReview($id_game, $id_platform, $id_user)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT r FROM App\Entity\Reviews r
            JOIN App\Entity\Orders o
            JOIN App\Entity\GameKeys gk
            WHERE o.idOrder = gk.idOrder 
            AND r.idUser = :idUser
            AND r.idPlatform = gk.idPlatform
            AND r.idGame = gk.idGame
            AND o.idUser = :idUser
            AND gk.idPlatform = :idPlatform
            AND gk.idGame = :idGame'
        )->setParameter('idUser', $id_user)
        ->setParameter('idPlatform', $id_platform)
        ->setParameter('idGame', $id_game);

        return $sql->getOneOrNullResult();
    }

    public function getAvgByGame($id_game, $id_platform)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT AVG(r.reviewCalification) FROM App\Entity\Reviews r
            WHERE r.idGame = :idGame
            AND r.idPlatform = :idPlatform 
            '
        )->setParameter('idPlatform', $id_platform)
        ->setParameter('idGame', $id_game);

        return $sql->getSingleColumnResult();
    }
}

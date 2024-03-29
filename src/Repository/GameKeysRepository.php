<?php

namespace App\Repository;

use App\Entity\GameKeys;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GameKeys>
 *
 * @method GameKeys|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameKeys|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameKeys[]    findAll()
 * @method GameKeys[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameKeysRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameKeys::class);
    }

    public function add(GameKeys $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GameKeys $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getKeysBySlug($slug, $order)
    {
        $platform = substr($slug, strripos($slug, '_') + 1);
        $gameSlug = substr($slug, 0, strripos($slug, '_'));

        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT gk FROM App\Entity\GameKeys gk
            JOIN App\Entity\Platforms p
            JOIN App\Entity\Games g
            WHERE p.platformName = :pName
            AND g.gameSlug = :gName
            AND gk.idOrder = :order
            AND g.idGame = gk.idGame
            AND p.idPlatform = gk.idPlatform'
        )->setParameter('gName', $gameSlug)
        ->setParameter('pName', $platform)
        ->setParameter('order', $order);

        return $sql->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

//    /**
//     * @return GameKeys[] Returns an array of GameKeys objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GameKeys
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

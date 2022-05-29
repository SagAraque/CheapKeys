<?php

namespace App\Repository;

use App\Entity\MediaGames;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MediaGames>
 *
 * @method MediaGames|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediaGames|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediaGames[]    findAll()
 * @method MediaGames[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaGamesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediaGames::class);
    }

    public function add(MediaGames $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MediaGames $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOnePerGame($game, $platform)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT mg FROM App\Entity\Media m
            JOIN App\Entity\MediaGames mg
             WHERE m.idMedia = mg.idMedia
             AND mg.idGame in (:game)
             AND mg.idPlatform in (:platform)
             AND m.mediaInfoimg = 0
            GROUP BY mg.idPlatform, mg.idGame'
        )->setParameter('game', $game, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY)
        ->setParameter('platform', $platform, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);

        return $sql->getResult();
    }

    public function findOneByInfo($game, $platform)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT m FROM App\Entity\Media m
            JOIN App\Entity\MediaGames mg
             WHERE m.idMedia = mg.idMedia
             AND mg.idGame  = :game
             AND mg.idPlatform = :platform
             AND m.mediaInfoimg = 1'
        )->setParameter('game', $game)
        ->setParameter('platform', $platform);

        return $sql->getSingleResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function findNoInfo($game, $platform)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT mg FROM App\Entity\Media m
            JOIN App\Entity\MediaGames mg
             WHERE m.idMedia = mg.idMedia
             AND mg.idGame  = :game
             AND mg.idPlatform = :platform
             AND m.mediaInfoimg = 0'
        )->setParameter('game', $game)
        ->setParameter('platform', $platform);

        return $sql->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

//    /**
//     * @return MediaGames[] Returns an array of MediaGames objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MediaGames
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\GamesPlatform;
use App\Entity\Platforms;
use App\Entity\Features;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GamesPlatform>
 *
 * @method GamesPlatform|null find($id, $lockMode = null, $lockVersion = null)
 * @method GamesPlatform|null findOneBy(array $criteria, array $orderBy = null)
 * @method GamesPlatform[]    findAll()
 * @method GamesPlatform[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GamesPlatformRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GamesPlatform::class);
    }

    public function add(GamesPlatform $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GamesPlatform $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findFeature($game, $platform)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT f FROM App\Entity\GamesPlatform f
            WHERE f.game = :game
            AND f.idPlatform = :platform'
        )->setParameter('platform', $platform)
        ->setParameter('game', $game);

        return $sql->getSingleResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function getPlatforms()
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT p.platformName as platform, COUNT(DISTINCT gp.idPlatform) as total, IDENTITY(gp.idPlatform)
            FROM App\Entity\GamesPlatform gp
            JOIN App\Entity\Platforms p
            WHERE p.idPlatform = gp.idPlatform
            GROUP BY gp.idPlatform'
        );

        return $sql->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function findAllNoQueryByPlatform($platform)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQueryBuilder()
        ->select('g')
        ->from(GamesPlatform::class, 'g');

        if($platform == 'pc'){
            $sql->innerJoin(Platforms::class, 'p')
            ->where('g.idPlatform = p.idPlatform')
            ->andWhere("p.platformName NOT IN ('playstation', 'xbox', 'switch')");
        }elseif($platform != 'all' && $platform != 'ofertas'){
            $sql->innerJoin(Platforms::class, 'p')
            ->where('g.idPlatform = p.idPlatform')
            ->andWhere('p.platformName = :platform')
            ->setParameter('platform', $platform);
        }elseif($platform == 'ofertas' ){
            $sql->innerJoin(Features::class, 'f')
            ->where('g.idFeature = f.idFeature')
            ->andWhere('f.gameDiscount > 0');
        }

        return $sql;
    }

    public function findByFeatureNoQuery($params, $order)
    {
        $index = 0;
        $em = $this->getEntityManager();
        
        $sql = $em->createQueryBuilder()
        ->select('p')
        ->from(GamesPlatform::class, 'p')
        ->join(Features::class, 'f')
        ->where('p.idFeature = f.idFeature');

        foreach ($params as $key => $value) {
            $index++;
            if(count(array_filter($value)) != 0){
                $sql -> andWhere('p.'.$key.' in (:field'.$index.')')
                ->setParameter('field'.$index, $value, \Doctrine\DBAL\Connection::PARAM_INT_ARRAY);
            }
        }

        if($order == 'lowPrice') $sql->orderBy('f.gamePrice', 'ASC');
        if($order == 'highPrice') $sql->orderBy('f.gamePrice', 'DESC');
        if($order == 'lowValoration') $sql->orderBy('f.gameValoration', 'ASC');
        if($order == 'highValoration') $sql->orderBy('f.gameValoration', 'DESC');

        return $sql;
    }

    public function findByWord($word)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT gp 
            FROM App\Entity\GamesPlatform gp
            JOIN App\Entity\Games g
            WHERE gp.game = g.idGame
            AND g.gameName LIKE :word'
        )
        ->setParameter('word', '%'.$word.'%')
        ->setMaxResults(6);

        return $sql->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function findAllWishNoQuery($id)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT gp FROM App\Entity\GamesPlatform gp
             JOIN App\Entity\WishlistGames w
             WHERE w.idWishlist = :wishlist
             AND gp.game = w.idGame
             AND gp.idPlatform = w.idPlatform
             '
        )->setParameter('wishlist', $id);

        return $sql;
    }
}

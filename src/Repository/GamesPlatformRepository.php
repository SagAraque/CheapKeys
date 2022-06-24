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
            AND f.idPlatform = :platform
            AND f.state = 1'
        )->setParameter('platform', $platform)
        ->setParameter('game', $game);

        return $sql->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
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
        ->from(GamesPlatform::class, 'g')
        ->where('g.state = 1');

        if($platform == 'pc'){
            $sql->innerJoin(Platforms::class, 'p')
            ->andWhere('g.idPlatform = p.idPlatform')
            ->andWhere("p.platformName NOT IN ('playstation', 'xbox', 'switch')");
        }elseif($platform != 'all' && $platform != 'ofertas'){
            $sql->innerJoin(Platforms::class, 'p')
            ->andWhere('g.idPlatform = p.idPlatform')
            ->andWhere('p.platformName = :platform')
            ->setParameter('platform', $platform);
        }elseif($platform == 'ofertas' ){
            $sql->innerJoin(Features::class, 'f')
            ->andWhere('g.idFeature = f.idFeature')
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
        ->where('p.idFeature = f.idFeature')
        ->andWhere('p.state = 1');

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
            AND g.gameName LIKE :word
            AND gp.state = 1'
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
             AND gp.state = 1
             '
        )->setParameter('wishlist', $id);

        return $sql;
    }

    public function findByDiscount($min = 0)
    {
        $em = $this -> getEntityManager();

        $sql = $em->createQuery(
            'SELECT gp FROM App\Entity\GamesPlatform gp
            JOIN App\Entity\Features f
            WHERE gp.idFeature = f.idFeature
            AND f.gameDiscount > :min
            AND gp.state = 1'
        )
        ->setParameter('min', strval($min))
        ->setMaxResults(8);

        return $sql -> getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function finddBestsellers()
    {
        $em = $this->getEntityManager();

        $sql = $em->createQueryBuilder('e')
        ->select('gp')
        ->from('App\Entity\GamesPlatform', 'gp')
        ->join('App\Entity\GameKeys', 'gk')
        ->where('gp.idPlatform = gk.idPlatform')
        ->andWhere('gp.game = gk.idGame')
        ->andWhere('gp.idPlatform = gk.idPlatform')
        ->andWhere('gp.state = 1')
        ->groupBy('gp.idPlatform, gp.game')
        ->orderBy('COUNT(gk)', 'DESC')
        ->setMaxResults(8);

        return $sql->getQuery()->getResult();
    }

    public function getTotalGames()
    {
        $em = $this -> getEntityManager();
        
        $sql = $em->createQuery('SELECT COUNT(g.game) FROM App\Entity\GamesPlatform g WHERE g.state = 1');

        return $sql->getArrayResult();
    }

    public function getNoStock()
    {
        $em = $this -> getEntityManager();

        $sql = $em->createQuery(
            'SELECT gp FROM App\Entity\GamesPlatform gp
            JOIN App\Entity\Features f
            WHERE gp.idFeature = f.idFeature
            AND f.gameStock = 0
            AND gp.state = 1'
        )->setMaxResults(12);

        return $sql -> getResult();
    }

    public function getAllGamesNoQuery()
    {
        $em = $this -> getEntityManager();

        $sql = $em -> createQuery(
            'SELECT gp FROM App\Entity\GamesPlatform gp WHERE gp.state = 1 ORDER BY gp.game'
        );

        return $sql;
    }

    public function searchProducts($searchValue)
    {
        $em = $this -> getEntityManager();

        $sql = $em -> createQuery(
            'SELECT gp FROM App\Entity\GamesPlatform gp
            JOIN App\Entity\Games g
            JOIN app\Entity\Platforms p
            WHERE g.gameName like :gName
            AND g.idGame = gp.game
            AND p.idPlatform = gp.idPlatform'
        )->setParameter('gName', '%'.$searchValue.'%');

        return $sql;
    }
}

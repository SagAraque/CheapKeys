<?php

namespace App\Repository;

use App\Entity\GamesPlatform;
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

    public function findAllNoQuery()
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT p FROM App\Entity\GamesPlatform p'
        );

        return $sql;
    }

    public function findByFeatureNoQuery($params)
    {
        $first = 0;
        $index = 0;
        $em = $this->getEntityManager();
        
        $sql = $em->createQueryBuilder()
        ->select('p')
        ->from(GamesPlatform::class, 'p');

        foreach ($params as $key => $value) {
            $index++;
            if(count(array_filter($value)) != 0){
                if($first == 0){
                    $sql -> where('p.'.$key.' in (:field'.$index.')');
                }else{
                    $sql->andWhere('p.'.$key.' in (:field'.$index.')');
                }
                
                $sql->setParameter('field'.$index, $value, \Doctrine\DBAL\Connection::PARAM_INT_ARRAY);
                $first = 1;
            }
        }

        return $sql;
    }
}

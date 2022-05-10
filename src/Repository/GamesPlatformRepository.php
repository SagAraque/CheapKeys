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
}

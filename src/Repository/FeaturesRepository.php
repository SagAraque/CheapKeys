<?php

namespace App\Repository;

use App\Entity\Features;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Features>
 *
 * @method Features|null find($id, $lockMode = null, $lockVersion = null)
 * @method Features|null findOneBy(array $criteria, array $orderBy = null)
 * @method Features[]    findAll()
 * @method Features[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeaturesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Features::class);
    }

    public function add(Features $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Features $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBySlug($slug)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT g FROM App\Entity\Games g
            WHERE g.gameSlug = :value'
        )->setParameter('value', $slug);

        return $sql->getSingleResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function getDeveloper()
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT f.gameDeveloper, COUNT(f.gameDeveloper) as total
            FROM App\Entity\Features f GROUP BY f.gameDeveloper'
        );

        return $sql->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function getStock()
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT COUNT(f.gameStock) as stock
            FROM App\Entity\Features f
            WHERE f.gameStock != 0'
        );

        $firstResult  = $sql->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        $sql =  $em->createQuery(
            'SELECT COUNT(f.gameStock) as stock
            FROM App\Entity\Features f
            WHERE f.gameStock = 0'
        );

        $secondResult = $sql->getSingleResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        return [['value' => $firstResult['stock'], 'title' => 'En Stock'], ['value' => $secondResult['stock'], 'title' => 'Sin Stock']];
    }

    public function getPegi()
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT f.gamePegi, COUNT(f.gamePegi) as value
            FROM App\Entity\Features f GROUP BY f.gamePegi'
        );

        return $sql->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
    }

    public function findMultipleFeatures($id)
    {
        $em = $this->getEntityManager();

        $sql = $em->createQueryBuilder()
        ->select('f')
        ->from(Features::class, 'f');

        if(count(array_filter($id)) != 0){
            $sql->where('f.gameDeveloper in (:developer)')
            ->setParameter('developer', $id,\Doctrine\DBAL\Connection::PARAM_INT_ARRAY );
        }

        return $sql->getQuery()->getResult();
    }
}

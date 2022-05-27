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

    public function findMultipleFeatures($params, $stock)
    {
        $first = 0;
        $index = 0;
        $em = $this->getEntityManager();

        $sql = $em->createQueryBuilder()
        ->select('f.idFeature')
        ->from(Features::class, 'f');

        foreach ($params as $key => $value) {
            $index++;
            if(count(array_filter($value)) != 0){
                $query = 'f.'.$key.' in (:field'.$index.')';
                $first == 0 ? $sql -> where($query) : $sql->andWhere($query);
                
                $sql->setParameter('field'.$index, $value, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);
                $first = 1;
            }
        }

        if(count(array_filter($stock)) != 2 && count(array_filter($stock)) != 0)
        {
            foreach($stock as $value){
                strcmp($value, "En Stock") ? $query = 'f.gameStock = 0' : $query = 'f.gameStock > 0';
                    
                $first == 0 ? $sql ->where($query) : $sql ->andWhere($query);
                $first = 1;
            }
        }
        return $sql->getQuery()->getArrayResult();
    }
}

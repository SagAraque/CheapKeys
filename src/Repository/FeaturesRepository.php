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
}

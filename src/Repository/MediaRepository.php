<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Media>
 *
 * @method Media|null find($id, $lockMode = null, $lockVersion = null)
 * @method Media|null findOneBy(array $criteria, array $orderBy = null)
 * @method Media[]    findAll()
 * @method Media[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

    public function add(Media $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Media $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByGame($id)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT m FROM App\Entity\Media m
             WHERE m.idGame = :value
             AND m.mediaInfoimg = 0'
        )->setParameter('value', $id);

        return $sql->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function findOneByInfo($id)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT m FROM App\Entity\Media m
             WHERE m.idGame = :value
             AND m.mediaInfoimg = 1'
        )->setParameter('value', $id);

        return $sql->getSingleResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function findOnePerGame($id)
    {

         $em = $this->getEntityManager();

         $sql =  $em->createQuery(
            'SELECT DISTINCT m FROM App\Entity\Media m
            WHERE m.idGame in ( :value )
            AND m.mediaInfoimg = 0
            GROUP BY m.idGame'
        )->setParameter('value', $id);

        return $sql->getResult();

    }


}

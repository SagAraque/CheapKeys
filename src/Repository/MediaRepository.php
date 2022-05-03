<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Media $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Media $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
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

}

<?php

namespace App\Repository;

use App\Entity\Meeting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Meeting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meeting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meeting[]    findAll()
 * @method Meeting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Meeting[]    getTitle()
 */
class MeetingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Meeting::class);
    }

    /**
     * @param string|null $keyword
     * @return mixed
     */
    public function getTitle(?string $keyword)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.title LIKE :key')
            ->setParameter('key', '%'.$keyword.'%')
            ->getQuery()
            ->getResult();
    }

    public function getTop10(): array
    {
        $querybuilder = $this->createQueryBuilder('meeting')
        ->orderBy('meeting.note', 'DESC')
        ->setMaxResults(10);
        
        return $querybuilder->getQuery()->getResult();
    }

    

    // /**
    //  * @return Meeting[] Returns an array of Meeting objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Meeting
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

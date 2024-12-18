<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Media>
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

//    /**
//     * @return Media[] Returns an array of Media objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Media
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findPopular(int $limit = 10): array
    {
        return $this->createQueryBuilder('m')
            ->select('m, SUM(wh.numberOfViews) AS HIDDEN totalViews')
            ->join('m.watchHistories', 'wh') 
            ->where('m INSTANCE OF :movieType')
            ->setParameter('movieType', 'movie')
            ->groupBy('m.id')
            ->orderBy('totalViews', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}

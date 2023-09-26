<?php

namespace App\Repository;

use App\Entity\Generique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Generique>
 *
 * @method Generique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Generique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Generique[]    findAll()
 * @method Generique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeneriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Generique::class);
    }

//    /**
//     * @return Generique[] Returns an array of Generique objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Generique
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

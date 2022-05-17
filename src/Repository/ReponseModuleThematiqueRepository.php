<?php

namespace App\Repository;

use App\Entity\ReponseModuleThematique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReponseModuleThematique>
 *
 * @method ReponseModuleThematique|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReponseModuleThematique|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReponseModuleThematique[]    findAll()
 * @method ReponseModuleThematique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponseModuleThematiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReponseModuleThematique::class);
    }

    public function add(ReponseModuleThematique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReponseModuleThematique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ReponseModuleThematique[] Returns an array of ReponseModuleThematique objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReponseModuleThematique
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

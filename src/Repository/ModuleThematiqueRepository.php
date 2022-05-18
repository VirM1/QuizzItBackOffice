<?php

namespace App\Repository;

use App\Entity\ModuleThematique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ModuleThematique>
 *
 * @method ModuleThematique|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModuleThematique|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModuleThematique[]    findAll()
 * @method ModuleThematique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleThematiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModuleThematique::class);
    }

    public function add(ModuleThematique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ModuleThematique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return ModuleThematique[] Returns an array of ModuleThematique objects
     */
    public function findAllByThematiqueId($value): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.thematique = :val')
            ->setParameter('val', $value)
            ->orderBy('m.libelleModuleThematique', 'ASC')
            ->getQuery()
            ->getArrayResult()
        ;
    }

//    public function findOneBySomeField($value): ?ModuleThematique
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

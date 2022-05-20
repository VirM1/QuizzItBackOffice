<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 *
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function add(Question $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Question $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Question[] Returns an array of Question objects
     */
    public function findQuizzQuestionsByModule($value): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.moduleThematique = :val')
            ->setParameter('val', $value)
            ->orderBy("RAND()")
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
            ;
    }


    public function countAllRelations(Question $question):array
    {
        return $this->createQueryBuilder('q')
            ->select(array("COUNT(q.id)"))
            ->innerJoin("q.reponseModuleThematique","rmt")
            ->andWhere('q = :question')
            ->setParameter('question', $question)
            ->getQuery()
            ->getResult();
    }

    public function countRightRelations(Question $question):array
    {
        return $this->createQueryBuilder('q')
            ->select(array("COUNT(q.id)"))
            ->innerJoin("q.reponseModuleThematique","rmt")
            ->innerJoin("rmt.reponses","reponses")
            ->andWhere('q = :question')
            ->setParameter('question', $question)
            ->andWhere("q.bonneReponse = reponses")
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Question[] Returns an array of Question objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Question
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

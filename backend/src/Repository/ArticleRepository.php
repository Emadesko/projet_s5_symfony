<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function paginateArticles(int $page, int $limit,string $value): Paginator
    {

        $query = $this->createQueryBuilder('a');
        if ($value != "") {
            $query->where('a.libelle like :value')
                ->setParameter('value',$value.'%');
        }
        $query->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->orderBy('a.id', 'ASC')
            ->getQuery();
        return new Paginator($query);
    }

    public function articlesRupture(int $page, int $limit,int $qte, string $libelle): Paginator
    {

        $query = $this->createQueryBuilder('a')
            ->where('a.qteStock <= :qteStock');
        if ($libelle != "") {
            $query->andWhere('a.libelle like :libelle')
                ->setParameter('libelle',$libelle.'%');
        }
        $query->setParameter('qteStock',$qte)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->orderBy('a.id', 'ASC')
            ->getQuery();
        return new Paginator($query);
    }

    //    /**
    //     * @return Article[] Returns an array of Article objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Article
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

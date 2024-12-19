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

    public function paginateArticles(int $page, int $limit,string $libelle,string $dispo,int $qte): Paginator
    {

        $query = $this->createQueryBuilder('a');
        if ($libelle != "") {
            $query->where('a.libelle like :libelle')
                ->setParameter('libelle',$libelle.'%');
        }
        if ($dispo == "oui") {
            $query->andWhere('a.qteStock > :qte')
                ->setParameter('qte',$qte);
        }
        if ($dispo == "non") {
            $query->andWhere('a.qteStock <= :qte')
                ->setParameter('qte',$qte);
        }
        $query->setFirstResult(($page - 1) * $limit)
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

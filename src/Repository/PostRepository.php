<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Post;
use App\Form\SearchType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Post[]    findSearch()
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }

    /**
     * @return Post[]
     */
    public function findSearch(SearchData $search): array
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('p');

        if (empty($search)) {
            return $this->findBy([], ['category' => 'DESC']);
        } else {
            if (!empty($search->q)) {
                $query = $query
                    ->andWhere('p.title LIKE :q OR p.content LIKE :q')
                    ->setParameter('q', "%{$search->q}%");
            }

            if (!empty($search->dateMin)) {
                $query = $query
                    ->andWhere('p.createdAt  >= :dateMin')
                    ->setParameter('dateMin', $search->dateMin);
            }

            if (!empty($search->dateMax)) {
                $query = $query
                    ->andWhere('p.createdAt <= :dateMax')
                    ->setParameter('dateMax', $search->dateMax);
            }

            if (!empty($search->categories)) {
                $query = $query
                    ->andWhere('p.category IN (:categories)')
                    ->setParameter('categories', $search->categories);
            }


            return $query->getQuery()->getResult();
        }
    }
}

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
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @return Query
     */
    public function findAllVisibleQuery(): Query
    {
        return $this->findVisibleQuery()
            ->getQuery();
    }

    public function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }
}

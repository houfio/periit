<?php

namespace App\Repository;

use App\Entity\Excursion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Excursion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Excursion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Excursion[]    findAll()
 * @method Excursion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExcursionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Excursion::class);
    }

    public function findAllPaginated($page, $size)
    {
        $query = $this->createQueryBuilder('e')->getQuery();
        $paginator = new Paginator($query);

        $paginator->getQuery()
            ->setFirstResult($size * ($page - 1))
            ->setMaxResults($size);

        return $paginator;
    }
}

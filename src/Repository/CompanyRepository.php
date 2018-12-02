<?php

namespace App\Repository;

use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function findAllPaginated($page, $size, $search, $levels, $materials, $methods)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.name LIKE :search');

        if (count($levels)) {
            $query = $query
                ->innerJoin('c.levels', 'l')
                ->andWhere('l.slug IN (:levels)')
                ->setParameter('levels', $levels);
        }

        if (count($materials)) {
            $query = $query
                ->innerJoin('c.materials', 'ma')
                ->andWhere('ma.slug IN (:materials)')
                ->setParameter('materials', $materials);
        }

        if (count($methods)) {
            $query = $query
                ->innerJoin('c.methods', 'me')
                ->andWhere('me.slug IN (:methods)')
                ->setParameter('methods', $methods);
        }

        $query = $query
            ->setParameter('search', "%$search%")
            ->getQuery();
        $paginator = new Paginator($query);

        $paginator->getQuery()
            ->setFirstResult($size * ($page - 1))
            ->setMaxResults($size);

        return $paginator;
    }
}

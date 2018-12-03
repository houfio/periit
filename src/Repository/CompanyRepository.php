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

    public function findAllPaginated($page, $size, $filters, $orderBy, $orderAs)
    {
        $query = $this->createQueryBuilder('c')
            ->orderBy("c.$orderBy", $orderAs)
            ->where('c.name LIKE :search');

        $filterNames = ['levels', 'materials', 'methods',];

        foreach ($filterNames as $name) {
            if (count($filters[$name])) {
                $query = $query
                    ->innerJoin("c.$name", $name)
                    ->andWhere("$name IN (:$name)")
                    ->setParameter($name, $filters[$name]);
            }
        }

        $query = $query
            ->setParameter('search', "%${filters['search']}%")
            ->getQuery();
        $paginator = new Paginator($query);

        $paginator->getQuery()
            ->setFirstResult($size * ($page - 1))
            ->setMaxResults($size);

        return $paginator;
    }
}

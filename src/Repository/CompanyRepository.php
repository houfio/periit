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

    public function findAllPaginated($page, $size, $search, Company $filters)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.name LIKE :search');

        $filters = [
            'levels' => $filters->getLevels(),
            'materials' => $filters->getMaterials(),
            'methods' => $filters->getMethods()
        ];

        foreach ($filters as $name => $filter) {
            if (count($filter)) {
                $query = $query
                    ->innerJoin("c.$name", $name)
                    ->andWhere("$name IN (:$name)")
                    ->setParameter($name, $filter);
            }
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

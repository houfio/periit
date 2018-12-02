<?php

namespace App\Repository;

use App\Entity\Method;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Method|null find($id, $lockMode = null, $lockVersion = null)
 * @method Method|null findOneBy(array $criteria, array $orderBy = null)
 * @method Method[]    findAll()
 * @method Method[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MethodRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Method::class);
    }
}

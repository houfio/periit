<?php

namespace App\Repository;

use App\Entity\ContactPerson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContactPerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactPerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactPerson[]    findAll()
 * @method ContactPerson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactPersonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContactPerson::class);
    }
}

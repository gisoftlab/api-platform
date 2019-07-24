<?php

namespace App\Repository;


use App\Entity\ProductItems;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * ProductItemsRepository
 */
class ProductItemsRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductItems::class);
    }
}

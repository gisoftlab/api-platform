<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

final class ProductService
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * PostService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $message
     * @return Product
     */
    public function createProduct(string $message): Post
    {
        $productEntity = new Product();
        $productEntity->setMessage($message);
        $this->em->persist($productEntity);
        $this->em->flush();

        return $productEntity;
    }

    /**
     * @return object[]
     */
    public function getAll(): array
    {
        return $this->em->getRepository(Product::class)->findBy([], ['id' => 'DESC']);
    }


    public function handle($data)
    {
        return $data;
    }
}

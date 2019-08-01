<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\ProductService;

class CreateProductPublication
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function __invoke()
    {
        return $this->productService->getAll();
    }
}

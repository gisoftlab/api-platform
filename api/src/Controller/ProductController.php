<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\PostService;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractController
{


    /**
     * @var ProductService
     */
    private $productService;

    /**
     * ProductController constructor.
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @param Product $data
     * @return Product
     */
    public function getResultActions(Product $data)
    {
        $result = $data->getTitle() .' - '.$data->getId();
        $data->setResult($result);

        return $data;
    }
}

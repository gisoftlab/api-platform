<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i = 1; $i <= 20; ++$i) {
            $product = new Product();
            $product->setTitle('product_title_'.$i);
            $product->setShort('product_short_'.$i);
            $product->setDescription('description_short_'.$i);
            $product->setPublished(($i%2)?true:false);
            $product->setPromoted(($i%2)?true:false);
            $product->setPrice($i);
            $product->setDeposit($i+20);

            $manager->persist($product);
        }

        $manager->flush();
    }
}

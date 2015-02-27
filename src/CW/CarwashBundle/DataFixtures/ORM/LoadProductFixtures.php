<?php

namespace CW\CarwashBundle\DataFixtures\ORM;

use CW\CarwashBundle\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProductFixtures extends BaseFixture
{
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        foreach (Configuration::$defaultProducts as $productName) {
            $product = new Product();
            $product->setName($productName)
                ->setPrice($this->faker->numberBetween(20, 50));

            $this->manager->persist($product);
            $this->manager->flush();
        }
    }

    public function getOrder()
    {
        return 4;
    }
}

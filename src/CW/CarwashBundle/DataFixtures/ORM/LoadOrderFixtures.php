<?php

namespace CW\CarwashBundle\DataFixtures\ORM;

use CW\CarwashBundle\Entity\Order;
use CW\CarwashBundle\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;

class LoadOrderFixtures extends BaseFixture
{
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->iterator(Configuration::ORDERS, function ($index) {
            $order = new Order();
            $client = $this->manager->getRepository('CWCarwashBundle:Client')->find($this->faker->numberBetween(1, 5));
            $user = $this->manager->getRepository('CWUserBundle:User')->find($this->faker->numberBetween(1, 3));
            $products = $this->manager->getRepository('CWCarwashBundle:Product')->findAll();
            $order->setClient($client)
                ->setUser($user)
                ->setCreatedAt($this->faker->dateTimeBetween('-2 days', 'now'))
                ->addProduct($this->faker->randomElement($products));

            return $order;
        }, 'order');
    }

    public function getOrder()
    {
        return 5;
    }
}

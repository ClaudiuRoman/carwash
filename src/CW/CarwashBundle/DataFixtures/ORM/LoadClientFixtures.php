<?php

namespace CW\CarwashBundle\DataFixtures\ORM;

use CW\CarwashBundle\Entity\Client;
use CW\CarwashBundle\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;

class LoadClientFixtures extends BaseFixture
{
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->iterator(Configuration::CLIENTS, function ($index) {
            $client = new Client();
            $client->setLicencePlate('BT0'. $index.'PHP');
                if ($this->faker->boolean(50)) {
                    $client->setHasSubscription(true)
                        ->setStartedAt($this->faker->dateTimeBetween('-1 month 1 week', 'now'));
                }

            return $client;
        }, 'client');
    }

    public function getOrder()
    {
        return 3;
    }
}

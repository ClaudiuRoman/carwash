<?php

namespace CW\CarwashBundle\DataFixtures\ORM;

use CW\CarwashBundle\Entity\Promotion;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPromotionFixtures extends BaseFixture
{
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->iterator(Configuration::PROMOTIONS, function ($index) {
            $promotion = new Promotion();
            $promotion->setName('Promotion ' . $index)
                ->setCriteria($this->faker->numberBetween(3, 6));
            if ($index == Configuration::PROMOTIONS) {
                $promotion->setActive(true);
            } else {
                $promotion->setActive(false);
            }

            return $promotion;
        }, 'promotion');
    }

    public function getOrder()
    {
        return 2;
    }
}

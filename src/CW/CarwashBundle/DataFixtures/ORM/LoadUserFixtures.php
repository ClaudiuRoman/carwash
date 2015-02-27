<?php

namespace CW\CarwashBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use CW\UserBundle\Entity\User;

class LoadUserFixtures extends BaseFixture
{
    private $userManager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->userManager = $this->container->get('fos_user.user_manager');

        $this->iterator(Configuration::USERS, function ($index) {
            $user = new User();
            $user->setEmail('user-' . $index)
                ->setUsername('user-'. $index)
                ->setEnabled(true)
                ->setPlainPassword('12345')
                ->setFirstName($this->faker->firstName)
                ->setLastName($this->faker->lastName);

            $this->userManager->updateUser($user);

            return $user;
        }, 'user');
    }

    public function getOrder()
    {
        return 0;
    }
}

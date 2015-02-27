<?php

namespace CW\CarwashBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use CW\CarwashBundle\DataFixtures\ORM\Traits\FixtureIterator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /** @var  Container */
    protected $container;
    /** @var  ObjectManager */
    protected $manager;
    protected $faker;
    protected static $cache = [];
    use FixtureIterator;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        return;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        // TODO: Implement getOrder() method.
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->faker     = Factory::create();
    }

    /**
     * @param $ref
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getObjects($ref)
    {
        if (!array_key_exists($ref, static::$cache)) {
            throw new \InvalidArgumentException('The reference does not exist');
        }

        // build obj array
        $objects = [];
        $this->iterator(static::$cache[$ref], function ($index) use ($ref, &$objects) {
            $objects[] = $this->getReference($ref.'-'.($index-1));
        });

        return $objects;
    }

    /**
     * @param $ref
     *
     * @return object
     * @throws \InvalidArgumentException
     */
    public function getRandomObject($ref)
    {
        if (!array_key_exists($ref, static::$cache)) {
            throw new \InvalidArgumentException('The reference does not exist');
        }

        $index = rand(0, static::$cache[$ref] - 1);

        return $this->getReference($ref.'-'.$index);
    }

    /**
     * @param $text
     * @return mixed|string
     */
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        return $text;
    }
}

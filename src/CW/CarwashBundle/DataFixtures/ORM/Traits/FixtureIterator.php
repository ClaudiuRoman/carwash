<?php

namespace CW\CarwashBundle\DataFixtures\ORM\Traits;

trait FixtureIterator
{
    public static $nest = 0;

    /**
     * @param          $name
     * @param callable $callback
     * @param null     $ref
     *
     * @throws \InvalidArgumentException
     * @return void|null|object
     */
    public function iterator($name, callable $callback, $ref = null)
    {
        $time_start = microtime(true);

        if (is_int($name)) {
            $this->log(true, sprintf('Iteration for %s records having reference "%s".', $name, $ref));

            $this->countIteration($name, $callback, $ref);

            $this->log(false, sprintf(
                'Iteration for "%s" records having reference "%s" and it lasted "%s".',
                $name,
                $ref,
                microtime(true) - $time_start
            ));
        } elseif (is_string($name)) {
            $this->log(true, sprintf('Iterating through all the "%s" references', $name));

            $count = $this->referenceIteration($name, $callback);

            $this->log(false, sprintf(
                'Iteration for all "%s" records having reference "%s" and it lasted "%s".',
                $count - 1,
                $name,
                microtime(true) - $time_start
            ));
        } else {
            throw new \InvalidArgumentException;
        }

        $this->manager->flush();
    }

    /**
     * @param          $name
     * @param callable $callback
     * @param          $ref
     */
    protected function countIteration($name, callable $callback, $ref)
    {
        $count = 0;
        if ($ref) {
            $increase = isset(self::$cache[$ref]) ? self::$cache[$ref] : 0;
            while ($count++ < $name) {
                $object = $callback($count);
                $this->setReference($ref . '-' . $increase++, $object);

                if ($this->manager) {
                    $this->manager->persist($object);
                    if ($this->faker->boolean(5)) {
                        $this->manager->flush();
                    }
                }
            }
            static::$cache[$ref] = $increase;
        } else {
            while ($count++ < $name) {
                $callback($count);
            }
        }
    }

    /**
     * @param          $name
     * @param callable $callback
     *
     * @return mixed
     */
    protected function referenceIteration($name, callable $callback)
    {
        $count = 0;
        while ($this->hasReference($name . '-' . $count)
            && ($object = $this->getReference($name . '-' . $count++))) {
            $callback($object);
        }
        return $count;
    }

    private function log($isStarting, $message)
    {
        if (!$isStarting) {
            static::$nest--;
        }

        $tabPrefix = str_repeat("\t", static::$nest);
        printf('%s%s : %s'."\n", $tabPrefix, $isStarting ? '[Start] ' : '[End] ', $message);

        if ($isStarting) {
            static::$nest++;
        }
    }
}

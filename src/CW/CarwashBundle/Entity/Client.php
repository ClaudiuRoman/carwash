<?php

namespace CW\CarwashBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity
 */
class Client
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="licence_plate", type="string", length=255)
     */
    private $licencePlate;

    /** @var boolean
     *
     * @ORM\Column(name="has_subscription", type="boolean")
     */
    private $hasSubscription = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="started_at", type="datetime", nullable=true)
     */
    private $startedAt;

    /**
     * @var Order[]
     *
     * @ORM\OneToMany(targetEntity="CW\CarwashBundle\Entity\Order", mappedBy="client")
     */
    private $orders;

    /**
     * @var integer
     *
     * @ORM\Column(name="wash_washCounter", type="integer")
     */
    private $washCounter = 0;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set licencePlate
     *
     * @param string $licencePlate
     * @return Client
     */
    public function setLicencePlate($licencePlate)
    {
        $this->licencePlate = $licencePlate;

        return $this;
    }

    /**
     * Get licencePlate
     *
     * @return string 
     */
    public function getLicencePlate()
    {
        return $this->licencePlate;
    }

    /**
     * @return \DateTime
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * @param \DateTime $startedAt
     * @return $this
     */
    public function setStartedAt($startedAt)
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isHasSubscription()
    {
        return $this->hasSubscription;
    }

    /**
     * @param boolean $hasSubscription
     * @return $this
     */
    public function setHasSubscription($hasSubscription)
    {
        $this->hasSubscription = $hasSubscription;

        return $this;
    }

    /**
     * @return Order[]
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param Order[] $orders
     * @return $this
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * @return int
     */
    public function getWashCounter()
    {
        return $this->washCounter;
    }

    /**
     * @param int $washCounter
     * @return $this
     */
    public function setWashCounter($washCounter)
    {
        $this->washCounter = $washCounter;

        return $this;
    }
}

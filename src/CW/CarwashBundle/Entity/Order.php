<?php

namespace CW\CarwashBundle\Entity;

use CW\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity()
 */
class Order
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="CW\CarwashBundle\Entity\Client", inversedBy="orders", cascade={"persist"})
     */
    private $client;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="CW\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var Receipt
     *
     * @ORM\OneToOne(targetEntity="CW\CarwashBundle\Entity\Receipt", inversedBy="order", cascade={"persist"})
     */
    private $receipt;

    /**
     * @var Product[]
     *
     * @ORM\ManyToMany(targetEntity="CW\CarwashBundle\Entity\Product", inversedBy="orders")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     * @return $this
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Receipt
     */
    public function getReceipt()
    {
        return $this->receipt;
    }

    /**
     * @param Receipt $receipt
     * @return $this
     */
    public function setReceipt($receipt)
    {
        $this->receipt = $receipt;

        return $this;
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Product[] $products
     * @return $this
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function addProduct(Product $product)
    {
        $this->products->add($product);

        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function removeTag(Product $product)
    {
        $this->products->removeElement($product);

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}

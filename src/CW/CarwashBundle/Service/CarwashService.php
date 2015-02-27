<?php

namespace CW\CarwashBundle\Service;

use CW\CarwashBundle\Entity\Client;
use CW\CarwashBundle\Entity\Order;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("carwash.service")
 */
class CarwashService
{
    const VAT = 24;
    private $em;

    /** @DI\InjectParams() */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Client $client
     * @return Client
     */
    public function checkIfClientExists(Client $client)
    {
        $clientObject = $this->em->getRepository('CWCarwashBundle:Client')->findOneBy([
            'licencePlate' => $client->getLicencePlate()
        ]);
        if ($clientObject) {
            return $clientObject;
        } else {
            return $client;
        }
    }

    /**
     * @param Order $order
     * @return array
     */
    public function calculateTotalFromOrder(Order $order)
    {
        $total = 0;
        $totalWithDiscount = 0;
        $promotion = false;
        foreach ($order->getProducts() as $product) {
            $total += $product->getPrice();
        }

        if ($order->getClient()->isHasSubscription()) {
            $now = new \DateTime();
            $clientSubscriptionExpiration = $order->getClient()->getStartedAt()->add(new \DateInterval('P1M'));
            if ($now < $clientSubscriptionExpiration) {
                $totalWithDiscount = $total - $total / 10;
            }
        } else {
            $promotion = $this->getEligibilePromotion($order);
        }
        if ($totalWithDiscount) {
            $vat = round($totalWithDiscount  * (self::VAT / 100), 2);
        } else {
            $vat = round($total  * (self::VAT / 100), 2);
        }

        if ($promotion) {
            $total = 0;
        }

        return [
            'total' => $total,
            'vat' => $vat,
            'promotion' => $promotion,
            'totalWithDiscount' => $totalWithDiscount
        ];
    }

    /**
     * @param Order $order
     * @return bool
     */
    private function getEligibilePromotion(Order $order)
    {
        $promotion = $this->em->getRepository('CWCarwashBundle:Promotion')->findOneBy([
            'active' => true
        ]);
        if ($promotion) {
            if ($promotion->getCriteria() - 1 <= $order->getClient()->getWashCounter()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return \CW\CarwashBundle\Entity\Promotion
     */
    public function getActivePromotion()
    {
        $promotion = $this->em->getRepository('CWCarwashBundle:Promotion')->findOneBy([
            'active' => true
        ]);

        return $promotion;
    }

    /**
     * @param Order $order
     * @return Order
     */
    public function processWashCounter(Order $order)
    {
        $promotion = $this->getActivePromotion();

        if ($promotion->getCriteria() -1  == $order->getClient()->getWashCounter()) {
            $order->getClient()->setWashCounter(0);
        } else {
            $order->getClient()->setWashCounter($order->getClient()->getWashCounter()+1);
        }

        return $order;
    }
}
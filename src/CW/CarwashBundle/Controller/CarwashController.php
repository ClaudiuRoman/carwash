<?php

namespace CW\CarwashBundle\Controller;

use CW\CarwashBundle\Entity\Order;
use CW\CarwashBundle\Entity\Receipt;
use CW\CarwashBundle\Form\OrderType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class CarwashController extends Controller
{
    /**
     * @Route("/", name="carwash_list")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository('CWCarwashBundle:Order')->findBy([
            'user' => $this->getUser()
        ]);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $orders,
            $request->query->get('page', 1),
            $this->container->getParameter('pagination.items_per_page')
        );

        return [
            'orders' => $pagination
        ];
    }

    /**
     * @Route("/manage-order/{id}", name="carwash_manage", defaults={"id" = null})
     * @Template()
     */
    public function manageOrderAction($id, Request $request)
    {
        $order = $this->getOrCreateOrder($id);
        $form = $this->createForm(new OrderType(), $order);
        if ($form->handleRequest($request) && $form->isValid()) {
            $this->processOrderForm($order);

            return $this->redirect($this->generateUrl('carwash_list'));
        }

        return [
            'form' => $form->createView(),
            'order' => $order
        ];
    }

    /**
     * @Route("/delete-order/{id}", name="carwash_delete")
     */
    public function deleteOrderAction($id)
    {
        if (!$id) {
            throw new EntityNotFoundException();
        }
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('CWCarwashBundle:Order')->find($id);
        $em->remove($order);
        $em->flush();

        return $this->redirect($this->generateUrl('carwash_list'));
    }

    /**
     * @Route("/complete-order/{id}", name="carwash_complete")
     * @Template()
     */
    public function completeOrderAction(Request $request, $id)
    {
        if (!$id) {
            throw new EntityNotFoundException();
        }

        $carwashService = $this->get('carwash.service');
        $em = $this->getDoctrine()->getManager();

        $promotion = $carwashService->getActivePromotion();
        $order = $em->getRepository('CWCarwashBundle:Order')->find($id);
        $value = $carwashService->calculateTotalFromOrder($order);

        $receipt = new Receipt();
        $receipt->setCreatedAt(new \DateTime())
            ->setOrder($order)
            ->setValue($value['total']);

        if ($request->isMethod('post')) {
            $this->processReceipt($order, $value, $em);

            return $this->redirect($this->generateUrl('carwash_list'));
        }

        return [
            'receipt' => $receipt,
            'price' => $value,
            'promotion' => $promotion
        ];
    }

    /**
     * @param $id
     * @return Order
     */
    private function getOrder($id)
    {
        $order = $this->container->get('doctrine.orm.entity_manager')
            ->getRepository('CWCarwashBundle:Order')
            ->findOneBy(['id' => $id]);

        if (!$order) {
            throw $this->createNotFoundException();
        }

        return $order;
    }

    /**
     * @param $id
     * @return Order
     */
    private function getOrCreateOrder($id)
    {
        if (!$id) {
            $order = new Order();
            $order->setUser($this->getUser());
            return $order;
        } else {
            $order = $this->getOrder($id);
            return $order;
        }
    }

    /**
     * @param Order $order
     */
    private function processOrderForm(Order $order)
    {
        $em = $this->getDoctrine()->getManager();
        $carwashService = $this->get('carwash.service');

        $client = $order->getClient();
        $client = $carwashService->checkIfClientExists($client);

        $order->setUser($this->getUser())
            ->setCreatedAt(new \DateTime())
            ->setClient($client);

        $em->persist($order);
        $em->flush();
    }

    /**
     * @param Order $order
     * @param $value
     * @param EntityManager $em
     */
    public function processReceipt(Order $order, $value, EntityManager $em)
    {
        $carwashService = $this->get('carwash.service');
        $receipt = new Receipt();
        if ($value['totalWithDiscount']) {
            $receipt->setValue($value['totalWithDiscount']);
        } else {
            $receipt->setValue($value['total']);
        }
        $receipt->setOrder($order)
            ->setCreatedAt(new \DateTime());

        $carwashService->processWashCounter($order);
        $order->setReceipt($receipt);

        $em->persist($order);
        $em->persist($receipt);
        $em->flush();
    }
}

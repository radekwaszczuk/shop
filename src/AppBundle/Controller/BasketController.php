<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of BasketController
 */
class BasketController extends Controller
{
    /**
     * @Route("/dodaj-do-koszyka/{id}", name="add_to_basket")
     */
    public function addAction($id, Request $request)
    {
        $products = $this->getProducts();

        if (!array_key_exists($id, $products)) {
            $this->createNotFoundException('Produkt o takim id nie istnieje');
        }

        $basket = $request
            ->getSession()
            ->get('basket', []);

        $basket[] = $products[$id];

        $request
            ->getSession()
            ->set('basket', $basket);

        return $this->redirectToRoute('basket');
    }

    public function removeAction()
    {

    }

    /**
     * @Route("/koszyk", name="basket")
     */
    public function showAction(Request $request)
    {
        //$basket = $this->get('session');

        $basket = $request
            ->getSession()
            ->get('basket', []);

        return $this->render('Basket/show.html.twig', [
            'basket' => $basket,
        ]);
    }

    public function getProducts()
    {
        $file = file('product.txt');
        $products = array();
        foreach ($file as $p) {
            $e = explode(':', trim($p));
            $products[$e[0]] = array(
                'id' => $e[0],
                'name' => $e[1],
                'price' => $e[2],
                'desc' => $e[3],
            );
        }

        return $products;
    }

}
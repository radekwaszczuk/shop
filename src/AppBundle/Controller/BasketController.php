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
    public function addAction(\AppBundle\Entity\Product $product)
    {
        $this->get('basket')->add($product);

        return $this->redirectToRoute('basket');
    }

    public function removeAction()
    {

    }

    /**
     * @Route("/koszyk", name="basket")
     */
    public function showAction()
    {
        return $this->render('Basket/show.html.twig', [
            'basket' => $this->get('basket')->getProducts(),
        ]);
    }

}
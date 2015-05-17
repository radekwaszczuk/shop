<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProductController extends Controller
{
    /**
     * @Route("/product/{id}", name="product", requirements={"id": "\d+"})
     */
    public function showAction(\AppBundle\Entity\Product $product)
    {
//        $product = $this->getDoctrine()
//            ->getRepository('AppBundle:Product')
//            ->find($id);
//
//        if (!$product) {
//            $this->createNotFoundException('Produkt o danym ID nie istnieje');
//        }

        return $this->render('Product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/produkty", name="products")
     */
    public function listAction()
    {
        $products = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findAll()
        ;

        return $this->render('Product/list.html.twig', array(
            'products' => $products,
        ));
    }
}

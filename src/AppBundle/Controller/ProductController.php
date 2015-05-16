<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProductController extends Controller
{
    /**
     * @Route("/product/{id}", name="product")
     */
    public function showAction($id)
    {
        $products = $this->getProducts();
        if (!array_key_exists($id, $products)) {
            $this->createNotFoundException('Produkt o takim id nie istnieje');
        }

        return $this->render('Product/show.html.twig', [
            'product' => $products[$id],
        ]);
    }

    /**
     * @Route("/produkty", name="products")
     */
    public function listAction()
    {

        return $this->render('Product/list.html.twig', array(
            'products' => $this->getProducts(),
        ));
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

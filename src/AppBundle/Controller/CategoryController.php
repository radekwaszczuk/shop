<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of CategoryController
 */
class CategoryController extends Controller
{
    public function listAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        return $this->render('Category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/kategoria/{id}", name="category", requirements={"id": "\d+"})
     */
    public function showAction(\AppBundle\Entity\Category $category)
    {
        $products = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findBy([
                'category' => $category
            ]);

        return $this->render('Product/list.html.twig', [
            'products' => $products,
        ]);
    }

}
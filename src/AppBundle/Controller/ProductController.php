<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use AppBundle\Form\ProductType;
use AppBundle\Form\SearchProductsType;

class ProductController extends Controller
{
    /**
     * @Route("/product/{slug}", name="product")
     */
    public function showAction(\AppBundle\Entity\Product $product, Request $request)
    {
//        $product = $this->getDoctrine()
//            ->getRepository('AppBundle:Product')
//            ->find($id);
//
//        if (!$product) {
//            $this->createNotFoundException('Produkt o danym ID nie istnieje');
//        }

        $em = $this->getDoctrine()->getManager();

        $productForm = $this->createForm(new ProductType(), $product);
        $productForm->handleRequest($request);
        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product', [
                'id' => $product->getId(),
            ]);
        }


        $comment = new Comment();

        $form = $this->createForm(new CommentType(), $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setProduct($product);
            $comment->setUser($this->getUser());

            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('product', [
                'id' => $product->getId(),
            ]);
        }

        return $this->render('Product/show.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'productForm' => $productForm->createView(),
        ]);
    }

    /**
     * @Route("/produkty", name="products")
     */
    public function listAction(Request $request)
    {
        $form = $this->createForm(new SearchProductsType());
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $keyword = $form->get('keyword')->getData();
            
            $productsQuery = $this->getDoctrine()
                ->getRepository('AppBundle:Product')
                ->findProductsQuery($keyword)
            ;
            
        } else {

            $productsQuery = $this->getDoctrine()
                ->getRepository('AppBundle:Product')
                ->getProductsQuery()
            ;

        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $productsQuery,
            $request->query->get('page', 1)/*page number*/,
            10/*limit per page*/
        );

        $message = $this->get('translator')->trans('message');

        return $this->render('Product/list.html.twig', array(
            'products' => $pagination,
            'form' => $form->createView(),
            'message' => $message,
        ));
    }
}

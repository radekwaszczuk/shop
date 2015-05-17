<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Description of Basket
 */
class Basket
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getProducts()
    {
        return $this->session->get('basket', []);
    }

    public function add(\AppBundle\Entity\Product $product, $quantity = 1)
    {
        $products = $this->getProducts();

        if (!array_key_exists($product->getId(), $products)) {
            $products[$product->getId()] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'quantity' => 0,
            ];
        }

        $products[$product->getId()]['quantity'] += $quantity;

        $this->session->set('basket', $products);

        return $this;
    }

}
<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/product/{id}');
    }

    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/produkty');
    }

}

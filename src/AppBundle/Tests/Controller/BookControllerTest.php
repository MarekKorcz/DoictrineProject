<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
    public function testCreatebook()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createBook');
    }

}

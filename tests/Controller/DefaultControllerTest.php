<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testHomepageProtectedRouteAndRedirect()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        static::assertSame(302, $client->getResponse()->getStatusCode());
        static::assertResponseRedirects('/login');
        $client->followRedirect();
    }

}


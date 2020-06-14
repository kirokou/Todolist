<?php

namespace App\Tests\Controller;

use App\Tests\Traits\NeedLogin;
use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    use NeedLogin;
    //liips
    use FixturesTrait;
    
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient();

         //606: Liip Trait fixture: Pour tous les tests ayant besoin de la bd
         //Recharge la base de données a chaque lancement d'un test de classe
         $this->loadFixtures([UserFixtures::class]);

        parent::setUp();

    }

    public function testLoginPage()
    {
        $crawler = $this->client->request('GET', '/login');
        // Routes
        static::assertSame(200, $this->client->getResponse()->getStatusCode());
        static::assertResponseIsSuccessful();

        // form
        static::assertSelectorNotExists('.alert.alert-danger');
        static::assertSame(1, $crawler->filter('form')->count());
        static::assertSame(1, $crawler->filter('input[name="username"]')->count());
        static::assertSame(1, $crawler->filter('input[name="password"]')->count());
        static::assertSame(1, $crawler->filter('button[type="submit"]')->count());

        // buttoms
        static::assertSame(1, $crawler->filter('a.btn.btn-primary')->count());
    }

    public function testLoginWithBadCredentials()
    {
        $crawler = $this->client->request('GET', '/login');

        // Form
        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'test';
        $form['password'] = 'InvalidPassword';
        $this->client->submit($form); 

        // Form redirect
        static::assertResponseRedirects('/login');
        $this->client->followRedirect();

        // Assertions
        static::assertSame(200, $this->client->getResponse()->getStatusCode());
        static::assertSelectorExists('.alert.alert-danger');
        static::assertSelectorTextSame('div.alert', "Identifiants incorrects");
        
    }
    
    public function testLoginIsSuccessuful()
    {
        $crawler = $this->client->request('GET', '/login');

        // Form
        $form = $crawler->selectButton('Se connecter')->form();
        $form['username'] = 'admin1';
        $form['password'] = 'admin1';
        $this->client->submit($form); 

        // Form redirect
        static::assertSame(302, $this->client->getResponse()->getStatusCode());
        static::assertResponseRedirects('/');
        $this->client->followRedirect();
        static::assertSame(200, $this->client->getResponse()->getStatusCode());

        // No Message error
        static::assertSelectorNotExists('.alert.alert-danger');        
    }

    public function testUserAuthenticatedFully()
    {
        $this->logIn($this->client, $this->getUser('admin1'));

        $this->client->request('GET', '/login');
        static::assertResponseRedirects('/');
        $this->client->followRedirect();

        static::assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testLogout()
    {
        $this->client->request('GET', '/logout');
        static::assertSame(302, $this->client->getResponse()->getStatusCode());
        static::assertResponseRedirects('/login');
        $this->client->followRedirect();

        static::assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

}
<?php

namespace App\Tests\Controller;

use App\Tests\Traits\NeedLogin;
use App\DataFixtures\TaskFixtures;
use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    use NeedLogin;
    //liips
    use FixturesTrait;

    protected $client;
    protected $userRepository;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->userRepository = static::$container->get(UserRepository::class);

        //606: Pour tous les tests ayant besoin de la bd
        //Recharge la base de données a chaque lancement d'un test de classe
        $this->loadFixtures([TaskFixtures::class, UserFixtures::class]);

        parent::setUp();
    }

    public function testUserListProtectedAccessAndRedirect()
    {
        $this->client->request('GET', '/users');
        static::assertSame(302, $this->client->getResponse()->getStatusCode());
        static::assertResponseRedirects('/login');
        $this->client->followRedirect();
    }

    public function testUserListAccessDenied()
    {
        $this->logIn($this->client, $this->getUser('user0'));

        $this->client->request('GET', '/users');
        static::assertSame(403, $this->client->getResponse()->getStatusCode());
    }

    public function testUserIsSucessfull()
    {
        $this->logIn($this->client, $this->getUser('admin1'));

        $this->client->request('GET', '/users');
        static::assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testGETCreateUserPageIsSuccess()
    {
        $this->logIn($this->client, $this->getUser('admin1'));

        $this->client->request('GET', '/users/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }


    public function testPOSTCreateUserIsSuccess()
    {
        $this->logIn($this->client, $this->getUser('admin1'));

        $crawler = $this->client->request('GET', '/users/create');
     
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'newuser';
        $form['user[email]'] = 'newuser@gmail.com';
        $form['user[password][first]'] = '123456789';
        $form['user[password][second]'] = '123456789';
        $form['user[role]'] = 'ROLE_ADMIN';
     
        // verifier si la creation s'est bien fait dans la bad
        $this->client->submit($form);

        static::assertResponseRedirects('/users');
        $crawler = $this->client->followRedirect(); 

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testPOSTUpdateUserIsSuccess()
    {
        $anUser = $this->getUser('admin1'); 
        //Authentification
        $this->logIn($this->client, $anUser);
        
        //Recupération d'un task existant a modifier
        $RecupOneUser = $this->userRepository->findOneBy(['username' =>'user0']);
        $this->assertNotNull($RecupOneUser);

        $crawler = $this->client->request('GET', '/users/'.$RecupOneUser->getId().'/edit');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
     
        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'newuser-updated';
        $form['user[email]'] = 'newuser@gmail.com';
        $form['user[password][first]'] = '123456789';
        $form['user[password][second]'] = '123456789';
        $form['user[role]'] = 'ROLE_ADMIN';
     
        $this->client->submit($form);

        static::assertResponseRedirects('/users');
        $crawler = $this->client->followRedirect(); // Attention à bien récupérer le crawler mis à jour

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }


}
<?php

namespace App\Tests\Controller;

use App\Tests\Traits\NeedLogin;
use App\DataFixtures\TaskFixtures;
use App\DataFixtures\UserFixtures;
use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Response;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    use NeedLogin;
    //liips
    use FixturesTrait;

    protected $client;
    protected $taskRepository;


    public function setUp()
    {
        $this->client = static::createClient();
        $this->taskRepository = static::$container->get(TaskRepository::class);

        //606: Pour tous les tests ayant besoin de la bd
        //Recharge la base de données a chaque lancement d'un test de classe

        $this->loadFixtures([TaskFixtures::class, UserFixtures::class]);

        parent::setUp();

    }

    public function testTaskListProtectedAccessAndRedirect()
    {
        $this->client->request('GET', '/tasks');
        static::assertSame(302, $this->client->getResponse()->getStatusCode());
        static::assertResponseRedirects('/login');
        $this->client->followRedirect();
    }

    public function testTaskListIsSuccess()
    {
        $this->logIn($this->client, $this->getUser('admin1'));

        $this->client->request('GET', '/tasks');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGETCreateTaskPageIsSuccess()
    {
        $this->logIn($this->client, $this->getUser('admin1'));

        $this->client->request('GET', '/tasks/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGETCreateTaskPageIsForbiddenAndRedirect()
    {
        $this->client->request('GET', '/tasks/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        static::assertResponseRedirects('/login');
        $this->client->followRedirect();
    }

    public function testPOSTCreateTaskIsSuccess()
    {
        $this->logIn($this->client, $this->getUser('admin1'));

        $crawler = $this->client->request('GET', '/tasks/create');
     
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Titre du task';
        $form['task[content]'] = 'Contenu du task';
     
        $this->client->submit($form);

        static::assertResponseRedirects('/tasks');
        $crawler = $this->client->followRedirect(); // Attention à bien récupérer le crawler mis à jour

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testPOSTUpdateTaskIsSuccess()
    {
        $anUser = $this->getUser('admin1'); 
        //Authentification
        $this->logIn($this->client, $anUser);
        
        //Recupération d'un task existant a modifier
        $RecupOneTask = $this->taskRepository->findOneBy(['author' => $anUser]);
        $this->assertNotNull($RecupOneTask);

        $crawler = $this->client->request('GET', '/tasks/'.$RecupOneTask->getId().'/edit');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
     
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Titre modifié';
        $form['task[content]'] = 'contenu modifié';
     
        $this->client->submit($form);

        static::assertResponseRedirects('/tasks');
        $crawler = $this->client->followRedirect(); // Attention à bien récupérer le crawler mis à jour

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testToggle()
    {
        $anUser = $this->getUser('admin1'); 
        //Authentification
        $this->logIn($this->client, $anUser);
        
        //Recupération d'un task existant a modifier
        $RecupOneTask = $this->taskRepository->findOneBy(['author' => $anUser]);
        $this->assertNotNull($RecupOneTask);

        $crawler = $this->client->request('GET', '/tasks/'.$RecupOneTask->getId().'/toggle');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        
        static::assertResponseRedirects('/tasks');
        $crawler = $this->client->followRedirect(); 
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testDeleteTaskIsSuccess()
    {
        $anUser = $this->getUser('admin1'); 
        //Authentification
        $this->logIn($this->client, $anUser);
        
        //Recupération d'un task existant a modifier
        $RecupOneTask = $this->taskRepository->findOneBy(['author' => $anUser]);
        $this->assertNotNull($RecupOneTask);

        $crawler = $this->client->request('GET', '/tasks/'.$RecupOneTask->getId().'/delete');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        
        static::assertResponseRedirects('/tasks');
        $crawler = $this->client->followRedirect(); // Attention à bien récupérer le crawler mis à jour
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testDeleteAnonymeTaskIsSuccessByAdmin()
    {
        $anUser = $this->getUser('admin1'); 
        //Authentification
        $this->logIn($this->client, $anUser);
        
        //Recupération d'un task existant a modifier
        $RecupOneTask = $this->taskRepository->findOneBy(['author' => null]);
        $this->assertNotNull($RecupOneTask);

        $crawler = $this->client->request('GET', '/tasks/'.$RecupOneTask->getId().'/delete');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        
        static::assertResponseRedirects('/tasks');
        $crawler = $this->client->followRedirect(); // Attention à bien récupérer le crawler mis à jour
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }

    public function testDeleteAnonymeTaskIsFaillureByUser()
    {
        $anUser = $this->getUser('user0'); 
        //Authentification
        $this->logIn($this->client, $anUser);
        
        //Recupération d'un task sans auteur
        $RecupOneTask = $this->taskRepository->findOneBy(['author' => null]);

        $this->assertNotNull($RecupOneTask);

        $crawler = $this->client->request('GET', '/tasks/'.$RecupOneTask->getId().'/delete');
        $this->assertSame(403, $this->client->getResponse()->getStatusCode());
        
    }

}
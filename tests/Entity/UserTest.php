<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    private $user;
    private $task;
    private $createdAt;

    public function setUp(): void
    {
        $this->user = new User();
        $this->task = new Task();
        $this->createdAt = new \DateTime();
    }

    public function testId()
    {
        self::assertEquals(null, $this->user->getId());
    }

    public function testUsername()
    {
        $this->user->setUsername('usertest');
        self::assertEquals('usertest', $this->user->getUsername());
    }
   
    public function testPassword()
    {
        $this->user->setPassword('usertestpassword');
        self::assertEquals('usertestpassword', $this->user->getPassword());
    }
    
    public function testEmail()
    {
        $this->user->setEmail('usertest@domain.fr');
        self::assertEquals('usertest@domain.fr', $this->user->getEmail());
    }

    public function testGetSalt()
    {
        self::assertEquals(null, $this->user->getSalt());
    }

    public function testAuthor()
    {
        $this->user->setRoles(['ROLE_USER']);
        self::assertEquals(array('0' => 'ROLE_USER'), $this->user->getRoles());
    }

    public function testEraseCredentials()
    {
        $user = $this->user;
        $this->user->eraseCredentials();
        self::assertEquals($user, $this->user);
    }

    public function testUserGetId()
    {
        self::assertEquals(null, $this->user->getId());
    }

    public function testGetTask():void 
    {
        //test add method
        $value = new Task();
        $response = $this->user->addTask($value);

        self::assertInstanceOf(User::class, $response);
        self::assertCount(1, $this->user->getTasks());
        self::assertTrue($this->user->getTasks()->contains($value));

        //test remove method
        $response = $this->user->removeTask($value);

        self::assertInstanceOf(User::class, $response);
        self::assertCount(0, $this->user->getTasks());
        self::assertFalse($this->user->getTasks()->contains($value));
    }
}

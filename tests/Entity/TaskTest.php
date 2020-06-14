<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{
    private $task;
    private $createdAt;
    private $author;

    public function setUp(): void
    {
        $this->task = new Task();
        $this->createdAt = new \DateTime();
        $this->author = new User();
    }

    public function testId()
    {
        self::assertEquals(null, $this->task->getId());
    }

    public function testCreatedAt()
    {
        $this->task->setCreatedAt(new \DateTime);

        self::assertEquals(date('Y-m-d H:i:s'), $this->task->getCreatedAt()->format('Y-m-d H:i:s'));
    }

 
    public function testTitle()
    {
        $this->task->setTitle('La dépression post natale chez les cervidés');
        self::assertEquals('La dépression post natale chez les cervidés', $this->task->getTitle());
    }
 
    public function testContent()
    {
        $this->task->setContent('Super contenu');
        self::assertEquals('Super contenu', $this->task->getContent());
    }

    public function testIsDone()
    {
        self::assertEquals(false, $this->task->IsDone());
    }

    public function testToggle()
    {
        self::assertEquals(false, $this->task->toggle(false)->IsDone());
    }

    public function testAuthor()
    {
        $userStub = $this->createMock(User::class);
        $this->task->setAuthor($userStub);
        self::assertEquals($userStub, $this->task->getAuthor());
    }

    public function testNoUser()
    {
        self::assertEquals('anonyme', $this->task->getAuthor());
    }

}

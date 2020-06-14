<?php

namespace App\Tests\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use App\Security\Voter\TaskVoter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class TaskVoterTest extends TestCase
{
    private $decisionManager;

    public function setUp(): void
    {
        $this->decisionManager = $this->CreateMock(AccessDecisionManagerInterface::class);
    }


    public function testVoteInvalidAttributes()
    {
        $task = new Task();
        $task = new Task();
        $this->decisionManager->method('decide')->willReturn(true);
        $voter = new TaskVoter($this->decisionManager);
        $tokenMock = $this->CreateMock(TokenInterface::class);
        $tokenMock->method('getUser')->willReturn($task);

        $result = $voter->vote($tokenMock, $task, array('TASK_TOTO'));

        static::assertEquals(false, $result);
    }

    public function testVoteInvalidSubject()
    {
        $task = new Task();

        $this->decisionManager->method('decide')->willReturn(true);
        $voter = new TaskVoter($this->decisionManager);
        $tokenMock = $this->CreateMock(TokenInterface::class);
        $tokenMock->method('getUser')->willReturn($task);

        $result = $voter->vote($tokenMock, $task, array('TASK_DELETE_ANONYME'));

        static::assertEquals('-1', $result);
    }


    public function testVoteInvalidToken()
    {
        $user = new User();

        $this->decisionManager->method('decide')->willReturn(true);
        $voter = new TaskVoter($this->decisionManager);
        $tokenMock = $this->CreateMock(TokenInterface::class);
        $tokenMock->method('getUser')->willReturn($user);

        $result = $voter->vote($tokenMock, $user, array('TASK_DELETE_ANONYME'));

        $this->assertEquals(false, $result);
    }
}
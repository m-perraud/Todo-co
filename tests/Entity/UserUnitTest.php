<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $user = new User();

        $user->setUsername('testuserphpunit')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('testuserphpunit')
            ->setEmail('testunit@test.fr');

        $this->assertTrue('testuserphpunit' === $user->getUsername());
        $this->assertTrue($user->getRoles() === ['ROLE_ADMIN', 'ROLE_USER']);
        $this->assertTrue('testuserphpunit' === $user->getPassword());
        $this->assertTrue('testunit@test.fr' === $user->getEmail());
        $this->assertTrue('testuserphpunit' === $user->getUserIdentifier());
    }

    public function testIsFalse(): void
    {
        $user = new User();

        $user->setUsername('testuserphpunit')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('testuserphpunit')
            ->setEmail('testunit@test.fr');

        $this->assertFalse('falseuserphpunit' === $user->getUsername());
        $this->assertFalse('ROLE_USER' == $user->getRoles());
        $this->assertFalse('falseuserphpunit' === $user->getPassword());
        $this->assertFalse('falsetestunit@test.fr' === $user->getEmail());
        $this->assertFalse('falseuserphpunit' === $user->getUserIdentifier());
    }

    public function testIsEmpty(): void
    {
        $user = new User();

        $this->assertEmpty($user->getId());
        $this->assertEmpty($user->getUsername());
        $this->assertEmpty([] === $user->getRoles());
        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getUserIdentifier());
        $this->assertNull($user->eraseCredentials());
    }

    public function testAddGetRemoveTaskAuthor()
    {
        $taskAuthor = new User();
        $task = new Task();

        $this->assertEmpty($task->getAuthor());

        $taskAuthor->addTaskAuthor($task);
        $this->assertSame($taskAuthor, $task->getAuthor());
        $this->assertContains($task, $taskAuthor->getTaskAuthor());

        $taskAuthor->removeTaskAuthor($task);
        $this->assertEmpty($task->getAuthor());
    }
}

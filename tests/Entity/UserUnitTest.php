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

        $this->assertTrue($user->getUsername() === 'testuserphpunit');
        $this->assertTrue($user->getRoles() === ['ROLE_ADMIN', 'ROLE_USER']);
        $this->assertTrue($user->getPassword() === 'testuserphpunit');
        $this->assertTrue($user->getEmail() === 'testunit@test.fr');
        $this->assertTrue($user->getUserIdentifier() === 'testuserphpunit');

    }

    public function testIsFalse(): void
    {
        $user = new User();

        $user->setUsername('testuserphpunit')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('testuserphpunit')
            ->setEmail('testunit@test.fr');

        $this->assertFalse($user->getUsername() === 'falseuserphpunit');
        $this->assertFalse($user->getRoles() === 'ROLE_USER');
        $this->assertFalse($user->getPassword() === 'falseuserphpunit');
        $this->assertFalse($user->getEmail() === 'falsetestunit@test.fr');
        $this->assertFalse($user->getUserIdentifier() === 'falseuserphpunit');

    }

    public function testIsEmpty(): void
    {
        $user = new User();

        $this->assertEmpty($user->getId());
        $this->assertEmpty($user->getUsername());
        $this->assertEmpty($user->getRoles() === []);
        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getUserIdentifier());
        $this->assertNull($user->eraseCredentials());


    }

    public function testAddGetRemoveTaskAuthor()
    {
        $taskAuthor = new User();
        $task = new Task();
        
        $this->assertEmpty($task->getAuthor());

        $taskAuthor->addTaskAuthor($taskAuthor);
        $this->assertContains($taskAuthor, $task->getAuthor());

        $taskAuthor->removeTaskAuthor($taskAuthor);
        $this->assertEmpty($task->getAuthor());

    }


}

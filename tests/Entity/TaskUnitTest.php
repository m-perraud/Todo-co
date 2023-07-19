<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $task = new Task();
        $dateTime = new \DateTime();
        $author = new User();

        $task->setCreatedAt($dateTime)
            ->setTitle('TestPHPUnit')
            ->setContent('Ceci est le contenu du test PHPUnit')
            ->setIsDone(true)
            ->setAuthor($author);

        $this->assertTrue($task->getCreatedAt() === $dateTime);
        $this->assertTrue('TestPHPUnit' === $task->getTitle());
        $this->assertTrue('Ceci est le contenu du test PHPUnit' === $task->getContent());
        $this->assertTrue(true === $task->isIsDone());
        $this->assertTrue($task->getAuthor() === $author);
    }

    public function testIsFalse()
    {
        $task = new Task();
        $dateTime = new \DateTime();
        $author = new User();

        $task->setCreatedAt($dateTime)
            ->setTitle('TestPHPUnit')
            ->setContent('Ceci est le contenu du test PHPUnit')
            ->setIsDone(true)
            ->setAuthor($author);

        $this->assertFalse($task->getCreatedAt() === new \DateTime());
        $this->assertFalse('FalseTestPHPUnit' === $task->getTitle());
        $this->assertFalse('False : Ceci est le contenu du test PHPUnit' === $task->getContent());
        $this->assertFalse(false === $task->isIsDone());
        $this->assertFalse($task->getAuthor() === new User());
    }

    public function testIsEmpty()
    {
        $task = new Task();

        $this->assertEmpty($task->getId());
        $this->assertEmpty($task->getCreatedAt());
        $this->assertEmpty($task->getTitle());
        $this->assertEmpty($task->getContent());
        $this->assertEmpty($task->isIsDone());
        $this->assertEmpty($task->getAuthor());
    }
}

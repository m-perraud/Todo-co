<?php

namespace App\Tests;

use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Form;

class TaskFunctionalTest extends WebTestCase
{
    public function testShouldDisplayTaskList(): void
    {
        $client = static::createClient();
        $client->request('GET', '/task');

        $this->assertResponseIsSuccessful();
    }

    public function testShouldDisplayTaskCreatePage(): void
    {
        $client = static::createClient();
        $user = static::getContainer()->get(UserRepository::class)->findOneByUsername('admin');
        $client->loginUser($user);

        $client->request('POST', '/task/create');
        $this->assertResponseIsSuccessful();
    }

    public function testShouldCreateTask(): void
    {
        $client = static::createClient();
        $user = static::getContainer()->get(UserRepository::class)->findOneByUsername('admin');
        $client->loginUser($user);

        $crawler = $client->request('GET', '/task/create');
        $this->assertInstanceOf(Form::class,
            $crawler->selectButton('Ajouter')->form());
        $client->submitForm('Ajouter', [
            'task[title]' => 'Test création',
            'task[content]' => 'Test contenu création',
            'task[isDone]' => 1,
        ]);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertRouteSame('task_list');
        $this->assertSelectorExists('div.alert.alert-success');
    }

    public function testShouldEditTask(): void
    {
        $client = static::createClient();
        $user = static::getContainer()->get(UserRepository::class)->findOneByUsername('admin');
        $client->loginUser($user);
        $task = $user->getTaskAuthor()->first();
        $taskId = $task->getId();

        $crawler = $client->request('GET', '/task/'.$taskId.'/edit');
        $this->assertRequestAttributeValueSame('id', $taskId);
        $this->assertInstanceOf(Form::class,
            $crawler->selectButton('Modifier')->form());
        $client->submitForm('Modifier', [
            'task[title]' => 'Test modif',
            'task[content]' => 'Test contenu modif',
            'task[isDone]' => 1,
        ]);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertRouteSame('task_list');
        $this->assertSelectorExists('div.alert.alert-success');
    }

    public function testTaskToggle(): void
    {
        $client = static::createClient();
        $user = static::getContainer()->get(UserRepository::class)->findOneByUsername('admin');
        $client->loginUser($user);
        $task = $user->getTaskAuthor()->first();
        $taskId = $task->getId();

        $client->request('GET', '/task/'.$taskId.'/toggle');
        $this->assertRequestAttributeValueSame('id', $taskId);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertRouteSame('task_list');
        $this->assertSelectorExists('div.alert.alert-success');
    }

    public function testShouldDeleteTaskUser(): void
    {
        $client = static::createClient();
        $user = static::getContainer()->get(UserRepository::class)->findOneByUsername('anonyme');
        $client->loginUser($user);
        $task = $user->getTaskAuthor()->first();
        $taskId = $task->getId();

        $client->request('GET', '/task/'.$taskId.'/delete');
        $this->assertRequestAttributeValueSame('id', $taskId);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertRouteSame('task_list');
        $this->assertSelectorExists('div.alert.alert-success');
    }

    /*
    public function testShouldDeleteTaskAdmin(): void
    {

        $client = static::createClient();
        $user = static::getContainer()->get(UserRepository::class)->findOneByUsername('admin');
        $task = static::getContainer()->get(TaskRepository::class)->findOneBy(['author' => 'anonyme']);
        $client->loginUser($user);
        //dd($task);
        $taskId = $task->getId();

        $client->request('GET', '/task/' . $taskId . '/delete');
        $this->assertRequestAttributeValueSame('id', $taskId);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertRouteSame('task_list');
        $this->assertSelectorExists('div.alert.alert-success');
    }
    */
}

<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Form;

class UserFunctionalTest extends WebTestCase
{
    public function testShouldDisplayUserCreatePage(): void
    {
        $client = static::createClient();
        $user = static::getContainer()->get(UserRepository::class)->findOneByUsername('admin');
        $client->loginUser($user);

        $client->request('POST', '/users/create');
        $this->assertResponseIsSuccessful();
    }

    public function testShouldCreateUser(): void
    {
        $client = static::createClient();
        $user = static::getContainer()->get(UserRepository::class)->findOneByUsername('admin');
        $client->loginUser($user);

        $crawler = $client->request('GET', '/users/create');
        $this->assertInstanceOf(Form::class,
            $crawler->selectButton('Ajouter')->form());
        $client->submitForm('Ajouter', [
            'user[username]' => 'Testcréauser',
            'user[password][first]' => 'testpassword',
            'user[password][second]' => 'testpassword',
            'user[email]' => 'testuser@test.fr',
            'user[isAdmin]' => true,
        ]);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertRouteSame('user_list');
        $this->assertSelectorExists('div.alert.alert-success');
    }

    public function testShouldEditUser(): void
    {
        $client = static::createClient();
        $user = static::getContainer()->get(UserRepository::class)->findOneByUsername('Testcréauser');
        $client->loginUser($user);
        $userId = $user->getId();

        $crawler = $client->request('GET', '/users/'.$userId.'/edit');
        $this->assertRequestAttributeValueSame('id', $userId);
        $this->assertInstanceOf(Form::class,
            $crawler->selectButton('Modifier')->form());
        $client->submitForm('Modifier', [
            'user[username]' => 'Testcréauser1',
            'user[password][first]' => 'testpassword',
            'user[password][second]' => 'testpassword',
            'user[email]' => 'testuser1@test.fr',
            'user[isAdmin]' => true,
        ]);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertRouteSame('user_list');
        $this->assertSelectorExists('div.alert.alert-success');
    }
}

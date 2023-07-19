<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginFunctionalTest extends WebTestCase
{
    public function testShouldDisplayLoginPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
    }

    public function testVisitingWhileLoggedIn(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $client->followRedirects();

        $client->submitForm('se_connecter', [
            '_username' => 'admin',
            '_password' => 'AppFixturesPass',
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testInvalidCredentials(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $client->followRedirects();

        $client->submitForm('se_connecter', [
            '_username' => 'admin',
            '_password' => 'admin',
        ]);

        $this->assertRouteSame('app_login');
    }
}

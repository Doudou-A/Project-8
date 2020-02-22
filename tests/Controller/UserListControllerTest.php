<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserListControllerTest extends WebTestCase
{
    public function testListAction()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'password',
        ]);

        $crawler = $client->request('GET', '/users');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('html:contains("Liste des utilisateurs")')->count());
    }
}
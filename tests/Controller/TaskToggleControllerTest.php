<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskToggleControllerTest extends WebTestCase
{
    public function testTaskToggleNoDoneAction()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'password',
        ]);

        $client->request('GET', '/tasks/5/toggle');

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("a bien été marquée comme faite.")')->count());     
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testTaskToggleIsDoneAction()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'password',
        ]);

        $client->request('GET', '/tasks/36/toggle');

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("a bien été marquée comme non faite.")')->count());     
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}
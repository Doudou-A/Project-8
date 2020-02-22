<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskListControllerTest extends WebTestCase
{
    public function testListTaskAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('html:contains("Liste des toutes les tâches")')->count());
    }
}
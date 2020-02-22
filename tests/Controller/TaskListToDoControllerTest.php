<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskListToDoControllerTest extends WebTestCase
{
    public function testListToDoTaskAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks-ToDo');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('html:contains("Liste des tâches à faire")')->count());
    }
}
<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskListFinishControllerTest extends WebTestCase
{
    public function testListFinishTaskAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tasks-finish');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('html:contains("Liste des tâches terminées")')->count());
    }
}
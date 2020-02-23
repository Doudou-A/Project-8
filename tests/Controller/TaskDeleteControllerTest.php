<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskDeleteControllerTest extends WebTestCase
{
    public function testDeleteTaskAction()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'password',
        ]);

        $client->request('GET', '/tasks/5/delete');

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("La tâche a bien été supprimée !")')->count());     
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteUserTaskAction()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'adel',
            'PHP_AUTH_PW'   => 'password',
        ]);

        $client->request('GET', '/tasks/5/delete');

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains(" Vous n\'êtes pas autorisé à supprimer la tâche")')->count());     
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}
<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    public function testHomepageIsUp()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !")')->count());
    }
}
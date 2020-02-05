<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHomepageIsUp()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testHomePage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
    }

    public function testAddNewUser()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form(); 

        $form['user[username]'] = 'AdYehh';
        $form['user[email]'] = 'emailName';
        $form['user[password]'] = 'password';
        $form['user[roles]'] = 'role_admin';

        $client->submit($form);

        $client->followRedirect();

        echo $client->getResponse()->getContent();
    }  
}
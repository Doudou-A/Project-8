<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserCreateControllerTest extends WebTestCase
{
    public function testAddNewUser()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'password',
        ]);

        $crawler = $client->request('GET', '/users/create');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('html:contains("Créer un utilisateur")')->count());

        $form = $crawler->selectButton('Ajouter')->form(); 

        $form['user[username]'] = 'Username';
        $form['user[email]'] = 'Email@gmail.com';
        $form['user[password]'] = 'password';
        $form['user[roles][0]'] = 'ROLE_ADMIN';

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("L\'utilisateur ajouté avec succès !")')->count()); 

    }
}
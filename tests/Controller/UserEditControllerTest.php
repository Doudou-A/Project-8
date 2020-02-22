<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserEditControllerTest extends WebTestCase
{
    public function testEditAction()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'password',
        ]);

        $crawler = $client->request('GET', '/users/1/edit');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('html:contains("Modifier")')->count());

        $form = $crawler->selectButton('Modifier')->form(); 
            
        $form['user[username]'] = 'admin';
        $form['user[email]'] = 'admin@gmail.com';
        $form['user[password]'] = 'password';
        $form['user[roles][0]'] = 'ROLE_ADMIN';
        
        $client->submit($form);
        
        $crawler = $client->followRedirect();

        /* echo $client->getResponse()->getContent(); */ 
        $this->assertSame(1, $crawler->filter('html:contains("L\'utilisateur a bien été modifié")')->count());   
    }
}
<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskEditControllerTest extends WebTestCase
{
    public function testTaskEditAction()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'password',
        ]);

        $crawler = $client->request('GET', '/tasks/5/edit');

        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertSame(1, $crawler->filter('html:contains("Modifier")')->count());

        $form = $crawler->selectButton('Modifier')->form(); 
            
        $form['task[createAt][month]'] = '2';
        $form['task[createAt][year]'] = '2022';
        $form['task[createAt][day]'] = '22';
        $form['task[title]'] = 'test title';
        $form['task[content]'] = 'test content';
        
        $client->submit($form);
        
        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("La tâche a été bien été modifiée !")')->count());    
    }
}
<?php

namespace App\Tests\Entity;

require('vendor/autoload.php');

use DateTime;
use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testCreateAt()
    {
        $task = new Task();
        $dateTime = new DateTime("10:01:00");

        $task->setCreateAt($dateTime);
        $this->assertEquals(new DateTime("10:01:00"), $task->getCreateAt());
    }
    
    public function testTitle()
    {
        $task = new Task();
        $title = "Test";
        
        $task->setTitle($title);
        $this->assertEquals("Test", $task->getTitle());
    }

    public function testContent()
    {
        $task = new Task();
        $content = "Test 1";
        
        $task->setContent($content);
        $this->assertEquals("Test 1", $task->getContent());
    }

    public function testIsDone()
    {
        $task = new Task();
        $isDone = true;
        
        $task->setIsDone($isDone);
        $this->assertEquals(true, $task->getIsDone());
    }

    public function testUser()
    {
        $task = new Task();
        $user = new User();
        $task->setUser($user);
        
        $this->assertEquals(new User(), $task->getUser());
    }  
}
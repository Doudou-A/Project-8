<?php

namespace App\Tests\Entity;

require('vendor/autoload.php');

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ArrayCollection;

class UserTest extends TestCase
{
    public function testId()
    {
        $user = new User();

        $this->assertEquals(null, $user->getId());
    }

    public function testUsername()
    {
        $user = new User();
        $username = "Test";

        $user->setUsername($username);
        $this->assertEquals("Test", $user->getUsername());
    }

    public function testEmail()
    {
        $user = new User();
        $email = "Test 1";

        $user->setEmail($email);
        $this->assertEquals("Test 1", $user->getEmail());
    }

    public function testRoles()
    {
        $user = new User();
        $roles= ["ROLE_TEST"];

        $user->setRoles($roles);

        $this->assertEquals("ROLE_TEST", $user->getRoles()[0]);
    }

    public function testPassword()
    {
        $user = new User();
        $password= "PasswordTest";

        $user->setPassword($password);

        $this->assertEquals("PasswordTest", $user->getPassword());
    }

    public function testGetSalt()
    {
        $user = new User();

        $this->assertEquals(null, $user->getSalt());
    }

    public function testEraseCredentialst()
    {
        $user = new User();

        $this->assertEquals(null, $user->eraseCredentials());
    }

    public function testTaskAdd()
    {
        $task = new Task();
        $user = new User();

        $user->addTask($task);

        $this->assertEquals($user, $task->getUser());
    }   

    public function testTaskRemove()
    {
        $task = new Task();
        $user = new User();

        $user->addTask($task);
        $user->removeTask($task);

        $this->assertEquals(null, $task->getUser());
    }  
    
    public function testGetTask()
    {
        $user = new User();
        $tasks = new ArrayCollection();

        $this->assertEquals($tasks, $user->getTasks());
    }  
}

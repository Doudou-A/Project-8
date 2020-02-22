<?php

namespace App\Service;

use App\Entity\Task;
use App\Form\UserType;
use App\Repository\TaskRepository;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    private $encoder;
    private $manager;
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->formFactory = $formFactory;
        $this->manager = $manager;
    }

    public function create($user)
    {
        $this->encode($user);

        $this->persist($user);
    }

    public function edit($user)
    {
        $this->encode($user);

        $this->persist($user);
    }

    public function encode($user)
    {
        $password = $this->encoder->encodePassword($user, $user->getPassword());

        $user->setPassword($password);

    }

    public function form($user, $request)
    {
        $form = $this->formFactory->create(UserType::class, $user);

        $form->handleRequest($request);

        return $form;
    }

    public function persist($entity)
    {
        $this->manager->persist($entity);
        $this->manager->flush();
    }

}
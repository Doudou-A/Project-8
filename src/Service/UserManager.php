<?php

namespace App\Service;

use App\Entity\Task;
use App\Form\TaskType;
use App\Form\UserType;
use App\Repository\TaskRepository;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;

class UserManager
{
    private $encoder;
    private $container;
    private $manager;
    private $repo;
    private $request;
    private $formFactory;

    public function __construct(ContainerInterface $container, FormFactoryInterface $formFactory, EntityManagerInterface $manager, TaskRepository $repo, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->container = $container;
        $this->formFactory = $formFactory;
        $this->manager = $manager;
        $this->repo = $repo;
        $this->request = $request;
    }

    public function addFlash($type, $message)
    {
        $this->container->get('session')->getFlashBag()->add($type, $message);
    }

    public function create($user)
    {
        $this->encode($user);

        $this->persist($user);

        $this->addFlash('success', 'L\'utilisateur ajouté avec succès !');
    }

    public function edit($user)
    {
        $this->encode($user);

        $this->persist($user);

        $this->addFlash('success', "L'utilisateur a bien été modifié");
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
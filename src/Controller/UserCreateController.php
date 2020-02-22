<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserCreateController extends AbstractController
{
    /**
     * @Route("/users/create", name="user_create")
     */
    public function createAction(Request $request, UserManager $userManager)
    {
        $user = new User();

        $form = $userManager->form($user, $request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $userManager->create($user);

            $this->addFlash('success', 'L\'utilisateur ajouté avec succès !');

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['formUser' => $form->createView()]);
    }
}
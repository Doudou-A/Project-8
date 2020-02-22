<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserEditController extends AbstractController
{
    /**
     * @Route("/users/{id}/edit", name="user_edit")
     */
    public function editUserAction(User $user, Request $request, UserManager $userManager)
    {
        $form = $userManager->form($user, $request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userManager->edit($user);

            $this->addFlash('success', "Utilisateur modifié avec succès !");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}

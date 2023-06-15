<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function formUser(UserPasswordHasherInterface $userPasswordHasher, Request $request, EntityManagerInterface $manager, User $user = null)
    {
        if ($user == null) {
            $user = new User;
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setDateEnregistrement(new \DateTime);

            if (!$user->getId()) {
                // Hasher le mot de passe uniquement lors de l'ajout d'un nouvel utilisateur
                $hashedPassword = $userPasswordHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($hashedPassword);
            }

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', "L'utilisateur a bien été enregistré");
            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/addUsers.html.twig', [
            'form' => $form->createView(),
            'editUser' => $user->getId() !== null
        ]);
    }
}

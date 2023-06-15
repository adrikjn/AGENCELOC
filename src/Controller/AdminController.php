<?php

namespace App\Controller;

use Datetime;
use App\Entity\User;
use App\Form\UserType;
use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\UserRepository;
use App\Repository\CommandeRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/admin/vehicule', name: 'admin_vehicule')]
    public function adminVehicule(VehiculeRepository $repo, EntityManagerInterface $manager){
        $vehicules = $repo->findAll();
        
        return $this->render('admin/gestionVehicules.html.twig', [
            'vehicules' => $vehicules
        ]);
    }

    #[Route('/admin/vehicule/see/{id}', name: "admin_vehicule_see")]
    public function seeVehicule(Vehicule $vehicule){
        return $this->render('admin/seeVehicule.html.twig', [
            'vehicule' => $vehicule
        ]);
    }

    #[Route('/admin/vehicule/edit/{id}', name: 'admin_vehicule_edit')]
    #[Route('/admin/vehicule/new', name: 'admin_vehicule_new')]
    public function formVehicule(Request $request, EntityManagerInterface $manager, Vehicule $vehicule = null){

        if($vehicule == null){
            $vehicule = new Vehicule;
        }

        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $vehicule->setDateEnregistrement(new \Datetime);
            $manager->persist($vehicule);
            $manager->flush();
            $this->addFlash('success', 'La voiture a bien été enregistré');
            return $this->redirectToRoute('admin_vehicule');
        }

        return $this->render('admin/addVehicule.html.twig', [
            'form' => $form,
            'edit' => $vehicule->getId()!==null
        ]);
    }

    #[Route('/admin/vehicule/delete/{id}', name: "admin_vehicule_delete")]
    public function deleteVehicule(Vehicule $vehicule, EntityManagerInterface $manager){
        $manager->remove($vehicule);
        $manager->flush();
        $this->addFlash('success', "L'article a bien été supprimé");
        return $this->redirectToRoute("admin_vehicule");
    }

    #[Route('/admin/users', name: 'admin_users')]
    public function adminUser(UserRepository $repo, EntityManagerInterface $manager){
        $users = $repo->findAll();
        
        return $this->render('admin/gestionUsers.html.twig', [
            'users' => $users
        ]);
    }


    #[Route('/admin/users/edit/{id}', name: 'admin_users_edit')]
    #[Route('/admin/users/new', name: 'admin_users_new')]
    public function formUser(UserPasswordHasherInterface $userPasswordHasher, Request $request, EntityManagerInterface $manager, User $user = null){

        if($user == null){
            $user = new User;
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user->setDateEnregistrement(new \Datetime);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', "L'utilisateur a bien été enregistré");
            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/addUsers.html.twig', [
            'form' => $form,
            'editUser' => $user->getId()!==null
        ]);
    }
    
    #[Route('/admin/user/delete/{id}', name: "admin_user_delete")]
    public function deleteUser(User $user, EntityManagerInterface $manager){
        $manager->remove($user);
        $manager->flush();
        $this->addFlash('success', "L'utilisateur a bien été supprimé");
        return $this->redirectToRoute("admin_users");
    }

    #[Route('/admin/user/see/{id}', name: "admin_user_see")]
    public function seeUser(User $user){
        return $this->render('admin/seeUser.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/admin/commandes', name: 'admin_commandes')]
    public function adminCommandes(CommandeRepository $repo, EntityManagerInterface $manager){
        $commandes = $repo->findAll();
        // dd($commandes);
        
        return $this->render('admin/gestionCommandes.html.twig', [
            'commandes' => $commandes
        ]);
    }
}




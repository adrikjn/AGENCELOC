<?php

namespace App\Controller;

use Datetime;
use App\Entity\Vehicule;
use App\Form\VehiculeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
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
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/addVehicule.html.twig', [
            'form' => $form,
            // 'editMode' => $vehicule->getId()!==null
        ]);
    }
}

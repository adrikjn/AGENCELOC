<?php

namespace App\Controller;

use Datetime;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    #[Route('/', name: 'app_app')]
    public function index(VehiculeRepository $repo, EntityManagerInterface $manager): Response
    {
        $vehicules = $repo->findAll();
        return $this->render('app/index.html.twig', [
            'vehicules' => $vehicules
        ]);
    }

    #[Route('/commander', name:'command')]
    public function commanderVehicule(Request $request, EntityManagerInterface $manager){
        $commande = new Commande;

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $commande->setDateEnregistrement(new Datetime);
            $manager->persist($commande);
            $manager->flush();
            $this->addFlash('success', "Votre commande a bien été pris");
            return $this->redirectToRoute('app_app');
        }

        return $this->render('app/addCommande.html.twig', [
            'form' => $form
        ]);
    }
}

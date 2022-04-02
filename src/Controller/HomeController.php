<?php

namespace App\Controller;

use App\Entity\VisitorsMessage;
use App\Form\VisitorMessageType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        Request $request,
        EntityManagerInterface $manager // EntityManager : Permet de manipuler nos entités ;

    ): Response
    {
        $message = new VisitorsMessage();

        // On va spécifier une autre route pour la soumission du formualaire
        $form = $this->createForm(VisitorMessageType::class, $message);

        // SI le formulaire comporte le formulaire complété, il va mettre à jour la variable $message
        $form->handleRequest($request);
        
        // On s'assure que le form est soumis et qu'il est valide
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($message);
            $manager->flush();
            return $this->redirectToRoute("home");
        }
        return $this->render('home/index.html.twig',  [
            "formMessage" => $form->createView()
            //'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
      return $this->render('home/about.html.twig', [
            'controller_name' => 'test',
        ]);
    }

   
}

<?php

namespace App\Controller;

use App\Entity\VisitorsMessage;
use Doctrine\ORM\EntityManager;
use App\Form\VisitorMessageType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\mailer;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        Request $request,

    ): Response
    {
        $message = new VisitorsMessage();

        // On va spécifier une autre route pour la soumission du formualaire
        $form = $this->createForm(VisitorMessageType::class, $message, [
            "action"=>$this->generateUrl("home_visitor_message_post")
        ]);

        
        return $this->render('home/index.html.twig',  [
            "formMessage" => $form->createView()
            //'controller_name' => 'HomeController',
        ]);
    }

    
    #[Route('/visitor-message/post', name:'home_visitor_message_post', methods:'POST') ]
    public function postVisitorMessageAjax(
        Request $request,
        MailerInterface $mailer,
        EntityManagerInterface $manager // EntityManager : Permet de manipuler nos entités ;
    ):Response
    {

        $message = new VisitorsMessage();

        // On va spécifier une autre route pour la soumission du formualaire
        $form = $this->createForm(VisitorMessageType::class, $message, [
            "action"=>$this->generateUrl("home_visitor_message_post")
        ]);

        // SI le formulaire comporte le formulaire complété, il va mettre à jour la variable $message
        $form->handleRequest($request);
        
        // On s'assure que le form est soumis et qu'il est valide
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($message);
            $manager->flush();
            // Renvoyer la réponse en JSON
            $email = (new Email())


            
                ->from('nepasrepondre@bella.com')
                ->to('admin.labela@labela.com')
                ->subject('Nouveau message sur le backoffice')
                ->html('<p>Veuillez vous connecter au <a href="http://labelabusiness.herokuapp.com/admin">Backoffice</a> pour y répondre</p>'); //chemin vers admin
            $mailer->send($email);

        return $this->json([
            "message"   => "Votre message a bien été envoyé, Merci!"
        ],
            Response::HTTP_OK); 
        }
        // Renvoyer la réponse en JSON
        return $this->json([
            "message"   => "Votre message n'a pas pu etre envoyé!"
        ],
            Response::HTTP_BAD_REQUEST); 
    }

    

    

    #[Route('/about', name: 'app_about', methods:['GET'])]
    public function about(): Response
    {
      return $this->render('home/about.html.twig', [
            'controller_name' => 'test',
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(
        Request $request,
        //EntityManagerInterface $manager // EntityManager : Permet de manipuler nos entités ;

    ): Response
    {
        $message = new VisitorsMessage();

        

        // On va spécifier une autre route pour la soumission du formualaire
        $form = $this->createForm(VisitorMessageType::class, $message);

        /// On va spécifier une autre route pour la soumission du formualaire
        $form = $this->createForm(VisitorMessageType::class, $message, [
            "action"=>$this->generateUrl("home_visitor_message_post")
        ]);
        return $this->render('home/contact.html.twig',  [
            "formMessage" => $form->createView()
            //'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/contact-message/post', name:'contact_visitor_message_post', methods:'POST') ]
    public function postContactMessageAjax(
        Request $request,
        EntityManagerInterface $manager // EntityManager : Permet de manipuler nos entités ;
    ):Response
    {

        $message = new VisitorsMessage();

        // On va spécifier une autre route pour la soumission du formualaire
        $form = $this->createForm(VisitorMessageType::class, $message, [
            "action"=>$this->generateUrl("contact_visitor_message_post")
        ]);

        // SI le formulaire comporte le formulaire complété, il va mettre à jour la variable $message
        $form->handleRequest($request);
        
        // On s'assure que le form est soumis et qu'il est valide
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($message);
            $manager->flush();
            // Renvoyer la réponse en JSON
        return $this->json([
            "message"   => "Votre message a bien été envoyé, Merci!"
        ],
            Response::HTTP_OK); 
        }
        // Renvoyer la réponse en JSON
        return $this->json([
            "message"   => "Votre message n'a pas pu etre envoyé!"
        ],
            Response::HTTP_BAD_REQUEST); 
    }

    #[Route('/services', name: 'app_services')]
    public function services(
        Request $request,
        //EntityManagerInterface $manager // EntityManager : Permet de manipuler nos entités ;

    ): Response
    {
        $message = new VisitorsMessage();

        

        // On va spécifier une autre route pour la soumission du formualaire
        $form = $this->createForm(VisitorMessageType::class, $message);

        /// On va spécifier une autre route pour la soumission du formualaire
        $form = $this->createForm(VisitorMessageType::class, $message, [
            "action"=>$this->generateUrl("home_visitor_message_post")
        ]);
        return $this->render('home/services.html.twig',  [
            "formMessage" => $form->createView()
            //'controller_name' => 'HomeController',
        ]);
    }
    
   /* #[Route('/services', name: 'app_services')]
    public function services(
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
            return $this->redirectToRoute("app_services");
        }
        return $this->render('home/services.html.twig',  [
            "formMessage" => $form->createView()
            //'controller_name' => 'HomeController',
        ]);
    }*/
    #[Route('/services-message/post', name:'services_visitor_message_post', methods:'POST') ]
    public function postServicesMessageAjax(
        Request $request,
        EntityManagerInterface $manager // EntityManager : Permet de manipuler nos entités ;
    ):Response
    {

        $message = new VisitorsMessage();

        // On va spécifier une autre route pour la soumission du formualaire
        $form = $this->createForm(VisitorMessageType::class, $message, [
            "action"=>$this->generateUrl("services_visitor_message_post")
        ]);

        // SI le formulaire comporte le formulaire complété, il va mettre à jour la variable $message
        $form->handleRequest($request);
        
        // On s'assure que le form est soumis et qu'il est valide
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($message);
            $manager->flush();
            // Renvoyer la réponse en JSON
        return $this->json([
            "message"   => "Votre message a bien été envoyé, Merci!"
        ],
            Response::HTTP_OK); 
        }
        // Renvoyer la réponse en JSON
        return $this->json([
            "message"   => "Votre message n'a pas pu etre envoyé!"
        ],
            Response::HTTP_BAD_REQUEST); 
    }


   
}

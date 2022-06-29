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

    /**
     * @return void
     * @Route("/visitor-message/post", name="home_visitor_message_post", methods={"GET", "POST"})
     */
    public function postVisitorMessageAJAX(
        Request $request,
        EntityManagerInterface $manager,
        MailerInterface $mailer
    ):Response
    {

        $message = new VistorMessage();

        // On va spécifier une autre route pour la soumission du formualaire
        $form = $this->createForm( VisitorMessageType::class, $message, [
            "action" => $this->generateUrl("home_visitor_message_post")
        ] );


        // SI le formulaire comporte le formulaire complété, il va mettre à jour la variable $message
        $form->handleRequest($request);

        // ON s'assure que le form est soumis et qu'il est valide
        if( $form->isSubmitted() && $form->isValid() ){
            $manager->persist($message);
            $manager->flush();

            $email = new Email();


            $email
                ->from("nepasrepondre@bella.com")
                ->to("devdemalade@outlook.fr")
                ->subject("Un message vous attend sur BellaFinance")
                ->html('<p>Vous avez reçu un email sur BellaFinance</p>');
            $mailer->send($email);



            // Renvoyer la réponse en JSON
            return $this->json([
                "message"   => "Votre message a bien été envoyé, Merci!"
            ],
                Response::HTTP_OK);
        }

        // Renvoyer la réponse en JSON
        return $this->json([
            "message"   => "Votre message n'a pas pu être envoyé!"
        ],
        Response::HTTP_BAD_REQUEST);
    }

    

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
      return $this->render('home/about.html.twig', [
            'controller_name' => 'test',
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(
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
            return $this->redirectToRoute("app_contact");
        }
        return $this->render('home/contact.html.twig',  [
            "formMessage" => $form->createView()
            //'controller_name' => 'HomeController',
        ]);
    }
    
    #[Route('/services', name: 'app_services')]
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
    }


   
}

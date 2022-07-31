<?php

namespace App\Controller;

use App\Entity\VisitorEmailResponse;
use App\Entity\VisitorsMessage;
use App\Form\VisitorEmailResponseType;
use App\Repository\VisitorEmailResponseRepository;
use App\Repository\VisitorRequestRepository;
use App\Repository\VisitorsMessageRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @isGranted("ROLE_USER")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(
        VisitorsMessageRepository $vistorMessageRepository
    ): Response
    {
        
        $messages = $vistorMessageRepository->findBy(["isArchived" => false]);

        return $this->render('admin/index.html.twig', [
            "visitorMessages"      => $messages,
            "isArchive"            => false
        ]);
    }

    /**
     * @Route("/admin/archived", name="admin_vmess_archived")
     */
    public function archivedMessage(
        VisitorsMessageRepository $vistorMessageRepository
    ): Response
    {

        $messages = $vistorMessageRepository->findBy(["isArchived" => true]);

        return $this->render('admin/index.html.twig', [
            "visitorMessages"      => $messages,
            "isArchive"            => true
        ]);
    }



    /**
     * @param VistorMessage $message
     * @param VistorMessageRepository $messageRepository
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @Route("/admin/visitor-message/{id}/delete", name="admin_vmess_delete")
     */
    public function deleteVisitorMessageAjax(
        VisitorsMessage $message,
        VisitorsMessageRepository $messageRepository
    ):Response
    {
        // Le repository supprime le message avec ->remove($message)
        $messageRepository->remove($message);

        // On renvoie une réponse au format JSON
        return $this->json([
            "status"    => "Effacé",
            "message"   => "Le message a été effacé!"
        ]);
    }



    /**
     * @param VistorMessage $message
     * @param VistorMessageRepository $messageRepository
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @Route("/admin/visitor-message/{id}/archive", name="admin_vmess_archive")
     */
    public function archiveVisitorMessageAjax(
        VisitorsMessage $message,
        VisitorsMessageRepository $messageRepository
    ):Response
    {
        $message->setIsArchived(true);
        // Le repository sauvegarde le message en base
        $messageRepository->add($message);

        // On renvoie une réponse au format JSON
        return $this->json([
            "status"    => "Archivé",
            "message"   => "Le message a été archivé!"
        ]);
    }


    /**
     * @param VistorMessage $message
     * @param VistorMessageRepository $messageRepository
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @Route("/admin/visitor-message/{id}/unarchive", name="admin_vmess_unarchive")
     */
    public function unarchiveVisitorMessageAjax(
        VisitorsMessage $message,
        VisitorsMessageRepository $messageRepository
    ):Response
    {
        $message->setIsArchived(false);
        // Le repository sauvegarde le message en base
        $messageRepository->add($message);

        // On renvoie une réponse au format JSON
        return $this->json([
            "status"    => "Désarchivé",
            "message"   => "Le message a été restoré!"
        ]);
    }

    /**
     * @param MailerInterface $mailer
     * @return RedirectResponse
     * @Route("/admin/email", name="email_test")
     */
    public function test( MailerInterface $mailer )
    {

        // On instancie la classe email
        $email = new Email();


        $email  ->from('nepasrepondre_devdeouf@gmail.com')
                ->to('devdemalade@outlook.fr')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Vous avez un message!!')
                ->text('Sending emails is fun again!')
                ->html('<p>See Twig integration for better HTML integration!</p>');
                
        $this->mailer->send($email);

        return $this->redirectToRoute("admin");

    }


    /**
     * @param MailerInterface $mailer
     * @param VisitorsMessage $visitorsMessage
     * @param Request $request
     * @return Response
     * @Route ("/admin/visitor-message/{id}/send/email", name="admin_vmess_send_email")
     */
    public function sendEmailToVisitor(
        MailerInterface $mailer,
        VisitorsMessage $visitorsMessage,
        Request $request,
        VisitorEmailResponseRepository $emailResponseRepository
    ){
        // Nous allons créer la réponse
        $response = new VisitorEmailResponse( $visitorsMessage );
        $response->setSubject( "Re: ".$visitorsMessage->getSubject() );

        // Nous allons créer un formulaire de réponse
        $form = $this->createForm( VisitorEmailResponseType::class, $response );

        // On va remplir l'entité avec le contenu posté de la requête
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ){
            $response->setCreatedAt( new \DateTimeImmutable("now"));
            $emailResponseRepository->add($response);

            $email = (new Email())


            
                ->from('nepasrepondre@bella.com')
                ->to($visitorsMessage->getEmail())
                ->subject($response->getSubject())
                ->html('<p>'.$response->getContent().'</p>');
            $this->mailer->send($email);


            return $this->redirectToRoute( "admin" );
        }

        return $this->render("admin/send_email.html.twig", [
            "message"   => $visitorsMessage,
            "form"   => $form->createView()
        ]);

    }


}
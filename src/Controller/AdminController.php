<?php

namespace App\Controller;

use App\Repository\VisitorMessageRepository;
use Doctrine\ORM\Mapping\Id;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    
    #[IsGranted("ROLE_USER")]
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/visitor/message', name: 'admin_visitor_message')]
    public function visitorMessages (VisitorMessageRepository $repo) 
    {
        $messages  = $repo->findAll();

        return $this->render('admin/visitor_message.html.twig', [
            "visitorMessages" => $messages,
            "lastMessage" => $repo->findOneBy([],['id'=>'DESC'])
            
        ]);

    }
}

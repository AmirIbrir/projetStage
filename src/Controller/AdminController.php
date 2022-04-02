<?php

namespace App\Controller;


use App\Repository\VisitorsMessageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



/**
 * @IsGranted("ROLE_USER")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(
        VisitorsMessageRepository $visitorsMessageRepository
    ): Response
    {
        
        $messages = $visitorsMessageRepository->findAll();

        return $this->render('admin/index.html.twig', [
            "messages" => $messages
        ]);
    }


}
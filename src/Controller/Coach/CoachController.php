<?php

namespace App\Controller\Coach;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachController extends AbstractController
{
    /**
         * @Route("/coach", name="coach")
     */
    public function index(): Response
    {
        return $this->render('coach/reset.html.twig', [
            'controller_name' => 'CoachController',
        ]);
    }
}

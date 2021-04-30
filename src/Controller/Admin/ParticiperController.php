<?php

namespace App\Controller\Admin;

use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticiperController extends AbstractController
{
    /**
     * @Route("/participer", name="participer")
     */
    public function index(): Response
    {
        return $this->render('admin/participer/index.html.twig', [
            'controller_name' => 'ParticiperController',
        ]);
    }

    /**
     * @param ParticipantRepository $repository
     * @return Response
     * @Route("/AfficheParticipant",name="AfficheParticipant")
     */
    public function affiche(ParticipantRepository $repository){
        //  $repository=$this->getDoctrine()->getRepository(Participant::class);
        $participant=$repository->findAll();
        return $this->render('admin/participer/index.html.twig',
            ['participant'=>$participant]);

    }




}

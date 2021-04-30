<?php

namespace App\Controller\Client;

use App\Repository\formationRepository;
use App\Repository\participantsRepository;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesformationController extends AbstractController
{
    /**
     * @Route("/mesformation", name="mesformation")
     */
    public function index(): Response
    {
        return $this->render('mesformation/index.html.twig', [
            'controller_name' => 'MesformationController',
        ]);
    }

    /**
     * @param formationRepository $repo
     * @return Response
     * @Route ("/client/mesformation",name="mesforma")
     */
    public function Afficheformation(formationRepository $repo){
        $user= $this->getUser();




        $formation = $repo->mesformations($user->getId());//het l id ye 3ajngui


        return $this->render('client/formationclient/MesFormation.html.twig',
            ['mesformation'=>$formation]);

    }

    /**
     * @param formationRepository $repo
     * @param $id
     * @return Response
     * @Route ("client/mesformation/detail/{id}",name="detail")
     */
    public function Afficheformation_detail(formationRepository $repo,$id,participantsRepository $rpp){
        $formation = $repo->find($id);//het l id ye 3ajngui
        $participant=$rpp->findBy(['idformation'=>$id]);




        return $this->render('client/formationclient/Formation_detail.html.twig',
            ['formationdetail'=>$formation,
                'part'=>$participant]);


    }
}

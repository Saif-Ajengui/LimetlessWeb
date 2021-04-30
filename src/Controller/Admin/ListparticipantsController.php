<?php

namespace App\Controller\Admin;

use App\Entity\Participants;
use App\Entity\Utilisateur;
use App\Form\ParticipantsType;
use App\Repository\formationRepository;
use App\Repository\participantsRepository;
use App\Repository\utilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListparticipantsController extends AbstractController
{
    /**
     * @Route("/listparticipants", name="listparticipants")
     */
    public function index(): Response
    {
        return $this->render('listparticipants/index.html.twig', [
            'controller_name' => 'ListparticipantsController',
        ]);
    }

 //   /**
 //    * @return Response
 //    * @Route ("admin/listparticipantst",name="listPtee")
 //    */
 //   public function tableParticipant()
//    {
   //     return $this->render('admin/participants/tableparticipant.html.twig');
   // }

    /**
     * @param Request $request

     * @param participantsRepository $prep
     * @param formationRepository $frep
     * @return Response
     * @Route ("admin/listparticipantst",name="listPt")
     */
    public function testformation(Request $request,participantsRepository $prep,formationRepository $frep)
    {
        $part =new Participants();
        $form=$this->createForm(ParticipantsType::class,$part);

        $form->add('affff',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            return $this->redirectToRoute('listPt');
        }

        //$participant=$prp->findAll();

       // $u = $form["idformation"]->getData();

        $participant=$prep->listpartici(3);


        //$formations=$frep->find(3);
        //$participant=$prep->listparticipantparformation() ;
        //$utilisateree = $this->getDoctrine()->getRepository(Participants::class)->findBy(['id'=>$participant]) ;
       // $utilisater=$prp->findByidUtilisateur($participant);
        //$utilisater = $this->getDoctrine()->getRepository(Utilisateur::class)->findBy(['idUtilisateur' => ]);




        return $this->render('admin/participants/tableparticipant.html.twig',[
        'formc'=>$form->createView(),
            'participantf'=>$participant,


        ]);
    }

    /**
     * @param utilisateurRepository $prp
     * @param participantsRepository $prep
     * @param formationRepository $frep
     * @param $id
     * @return Response
     * @Route ("/admin/litpr/{id}",name="pr")
     */
    public function tbpart(utilisateurRepository $prp,participantsRepository $prep,formationRepository $frep,$id){
        $part =new Participants();
        $form=$this->createForm(ParticipantsType::class,$part);
        //$participant=$prp->findAll();
        //$u = $form["idformation"]->getData();

        //$formations=$frep->find(3);
        $sujetf=$frep->find($id);


        $participant=$prep->listpartici($id);


        //$participant=$prep->listparticipantparformation() ;
        //$utilisateree = $this->getDoctrine()->getRepository(Participants::class)->findBy(['id'=>$participant]) ;

        //$utilisater=$prp->findByidUtilisateur($participant);


        //$utilisater = $this->getDoctrine()->getRepository(Utilisateur::class)->findBy(['idUtilisateur' => ]);


        return $this->render('admin/participants/tableparticipant.html.twig',[
            'formc'=>$form->createView(),

            'participantf'=>$participant,
            'sujetf'=>$sujetf
        ]);


    }

    /**
     * @Route ("/admin/statis",name="sta")
     */
    public function statistique(participantsRepository $partrep,formationRepository $frep){

        $test=$partrep->countByidformation();


        $nbrp=[];

        $sujetf=[];
        foreach ($test as $part){
            $nbrp[]=$part['nbrp'];
            $formationid=$part['idformation'];
            $formation=$partrep->sujetformation($formationid);
            foreach ($formation as $f) {
                $sujetf[] = $f['s'];
            }

        }


        return $this->render('admin/participants/statistique.html.twig',[
            'idformation'=>json_encode($sujetf),
            'countparticipants'=>json_encode($nbrp)

        ]);


    }





}


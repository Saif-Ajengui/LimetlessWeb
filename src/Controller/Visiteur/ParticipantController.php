<?php

namespace App\Controller\Visiteur;

use App\Entity\Participant;
use App\Entity\Evenement;
use App\Form\ParticipantType;
use App\Form\PayerType;
use App\Repository\ParticipantRepository;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;





class ParticipantController extends AbstractController
{
    /**
     * @Route("/participant", name="participant")
     */
    public function index(): Response
    {
        return $this->render('visiteur/participant/index.html.twig', [
            'controller_name' => 'ParticipantController',
        ]);
    }

    /**
     * @param EvenementRepository $repository
     * @return Response
     * @Route("/AffichePEvent",name="AffichePEvent")
     */
    public function afficheEvents(EvenementRepository $repository){
        //  $repository=$this->getDoctrine()->getRepository(Evenement::class);
        $evenement=$repository->findAll();
        return $this->render('visiteur/participant/index.html.twig',
            ['evenement'=>$evenement]);

    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("PEvenement/Add/{id_event}",name="Add")
     * @throws \Symfony\Component\Form\Exception\LogicException
     */
    public function addPEvent(EvenementRepository $repository,$id_event, Request  $request){

        $participant = new Participant();
        $form=$this->createForm(ParticipantType::class,$participant);
        //button add
        $form->add('Ajouter',SubmitType::class);
        //button add
        $form->handleRequest($request); //parcourir req extraire les champs du form
        $evenement = new Evenement();
        $evenement=$repository->find($id_event);
        if($evenement->getNbMaxParticipant() > $evenement->getNbParticipant()){



            if($form->isSubmitted() && $form->isValid()){

                $evenement=$repository->find($id_event);
                $evenement->ajoutNbParticip();
                $em=$this->getDoctrine()->getManager();
                $em->persist($participant);
                $em->flush();
                return $this->redirectToRoute('AffichePEvent');
            }

            return $this->render('visiteur/participant/Add.html.twig',[
                'form'=>$form->createView() //$form de type form builder elle va me permettre de cree un affichage plus centré

            ]);


        }else{

            return $this->redirectToRoute('AffichePEvent');
        }


    }




    /**
     * @Route("/map/{id}", name="map")
     */
    public function map(EvenementRepository $repository,$id): Response
    {
        $events=$repository->find($id);
        return $this->render('admin/event/map.html.twig', [
            "events"=>$events
        ]);
    }




}

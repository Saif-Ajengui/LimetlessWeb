<?php

namespace App\Controller\Admin;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class EventController extends AbstractController
{


    /**
     * @Route("/event", name="event")
     */
    public function index(): Response
    {
        return $this->render('admin/event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }

    /**
     * @param EvenementRepository $repository
     * @return Response
     * @Route("/AfficheEvent",name="AfficheEvent")
     */
    public function affiche(EvenementRepository $repository){
        //  $repository=$this->getDoctrine()->getRepository(Evenement::class);
        $evenement=$repository->findAll();
        return $this->render('admin/event/index.html.twig',
            ['evenement'=>$evenement]);

    }

    /**
     * @Route("/DeleteEvent/{id_event}",name="DeleteEvent")
     */
    public function delete($id_event,EvenementRepository $repository){

        $evenement=$repository->find($id_event);
        $em=$this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('AfficheEvent'); //nom de la route vers l'affichage des events

    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("Evenement/Add",name="AddEvent")
     * @throws \Symfony\Component\Form\Exception\LogicException
     */
    public function add(Request  $request){
        $evenement=new Evenement();
        $evenement->setNbParticipant(0);
        $evenement->setNbMaxParticipant(0);
        $form=$this->createForm(EvenementType::class,$evenement);
        //button add
        $form->add('Ajouter',SubmitType::class);
        //button add
        $form->handleRequest($request); //parcourir req extraire les champs du form
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('AfficheEvent');
        }
        return $this->render('admin/event/Add.html.twig',[
            'form'=>$form->createView() //$form de type form builder elle va me permettre de cree un affichage plus centré

        ]);

    }

    /**
     * @param EvenementRepository $repository
     * @Route("Event/UpdateEvent/{id_event}",name="UpdateEvent")
     */
    public function Update(EvenementRepository $repository,$id_event, Request $request){
        $evenement=$repository->find($id_event);
        $form=$this->createForm(EvenementType::class,$evenement);
        $form->add('UpdateEvent',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheEvent');
        }
        return $this->render('admin/event/Add.html.twig',[
            'form'=>$form->createView() //$form de type form builder elle va me permettre de cree un affichage plus centré

        ]);


    }


    /**
     * @param EvenementRepository $repository
     * @Route("/AfficheEvent/recherche",name="recherche")
     */
    public function rechercher(EvenementRepository $repository, Request $request){
        $data=$request->get('search');
        //$this->get();
        var_dump($data);
       $evenement=$repository->findBy(['nom'=>$data]);

        return $this->render('admin/event/index.html.twig',
            ['evenement'=>$evenement]);

    }

    /**
     * @param EvenementRepository $repository
     * @return Response
     * @Route("/AfficheEvent/orderByName",name="orderByName")
     */
    public function orderByNameDQL(EvenementRepository $repository){
        $evenement=$repository->orderByName();
        return $this->render('admin/event/index.html.twig',
            ['evenement'=>$evenement]);
    }

    /**
     * @param EvenementRepository $repository
     * @return Response
     * @Route("/AfficheEvent/orderByType",name="orderByType")
     */
    public function orderByTypeDQL(EvenementRepository $repository){
        $evenement=$repository->orderByType();
        return $this->render('admin/event/index.html.twig',
            ['evenement'=>$evenement]);
    }

    /**
     * @param EvenementRepository $repository
     * @return Response
     * @Route("/AfficheEvent/orderDateDeb",name="orderByDateDeb")
     */
    public function orderByDateDebDQL(EvenementRepository $repository){
        $evenement=$repository->orderByDateDeb();
        return $this->render('admin/event/index.html.twig',
            ['evenement'=>$evenement]);
    }


    /**
     * @param EvenementRepository $repository
     * @return Response
     * @Route("/AfficheEvent/orderDateFin",name="orderByDateFin")
     */
    public function orderByDateFinDQL(EvenementRepository $repository){
        $evenement=$repository->orderByDateFin();
        return $this->render('admin/event/index.html.twig',
            ['evenement'=>$evenement]);
    }



}

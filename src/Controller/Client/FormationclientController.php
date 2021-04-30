<?php

namespace App\Controller\Client;

use App\Entity\Formation;
use App\Entity\Participants;
use App\Entity\PropretySearch;
use App\Entity\User;
use App\Entity\Utilisateur;
use App\Form\PropretySearchType;
use App\Repository\cour2Repository;
use App\Repository\courRepository;
use App\Repository\formationRepository;
use App\Repository\participantsRepository;
use App\Repository\utilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * @method getEntityManager()
 */
class FormationclientController extends AbstractController
{
    /**
     * @Route("/formationclient", name="formationclient")
     */
    public function index(): Response
    {
        return $this->render('formationclient/index.html.twig', [
            'controller_name' => 'FormationclientController',
        ]);
    }

    /**
     * @param formationRepository $repo
     * @param Request $request
     * @return Response
     * @Route("/client/affcihef",name="formationc")
     */

    public function Afficheformation(formationRepository $repo,Request $request){
        $search = new PropretySearch();
        $form=$this->createForm(PropretySearchType::class,$search);
        $form->handleRequest($request);

        $formation = $repo->OrderById();
        $articles=[];
        if($form->isSubmitted()&& $form->isValid()){
            $sujet=$search->getSujet();
            if($sujet!="")
                $formation=$this->getDoctrine()->getRepository(Formation::class)->findBy(['sujet'=>$sujet]);
            else
                $formation = $repo->OrderById();
        }
        return $this->render('client/formationclient/formation.html.twig',
            ['formation'=>$formation,
            'formS'=>$form->createView()
            ]);

    }
    /**
     * @param formationRepository $repo
     * @param Request $request
     * @return Response
     * @Route("/client/affcihefr",name="formationcr")
     */

    public function Afficheformatiorn(formationRepository $repo,Request $request){

        $data=$request->get('sujet');
        if($data == "Tout"){
            $formation = $repo->OrderById();
        }else
        $formation=$repo->findBy(['sujet'=>$data]);

        return $this->render('client/formationclient/formation.html.twig',
            ['formation'=>$formation]);

    }

    /**
     * @param formationRepository $repo
     * @return Response
     * @Route("/client/affcihefp",name="formationcP")
     */
    public function Afficheformationclient(formationRepository $repo){


        $formation=$repo->OrderByidQB();
        return $this->render('client/formationclient/formation.html.twig',
            ['formation'=>$formation]);

    }

    /**
     * @param formationRepository $repo
     * @param participantsRepository $repoP
     * @return Response
     * @Route("/client/affcihefpt1",name="formationcPt")
     */
    public function Afficheformationclientt(formationRepository $repo,participantsRepository $repoP){
        $participants=$repoP->find(3);

        $formation=$repo->OrderByidform($participants->getIdformation());

        return $this->render('client/formationclient/formation.html.twig',
            ['formationt'=>$formation]);

    }
    /**
     * @param formationRepository $repo
     * @return Response
     * @Route("/client/affcihefpt2",name="formationcPt")
     */
    public function Afficheformationclientt2(formationRepository $repo){
      $formation=$repo->OrderById();
        return $this->render('client/formationclient/formation.html.twig',
            ['formationt'=>$formation]);

    }


    /**
     * * @param $id
     * @param cour2RepositoryRepository $repo
     * @return Response
     * @Route("/client/affcihec/{id}",name="courc")
     */
    public function Affichecour($id,cour2Repository  $repo){

        $cour = $repo->findBy(['idf'=>$id]);



        return $this->render('client/formationclient/cour.html.twig',
            ['cour'=>$cour
            ]
        );

    }

    /**
     * @param $id
     * @param participantsRepository $rpp
     * @param \Swift_Mailer $mailer
     * @param $s
     * @return Response
     * @Route ("/client/participer/{id}/{s}",name="participerf")
     */
    public function Participer_formation($id,participantsRepository $rpp,\Swift_Mailer  $mailer,$s){
        $participant=new Participants();
        $user= $this->getUser();
        $idclient = $this->getDoctrine()->getRepository(User::class)->find($user->getId());//het lid ye l3ajngui
        $idformation = $this->getDoctrine()->getRepository(Formation::class)->find($id);

        $participant->setIdformation($idformation);
        $participant->setIdclient($idclient);
       // $participant=$rpp->findBy(['idformation'=>$id]);


        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('ghassenmechmech1@gmail.com')
            ->setTo('ghassenmechmech1@gmail.com')
            ->setBody("Bienvenue "." votre participation a éte enregistrer dans la formation "."'".$s."'"

            );
        $mailer->send($message);


        $em = $this->getDoctrine()->getManager();
        $em->persist($participant);
        $em->flush();

        return $this->redirectToRoute('formationc');

    }








}

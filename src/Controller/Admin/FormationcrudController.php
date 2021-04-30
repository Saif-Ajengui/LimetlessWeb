<?php

namespace App\Controller\Admin;

use App\Entity\Cour2;
use App\Entity\Formation;
use App\Form\AjoutcourType;
use App\Form\AjoutformsType;
use App\Repository\cour2Repository;
use App\Repository\formationRepository;
use App\Repository\participantsRepository;
use App\Repository\utilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationcrudController extends AbstractController
{
    /**
     * @Route("/formationcrud", name="formationcrud")
     */
    public function index(): Response
    {

        return $this->render('formationcrud/Ajouterformation.html.twig', [
            'controller_name' => 'FormationcrudController',
        ]);
    }


    /**
     * @param Request $request
     * @return Response
     * @Route ("/admin/fomration",name="ajoutform")
     */
    function Add(Request $request): Response
    {
        $formation =new Formation();
        $form=$this->createForm(AjoutformsType::class,$formation);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            $em=$this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute('ajoutcour');

        }
        return $this->render('admin/formationcrud/Ajouterformation.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/admin/cour",name="ajoutcour")
     */
    function AddC(Request $request): Response
    {
        $cour =new Cour2();
        $form=$this->createForm(AjoutcourType::class,$cour);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           /** @var UploadedFile $uploadedFile */
           $uploadedFile=$form['extension']->getData();
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName().".pdf", PATHINFO_FILENAME);
            $cour->setExtension($originalFilename);

            /** @var UploadedFile $uploadedFilei */
            $uploadedFilei=$form['image']->getData();
            $originalFilenamei = pathinfo($uploadedFilei->getClientOriginalName().".".$uploadedFilei->getExtension(), PATHINFO_FILENAME);
            $cour->setImage($originalFilenamei);




            $em=$this->getDoctrine()->getManager();
            $em->persist($cour);
            $em->flush();
            return $this->redirectToRoute('upf');

        }
        return $this->render('admin/formationcrud/Ajoutercour.html.twig',[
            'formc'=>$form->createView()
        ]);
    }

    /**
     * @param formationRepository $repof
     * @return Response
     * @Route ("/admin/upform",name="upf")
     */
    public function adminform(formationRepository $repof){
        $formation = $repof->findAll();


        return $this->render('admin/formationcrud/upanddeletform.html.twig',
            ['formation'=>$formation]);
    }
    /**
     * @param formationRepository $repo
     * @param Request $request
     * @return Response
     * @Route("/client/Aaffcihefr",name="Aformationcr")
     */

    public function AfficheformatiornAdmin(formationRepository $repo,Request $request){

        $data=$request->get('sujet');
        if($data == "Tout"){
            $formation = $repo->OrderById();
        }else
            $formation=$repo->findBy(['sujet'=>$data]);

        return $this->render('admin/formationcrud/upanddeletform.html.twig',
            ['formation'=>$formation]);

    }

    /**
     * @param $id
     * @param formationRepository $repod
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/suppf/{id}",name="df")
     */
    public function Deleteformation($id,formationRepository $repod){
        $formationdl=$repod->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($formationdl);

        $em->flush();
        return $this->redirectToRoute('upf');

    }

    /**
     * @param formationRepository $repositoryup
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *@Route("admin/updatef{id}",name="Updatef")
     */
    function Updateformation(formationRepository $repositoryup,$id,Request $request){
        $formationup=$repositoryup->find($id);
        $form=$this->createForm(AjoutformsType::class,$formationup);
        $form->add('UpDate',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("upf");

        }
        return $this->render('admin/formationcrud/Updatef.html.twig',[
            'upform'=>$form->createView()

        ]);

    }

    /**
     * @param $id
     * @param cour2Repository $repoc2
     * @return Response
     * @Route ("/admin/upcour{id}",name="upc")
     */
    public function admincour($id,cour2Repository $repoc2){
        $cour = $repoc2->findBy(['idf'=>$id]);


        return $this->render('admin/formationcrud/updateanddeletecour.html.twig',
            ['cour'=>$cour]);
    }

    /**
     * @param $id
     * @param cour2Repository $repodc2
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/admin/deletcour/{id}",name="dc")
     */
    public function Deletecour($id,cour2Repository $repodc2){
        $courdelete=$repodc2->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($courdelete);

        $em->flush();
        return $this->redirectToRoute('upf');

    }

    /**
     * @param cour2Repository $repositoryupc
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("admin/updatec{id}",name="Updatec")
     */
    function Updatecour(cour2Repository $repositoryupc,$id,Request $request){
        $courup=$repositoryupc->find($id);
        $form=$this->createForm(AjoutcourType::class,$courup);
        $form->add('UpDate',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("upf");

        }
        return $this->render('admin/formationcrud/UpdateC.html.twig',[
            'upcour'=>$form->createView()

        ]);

    }

    /**
     * @param formationRepository $repo
     * @param participantsRepository $repopar
     * @return Response
     * @Route ("admin/listparticipant",name="Listpar")
     */

    public function Affichelistparticipant(formationRepository $repo,participantsRepository $repopar,utilisateurRepository $repuser){
        //$forma=$repo->find(4);
        $Participant=$repopar->listparticipantparformation(3);


        return $this->render('participants/tableparticipant.html.twig',
            ['Participant'=>$Participant]);

    }




}

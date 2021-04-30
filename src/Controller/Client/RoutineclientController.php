<?php


namespace App\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Routineclient;
use App\Form\RoutineclientType;
use App\Repository\RoutineclientRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use App\Form\ConnexionType;


class RoutineclientController extends AbstractController
{
    /**
     * @Route("/Routineclient", name="Routineclient")
     */
    public function index(): Response
    {
        return $this->render('Routineclient/index.html.twig', [
            'controller_name' => 'RoutineclientController',
        ]);
    }


    /*Ajout des routines*/
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/register",name="register")
     */
    public function register(Request $request){
        $Routineclient=new Routineclient();
        $form=$this->createForm(RoutineclientType::class,$Routineclient);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $Routineclient = $form->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($Routineclient);
            $em->flush();
            return $this->redirectToRoute('afficherutil');
        }
        return $this->render('client/raea/ajout.html.twig',[
            'form'=>$form->createView()
        ]);
    }


    /*Affichage des routines*/
    /**
     * @param RoutineclientRepository $repository
     * @return Response
     * @Route("/afficherutil",name="afficherutil")
     */
    public function Affiche(RoutineclientRepository $repository){
        $routineclient=$repository->findAll();
        return $this->render('client/raea/affiche.html.twig',

            ['util'=>$routineclient]);
    }


    /*Suppression des routines*/
    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/suppadmin/{id}",name="suppadmin")
     */
    function delete($id){
        $repo=$this->getDoctrine()->getRepository(Routineclient::class);
        $Routineclient=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Routineclient);
        $em->flush();
        return $this->redirectToRoute('afficherutil');
    }


    /*Modification des routines*/
    /**
     * @param $id
     * @param RoutineclientRepository $repository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/update/{id}",name="update")
     */
    function update($id,RoutineclientRepository $repository,\Symfony\Component\HttpFoundation\Request $request){
        $Routineclient=$repository->find($id);
        $form=$this->createForm(RoutineclientType::class,$Routineclient);
        //$form->add('update',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("afficherutil");


        }
        return $this->render('client/raea/update.html.twig',
            [
                'f'=>$form->createView()
            ]);
    }

    /*Chercher des routnes*/
    /**
     * @param Request $request
     * @param RoutineclientRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/recherche",name="recherche")
     */

    function Recherche(Request $request,RoutineclientRepository $repository){
        $data=$request->get('search');
        $routineclient=$repository->findBy(['nomtache'=>$data]);
        return $this->render('client/raea/affiche.html.twig',[
            'util'=>$routineclient
        ]);
    }


    /*Tri des routines*/
    /**
     * @Route("/listTri", name="TRI")
     */
    public function listTri(Request $request, RoutineclientRepository $repository)
    {
        //list of students order By Duree
        $routineByDuree = $repository->orderByDuree();
        return $this->render('client/raea/affiche.html.twig', array(
                "routineByDuree" => $routineByDuree)
        );
    }


    /*Statistiques_marche*/
    /**
     * @Route("/stats", name="stats")
     */
    public function statistiques(){
        return $this->render('client/raea/statis.html.twig');
    }



    /*Statistiques*/
    /**
     * @Route("/chart", name="chart_stat")
     */
    public function chart(RoutineclientRepository $repo): Response
    {
        //chart
        $nb=[];
        $cats=$repo->countAvancement('ToDo');
        $nb[]=$cats[0][1];
        dump($nb);
        return $this->render('client/raea/chart.html.twig',[
            'nbavancement'=>json_encode($nb),
            'nom'=>'NB CLient'
        ]);
    }





    /**
     * @Route("/searchOffreajax ", name="ajaxsearch")
     */
    public function searchOffreajax(Request $request,RoutineclientRepository $repository)
    {
        $repository = $this->getDoctrine()->getRepository(Routineclient::class);
        $requestString=$request->get('searchValue');
        $routinesuivi = $repository->findByduree($requestString);

        return $this->render('client/raea/affiche.html.twig', [
            "util"=>$routinesuivi
        ]);

    }


    /**
     *@Route("/search/",name="routine_par_duree")
     *Method({"GET"})
     */
    public function RoutineParDuree(Request $request)
    {$routineclient=new Routineclient();
        $routineclient =[];
        $form= $this->createForm(RoutineclientType::class,$routineclient);
    $form->handleRequest($request);
    $duree=[];
    if($form->isSubmitted()&& $form->isValid())
    {   $duree= $routineclient->getDuree();
        $duree=$this->getDoctrine()->getRepository(Duree::class)
            ->findD($duree);
    }
    return$this->render('client/raea/search.html.twig',['form'=>$form->createView(),
        'duree'=>$duree]);
    }




    /*
        public function routineParDuree(Request $request){
            $routineclient = new Routineclient();
            $form= $this->createForm(RoutineclientType::class,$routineclient);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) $tache=$routineclient->getNomtache();
            { $duree= $routineclient->getDuree();
                if($duree!=""){
                    $d=$this->getDoctrine()->getRepository(Routineclient::class)
                        ->findBy($duree);
                }else{

            }

            }
            return$this->render('fixpart/affiche.html.twig',
                ['util'=>$routineclient]);
        }
    */


    /*
        /**
         * @param RoutineclientRepository $repository
         * @return Response
         * @Route("/search",name="search")
         */
    /*
    public function Search(RoutineclientRepository $repository){
        $routineclient=$repository->findBy(
            ['duree' => 'Keyboard']
        );
        return $this->render('fixpart/affiche.html.twig',

            ['util'=>$routineclient]);
    }
*/

}
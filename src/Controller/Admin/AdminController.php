<?php

namespace App\Controller\Admin;

use App\Form\RegistrationType;
use App\Form\UpdateRoleType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AdminController extends AbstractController
{
    /**
     * @Route("/acceuilAdmin", name="acceuilAdmin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @param UserRepository $repository
     * @return Response
     * @Route("/listeCoach",name="listeCoach")
     */
    public function listeCoach(UserRepository $repository){

        $utilisateur=$repository->findByType('Coach');
        return $this->render('admin/affiche.html.twig',

            ['util'=>$utilisateur]);
    }

    /**
     * @param UserRepository $repository
     * @return Response
     * @Route("/search",name="search")
     */
    public function search(Request $request,UserRepository $repository){

        $data=$request->get('search');

        $utilisateur=$repository->findBy(['email'=>$data]);
        return $this->render('admin/affiche.html.twig',

            ['util'=>$utilisateur]);
    }


    /**
     * @Route("/chart", name="chart")
     */
    public function chart(UserRepository $repo): Response
    {
        //chart
        $nb=[];
        $cats=$repo->countnbClient('Client');
        $nb[]=$cats[0][1];
        //chart
        $nb2=[];
        $cats2=$repo->countnbCoach('Coach');
        $nb2[]=$cats2[0][1];
        return $this->render('admin/stat.html.twig',[
            'nbclient'=>json_encode($nb),
            'nbcoach'=>json_encode($nb2),
            'nom'=>'NB CLient'
        ]);
    }




    /**
     * @param UserRepository $repository
     * @return Response
     * @Route("/afficher",name="afficher")
     */
    public function Affiche(UserRepository $repository){

        $utilisateur=$repository->findByIsvalider(false);
        return $this->render('admin/affiche.html.twig',

            ['util'=>$utilisateur]);
    }
    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/delete/{id}",name="delete")
     */
    function delete($id){
        $repo=$this->getDoctrine()->getRepository(User::class);
        $utilisateur=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($utilisateur);
        $em->flush();
        return $this->redirectToRoute('afficher');

    }

    /**
     * @param $id
     * @param UserRepository $repository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/updateRole/{id}",name="updateRole")
     */
    function updateType($id,UserRepository $repository,Request $request, \Swift_Mailer $mailer){
        $user=$repository->find($id);
        $form=$this->createForm(UpdateRoleType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $user->setIsvalider(true);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $message = (new \Swift_Message('Demande Coach'))
                ->setFrom('limitless.pidev@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    "Bonjour Wellness,<br><br>Vous avez été accepté comme coach, vous pouvez connecter sur votre dashboard !<br><br> Bien Cordialement,<br>Equipe WellNess",
                    'text/html'

                );
            $mailer->send($message);
            return $this->redirectToRoute("afficher");


        }
        return $this->render('admin/updateRole.html.twig',
            [
                'f'=>$form->createView()
            ]);


    }


}

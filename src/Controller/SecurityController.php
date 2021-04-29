<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CoachType;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function register(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $user=new User();
        $form=$this->createForm(RegistrationType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setIsvalider(true);
            //upload des images
            $file = $form->get('image')->getData();
            $uploads_directory = $this->getParameter('uploads_directory');
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $filename = $originalFilename . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename

            );
            $user->setImage($filename);
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/inscriptionCoach", name="inscriptionCoach")
     */
    public function registerCoach(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $user=new User();
        $form=$this->createForm(CoachType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setIsvalider(false);
            //upload des images
            $file = $form->get('image')->getData();
            $uploads_directory = $this->getParameter('uploads_directory');
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $filename = $originalFilename . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename

            );
            $user->setImage($filename);
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/registrationCoach.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @param $id
     * @param UserRepository $repository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/updateProfile/{id}",name="updateProfile")
     */
    function update($id,UserRepository $repository,Request $request,UserPasswordEncoderInterface $encoder){
        $user=$repository->find($id);
        $form=$this->createForm(RegistrationType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            //upload des images
            $file = $form->get('image')->getData();
            $uploads_directory = $this->getParameter('uploads_directory');
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $filename = $originalFilename . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename

            );
            $user->setImage($filename);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("profile");


        }
        return $this->render('security/updateProfile.html.twig',
            [
                'f'=>$form->createView()
            ]);


    }


    /**
     * @param $id
     * @param UserRepository $repository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/updateProfileCoach/{id}",name="updateProfileCoach")
     */
    function updateCoach($id,UserRepository $repository,Request $request,UserPasswordEncoderInterface $encoder){
        $user=$repository->find($id);
        $form=$this->createForm(CoachType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            //upload des images
            $file = $form->get('image')->getData();
            $uploads_directory = $this->getParameter('uploads_directory');
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $filename = $originalFilename . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename

            );
            $user->setImage($filename);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("profileCoach");


        }
        return $this->render('security/updateProfileCoach.html.twig',
            [
                'f'=>$form->createView()
            ]);


    }

    /**
     * @param $id
     * @param UserRepository $repository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/updateProfileClient/{id}",name="updateProfileClient")
     */
    function updateClient($id,UserRepository $repository,Request $request,UserPasswordEncoderInterface $encoder){
        $user=$repository->find($id);
        $form=$this->createForm(RegistrationType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            //upload des images
            $file = $form->get('image')->getData();
            $uploads_directory = $this->getParameter('uploads_directory');
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $filename = $originalFilename . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename

            );
            $user->setImage($filename);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("profileClient");


        }
        return $this->render('security/updateProfileClient.html.twig',
            [
                'f'=>$form->createView()
            ]);


    }


    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route("/", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        if ($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_');
        }

        if ($this->getUser() && $this->isGranted('ROLE_COACH')) {
            return $this->redirectToRoute('coach_');
        }
        if ($this->getUser() && $this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('client_');
        }

        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/admin",name="admin_")
     *
     */
    public function admin()
    {

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
    /**
     * @Route("/client",name="client_")
     *
     */
    public function client()
    {

        return $this->render('client/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
    /**
     * @Route("/coach",name="coach_")
     *
     */
    public function coach()
    {

        return $this->render('coach/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }



    /**
     * @Route("/profile", name="profile")
     */
    public function profile()
    {
        return $this->render('security/profile.html.twig');
    }

    /**
     * @Route("/profileClient", name="profileClient")
     */
    public function profileClient()
    {
        return $this->render('security/profileClient.html.twig');
    }

    /**
     * @Route("/profileCoach", name="profileCoach")
     */
    public function profileCoach()
    {
        return $this->render('security/profileCoach.html.twig');
    }


    /**
     * @Route("/deconnection", name="app_logout")
     */
    public function logout()
    {

    }


    /**
     * Link to this controller to start the "connect" process
     * @param ClientRegistry $userRegistry
     *
     * @Route("/connect/google", name="connect_google_start")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('google')
            ->redirect();
    }

    /**
     * After going to Google, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     *
     * @param Request $request
     * @param ClientRegistry $clientRegistry
     *
     * @Route("/connect/google/check", name="connect_google_check")
     * @return JsonResponse/\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectCheckAction(Request $request)
    {
        /*if(!$this->getUser()){
            return new JsonResponse(array('status'=>false,'message'=>"User not Found!"));
        }else {*/

            return $this->redirectToRoute('client_');

    }




}

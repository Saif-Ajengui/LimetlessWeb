<?php

namespace App\Controller\Client;

use App\Entity\Rdv;
use App\Entity\Utilisateur;
use App\Form\RdvType;
use App\Repository\RdvRepository;
use App\Repository\utilisateurRepository;
use League\Csv\Writer;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RdvController extends AbstractController
{
    /**
     * @Route("/chercherRndv", name="rdv")
     */
    public function index(): Response
    {
        return $this->render('client/rdv/index.html.twig', [
            "rdvList" => null, "show" => 0, "user" => null
        ]);
    }

    /**
     * @Route("/findUserBy/{id}", name="findUser")
     * @param utilisateurRepository $userRepo
     * @param $id
     * @return Response
     */
    public function findUser(utilisateurRepository $userRepo, $id): Response
    {
        $user = $userRepo->findOneBy(["idUtilisateur"=>$id]);
        if ($user == null) {
            return new Response("0");
        } else {
            return new Response("1");
        }
    }


    /**
     * @Route("/rendezvous/{id}", name="rendezVous")
     * @param RdvRepository $rdvRepo
     * @param utilisateurRepository $userRepo
     * @param $id
     * @return Response
     */
    public function rendezVous(RdvRepository $rdvRepo, utilisateurRepository $userRepo, $id): Response
    {
        $user = $userRepo->findOneBy(["idUtilisateur"=>$id]);
        $clients = [];
        if($user->getType() == "coach") {
            $rdvList = $rdvRepo->findBy(["idCoach"=>$id]);
            $i = 0;
            foreach($rdvList as $rd) {
            $clients[$i] = $userRepo->findOneBy(["idUtilisateur" =>$rd->getIdClient()]);
            $i++;
            }
        } else {
        $rdvList = $rdvRepo->findBy(["idClient"=>$id]);
        }
        $rdvList = array_map(null,$rdvList, $clients);
        return $this->render('client/rdv/index.html.twig', ["type" =>$user->getType(),
            "rdvList" => $rdvList, "show" => 1, "user" =>$user
        ]);
    }

    /**
     * @Route("/deleteRdv/{id}/{idUser}", name="delRdv")
     * @param RdvRepository $rdvRepo
     * @param $id
     * @param $idUser
     * @param utilisateurRepository $userRepo
     * @param Swift_Mailer $mailer
     * @return RedirectResponse
     */
    public function delRdv(RdvRepository $rdvRepo, $id, $idUser, utilisateurRepository $userRepo, Swift_Mailer $mailer)
    {

        $rdv = $rdvRepo->findOneBy( ["id" => $id]);
        $date = $rdv->getDate();
        $clientId = $rdv->getIdClient();
        $coachEmail = $rdv->getIdCoach()->getEmail();
        $user = $userRepo->findOneBy(["idUtilisateur"=>$idUser]);
        $entityManage=$this->getDoctrine()->getManager();
        $entityManage->remove($rdv);
        $entityManage->flush();
        if($user->getType() =="coach") {
            $sender = "coach";
            $u = $userRepo->findOneBy(["idUtilisateur"=>$clientId]);
            $email = $u->getEmail();
            $otherEmail = $coachEmail;
        } else {
            $sender = "user";
            $email = $coachEmail;
            $otherEmail = $user->getEmail();
        }

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('wellnessMailer@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'client/rdv/delEmail.html.twig',
                    ["date" => $date, "sender" => $sender, "otherEmail" =>$otherEmail]

                ),
                'text/html'
            )
            ->setSubject("Rendez-vous");
        $mailer->send($message);

        return $this->redirect("/rendezvous/".$user->getIdUtilisateur());
    }

    /**
     * @Route("/refreshCalendar/{id}", name="refreshCal")
     * @param RdvRepository $rdvRepo
     * @param $id
     * @param utilisateurRepository $userRepo
     */
    public function refReshCal(RdvRepository $rdvRepo, $id, utilisateurRepository $userRepo)
    {
        $user = $userRepo->findOneBy(["idUtilisateur"=>$id]);
        $rdvs = $rdvRepo->findBy(["idCoach" => $user->getIdUtilisateur()]);
        $dates = [];
        $i = 0;
        foreach($rdvs as $rdv) {
            $dates[$i] = $rdv->getDate();
            $i++;
        }
        return new JsonResponse($dates);
    }


    /**
     * @Route("/updateRdv/{id}/{idUser}", name="updateRdv")
     * @param RdvRepository $rdvRepo
     * @param Request $request
     * @param $id
     * @param $idUser
     * @param utilisateurRepository $userRepo
     * @param Swift_Mailer $mailer
     * @return RedirectResponse|Response
     */
    public function updateRdv(RdvRepository $rdvRepo,Request $request, $id, $idUser, utilisateurRepository $userRepo, Swift_Mailer $mailer)
    {
        $dates = [];

        $rdv = $rdvRepo->findOneBy( ["id" => $id]);
        $oldDate = $rdv->getDate();
        $coachId = $rdv->getIdCoach()->getIdUtilisateur();
        $rdvs = $rdvRepo->findBy(["idCoach" => $coachId]);
        $i = 0;
        foreach($rdvs as $rd) {
            $dates[$i] = $rd->getDate();
            $i++;
        }
        $user = $userRepo->findOneBy(["idUtilisateur"=>$idUser]);
        $form=$this->createForm(RdvType::class, $rdv);
        $form->add("Sauvegarder", SubmitType::class, [
            'attr' => ['class' => 'btn btn-info'],
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            if($oldDate != $rdv->getDate()) {
            // send email to user
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('wellnessMailer@gmail.com')
                ->setTo($rdv->getEmail())
                ->setBody(
                    $this->renderView(
                        'client/rdv/updateEmail.html.twig',
                        ["oldDate" => $oldDate, "newDate" => $rdv->getDate()]


                    ),
                    'text/html'
                )
                ->setSubject("Rendez-vous");
            $mailer->send($message);


            // send email to coach
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('wellnessMailer@gmail.com')
                ->setTo($rdv->getIdCoach()->getEmail())
                ->setBody(
                    $this->renderView(
                        'client/rdv/updateEmail.html.twig',
                        ["oldDate" => $oldDate, "newDate" => $rdv->getDate()]

                    ),
                    'text/html'
                )
                ->setSubject("Rendez-vous");
            $mailer->send($message);
            }
            return $this->redirect("/rendezvous/" . $user->getIdUtilisateur());
        }
        return $this->render("client/rdv/addRdv.html.twig", [
            'user'=>$user,
            'dates' =>$dates,
            'rdv' => $rdv,
            'form' =>$form->createView(),
        ]);
    }

    /**
     * @Route("/addRdv/{id}", name="addRdv")
     * @param RdvRepository $rdvRepo
     * @param Request $request
     * @param $id
     * @param utilisateurRepository $userRepo
     * @param Swift_Mailer $mailer
     * @return RedirectResponse|Response
     */
    public function addRdv(RdvRepository $rdvRepo,Request $request, $id, utilisateurRepository $userRepo, Swift_Mailer $mailer)
    {
        $dates = [];

        $rdv = new Rdv();
        $coachs = $userRepo->findBy(["type" =>"coach"]);
        $rdvs = $rdvRepo->findBy(["idCoach" => $coachs[0]->getIdUtilisateur()]);
        $i = 0;
        foreach($rdvs as $rd) {
            $dates[$i] = $rd->getDate();
            $i++;
        }
        $user = $userRepo->findOneBy(["idUtilisateur"=>$id]);
        $form=$this->createForm(RdvType::class, $rdv);
        $form->add("Sauvegarder", SubmitType::class, [
            'attr' => ['class' => 'btn btn-info'],
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $rdv->setEmail($user->getEmail());
            $rdv->setIdClient($user->getIdUtilisateur());
            $em=$this->getDoctrine()->getManager();
            $em->persist($rdv);
            $em->flush();

            // send email to user
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('wellnessMailer@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'client/rdv/email.html.twig',
                        ["status" => "user", 'userName' => $user->getFullName(), "userEmail"=>$user->getEmail(), "date" => $rdv->getDate(), "coachName" =>$rdv->getIdCoach()->getFullName(),"coachEmail"=>$rdv->getIdCoach()->getEmail()]


                    ),
                    'text/html'
                )
                ->setSubject("Rendez-vous");
            $mailer->send($message);


            // send email to coach
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('wellnessMailer@gmail.com')
                ->setTo($rdv->getIdCoach()->getEmail())
                ->setBody(
                    $this->renderView(
                        'client/rdv/email.html.twig',
                        ["status" => "coach", 'userName' => $user->getFullName(), "userEmail"=>$user->getEmail(), "date" => $rdv->getDate(), "coachName" =>$rdv->getIdCoach()->getFullName(),"coachEmail"=>$rdv->getIdCoach()->getEmail()]


                    ),
                    'text/html'
                )
                ->setSubject("Rendez-vous");
            $mailer->send($message);


            return $this->redirect("/rendezvous/" . $user->getIdUtilisateur());
        }
        return $this->render("client/rdv/addRdv.html.twig", [
            'user'=>$user,
            'dates' =>$dates,
            'rdv' => $rdv,
            'form' =>$form->createView(),
        ]);
    }

    /**
     * @Route("/expoerCSV/{id}", name="exportCSV")
     * @param RdvRepository $rdvRepo
     * @param utilisateurRepository $userRepo
     * @param $id
     * @throws \League\Csv\CannotInsertRecord
     */
    public function exportCSV(utilisateurRepository $userRepo, $id)
    {
        $user = $userRepo->findOneBy(["idUtilisateur"=>$id]);


        $header = ['Nom de client', 'Email', 'Date rendez-vous'];
        $rdvs = [];
        $i=0;
        foreach($user->getRdvList() as $rdv) {
            $user = $userRepo->findOneBy(["idUtilisateur"=>$rdv->getIdClient()]);
            $rdvs[$i] = [$user->getFullName(),$rdv->getEmail(),$rdv->getDate()];
            $i++;
        }
        //load the CSV document from a string
        $csv = Writer::createFromString();

        //insert the header
        $csv->insertOne($header);

        //insert all the records
        $csv->insertAll($rdvs);
        $csv->output('users.csv');
        exit();
    }

}

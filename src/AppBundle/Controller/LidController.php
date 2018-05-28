<?php
/**
 * Created by PhpStorm.
 * User: DeStilleGast
 * Date: 17-5-2018
 * Time: 14:13
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Lesson;
use AppBundle\Entity\Member;
use AppBundle\Entity\Registration;
use AppBundle\Form\EditMemberType;
use AppBundle\Form\MemberType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("lid")
 */
class LidController extends Controller
{
    private function generateMenu(){
        return [
            ["title" => "Home", "path" => "lid_home"],
            ["title" => "Aanbod", "path" => "lid_aanbod"],
            ["title" => "Ingeschreven", "path" => "lid_ingeschreven"],
            ["title" => "Profiel bewerken", "path" => "lid_bewerk"],
        ];
    }


    /**
     * @Route("/", name="lid_home")
     */
    public function palceholder(){
        $repo = $this->getDoctrine()->getRepository(Lesson::class);
        $sub = $repo->verkrijgGeregistreerdeLessen($this->getUser());


        return $this->xRender("Lid/home.html.twig", ['open' => $repo->verkrijgLesAanbodBezoeker(), 'aangemeld' => $sub]);
    }

    /**
     * @Route(path="/aanbod", name="lid_aanbod")
     */
    public function aanbodPagina(){
        $repo = $this->getDoctrine()->getRepository(Lesson::class);
        $res = $repo->verkrijgLesAanbodBezoeker();
        $sub = $repo->verkrijgGeregistreerdeLessen($this->getUser());

        $aanbod = array();

//       Filter systeem, het werkt
        foreach ($res as $aanbodLes){
            $gevonden = false;
            foreach ($sub as $subscribed){
                if($subscribed->isEqual($aanbodLes)){
                    $gevonden = true;
                }
            }

            if(!$gevonden){
                array_push($aanbod, $aanbodLes);
            }
        }

        return $this->xRender("Lid/aanbod.html.twig", ["aanbod" => $aanbod]);
    }


    /**
     * @Route(path="/inschrijvingen", name="lid_ingeschreven")
     */
    public function ingeschrevenPagina()
    {
        $repo = $this->getDoctrine()->getRepository(Lesson::class);
        $res = $repo->verkrijgGeregistreerdeLessen($this->getUser());

        return $this->xRender("Lid/inschrijvingen.html.twig", ["aanbod" => $res]);
    }


        /**
     * @Route("/inschrijven/{id}", name="lid_inschijven")
     * @Method("GET")
     */
    public function inschijvenPrep(Lesson $lesson){
        if($lesson->getTraining()->getExtraCosts() > 0) {
            return $this->xRender('Lid/bevestigInschrijven.html.twig', ["les" => $lesson]);
        }else{
            return $this->inschijven($lesson);
        }
    }

    /**
     * @Route("/inschrijven/{id}/ok", name="lid_inschijven_post")
     * @Method("POST")
     */
    public function inschijven(Lesson $lesson){
        $repo = $this->getDoctrine()->getRepository(Lesson::class);

        if($lesson->getMaxPersons() <= count($lesson->getRegistrations())){
            $this->addFlash('error', "Deze les zit vol, ons excuus voor het ongemak!");
            return $this->redirectToRoute("lid_aanbod");
        }

        foreach ($lesson->getRegistrations() as $r){
            if($r->getMember() == $this->getUser()){
                $this->addFlash('error', "U bent hier al ingeschreven");
                return $this->redirectToRoute("lid_aanbod");
            }
        }



        $registration = new Registration();
        $registration->setLesson($lesson);
        $registration->setMember($this->getUser());
        $registration->setPayment(true);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($registration);
        $entityManager->flush();

        $this->addFlash('ok', "U ben op '". $lesson->getTraining()->getDescription(). "' ingeschreven");
        return $this->redirectToRoute("lid_aanbod");
    }


    /**
     * @Route("/uitschijven/{id}", name="lid_uitschrijven")
     */
    public function uitschrijven_prep(Lesson $lesson){
        $isIngeschreven = false;
        foreach ($lesson->getRegistrations() as $r){
            if($r->getMember() == $this->getUser()){
                $isIngeschreven = true;
            }
        }

        if(!$isIngeschreven){
            $this->addFlash('error', "U bent hier niet ingeschreven");
            return $this->redirectToRoute("lid_ingeschreven");
        }


        return $this->xRender("Lid/bevestigUitschrijven.html.twig", ["les" => $lesson]);
    }

    /**
     * @Route("/uitschijven/{id}/ok", name="lid_uitschrijven_post")
     */
    public function uitschrijven(Lesson $lesson){
        $registration = null;
        foreach ($lesson->getRegistrations() as $r){
            if($r->getMember() == $this->getUser()){
                $registration = $r;
            }
        }

        if($registration == null){
            $this->addFlash('error', "U bent hier niet ingeschreven");
            return $this->redirectToRoute("lid_ingeschreven");
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($registration);
        $entityManager->flush();

        $this->addFlash('ok', "U bent uitgeschreven van: " . $lesson->getTraining()->getDescription());
        return $this->redirectToRoute('lid_ingeschreven');
    }


    /**
     * @Route("/edit", name="lid_bewerk")
     */
    public function bewerkGegevens(Request $request){
        $member = $this->getUser();

        $form = $this->createForm(EditMemberType::class, $member);
        $form->add('save', SubmitType::class, array('label' => "Bewerken"));

        // handler submit if any
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){


            //save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($member);
            $entityManager->flush();

            $this->addFlash("ok", "Informatie bewerkt");
            return $this->redirectToRoute("lid_home");

        }

        return $this->xRender(
            'editProfile.twig',
            array('form' => $form->createView())
        );
    }

    private function xRender($view, array $arr = array(), Response $response = null){
        return $this->render($view, array_merge($arr, ['simpleMenu' => $this->generateMenu()]), $response);
    }
}
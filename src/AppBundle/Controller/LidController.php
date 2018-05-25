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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        ];
    }


    /**
     * @Route("/", name="lid_home")
     */
    public function palceholder(){
        return $this->xRender("Lid/home.html.twig");
    }

    /**
     * @Route(path="/aanbod", name="lid_aanbod")
     */
    public function aanbodPagina(){
        $repo = $this->getDoctrine()->getRepository(Lesson::class);
        $res = $repo->verkrijgNietGeregistreerdeLessen($this->getUser());

        dump($res);

        return $this->xRender("Lid/aanbod.html.twig", ["aanbod" => $res]);
    }

    /**
     * @Route(path="/inschrijvingen", name="lid_ingeschreven")
     */
    public function ingeschrevenPagina()
    {
        $repo = $this->getDoctrine()->getRepository(Lesson::class);
        $res = $repo->verkrijgGeregistreerdeLessen($this->getUser());

        dump($res);

        return $this->xRender("Lid/aanbod.html.twig", ["aanbod" => $res]);
    }


        /**
     * @Route("/inschijven/{id}", name="lid_inschijven")
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
     * @Route("/inschijven/{id}/ok", name="lid_inschijven_post")
     * @Method("POST")
     */
    public function inschijven(Lesson $lesson){
        $repo = $this->getDoctrine()->getRepository(Lesson::class);

        if($lesson->getMaxPersons() < $lesson->getRegistrations()->count()){
            $this->addFlash('error', "Deze les zit vol, ons excuus voor het ongemak!");
            return $this->redirectToRoute("aanbodLid");
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


    private function xRender($view, array $arr = array(), Response $response = null){
        return $this->render($view, array_merge($arr, ['simpleMenu' => $this->generateMenu()]), $response);
    }
}
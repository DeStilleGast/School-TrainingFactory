<?php
/**
 * Created by PhpStorm.
 * User: DeStilleGast
 * Date: 17-5-2018
 * Time: 14:14
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Lesson;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("instructeur")
 */
class InstructeurController extends Controller
{
    public static function generateMenu(){
        return [
            ["title" => "Home", "path" => "instructeur_home"],
            ["title" => "Mijn lessen", "path" => "Instructeurs_index"],
            ["title" => "Agenda", "path" => "instructeur_agenda_index"],

        ];
    }

    /**
     * @Route("/", name="instructeur_home")
     */
    public function palceholder(){
//        return new Response("<head></head><body>INSTRUCTEUR PLACEHOLDER</body>");
        return $this->xRender("Instructeur/home.twig");
    }

    /**
     * Lists all agenda entities.
     *
     * @Route("/agenda", name="instructeur_agenda_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lessons = $em->getRepository('AppBundle:Lesson')->findAll();

        return $this->xRender('Instructeur/agenda/index.html.twig', array(
            'lessons' => $lessons,
        ));
    }

    /**
     * Finds and displays a agenda entity.
     *
     * @Route("agenda/{id}", name="instructeur_agenda_show")
     * @Method("GET")
     */
    public function showAction(Lesson $lesson)
    {
        return $this->xRender('Instructeur/agenda/show.html.twig', array(
            'lesson' => $lesson,
        ));
    }

    private function xRender($view, array $arr = array(), Response $response = null){
        return $this->render($view, array_merge($arr, ['simpleMenu' => $this->generateMenu()]), $response);
    }
}
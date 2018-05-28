<?php
/**
 * Created by PhpStorm.
 * User: DeStilleGast
 * Date: 17-5-2018
 * Time: 14:14
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    public static function generateMenu(){
        return [
            ["title" => "Home", "path" => "admin_home"],
            ["title" => "Members", "path" => "admin_lid_index"],
            ["title" => "Instructeurs", "path" => "admin_instructeur_index"],
            ["title" => "Trainings", "path" => "admin_training_index"],

        ];
    }

    /**
     * @Route("/", name="admin_home")
     */
    public function home(){
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Lesson');
        $geweest = $em->findAll();
        $open = $em->verkrijgLesAanbodBezoeker();

        $members = $this->getDoctrine()->getManager()->getRepository("AppBundle:Member")->findAll();
        $instructeurs = $this->getDoctrine()->getManager()->getRepository("AppBundle:Instructeur")->findAll();

        return $this->xRender("Admin/home.html.twig", ["geweest" => $geweest, "open" => $open, "members" => $members, "instructeurs" => $instructeurs]);
    }


    public function xRender($view, array $arr = array(), Response $response = null){
        return $this->render($view, array_merge($arr, ['simpleMenu' => $this->generateMenu()]), $response);
    }
}
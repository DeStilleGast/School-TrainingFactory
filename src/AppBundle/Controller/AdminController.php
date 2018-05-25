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
    public function palceholder(){
        return $this->xRender("Admin/home.html.twig");
    }


    public function xRender($view, array $arr = array(), Response $response = null){
        return $this->render($view, array_merge($arr, ['simpleMenu' => $this->generateMenu()]), $response);
    }
}
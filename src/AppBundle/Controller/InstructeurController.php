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
 * @Route("Instructeur")
 */
class InstructeurController extends Controller
{
    private function generateMenu(){
        return [
            ["title" => "Home", "path" => "instructeur_home"],
            ["title" => "Lessen", "path" => "Instructeurs_index"],

        ];
    }

    /**
     * @Route("/", name="instructeur_home")
     */
    public function palceholder(){
//        return new Response("<head></head><body>INSTRUCTEUR PLACEHOLDER</body>");
        return $this->xRender("Instructeur/home.twig");
    }

    private function xRender($view, array $arr = array(), Response $response = null){
        return $this->render($view, array_merge($arr, ['simpleMenu' => $this->generateMenu()]), $response);
    }
}
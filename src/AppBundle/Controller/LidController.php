<?php
/**
 * Created by PhpStorm.
 * User: DeStilleGast
 * Date: 17-5-2018
 * Time: 14:13
 */

namespace AppBundle\Controller;


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
        ];
    }


    /**
     * @Route("/", name="lid_home")
     */
    public function palceholder(){
        return $this->xRender("Lid/home.html.twig");
    }


    private function xRender($view, array $arr = array(), Response $response = null){
        return $this->render($view, array_merge($arr, ['simpleMenu' => $this->generateMenu()]), $response);
    }
}
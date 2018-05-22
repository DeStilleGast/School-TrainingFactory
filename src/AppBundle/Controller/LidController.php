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
    /**
     * @Route("/", name="lid_home")
     */
    public function palceholder(){
        return new Response("<head></head><body>LID PLACEHOLDER</body>");
    }
}
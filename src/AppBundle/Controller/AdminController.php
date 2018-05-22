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
 * @Route("admin")
 */
class AdminController extends Controller
{

    /**
     * @Route("/", name="admin_home")
     */
    public function palceholder(){
        return new Response("<head></head><body>ADMIN PLACEHOLDER</body>");
    }
}
<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends Controller
{


    private function generateMenu(){
        return [
            ["title" => "Homepage", "path" => "homepage"],
            ["title" => "Gedrag regels", "path" => "bezoekerGedragRegels"],
            ["title" => "Contact", "path" => "bezoekerContact"]
        ];
    }

    /**
     * @Route("/admin", name="admin_home")
     */
    public function palceholder(){
        return new Response("<head></head><body>ADMIN PLACEHOLDER</body>");
    }


    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $this->addFlash("loginError", $error);
        return $this->redirectToRoute("homepage");

//        return $this->render('default/baseBezoeker.twig', array(
//            'last_username' => $lastUsername,
//            'error'         => $error,
//            'simpleMenu' => $this->generateMenu(),
//        ));
    }


    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('Bezoeker/homepage.html.twig', [
//            'currentMenu' => "homepage",
            "error" => $this->get('session')->getFlashBag()->get("loginError"),
            'simpleMenu' => $this->generateMenu(),
        ]);
    }

    /**
     * @Route("/gedragRegels", name="bezoekerGedragRegels")
     */
    public function gedragsRegels(Request $request)
    {

        // source: http://www.prosportcentrum.nl/leden-info/huis-en-zaalregels/
        $gedragsRegels = ["Het gebruik van doping en stimulerende middelen is verboden.",
            "Drugsbezit en -gebruik zijn verboden en worden direct bestraft.",
            "Er is respect voor mede leden en trainers/begeleiders.",
            "Wij zijn sportief, ook al zijn andere het niet.",
            "Discriminatie, schelden, treiteren, pesten of op een andere manier kwetsen worden niet getolereerd en kunnen aanleiding zijn voor straffen.",
            "Vechten gebeurt alleen op de mat of ring. Nooit erbuiten.",
            "Technieken mogen niet worden gebruikt, wanneer iemand zich niet kan verdedigen.",
            "Technieken mogen alleen worden toegepast als zelfverdediging.",
            "Rommel moet worden opgeruimd."];


        return $this->render('Bezoeker/gedragsRegels.html.twig', [
            "rules" => $gedragsRegels,
            'simpleMenu' => $this->generateMenu(),
        ]);
    }

    /**
     * @Route("/contact", name="bezoekerContact")
     */
    public function contact(){
        return $this->render("Bezoeker/contact.html.twig", [
            "simpleMenu" => $this->generateMenu()
        ]);
    }



}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Member;
use AppBundle\Form\RegisterMemberType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends Controller
{
    private function generateMenu(){
        return [
            ["title" => "Homepage", "path" => "homepage"],
            ["title" => "Gedrag regels", "path" => "bezoekerGedragRegels"],
            ["title" => "Contact", "path" => "bezoekerContact"],
            ["title" => "Registreren", "path" => "registerLid"]
        ];
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
    }


    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->xRender('Bezoeker/homepage.html.twig', [
            "error" => $this->get('session')->getFlashBag()->get("loginError"),
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


        return $this->xRender('Bezoeker/gedragsRegels.html.twig', [
            "rules" => $gedragsRegels,
        ]);
    }

    /**
     * @Route("/contact", name="bezoekerContact")
     */
    public function contact(){
        return $this->xRender("Bezoeker/contact.html.twig");
    }

    /**
     * @Route("/register", name="registerLid")
    */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        //Create builder
        $member = new Member();
        $form = $this->createForm(RegisterMemberType::class, $member);

        // handler submit if any
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //Encode the password
            $password = $passwordEncoder->encodePassword($member, $member->getPlainPassword());
            $member->setPassword($password);

            //save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($member);
            $entityManager->flush();

            $this->addFlash("ok", "You are registered, please log in");
            return $this->redirectToRoute("login");
        }

        return $this->xRender(
            'Bezoeker/register.html.twig',
            array('form' => $form->createView())
        );

    }



    private function xRender($view, array $arr = array(), Response $response = null){
        return $this->render($view, array_merge($arr, ['simpleMenu' => $this->generateMenu()]), $response);
    }


}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lesson;
use AppBundle\Entity\Member;
use AppBundle\Form\MemberType;
use AppBundle\Form\RegisterMemberType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ["title" => "Active lessen", "path" => "aanbodBezoeker"],
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

        // last username entered by the Lid
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
        $form = $this->createForm(MemberType::class, $member);
        $form->add('save', SubmitType::class, array('label'=>"registreren"));

        // handler submit if any
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $repository=$this->getDoctrine()->getRepository(Member::class);
            $bestaande_user = $repository->findOneBy(['username' => $form->getData()->getUsername()]);
            $bestaande_email = $repository->findOneBy(['email' => $form->getData()->getEmail()]);

            if($bestaande_user==null && $bestaande_email == null)
            {
                //Encode the password
                $password = $passwordEncoder->encodePassword($member, $member->getPlainPassword());
                $member->setPassword($password);

                $member->setRoles(["ROLE_LID"]);


                //save the User!
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($member);
                $entityManager->flush();

                $this->addFlash("ok", "You are registered, please log in");
                return $this->redirectToRoute("login");
            }
            else if($bestaande_user != null)
            {
                $this->addFlash(
                    'error',
                    $member->getUsername()." bestaat al, kies een andere gebruikersnaam"
                );
                //vanaf hier ga je weer uit de if
            }else if($bestaande_email != null)
            {
                $this->addFlash(
                    'error',
                    $member->getEmail()." is al in gebruik, kies een andere email of vraag een nieuw wachtwoord aan"
                );
                //vanaf hier ga je weer uit de if
            }
        }

        return $this->xRender(
            'Bezoeker/register.html.twig',
            array('form' => $form->createView())
        );

    }

    /**
     * @Route(path="/aanbod", name="aanbodBezoeker")
     */
    public function aanbodPagina(){
        $repo = $this->getDoctrine()->getRepository(Lesson::class);
        $res = $repo->verkrijgLesAanbodBezoeker();

        return $this->xRender("Bezoeker/aanbod.html.twig", ["aanbod" => $res]);
    }

    private function renderDump($toDump){
        return $this->render("vardump.twig", ["toDump" => $toDump]);
    }

    private function xRender($view, array $arr = array(), Response $response = null){
        return $this->render($view, array_merge($arr, ['simpleMenu' => $this->generateMenu()]), $response);
    }
}

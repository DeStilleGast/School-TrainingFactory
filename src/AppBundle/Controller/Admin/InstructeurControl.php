<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\AdminController;
use AppBundle\Entity\Instructeur;
use AppBundle\Form\InstructeurType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * User controller.
 *
 * @Route("admin/instructeur")
 */
class InstructeurControl extends Controller
{
    /**
     * Lists all Lid entities.
     *
     * @Route("/", name="admin_instructeur_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:Instructeur')->findAll();

        return $this->xRender('Admin/Instructeur/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new Lid entity.
     *
     * @Route("/new", name="admin_instructeur_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        //Create builder
        $member = new Instructeur();
        $form = $this->createForm(InstructeurType::class, $member);

        // handler submit if any
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $repository=$this->getDoctrine()->getRepository(Instructeur::class);
            $bestaande_user = $repository->findOneBy(['username' => $form->getData()->getUsername()]);
            $bestaande_email = $repository->findOneBy(['email' => $form->getData()->getEmail()]);

            if($bestaande_user==null && $bestaande_email == null)
            {
                //Encode the password
                $password = $passwordEncoder->encodePassword($member, $member->getPlainPassword());
                $member->setPassword($password);

                $member->setRoles(["ROLE_INSTRUCTEUR"]);


                //save the User!
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($member);
                $entityManager->flush();

                $this->addFlash("ok", "Instructeur geregistreerd");
                return $this->redirectToRoute('admin_instructeur_show', array('id' => $member->getId()));
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

        return $this->xRender('Admin/instructeur/new.html.twig', array(
            'user' => $member,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Lid entity.
     *
     * @Route("/{id}", name="admin_instructeur_show")
     * @Method("GET")
     */
    public function showAction(Instructeur $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->xRender('Admin/instructeur/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Lid entity.
     *
     * @Route("/{id}/edit", name="admin_instructeur_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Instructeur $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\InstructeurType', $user);
        $editForm->remove("plainPassword");


        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_instructeur_edit', array('id' => $user->getId()));
        }

        return $this->xRender('Admin/instructeur/edit.html.twig', array(
            'Lid' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Lid entity.
     *
     * @Route("/{id}", name="admin_instructeur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Instructeur $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();

            $this->addFlash("ok", "Instructeur verwijderd");
        }

        return $this->redirectToRoute('admin_lid_index');
    }

    /**
     * Creates a form to delete a Lid entity.
     *
     * @param Instructeur $user The Lid entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Instructeur $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_instructeur_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function xRender($view, array $arr = array(), Response $response = null){
        return $this->render($view, array_merge($arr, ['simpleMenu' => AdminController::generateMenu()]), $response);
    }
}

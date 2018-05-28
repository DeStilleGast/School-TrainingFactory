<?php

namespace AppBundle\Controller\Instructeur;

use AppBundle\Controller\InstructeurController;
use AppBundle\Entity\Lesson;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Lesson controller.
 *
 * @Route("instructeur/lessons")
 */
class LessonController extends Controller
{
    /**
     * Lists all agenda entities.
     *
     * @Route("/", name="Instructeurs_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lessons = $em->getRepository('AppBundle:Lesson')->verkrijgInstructeurLessen($this->getUser());

        return $this->xRender('instructeur/lesson/index.html.twig', array(
            'lessons' => $lessons,
        ));
    }

    /**
     * Creates a new agenda entity.
     *
     * @Route("/new", name="Instructeurs_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $lesson = new Lesson();
        $form = $this->createForm('AppBundle\Form\LessonType', $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lesson->setInstructeur($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($lesson);
            $em->flush();

            return $this->redirectToRoute('Instructeurs_show', array('id' => $lesson->getId()));
        }

        return $this->xRender('instructeur/lesson/new.html.twig', array(
            'lesson' => $lesson,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a agenda entity.
     *
     * @Route("/{id}", name="Instructeurs_show")
     * @Method("GET")
     */
    public function showAction(Lesson $lesson)
    {
        $deleteForm = $this->createDeleteForm($lesson);

        return $this->xRender('instructeur/lesson/show.html.twig', array(
            'lesson' => $lesson,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing agenda entity.
     *
     * @Route("/{id}/edit", name="Instructeurs_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Lesson $lesson)
    {
        $deleteForm = $this->createDeleteForm($lesson);
        $editForm = $this->createForm('AppBundle\Form\LessonType', $lesson);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('ok', "Les begewerkt");
            return $this->redirectToRoute('Instructeurs_edit', array('id' => $lesson->getId()));
        }

        return $this->xRender('instructeur/lesson/edit.html.twig', array(
            'lesson' => $lesson,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a agenda entity.
     *
     * @Route("/{id}", name="Instructeurs_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lesson $lesson)
    {
        $form = $this->createDeleteForm($lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lesson);
            $em->flush();

            $this->addFlash('ok', "Les verwijderd");
        }

        return $this->redirectToRoute('Instructeurs_index');
    }

    /**
     * Creates a form to delete a agenda entity.
     *
     * @param Lesson $lesson The agenda entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Lesson $lesson)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Instructeurs_delete', array('id' => $lesson->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    public function xRender($view, array $arr = array(), Response $response = null){
        return $this->render($view, array_merge($arr, ['simpleMenu' => InstructeurController::generateMenu()]), $response);
    }
}

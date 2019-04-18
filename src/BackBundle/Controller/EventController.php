<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Event controller.
 *
 * @Route("events")
 */
class EventController extends Controller
{
    /**
     * Lists all event entities.
     *
     * @Route("/", name="events_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('BackBundle:Event')->findAll();

        return $this->render('back/event/index.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * Creates a new event entity.
     *
     * @Route("/new", name="events_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm('BackBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $str = str_replace("https://youtu.be","https://www.youtube.com/embed",$event->getYoutubePath());
            $event->setYoutubePath($str);
            $em->persist($event);
            $em->flush();

            $allowedExts = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png");
            $temp = explode(".", $_FILES["backbundle_event"]['name']['image']);
            $extension = end($temp);
            if(in_array($_FILES["backbundle_event"]['type']['image'], $allowedExts)){
                $ff = new UploadedFile($_FILES["backbundle_event"]['tmp_name']['image'],$_FILES["backbundle_event"]['name']['image']);
                $ff->move($this->container->get( 'kernel' )->getRootDir() . '/../web/asset/events/thumbnail/', $event->getId().'.'.$extension);
            }
            return $this->redirectToRoute('events_show', array('id' => $event->getId()));
        }

        return $this->render('back/event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a event entity.
     *
     * @Route("/{id}", name="events_show")
     * @Method("GET")
     */
    public function showAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('back/event/show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing event entity.
     *
     * @Route("/{id}/edit", name="events_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('BackBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $allowedExts = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png");
            $temp = explode(".", $_FILES["backbundle_event"]['name']['image']);
            $extension = end($temp);
            if(in_array($_FILES["backbundle_event"]['type']['image'], $allowedExts)){
                $ff = new UploadedFile($_FILES["backbundle_event"]['tmp_name']['image'],$_FILES["backbundle_event"]['name']['image']);
                $ff->move($this->container->get( 'kernel' )->getRootDir() . '/../web/asset/events/thumbnail/', $event->getId().'.'.$extension);
            }
            return $this->redirectToRoute('events_show', array('id' => $event->getId()));
        }

        return $this->render('back/event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a event entity.
     *
     * @Route("/{id}", name="events_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            unlink($event->getThumbnail());
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('events_index');
    }

    /**
     * Creates a form to delete a event entity.
     *
     * @param Event $event The event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('events_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

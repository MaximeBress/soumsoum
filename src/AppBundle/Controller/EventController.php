<?php

namespace AppBundle\Controller;

use BackBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/events")
 */
class EventController extends Controller
{
    /**
     * @Route("/", name="events")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('BackBundle:Event')->findAll();

        return $this->render('front/events/list.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * @Route("/{id}", name="event_show")
     */
    public function showAction(Event $event)
    {
        return $this->render('front/events/show.html.twig', array(
            'event' => $event,
        ));
    }
}

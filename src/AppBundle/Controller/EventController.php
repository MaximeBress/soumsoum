<?php

namespace AppBundle\Controller;

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
        return $this->render('front/events/list.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/{id}", name="event_show")
     */
    public function showAction($id)
    {
        return $this->render('front/events/show.html.twig', array(
            // ...
        ));
    }
}

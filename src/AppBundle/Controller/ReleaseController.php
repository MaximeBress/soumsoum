<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/releases")
 */
class ReleaseController extends Controller
{
    /**
     * @Route("/", name="releases")
     */
    public function listAction()
    {
        return $this->render('front/releases/list.html.twig', array(
            // ...
        ));
    }
    /**
     * @Route("/{id}", name="release_show")
     */
    public function showAction($id)
    {
        return $this->render('front/releases/show.html.twig', array(
            // ...
        ));
    }
}

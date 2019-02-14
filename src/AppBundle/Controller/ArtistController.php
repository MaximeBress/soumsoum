<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/artists")
 */
class ArtistController extends Controller
{
    /**
     * @Route("/", name="artists")
     */
    public function listAction()
    {
        return $this->render('front/artists/list.html.twig', array(
            // ...
        ));
    }
    /**
     * @Route("/{id}", name="artist_show")
     */
    public function showAction($id)
    {
        return $this->render('front/artists/show.html.twig', array(
            // ...
        ));
    }
}

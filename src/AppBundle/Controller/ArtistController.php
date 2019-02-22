<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackBundle\Entity\Artist;

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
     * @Route("/{id}", name="artists_show")
     */
    public function showAction(Artist $artist)
    {
        return $this->render('front/artists/show.html.twig', array(
            'artist' => $artist
        ));
    }
}

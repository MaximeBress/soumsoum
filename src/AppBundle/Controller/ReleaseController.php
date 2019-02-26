<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackBundle\Entity\Album;

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
        $albums = $em->getRepository('BackBundle:Album')->findAll();

        return $this->render('front/releases/list.html.twig', array(
            'albums' -> $albums
        ));
    }
    /**
     * @Route("/{id}", name="release_show")
     */
    public function showAction(Album $album)
    {
        return $this->render('front/releases/show.html.twig', array(
            'album' => $album
        ));
    }
}

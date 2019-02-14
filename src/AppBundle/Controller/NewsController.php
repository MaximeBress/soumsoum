<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/news")
 */
class NewsController extends Controller
{
    /**
     * @Route("/", name="news")
     */
    public function listAction()
    {
        return $this->render('front/news/list.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/{id}", name="news_show")
     */
    public function showAction($id)
    {
        return $this->render('front/news/show.html.twig', array(
            // ...
        ));
    }
}

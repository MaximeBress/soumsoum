<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/store")
 */
class StoreController extends Controller
{
    /**
     * @Route("/", name="store")
     */
    public function storeAction()
    {
        return $this->render('front/store/list.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/{id}", name="store_show")
     */
    public function showAction($id)
    {
        return $this->render('front/store/show.html.twig', array(
            // ...
        ));
    }
}

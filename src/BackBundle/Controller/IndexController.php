<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class IndexController extends Controller
{
    /**
     * @Route("/", name="back_homepage")
     */
    public function indexAction()
    {
        return $this->render('BackBundle:Index:index.html.twig', array(
            // ...
        ));
    }

}

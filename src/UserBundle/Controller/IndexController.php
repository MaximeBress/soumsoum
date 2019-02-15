<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function redirectAction()
    {
        if (false !== $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('back_homepage'));
        }
        return $this->redirect($this->generateUrl('front_homepage'));
    }
}

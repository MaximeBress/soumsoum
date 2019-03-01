<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BackBundle\Entity\News;

/**
 * @Route("/news")
 */
class NewsController extends Controller
{
    /**
     * @Route("/", name="news")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('BackBundle:News')->findAll();
        $categories = $em->getRepository('BackBundle:NewsType')->findAll();
        $recent = $em->getRepository('BackBundle:News')->findBy(array(), array(), 4);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $news,
            $request->query->getInt('page', 1)/*page number*/,
            6
        );

        return $this->render('front/news/list.html.twig', array(
            'news' => $pagination,
            'categories' => $categories,
            'recent' => $recent,
        ));
    }

    /**
     * @Route("/{id}", name="news_show")
     */
    public function showAction(News $news)
    {
        $em = $this->getDoctrine()->getManager();
        $recent = $em->getRepository('BackBundle:News')->findBy(array(), array(), 4);
        return $this->render('front/news/show.html.twig', array(
            'news'=>$news,
            'recent' => $recent,
        ));
    }
}

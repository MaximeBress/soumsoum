<?php

namespace BackBundle\Controller;

use BackBundle\Entity\News;
use BackBundle\Entity\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * News controller.
 *
 * @Route("news")
 */
class NewsController extends Controller
{
    /**
     * Lists all news entities.
     *
     * @Route("/", name="news_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('BackBundle:News')->findAll();
        $categories = $em->getRepository('BackBundle:NewsType')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $news,
            $request->query->getInt('page', 1)/*page number*/,
            4
        );
        $category = new NewsType();
        $form = $this->createForm('BackBundle\Form\NewsTypeType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('news_index');
        }

        return $this->render('back/news/index.html.twig', array(
            'pagination' => $pagination,
            'categories' => $categories,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new news entity.
     *
     * @Route("/new", name="news_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $news = new News();
        $form = $this->createForm('BackBundle\Form\NewsType', $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $type = $form->get('newsType')->getData();
            $em = $this->getDoctrine()->getManager();
            $news->setNewsType($type);
            $news->setAuthor($this->getUser());
            $em->persist($news);
            $em->flush();
            $allowedExts = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png");
            $temp = explode(".", $_FILES["backbundle_news"]['name']['image']);
            $extension = end($temp);
            if(in_array($_FILES["backbundle_news"]['type']['image'], $allowedExts)){
                $ff = new UploadedFile($_FILES["backbundle_news"]['tmp_name']['image'],$_FILES["backbundle_news"]['name']['image']);
                $ff->move($this->container->get( 'kernel' )->getRootDir() . '/../web/asset/news/thumbnail/', $news->getId().'.'.$extension);
            }

            return $this->redirectToRoute('news_back_show', array('id' => $news->getId()));
        }

        return $this->render('back/news/new.html.twig', array(
            'news' => $news,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a news entity.
     *
     * @Route("/{id}", name="news_back_show")
     * @Method("GET")
     */
    public function showAction(News $news)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $news->getAuthor()->getNews();
        $deleteForm = $this->createDeleteForm($news);

        return $this->render('back/news/show.html.twig', array(
            'news' => $news,
            'articles' => $articles,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing news entity.
     *
     * @Route("/{id}/edit", name="news_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, News $news)
    {
        $deleteForm = $this->createDeleteForm($news);
        $editForm = $this->createForm('BackBundle\Form\NewsType', $news, array(
            'method' => 'POST',
            'category'=> $news->getNewsType()
        ));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $allowedExts = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png");
            $temp = explode(".", $_FILES["backbundle_news"]['name']['image']);
            $extension = end($temp);
            if(in_array($_FILES["backbundle_news"]['type']['image'], $allowedExts)){
                $ff = new UploadedFile($_FILES["backbundle_news"]['tmp_name']['image'],$_FILES["backbundle_news"]['name']['image']);
                $ff->move($this->container->get( 'kernel' )->getRootDir() . '/../web/asset/news/thumbnail/', $news->getId().'.'.$extension);
            }

            return $this->redirectToRoute('news_back_show', array('id' => $news->getId()));
        }

        return $this->render('back/news/edit.html.twig', array(
            'news' => $news,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a news entity.
     *
     * @Route("/{id}/delete", name="news_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, News $news)
    {
        $form = $this->createDeleteForm($news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            unlink($news->getThumbnail());

            $em->remove($news);
            $em->flush();
        }
        return $this->redirectToRoute('news_index');
    }

    /**
     * Creates a form to delete a news entity.
     *
     * @param News $news The news entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(News $news)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('news_delete', array('id' => $news->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

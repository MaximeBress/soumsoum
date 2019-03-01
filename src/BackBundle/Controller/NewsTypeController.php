<?php

namespace BackBundle\Controller;

use BackBundle\Entity\News;
use BackBundle\Entity\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * News controller.
 *
 * @Route("newstype")
 */
class NewsTypeController extends Controller
{
    /**
     * Displays a form to edit an existing news entity.
     *
     * @Route("/edit-category", name="category_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $id =  $request->request->get('id');
        $title =  $request->request->get('title');

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('BackBundle:NewsType')->find($id);
        $category->setTitle($title);
        $em->persist($category);
        $em->flush();

        $o = new \stdClass;
        $o->success = true;

        return new JsonResponse($o);
    }

    /**
     * Deletes a news entity.
     *
     * @Route("/{id}", name="category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(NewsType $category)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('news_index');
    }
}

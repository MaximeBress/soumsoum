<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Artist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Artist controller.
 *
 * @Route("artist")
 */
class ArtistController extends Controller
{
    /**
     * Lists all artist entities.
     *
     * @Route("/", name="artist_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $artists = $em->getRepository('BackBundle:Artist')->findAll();

        return $this->render('back/artist/index.html.twig', array(
            'artists' => $artists,
        ));
    }

    /**
     * Creates a new artist entity.
     *
     * @Route("/new", name="artist_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $artist = new Artist();
        $form = $this->createForm('BackBundle\Form\ArtistType', $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($artist);
            $str = str_replace("https://youtu.be","https://www.youtube.com/embed",$artist->getYoutubePath());
            $artist->setYoutubePath($str);
            $em->persist($artist);
            $em->flush();
            $allowedExts = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png");
            $temp = explode(".", $_FILES["backbundle_artist"]['name']['image']);
            $extension = end($temp);
            if(in_array($_FILES["backbundle_artist"]['type']['image'], $allowedExts)){
                $ff = new UploadedFile($_FILES["backbundle_artist"]['tmp_name']['image'],$_FILES["backbundle_artist"]['name']['image']);
                $ff->move($this->container->get( 'kernel' )->getRootDir() . '/../web/asset/artists/thumbnail/', $artist->getId().'.'.$extension);
            }
            return $this->redirectToRoute('artist_show', array('id' => $artist->getId()));
        }

        return $this->render('back/artist/new.html.twig', array(
            'artist' => $artist,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a artist entity.
     *
     * @Route("/{id}", name="artist_show")
     * @Method("GET")
     */
    public function showAction(Artist $artist)
    {
        $deleteForm = $this->createDeleteForm($artist);

        return $this->render('back/artist/show.html.twig', array(
            'artist' => $artist,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing artist entity.
     *
     * @Route("/{id}/edit", name="artist_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Artist $artist)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($artist);
        $editForm = $this->createForm('BackBundle\Form\ArtistType', $artist);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($artist);
            $str = str_replace("https://youtu.be","https://www.youtube.com/embed",$artist->getYoutubePath());
            $artist->setYoutubePath($str);
            $em->persist($artist);
            $em->flush();
            $allowedExts = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png");
            $temp = explode(".", $_FILES["backbundle_artist"]['name']['image']);
            $extension = end($temp);
            if(in_array($_FILES["backbundle_artist"]['type']['image'], $allowedExts)){
                $ff = new UploadedFile($_FILES["backbundle_artist"]['tmp_name']['image'],$_FILES["backbundle_artist"]['name']['image']);
                $ff->move($this->container->get( 'kernel' )->getRootDir() . '/../web/asset/artists/thumbnail/', $artist->getId().'.'.$extension);
            }

            return $this->redirectToRoute('artist_show', array('id' => $artist->getId()));
        }

        return $this->render('back/artist/edit.html.twig', array(
            'artist' => $artist,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a artist entity.
     *
     * @Route("/{id}/delete", name="artist_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Artist $artist)
    {
        $form = $this->createDeleteForm($artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($artist->getAlbums() as $key => $album) {
                foreach ($album->getArtists() as $key => $artist) {
                    $artist->removeAlbum($album);
                }
                foreach ($album->getSongs() as $key => $song) {
                    $album->removeSong($song);
                    $em->remove($song);
                }
                if($album->getFolder()) {
                    $this->delTree($album->getFolder());
                }
            }
            unlink($artist->getThumbnailArtist());
            $em->remove($artist);
            $em->flush();
        }

        return $this->redirectToRoute('artist_index');
    }
    public function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? self::delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    /**
     * Creates a form to delete a artist entity.
     *
     * @param Artist $artist The artist entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Artist $artist)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('artist_delete', array('id' => $artist->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

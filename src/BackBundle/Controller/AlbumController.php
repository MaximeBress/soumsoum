<?php

namespace BackBundle\Controller;

use BackBundle\Entity\Album;
use BackBundle\Entity\Song;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Album controller.
 *
 * @Route("album")
 */
class AlbumController extends Controller
{
    /**
     * Lists all album entities.
     *
     * @Route("/", name="album_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $albums = $em->getRepository('BackBundle:Album')->findAll();

        return $this->render('back/album/index.html.twig', array(
            'albums' => $albums,
        ));
    }

    /**
     * Creates a new album entity.
     *
     * @Route("/new", name="album_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $album = new Album();
        $form = $this->createForm('BackBundle\Form\AlbumType', $album);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $artists = $form->get('artists')->getData();

            $em = $this->getDoctrine()->getManager();
            $str = str_replace("https://youtu.be","https://www.youtube.com/embed",$album->getYoutubePath());
            $album->setYoutubePath($str);
            $em->persist($album);
            foreach ($artists as $key => $artist) {
                $artist->addAlbum($album);
            }
            $em->flush();
            $allowedExts = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png");
            $temp = explode(".", $_FILES["backbundle_album"]['name']['image']);
            $extension = end($temp);
            if(in_array($_FILES["backbundle_album"]['type']['image'], $allowedExts)){
                $ff = new UploadedFile($_FILES["backbundle_album"]['tmp_name']['image'],$_FILES["backbundle_album"]['name']['image']);
                $ff->move($this->container->get( 'kernel' )->getRootDir() . '/../web/asset/albums/'.$album->getId().'/thumbnail/', $album->getId().'.'.$extension);
            }
            foreach ($album->getSongs() as $key => $song) {
                $id = $song->getId();
                $file = false;
                $tmp = false;
                $type = false;
                if(isset($_FILES["backbundle_album"]['name']['songs']['__name__'])) {
                    $file = $_FILES["backbundle_album"]['name']['songs']['__name__'];
                    $tmp = $_FILES["backbundle_album"]['tmp_name']['songs']['__name__'];
                    $type = $_FILES["backbundle_album"]['type']['songs']['__name__'];
                } else {
                    $file = $_FILES["backbundle_album"]['name']['songs'][$key+1];
                    $tmp = $_FILES["backbundle_album"]['tmp_name']['songs'][$key+1];
                    $type = $_FILES["backbundle_album"]['type']['songs'][$key+1];
                }
                $allowedExts = array("audio/*", "audio/mp3", "audio/mpeg", "audio/vnd.wav");
                $temp = explode(".", $file['file']);
                $extension = end($temp);
                if(in_array($type['file'], $allowedExts)){
                    $ff = new UploadedFile($tmp['file'],$file['file']);
                    $tmpFile = $this->container->get('kernel')->getRootDir().'/../web/asset/albums/'.$album->getId().'/songs/'.$song->getId().'.'.$extension;
                    if(is_file($tmpFile)) {
                        unlink($tmpFile);
                    }
                    $ff->move($this->container->get('kernel')->getRootDir().'/../web/asset/albums/'.$album->getId().'/songs/', $song->getId().'.'.$extension);
                }
            }
            return $this->redirectToRoute('album_show', array('id' => $album->getId()));
        }

        return $this->render('back/album/new.html.twig', array(
            'album' => $album,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a album entity.
     *
     * @Route("/{id}", name="album_show")
     * @Method("GET")
     */
    public function showAction(Album $album)
    {
        $deleteForm = $this->createDeleteForm($album);

        return $this->render('back/album/show.html.twig', array(
            'album' => $album,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing album entity.
     *
     * @Route("/{id}/edit", name="album_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Album $album)
    {
        $deleteForm = $this->createDeleteForm($album);
        $em = $this->getDoctrine()->getManager();
        $originalSongs = new ArrayCollection();
        foreach ($album->getSongs() as $song) {
            $originalSongs->add($song);
        }
        $arr = array();
        foreach ($album->getArtists() as $key => $artist) {
            $arr[] = $artist->getId();
        }

        $editForm = $this->createForm('BackBundle\Form\AlbumType', $album, array(
            'method' => 'POST',
            'artists'=> $album->getArtists()
        ));

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $artists = $editForm->get('artists')->getData();
            $em = $this->getDoctrine()->getManager();
            $str = str_replace("https://youtu.be","https://www.youtube.com/embed",$album->getYoutubePath());
            $album->setYoutubePath($str);
            foreach ($arr as $key => $id) {
                $em->getRepository('BackBundle:Artist')->find($id)->removeAlbum($album);
            }
            foreach ($artists as $key => $artist) {
                $artist->addAlbum($album);
            }

            foreach ($originalSongs as $song) {
                if (false === $album->getSongs()->contains($song)) {
                    $song->getAlbum()->removeSong($song);
                    $song->setAlbum(null);
                    $em->persist($song);
                    $em->remove($song);
                }
            }
            $em->persist($album);
            $em->flush();
            $allowedExts = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png");
            $temp = explode(".", $_FILES["backbundle_album"]['name']['image']);
            $extension = end($temp);
            if(in_array($_FILES["backbundle_album"]['type']['image'], $allowedExts)){
                $ff = new UploadedFile($_FILES["backbundle_album"]['tmp_name']['image'],$_FILES["backbundle_album"]['name']['image']);
                $ff->move($this->container->get('kernel')->getRootDir().'/../web/asset/albums/'.$album->getId().'/thumbnail/', $album->getId().'.'.$extension);
            }
            foreach ($album->getSongs() as $key => $song) {
                $id = $song->getId();
                $file = false;
                $tmp = false;
                $type = false;
                if(isset($_FILES["backbundle_album"]['name']['songs']['__name__'])) {
                    $file = $_FILES["backbundle_album"]['name']['songs']['__name__'];
                    $tmp = $_FILES["backbundle_album"]['tmp_name']['songs']['__name__'];
                    $type = $_FILES["backbundle_album"]['type']['songs']['__name__'];
                } else {
                    $file = $_FILES["backbundle_album"]['name']['songs'][$key];
                    $tmp = $_FILES["backbundle_album"]['tmp_name']['songs'][$key];
                    $type = $_FILES["backbundle_album"]['type']['songs'][$key];
                }
                $allowedExts = array("audio/*", "audio/mp3", "audio/mpeg", "audio/vnd.wav");
                $temp = explode(".", $file['file']);
                $extension = end($temp);
                if(in_array($type['file'], $allowedExts)){
                    $ff = new UploadedFile($tmp['file'],$file['file']);
                    $tmpFile = $this->container->get('kernel')->getRootDir().'/../web/asset/albums/'.$album->getId().'/songs/'.$song->getId().'.'.$extension;
                    if(is_file($tmpFile)) {
                        unlink($tmpFile);
                    }
                    $ff->move($this->container->get('kernel')->getRootDir().'/../web/asset/albums/'.$album->getId().'/songs/', $song->getId().'.'.$extension);
                }
            }

            return $this->redirectToRoute('album_show', array('id' => $album->getId()));
        }

        return $this->render('back/album/edit.html.twig', array(
            'album' => $album,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a album entity.
     *
     * @Route("/{id}/delete", name="album_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Album $album)
    {
        $form = $this->createDeleteForm($album);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
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
            $em->remove($album);
            $em->flush();
        }

        return $this->redirectToRoute('album_index');
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
     * Creates a form to delete a album entity.
     *
     * @param Album $album The album entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Album $album)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('album_delete', array('id' => $album->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Artist
 *
 * @ORM\Table(name="artist")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\ArtistRepository")
 */
class Artist
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="youtubePath", type="string", length=255, nullable=true)
     */
    private $youtubePath;

    /**
     * @var string
     *
     * @ORM\Column(name="facebookPath", type="string", length=255, nullable=true)
     */
    private $facebookPath;

    /**
     * @var string
     *
     * @ORM\Column(name="instaPath", type="string", length=255, nullable=true)
     */
    private $instaPath;

    /**
     * @var string
     *
     * @ORM\Column(name="spotifyPath", type="string", length=255, nullable=true)
     */
    private $spotifyPath;

    /**
     * @var \Doctrine\Common\Collections\Collection|Album[]
     *
     * @ORM\ManyToMany(targetEntity="Album", inversedBy="artists")
     * @ORM\JoinTable(
     *  name="artist_album",
     *  joinColumns={
     *      @ORM\JoinColumn(name="artist_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="album_id", referencedColumnName="id")
     *  }
     * )
     */
    protected $albums;

    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Artist
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Artist
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set youtubePath
     *
     * @param string $youtubePath
     *
     * @return Artist
     */
    public function setYoutubePath($youtubePath)
    {
        $this->youtubePath = $youtubePath;

        return $this;
    }

    /**
     * Get youtubePath
     *
     * @return string
     */
    public function getYoutubePath()
    {
        return $this->youtubePath;
    }

    /**
     * Add album
     *
     * @param \BackBundle\Entity\Album $album
     *
     * @return Artist
     */
    public function addAlbum(\BackBundle\Entity\Album $album)
    {
        $this->albums[] = $album;

        return $this;
    }

    /**
     * Remove album
     *
     * @param \BackBundle\Entity\Album $album
     */
    public function removeAlbum(\BackBundle\Entity\Album $album)
    {
        $this->albums->removeElement($album);
    }

    /**
     * Get albums
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * Set facebookPath
     *
     * @param string $facebookPath
     *
     * @return Artist
     */
    public function setFacebookPath($facebookPath)
    {
        $this->facebookPath = $facebookPath;

        return $this;
    }

    /**
     * Get facebookPath
     *
     * @return string
     */
    public function getFacebookPath()
    {
        return $this->facebookPath;
    }

    /**
     * Set instaPath
     *
     * @param string $instaPath
     *
     * @return Artist
     */
    public function setInstaPath($instaPath)
    {
        $this->instaPath = $instaPath;

        return $this;
    }

    /**
     * Get instaPath
     *
     * @return string
     */
    public function getInstaPath()
    {
        return $this->instaPath;
    }

    /**
     * Set spotifyPath
     *
     * @param string $spotifyPath
     *
     * @return Artist
     */
    public function setSpotifyPath($spotifyPath)
    {
        $this->spotifyPath = $spotifyPath;

        return $this;
    }

    /**
     * Get spotifyPath
     *
     * @return string
     */
    public function getSpotifyPath()
    {
        return $this->spotifyPath;
    }

    public function getWebPath()
    {
        return 'asset/artists/thumbnail/';
    }
    public function getThumbnailArtist()
    {
        $extensions = array('png','jpg','jpeg');
        foreach($extensions AS $ext){
            $thumb = $this->getWebPath().$this->id.'.'.$ext;
            if(is_file($thumb)){
                return $thumb;
            }
        }
        $thumb = 'bundles/back/img/icon-picture.png';
        return $thumb;
    }
}

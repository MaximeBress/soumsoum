<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Album
 *
 * @ORM\Table(name="album")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\AlbumRepository")
 */
class Album
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
     * @ORM\Column(name="producers", type="string", nullable=true)
     */
    private $producers;

    /**
     * @var string
     *
     * @ORM\Column(name="youtubePath", type="string", length=255, nullable=true)
     */
    private $youtubePath;

    /**
     * @var string
     *
     * @ORM\Column(name="amazonPath", type="string", length=255, nullable=true)
     */
    private $amazonPath;

    /**
     * @var string
     *
     * @ORM\Column(name="itunesPath", type="string", length=255, nullable=true)
     */
    private $itunesPath;

    /**
     * @var string
     *
     * @ORM\Column(name="soundCloudPath", type="string", length=255, nullable=true)
     */
    private $soundCloudPath;

    /**
     * @var string
     *
     * @ORM\Column(name="spotifyPath", type="string", length=255, nullable=true)
     */
    private $spotifyPath;

    /**
     * @var string
     *
     * @ORM\Column(name="googlePlayPath", type="string", length=255, nullable=true)
     */
    private $googlePlayPath;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="releaseDate", type="datetime")
     */
    private $releaseDate;

    /**
     * @var \Doctrine\Common\Collections\Collection|User[]
     *
     * @ORM\ManyToMany(targetEntity="Artist", mappedBy="albums")
     */
    protected $artists;

    /**
     * @ORM\OneToMany(targetEntity="Song", mappedBy="album", cascade={"persist"})
     */
    private $songs;

    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->artists = new ArrayCollection();
        $this->songs = new ArrayCollection();
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
     * @return Album
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
     * @return Album
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
     * @return Album
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
     * Set producers
     *
     * @param string $producers
     *
     * @return Album
     */
    public function setProducers($producers)
    {
        $this->producers = $producers;

        return $this;
    }

    /**
     * Get producers
     *
     * @return string
     */
    public function getProducers()
    {
        return $this->producers;
    }

    /**
     * Set amazonPath
     *
     * @param string $amazonPath
     *
     * @return Album
     */
    public function setAmazonPath($amazonPath)
    {
        $this->amazonPath = $amazonPath;

        return $this;
    }

    /**
     * Get amazonPath
     *
     * @return string
     */
    public function getAmazonPath()
    {
        return $this->amazonPath;
    }

    /**
     * Set itunesPath
     *
     * @param string $itunesPath
     *
     * @return Album
     */
    public function setItunesPath($itunesPath)
    {
        $this->itunesPath = $itunesPath;

        return $this;
    }

    /**
     * Get itunesPath
     *
     * @return string
     */
    public function getItunesPath()
    {
        return $this->itunesPath;
    }

    /**
     * Set soundCloudPath
     *
     * @param string $soundCloudPath
     *
     * @return Album
     */
    public function setSoundCloudPath($soundCloudPath)
    {
        $this->soundCloudPath = $soundCloudPath;

        return $this;
    }

    /**
     * Get soundCloudPath
     *
     * @return string
     */
    public function getSoundCloudPath()
    {
        return $this->soundCloudPath;
    }

    /**
     * Set spotifyPath
     *
     * @param string $spotifyPath
     *
     * @return Album
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

    /**
     * Set googlePlayPath
     *
     * @param string $googlePlayPath
     *
     * @return Album
     */
    public function setGooglePlayPath($googlePlayPath)
    {
        $this->googlePlayPath = $googlePlayPath;

        return $this;
    }

    /**
     * Get googlePlayPath
     *
     * @return string
     */
    public function getGooglePlayPath()
    {
        return $this->googlePlayPath;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     *
     * @return Album
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    public function getWebPath()
    {
        return 'asset/albums/';
    }
    public function getFolder()
    {
        $folder = $this->getWebPath().$this->id;
        if(is_dir($folder)) {
            return $this->getWebPath().$this->id;
        }
        return false;
    }
    public function getThumbnail()
    {
        $extensions = array('png','jpg','jpeg');
        foreach($extensions AS $ext){
            $thumb = $this->getWebPath().'/'.$this->id.'/thumbnail/'.$this->id.'.'.$ext;
            if(is_file($thumb)){
                return $thumb;
            }
        }
        $thumb = 'bundles/back/img/icon-person.png';
        return $thumb;
    }

    /**
     * Add song
     *
     * @param \BackBundle\Entity\Song $song
     *
     * @return Album
     */
    public function addSong(\BackBundle\Entity\Song $song)
    {

        $song->setAlbum($this);
        $this->songs[] = $song;

        return $this;
    }

    /**
     * Remove song
     *
     * @param \BackBundle\Entity\Song $song
     */
    public function removeSong(\BackBundle\Entity\Song $song)
    {
        $this->songs->removeElement($song);
    }

    /**
     * Get songs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSongs()
    {
        return $this->songs;
    }

    /**
     * Add artist
     *
     * @param \BackBundle\Entity\Artist $artist
     *
     * @return Album
     */
    public function addArtist(\BackBundle\Entity\Artist $artist)
    {
        $this->artists[] = $artist;

        return $this;
    }

    /**
     * Remove artist
     *
     * @param \BackBundle\Entity\Artist $artist
     */
    public function removeArtist(\BackBundle\Entity\Artist $artist)
    {
        $this->artists->removeElement($artist);
    }

    /**
     * Get artists
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArtists()
    {
        return $this->artists;
    }

    public function findArtist($id)
    {
        if(count($this->artists) > 0) {
            foreach ($this->artists as $key => $artist) {
                if($artist->getId() == $id) {
                    return true;
                }
            }
        }

        return false;
    }
}

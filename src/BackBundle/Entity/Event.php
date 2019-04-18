<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\EventRepository")
 */
class Event
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
     * @var \DateTime
     *
     * @ORM\Column(name="startAt", type="datetime")
     */
    private $startAt;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

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
     * @return Event
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
     * @return Event
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
     * Set startAt
     *
     * @param \DateTime $startAt
     *
     * @return Event
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return Event
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set youtubePath
     *
     * @param string $youtubePath
     *
     * @return Event
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
     * Set facebookPath
     *
     * @param string $facebookPath
     *
     * @return Event
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
    public function getWebPath()
    {
        return 'asset/events/thumbnail/';
    }
    public function getThumbnail()
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

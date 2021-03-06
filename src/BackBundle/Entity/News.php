<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\NewsRepository")
 */
class News
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="NewsType", inversedBy="news")
     * @ORM\JoinColumn(name="news_type_id", referencedColumnName="id")
     */
    private $newsType;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="news")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $author;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
     * Set title
     *
     * @param string $title
     *
     * @return News
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return News
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return News
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
     * Set newsType
     *
     * @param \BackBundle\Entity\NewsType $newsType
     *
     * @return News
     */
    public function setNewsType(\BackBundle\Entity\NewsType $newsType = null)
    {
        $this->newsType = $newsType;

        return $this;
    }

    /**
     * Get newsType
     *
     * @return \BackBundle\Entity\NewsType
     */
    public function getNewsType()
    {
        return $this->newsType;
    }

    public function getWebPath()
    {
        return 'asset/news/thumbnail/';
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
        return false;
    }

    /**
     * Set author
     *
     * @param \BackBundle\Entity\User $author
     *
     * @return News
     */
    public function setAuthor(\BackBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \BackBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }
}

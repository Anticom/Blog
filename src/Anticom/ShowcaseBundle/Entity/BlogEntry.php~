<?php
/**
 * BlogEntry.php
 *
 * Date: 13.03.14
 * Time: 14:06
 * @author    Timo Mühlbach
 * @namespace Anticom\ShowcaseBundle\Entity
 */

namespace Anticom\ShowcaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BlogEntry
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="Anticom\ShowcaseBundle\Entity\BlogEntryRepository")
 * @ORM\Table(name="blog_entry")
 * @ORM\HasLifecycleCallbacks()
 */
class BlogEntry {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @ORM\Column(type="string", length=200) */
    protected $title;
    /** @ORM\Column(type="text", nullable=false) */
    protected $body;
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="blogEntries")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    protected $author;

    #region relations
    /** @ORM\OneToMany(targetEntity="Comment", mappedBy="blogEntry") */
    protected $comments;
    #endregion

    #region triggered
    /** @ORM\Column(type="datetime") */
    protected $dateTimeCreated;
    #endregion

    public function __construct() {
        $this->comments = new ArrayCollection();
    }

    /** @ORM\PrePersist */
    public function setDateTimeCreated() {
        $this->dateTimeCreated = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return BlogEntry
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
     * Set body
     *
     * @param string $body
     * @return BlogEntry
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get dateTimeCreated
     *
     * @return \DateTime 
     */
    public function getDateTimeCreated()
    {
        return $this->dateTimeCreated;
    }

    /**
     * Set author
     *
     * @param \Anticom\ShowcaseBundle\Entity\User $author
     * @return BlogEntry
     */
    public function setAuthor(\Anticom\ShowcaseBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Anticom\ShowcaseBundle\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add comments
     *
     * @param \Anticom\ShowcaseBundle\Entity\Comment $comments
     * @return BlogEntry
     */
    public function addComment(\Anticom\ShowcaseBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Anticom\ShowcaseBundle\Entity\Comment $comments
     */
    public function removeComment(\Anticom\ShowcaseBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
}

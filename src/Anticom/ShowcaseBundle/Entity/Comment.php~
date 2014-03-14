<?php
/**
 * Comment.php
 *
 * Date: 13.03.14
 * Time: 14:28
 * @author    Timo Mühlbach
 * @namespace Anticom\ShowcaseBundle\Entity
 */

namespace Anticom\ShowcaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BlogEntry
 * @ORM\Entity()
 * @ORM\Table(name="comment")
 * @ORM\HasLifecycleCallbacks()
 */
class Comment {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    protected $author;
    /** @ORM\Column(type="text") */
    protected $body;

    #region relations
    /**
     * @ORM\ManyToOne(targetEntity="BlogEntry", inversedBy="comments")
     * @ORM\JoinColumn(name="blog_entry_id", referencedColumnName="id")
     */
    protected $blogEntry;

    /** @ORM\OneToMany(targetEntity="Comment", mappedBy="parent") */
    protected $children;
    /**
     * @ORM\ManyToOne(targetEntity="Comment", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    protected $parent;
    #endregion

    #region triggered
    /** @ORM\Column(type="datetime") */
    protected $dateTimeCreated;
    #endregion

    public function __construct() {
        $this->children = new ArrayCollection();
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
     * Set body
     *
     * @param string $body
     * @return Comment
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
     * @return Comment
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
     * Set blogEntry
     *
     * @param \Anticom\ShowcaseBundle\Entity\BlogEntry $blogEntry
     * @return Comment
     */
    public function setBlogEntry(\Anticom\ShowcaseBundle\Entity\BlogEntry $blogEntry = null)
    {
        $this->blogEntry = $blogEntry;

        return $this;
    }

    /**
     * Get blogEntry
     *
     * @return \Anticom\ShowcaseBundle\Entity\BlogEntry 
     */
    public function getBlogEntry()
    {
        return $this->blogEntry;
    }

    /**
     * Add children
     *
     * @param \Anticom\ShowcaseBundle\Entity\Comment $children
     * @return Comment
     */
    public function addChild(\Anticom\ShowcaseBundle\Entity\Comment $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Anticom\ShowcaseBundle\Entity\Comment $children
     */
    public function removeChild(\Anticom\ShowcaseBundle\Entity\Comment $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Anticom\ShowcaseBundle\Entity\Comment $parent
     * @return Comment
     */
    public function setParent(\Anticom\ShowcaseBundle\Entity\Comment $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Anticom\ShowcaseBundle\Entity\Comment 
     */
    public function getParent()
    {
        return $this->parent;
    }
}

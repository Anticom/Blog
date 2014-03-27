<?php
/**
 * Comment.php
 *
 * @author    Timo M
 * @namespace Anticom\ShowcaseBundle\Entity
 * @package   Entity
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Anticom\ShowcaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Comment
 *
 * @ORM\Entity()
 * @ORM\Table(name="comment")
 * @ORM\HasLifecycleCallbacks()
 */
class Comment {
    /**
     * @var int Unique ID for each Comment
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var User Author of that Comment
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $author;
    /**
     * @var string Body of the Comment
     * @ORM\Column(type="text")
     */
    protected $body;

    #region relations
    /**
     * @var BlogEntry The BlogEntry the Comment belongs to
     * @ORM\ManyToOne(targetEntity="BlogEntry", inversedBy="comments")
     * @ORM\JoinColumn(name="blog_entry_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $blogEntry;

    /**
     * @var Comment[] Direct responses (Comments) to that Comment
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="parent")
     */
    protected $children;
    /**
     * @var Comment|null Direct Parent Comment / null of that Comment
     * @ORM\ManyToOne(targetEntity="Comment", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $parent;
    #endregion

    #region triggered
    /**
     * @var \DateTime When the BlogEntry was created
     * @ORM\Column(type="datetime")
     */
    protected $dateTimeCreated;

    #endregion

    /**
     * Set some sensible defaults
     */
    public function __construct() {
        $this->children = new ArrayCollection();
    }

    /**
     * Method for Doctrine to automatically set $dateTimeCreated
     * @ORM\PrePersist
     */
    public function autoSetDateTimeCreated() {
        $this->dateTimeCreated = new \DateTime();

        return $this;
    }

    /**
     * Find absolute root comment in Comment thread
     *
     * @return Comment
     */
    public function getRootComment() {
        if($this->parent !== null) {
            return $this->getParent()->getRootComment();
        } else {
            return $this;
        }
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Comment
     */
    public function setBody($body) {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * Set dateTimeCreated
     * @param \DateTime $dateTimeCreated
     * @return Comment
     */
    public function setDateTimeCreated(\DateTime $dateTimeCreated) {
        $this->dateTimeCreated = $dateTimeCreated;

        return $this;
    }

    /**
     * Get dateTimeCreated
     *
     * @return \DateTime
     */
    public function getDateTimeCreated() {
        return $this->dateTimeCreated;
    }

    /**
     * Set author
     *
     * @param \Anticom\ShowcaseBundle\Entity\User $author
     * @return Comment
     */
    public function setAuthor(\Anticom\ShowcaseBundle\Entity\User $author = null) {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Anticom\ShowcaseBundle\Entity\User
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Set blogEntry
     *
     * @param \Anticom\ShowcaseBundle\Entity\BlogEntry $blogEntry
     * @return Comment
     */
    public function setBlogEntry(\Anticom\ShowcaseBundle\Entity\BlogEntry $blogEntry = null) {
        $this->blogEntry = $blogEntry;

        return $this;
    }

    /**
     * Get blogEntry
     *
     * @return \Anticom\ShowcaseBundle\Entity\BlogEntry
     */
    public function getBlogEntry() {
        return $this->blogEntry;
    }

    /**
     * Add children
     *
     * @param \Anticom\ShowcaseBundle\Entity\Comment $children
     * @return Comment
     */
    public function addChild(\Anticom\ShowcaseBundle\Entity\Comment $children) {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Anticom\ShowcaseBundle\Entity\Comment $children
     */
    public function removeChild(\Anticom\ShowcaseBundle\Entity\Comment $children) {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Anticom\ShowcaseBundle\Entity\Comment $parent
     * @return Comment
     */
    public function setParent(\Anticom\ShowcaseBundle\Entity\Comment $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Anticom\ShowcaseBundle\Entity\Comment
     */
    public function getParent() {
        return $this->parent;
    }
}

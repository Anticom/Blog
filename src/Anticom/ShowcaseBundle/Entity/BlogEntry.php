<?php
/**
 * BlogEntry.php
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
 * Class BlogEntry
 *
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="Anticom\ShowcaseBundle\Entity\BlogEntryRepository")
 * @ORM\Table(name="blog_entry")
 * @ORM\HasLifecycleCallbacks()
 */
class BlogEntry {
    /**
     * @var int Unique ID for each BlogEntry
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string The BlogEntriy's title
     * @ORM\Column(type="string", length=200)
     */
    protected $title;
    /**
     * @var string The BlogEntry's body
     * @ORM\Column(type="text", nullable=false)
     */
    protected $body;
    /**
     * @var User The BlogEntry's author
     * @ORM\ManyToOne(targetEntity="User", inversedBy="blogEntries")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $author;

    #region relations
    /**
     * @var Comment[] Comments that belong to that BlogEntry
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="blogEntry")
     */
    protected $comments;
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
        $this->comments = new ArrayCollection();
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
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return BlogEntry
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return BlogEntry
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
     * @return BlogEntry
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
     * @return BlogEntry
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
     * Add comments
     *
     * @param \Anticom\ShowcaseBundle\Entity\Comment $comments
     * @return BlogEntry
     */
    public function addComment(\Anticom\ShowcaseBundle\Entity\Comment $comments) {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Anticom\ShowcaseBundle\Entity\Comment $comments
     */
    public function removeComment(\Anticom\ShowcaseBundle\Entity\Comment $comments) {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments() {
        return $this->comments;
    }
}

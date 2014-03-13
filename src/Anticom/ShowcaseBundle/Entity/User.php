<?php
/**
 * User.php
 *
 * Date: 13.03.14
 * Time: 14:26
 * @author    Timo Mühlbach
 * @namespace Anticom\ShowcaseBundle\Entity
 */

namespace Anticom\ShowcaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class BlogEntry
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @ORM\Column(type="string", length=100) */
    protected $nickName;
    /** @ORM\Column(type="string", length=255) */
    protected $email;
    /**
     * @see  https://github.com/cpliakas/doctrine-password
     * @todo figure out, where to add the Type to DBAL\Types
     * @ORM\Column(type="string")
     */
    protected $password;

    #region relations
    /** @ORM\OneToMany(targetEntity="BlogEntry", mappedBy="author") */
    protected $blogEntries;
    /** @ORM\OneToMany(targetEntity="Comment", mappedBy="author") */
    protected $comments;
    #endregion

    public function __construct() {
        $this->blogEntries = new ArrayCollection();
        $this->comments    = new ArrayCollection();
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
     * Set nickName
     *
     * @param string $nickName
     * @return User
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;

        return $this;
    }

    /**
     * Get nickName
     *
     * @return string 
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Add blogEntries
     *
     * @param \Anticom\ShowcaseBundle\Entity\BlogEntry $blogEntries
     * @return User
     */
    public function addBlogEntry(\Anticom\ShowcaseBundle\Entity\BlogEntry $blogEntries)
    {
        $this->blogEntries[] = $blogEntries;

        return $this;
    }

    /**
     * Remove blogEntries
     *
     * @param \Anticom\ShowcaseBundle\Entity\BlogEntry $blogEntries
     */
    public function removeBlogEntry(\Anticom\ShowcaseBundle\Entity\BlogEntry $blogEntries)
    {
        $this->blogEntries->removeElement($blogEntries);
    }

    /**
     * Get blogEntries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBlogEntries()
    {
        return $this->blogEntries;
    }

    /**
     * Add comments
     *
     * @param \Anticom\ShowcaseBundle\Entity\Comment $comments
     * @return User
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

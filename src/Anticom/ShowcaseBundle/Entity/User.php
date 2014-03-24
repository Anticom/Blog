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
use Serializable;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class BlogEntry
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User implements UserInterface, Serializable {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /** @ORM\Column(type="string", length=100) */
    protected $username;
    /** @ORM\Column(type="string", length=255) */
    protected $email;
    /** @ORM\Column(type="string", length=255) */
    protected $password;
    /** @var  @ORM\Column(name="is_active", type="boolean") */
    protected $isActive;

    #region relations
    /** @ORM\OneToMany(targetEntity="BlogEntry", mappedBy="author") */
    protected $blogEntries;
    /** @ORM\OneToMany(targetEntity="Comment", mappedBy="author") */
    protected $comments;

    //protected $roles;
    #endregion

    public function __construct() {
        $this->blogEntries = new ArrayCollection();
        $this->comments    = new ArrayCollection();
        $this->isActive    = true;
    }

    #region interface implementations
    /**
     * @inheritDoc
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt() {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles() {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize() {
        return serialize(
            array(
                $this->id,
                $this->username,
                $this->password
            )
        );
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized) {
        list (
            $this->id,
            $this->username,
            $this->password
            ) = unserialize($serialized);
    }
    #endregion

    #region getters & setters
    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive() {
        return $this->isActive;
    }

    /**
     * Add blogEntries
     *
     * @param \Anticom\ShowcaseBundle\Entity\BlogEntry $blogEntries
     * @return User
     */
    public function addBlogEntry(\Anticom\ShowcaseBundle\Entity\BlogEntry $blogEntries) {
        $this->blogEntries[] = $blogEntries;

        return $this;
    }

    /**
     * Remove blogEntries
     *
     * @param \Anticom\ShowcaseBundle\Entity\BlogEntry $blogEntries
     */
    public function removeBlogEntry(\Anticom\ShowcaseBundle\Entity\BlogEntry $blogEntries) {
        $this->blogEntries->removeElement($blogEntries);
    }

    /**
     * Get blogEntries
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlogEntries() {
        return $this->blogEntries;
    }

    /**
     * Add comments
     *
     * @param \Anticom\ShowcaseBundle\Entity\Comment $comments
     * @return User
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
    #endregion
}

<?php
/**
 * User.php
 *
 * @author    Timo M
 * @namespace Anticom\ShowcaseBundle\Entity
 * @package   Entity
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Anticom\ShowcaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 *
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User implements UserInterface, Serializable {
    /**
     * @var int Unique ID for each User
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string The User's nickname
     * @ORM\Column(type="string", length=100)
     */
    protected $username;
    /**
     * @var string The User's e-mail adress
     * @ORM\Column(type="string", length=255)
     */
    protected $email;
    /**
     * @var string The User's password
     * @ORM\Column(type="string", length=255)
     */
    protected $password;
    /**
     * @var bool Whether the User is active or not
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;

    #region relations
    /**
     * @var BlogEntry[] BlogEntries that belong to that User
     * @ORM\OneToMany(targetEntity="BlogEntry", mappedBy="author")
     */
    protected $blogEntries;
    /**
     * @var Comment[] Comments that belong to that User
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="author")
     */
    protected $comments;

    //protected $roles;
    #endregion

    /**
     * Set some sensible defaults
     */
    public function __construct() {
        $this->blogEntries = new ArrayCollection();
        $this->comments    = new ArrayCollection();
        $this->isActive    = true;
    }

    #region interface implementations
    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt() {
        return null;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles() {
        return array('ROLE_USER');
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() {
    }

    /**
     * Serializes the Object
     *
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
     * Unserializes the Object
     *
     * @see \Serializable::unserialize()
     * @param string $serialized
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

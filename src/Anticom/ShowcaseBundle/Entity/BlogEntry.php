<?php
/**
 * BlogEntry.php
 * 
 * Date: 13.03.14
 * Time: 14:06
 * @author Timo Mühlbach
 * @namespace Anticom\ShowcaseBundle\Entity
 */

namespace Anticom\ShowcaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class BlogEntry
 * @ORM\Entity()
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

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $title;
    /**
     * @ORM\Column(type="text")
     */
    protected $body;
    protected $author;

    protected $comments;

    /**
     * @ORM\Colum(type="datetime")
     */
    protected $dateTimeCreated;

    /**
     * @ORM\PrePersist
     */
    public function setDateTimeCreated() {
        $this->dateTimeCreated = new \DateTime();
    }
} 
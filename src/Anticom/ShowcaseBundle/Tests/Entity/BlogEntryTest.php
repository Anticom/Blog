<?php

namespace Anticom\ShowcaseBundle\Tests\Entity;

use Anticom\ShowcaseBundle\Entity\BlogEntry;
use Anticom\ShowcaseBundle\Entity\Comment;
use Anticom\ShowcaseBundle\Entity\User;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Anticom\ShowcaseBundle\Entity\BlogEntry
 */
class BlogEntryTest extends PHPUnit_Framework_TestCase {
    #region setup
    /** @var  BlogEntry */
    protected $blogEntry;

    protected function setUp() {
        $this->blogEntry = new BlogEntry();
    }
    #endregion

    #region tests
    /**
     * @dataProvider provideTitle
     */
    public function testTitle($title) {
        $this->assertEquals($title, $this->blogEntry->setTitle($title)->getTitle());
    }

    /**
     * @dataProvider provideBody
     */
    public function testBody($body) {
        $this->assertEquals($body, $this->blogEntry->setBody($body)->getBody());
    }

    /**
     * @dataProvider provideAuthor
     */
    public function testAuthor($author) {
        $this->assertEquals($author, $this->blogEntry->setAuthor($author)->getAuthor());
    }

    /**
     * @dataProvider provideDateTimeCreated
     */
    public function testDateTimeCreated($date) {
        $this->assertEquals($date, $this->blogEntry->autoSetDateTimeCreated()->setDateTimeCreated($date)->getDateTimeCreated());
    }

    public function testComments() {
        $dummyComment = new Comment();
        $this->assertCount(0, $this->blogEntry->getComments());
        $this->blogEntry->addComment($dummyComment);
        $this->assertCount(1, $this->blogEntry->getComments());
        $this->blogEntry->removeComment($dummyComment);
        $this->assertCount(0, $this->blogEntry->getComments());
    }
    #endregion

    #region providers
    public static function provideTitle() {
        return array(
            array('plain'),
            array('<b>formatted</b>')
        );
    }

    public static function provideBody() {
        return array(
            array('plain'),
            array('<b>formatted</b>')
        );
    }

    public static function provideAuthor() {
        return array(
            array(new User()),
            array(null)
        );
    }

    public static function provideDateTimeCreated() {
        return array(
            array(new \DateTime())
        );
    }
    #endregion
}

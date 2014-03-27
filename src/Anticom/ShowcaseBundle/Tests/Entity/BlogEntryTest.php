<?php
/**
 * BlogEntryTest.php
 *
 * @author    Timo M
 * @namespace Anticom\ShowcaseBundle\Tests\Entity
 * @package   Test\Unit\Entity
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Anticom\ShowcaseBundle\Tests\Entity;

use Anticom\ShowcaseBundle\Entity\BlogEntry;
use Anticom\ShowcaseBundle\Entity\Comment;
use Anticom\ShowcaseBundle\Entity\User;
use PHPUnit_Framework_TestCase;

/**
 * Class BlogEntryTest
 *
 * @coversDefaultClass \Anticom\ShowcaseBundle\Entity\BlogEntry
 */
class BlogEntryTest extends PHPUnit_Framework_TestCase {
    #region setup
    /** @var  BlogEntry Common BlogEntry */
    protected $blogEntry;

    /**
     * Called before every test
     */
    protected function setUp() {
        $this->blogEntry = new BlogEntry();
    }
    #endregion

    #region tests
    /**
     * Test Title
     *
     * @param string $title
     *
     * @dataProvider provideTitle
     */
    public function testTitle($title) {
        $this->assertEquals($title, $this->blogEntry->setTitle($title)->getTitle());
    }

    /**
     * Test Body
     *
     * @param string $body
     *
     * @dataProvider provideBody
     */
    public function testBody($body) {
        $this->assertEquals($body, $this->blogEntry->setBody($body)->getBody());
    }

    /**
     * Test Author
     *
     * @param User $author
     *
     * @dataProvider provideAuthor
     */
    public function testAuthor($author) {
        $this->assertEquals($author, $this->blogEntry->setAuthor($author)->getAuthor());
    }

    /**
     * Test DateTimeCreated
     *
     * @param \DateTime $date
     *
     * @dataProvider provideDateTimeCreated
     */
    public function testDateTimeCreated($date) {
        $this->assertEquals($date, $this->blogEntry->autoSetDateTimeCreated()->setDateTimeCreated($date)->getDateTimeCreated());
    }

    /**
     * Test Comments
     */
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
    /**
     * Provider for testTitle
     *
     * @return array
     */
    public static function provideTitle() {
        return array(
            array('plain'),
            array('<b>formatted</b>')
        );
    }

    /**
     * Provider for testBody
     *
     * @return array
     */
    public static function provideBody() {
        return array(
            array('plain'),
            array('<b>formatted</b>')
        );
    }

    /**
     * Provider for testAuthor
     *
     * @return array
     */
    public static function provideAuthor() {
        return array(
            array(new User()),
            array(null)
        );
    }

    /**
     * Provider for testDateTimeCreated
     *
     * @return array
     */
    public static function provideDateTimeCreated() {
        return array(
            array(new \DateTime())
        );
    }
    #endregion
}

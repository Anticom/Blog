<?php
/**
 * CommentTest.php
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
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CommentTest
 *
 * @coversDefaultClass \Anticom\ShowcaseBundle\Entity\Comment
 */
class CommentTest extends WebTestCase {
    #region setup
    /**
     * @var \Doctrine\ORM\EntityManager Common EntityManager
     */
    private $em;
    /**
     * @var Comment Common Comment
     */
    protected $comment;

    /**
     * Called before every test
     */
    public function setUp() {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->comment = new Comment();
    }

    /**
     * Called after every test
     */
    protected function tearDown() {
        parent::tearDown();
        $this->em->close();
    }
    #endregion

    #region tests
    /**
     * Test Body
     *
     * @param string $body
     *
     * @dataProvider provideBody
     */
    public function testBody($body) {
        $this->assertEquals($body, $this->comment->setBody($body)->getBody());
    }

    /**
     * Test Author
     *
     * @param User $author
     *
     * @dataProvider provideAuthor
     */
    public function testAuthor($author) {
        $this->assertEquals($author, $this->comment->setAuthor($author)->getAuthor());
    }

    /**
     * Test DateTimeCreated
     *
     * @param \DateTime $date
     *
     * @dataProvider provideDateTimeCreated
     */
    public function testDateTimeCreated($date) {
        $this->assertEquals($date, $this->comment->autoSetDateTimeCreated()->setDateTimeCreated($date)->getDateTimeCreated());
    }

    /**
     * Test BlogEntry
     */
    public function testBlogEntry() {
        $dummyBlogEntry = new BlogEntry();
        $this->assertEquals(null, $this->comment->getBlogEntry());
        $this->assertEquals($dummyBlogEntry, $this->comment->setBlogEntry($dummyBlogEntry)->getBlogEntry());
    }

    /**
     * Test Children (Comments)
     */
    public function testChildComments() {
        $dummyComment = new Comment();
        $this->assertCount(0, $this->comment->getChildren());
        $this->comment->addChild($dummyComment);
        $this->assertCount(1, $this->comment->getChildren());
        $this->comment->removeChild($dummyComment);
        $this->assertCount(0, $this->comment->getChildren());
    }

    /**
     * Test RootComment
     *
     * @param int $currentId
     * @param int $rootId
     *
     * @dataProvider provideRootComment
     */
    public function testRootComment($currentId, $rootId) {
        /** @var Comment $current */
        $repo    = $this->em->getRepository('AnticomShowcaseBundle:Comment');
        $current = $repo->find($currentId);
        $root    = $current->getRootComment();

        $this->assertEquals($rootId, $root->getId());
    }
    #region tests

    #region providers
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

    /**
     * Provider for testRootComment
     *
     * @return array
     */
    public static function provideRootComment() {
        return array(
            array(1, 1),
            array(2, 1),
            array(3, 3)
        );
    }
    #endregion
}

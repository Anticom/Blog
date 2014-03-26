<?php

namespace Anticom\ShowcaseBundle\Tests\Entity;

use Anticom\ShowcaseBundle\Entity\BlogEntry;
use Anticom\ShowcaseBundle\Entity\Comment;
use Anticom\ShowcaseBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @coversDefaultClass \Anticom\ShowcaseBundle\Entity\Comment
 */
class CommentTest extends WebTestCase {
    #region setup
    /** @var \Doctrine\ORM\EntityManager */
    private $em;
    /** @var  Comment */
    protected $comment;

    public function setUp() {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->comment = new Comment();
    }

    protected function tearDown() {
        parent::tearDown();
        $this->em->close();
    }
    #endregion

    #region tests
    /**
     * @dataProvider provideBody
     */
    public function testBody($body) {
        $this->assertEquals($body, $this->comment->setBody($body)->getBody());
    }

    /**
     * @dataProvider provideAuthor
     */
    public function testAuthor($author) {
        $this->assertEquals($author, $this->comment->setAuthor($author)->getAuthor());
    }

    /**
     * @dataProvider provideDateTimeCreated
     */
    public function testDateTimeCreated($date) {
        $this->assertEquals($date, $this->comment->autoSetDateTimeCreated()->setDateTimeCreated($date)->getDateTimeCreated());
    }

    public function testBlogEntry() {
        $dummyBlogEntry = new BlogEntry();
        $this->assertEquals(null, $this->comment->getBlogEntry());
        $this->assertEquals($dummyBlogEntry, $this->comment->setBlogEntry($dummyBlogEntry)->getBlogEntry());
    }

    public function testChildComments() {
        $dummyComment = new Comment();
        $this->assertCount(0, $this->comment->getChildren());
        $this->comment->addChild($dummyComment);
        $this->assertCount(1, $this->comment->getChildren());
        $this->comment->removeChild($dummyComment);
        $this->assertCount(0, $this->comment->getChildren());
    }

    /**
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

    public static function provideRootComment() {
        return array(
            array(1, 1),
            array(2, 1),
            array(3, 3)
        );
    }
    #endregion
}

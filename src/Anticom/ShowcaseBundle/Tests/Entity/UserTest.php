<?php

namespace Anticom\ShowcaseBundle\Tests\Entity;

use Anticom\ShowcaseBundle\Entity\BlogEntry;
use Anticom\ShowcaseBundle\Entity\Comment;
use Anticom\ShowcaseBundle\Entity\User;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Anticom\ShowcaseBundle\Entity\User
 */
class UserTest extends PHPUnit_Framework_TestCase {
    #region setup
    /** @var  User */
    protected $user;

    public function setUp() {
        $this->user = new User();
    }
    #endregion

    #region tests
    /**
     * @dataProvider provideUsername
     */
    public function testUsername($username) {
        $this->assertEquals($username, $this->user->setUsername($username)->getUsername());
    }

    /**
     * @dataProvider provideEmail
     */
    public function testEmail($email) {
        $this->assertEquals($email, $this->user->setEmail($email)->getEmail());
    }

    /**
     * @dataProvider providePassword
     */
    public function testPassword($password) {
        $this->assertEquals($password, $this->user->setPassword($password)->getPassword());
    }

    /**
     * @dataProvider provideActiveState
     */
    public function testIsActive($state) {
        $this->assertEquals($state, $this->user->setIsActive($state)->getIsActive());
    }

    #region interfaces
    public function testSalt() {
        $this->assertEquals(null, $this->user->getSalt());
    }

    public function testRoles() {
        $this->assertEquals(array('ROLE_USER'), $this->user->getRoles());
    }

    /**
     * @depends testUsername
     * @depends testPassword
     */
    public function testSerialize($username, $password) {
        $expected = serialize(array(null,$username,$password));
        $serialized = $this->user->setUsername($username)->setPassword($password)->serialize();
        $this->assertEquals($expected,$serialized);

        $unserialized = clone $this->user;
        $unserialized->unserialize($serialized);
        $this->assertEquals($this->user, $unserialized);
    }

    public function testBlogEntry() {
        $dummyBlogEntry = new BlogEntry();
        $this->assertCount(0, $this->user->getBlogEntries());
        $this->user->addBlogEntry($dummyBlogEntry);
        $this->assertCount(1, $this->user->getBlogEntries());
        $this->user->removeBlogEntry($dummyBlogEntry);
        $this->assertCount(0, $this->user->getBlogEntries());
    }

    public function testComments() {
        $dummyComment = new Comment();
        $this->assertCount(0, $this->user->getComments());
        $this->user->addComment($dummyComment);
        $this->assertCount(1, $this->user->getComments());
        $this->user->removeComment($dummyComment);
        $this->assertCount(0, $this->user->getComments());
    }
    #endregion
    #endregion

    #region providers
    public static function provideUsername() {
        return array(
            array('oneString'),
            array('two strings')
        );
    }

    public static function provideEmail() {
        return array(
            array('valid@example.com'),
            array('yet.another@email.com')
        );
    }

    public static function providePassword() {
        return array(
            array('xjesirijoeriower'),
            array('asr764sar6aser6'),
            array('_-?!#sri64sr89r32461fse')
        );
    }

    public static function provideActiveState() {
        return array(
            array(true),
            array(false)
        );
    }

    public static function provideSerializationInfo() {
        return array(
            array('username', 'password'),
            array('another username', '_-?!#sri64sr89r32461fse')
        );
    }
    #endregion
}

<?php
/**
 * UserTest.php
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
 * Class UserTest
 *
 * @coversDefaultClass \Anticom\ShowcaseBundle\Entity\User
 */
class UserTest extends PHPUnit_Framework_TestCase {
    #region setup
    /** @var  User Common User */
    protected $user;

    /**
     * Called before every test
     */
    public function setUp() {
        $this->user = new User();
    }
    #endregion

    #region tests
    /**
     * Test Id
     */
    public function testId() {
        $this->assertEquals(null, $this->user->getId());
    }

    /**
     * Test Username
     *
     * @param string $username
     *
     * @dataProvider provideUsername
     */
    public function testUsername($username) {
        $this->assertEquals($username, $this->user->setUsername($username)->getUsername());
    }

    /**
     * Test Email
     *
     * @param string $email
     *
     * @dataProvider provideEmail
     */
    public function testEmail($email) {
        $this->assertEquals($email, $this->user->setEmail($email)->getEmail());
    }

    /**
     * Test Password
     *
     * @param string $password
     *
     * @dataProvider providePassword
     */
    public function testPassword($password) {
        $this->assertEquals($password, $this->user->setPassword($password)->getPassword());
    }

    /**
     * Test IsActive
     *
     * @param bool $state
     *
     * @dataProvider provideActiveState
     */
    public function testIsActive($state) {
        $this->assertEquals($state, $this->user->setIsActive($state)->getIsActive());
    }

    #region interfaces
    /**
     * Test Salt
     */
    public function testSalt() {
        $this->assertEquals(null, $this->user->getSalt());
    }

    /**
     * Test Roles
     */
    public function testRoles() {
        $this->assertNotEmpty($this->user->getRoles());
        $this->assertEquals(array('ROLE_USER'), $this->user->getRoles());
    }

    /**
     * Test \Serializable Interface
     *
     * @param string $username
     * @param string $password
     *
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

    /**
     * Test BlogEntry
     */
    public function testBlogEntry() {
        $dummyBlogEntry = new BlogEntry();
        $this->assertCount(0, $this->user->getBlogEntries());
        $this->user->addBlogEntry($dummyBlogEntry);
        $this->assertCount(1, $this->user->getBlogEntries());
        $this->user->removeBlogEntry($dummyBlogEntry);
        $this->assertCount(0, $this->user->getBlogEntries());
    }

    /**
     * Test Comments
     */
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
    /**
     * Provider for testUsername
     *
     * @return array
     */
    public static function provideUsername() {
        return array(
            array('oneString'),
            array('two strings')
        );
    }

    /**
     * Provider for testEmail
     *
     * @return array
     */
    public static function provideEmail() {
        return array(
            array('valid@example.com'),
            array('yet.another@email.com')
        );
    }

    /**
     * Provider for testPassword
     *
     * @return array
     */
    public static function providePassword() {
        return array(
            array('xjesirijoeriower'),
            array('asr764sar6aser6'),
            array('_-?!#sri64sr89r32461fse')
        );
    }

    /**
     * Provider for testIsActive
     *
     * @return array
     */
    public static function provideActiveState() {
        return array(
            array(true),
            array(false)
        );
    }

    /**
     * Provider for testSerialize
     *
     * @return array
     */
    public static function provideSerializationInfo() {
        return array(
            array('username', 'password'),
            array('another username', '_-?!#sri64sr89r32461fse')
        );
    }
    #endregion
}

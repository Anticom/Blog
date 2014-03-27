<?php
/**
 * CommentControllerTest.php
 *
 * @author    Timo M
 * @namespace Anticom\ShowcaseBundle\Tests\Controller
 * @package   Test\Functional\Controller
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CommentControllerTest
 */
class CommentControllerTest extends WebTestCase {
    #region tests
    /**
     * Try to create a new Comment unauthenticated
     */
    public function testNewDenied() {
        $client = static::createClient();
        $client->request('GET', '/blog/comment/new/1');

        $response = $client->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertTrue($response->isRedirect('/login'));
    }

    /**
     * Try to create a new Comment authenticated
     */
    public function testNewAuthenticated() {
        $client  = static::createClient(array(), SecurityControllerTest::$auth);
        $crawler = $client->request('GET', '/blog/comment/new/1');
        $this->assertTrue($crawler->filter('html:contains("Neuen Kommentar verfassen")')->count() > 0);
    }

    /**
     * Try to create a new Comment authenticated for a BlogEntry that not exists
     */
    public function testNewAuthenticated404() {
        $client  = static::createClient(array(), SecurityControllerTest::$auth);
        $client->request('GET', '/blog/comment/new/0');

        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Try to create a new Comment authenticated as a response to another Comment
     *
     * @depends testNewAuthenticated
     */
    public function testNewWithParentAuthenticated() {
        $client  = static::createClient(array(), SecurityControllerTest::$auth);
        $crawler = $client->request('GET', '/blog/comment/new/1/1');
        $this->assertTrue($crawler->filter('html:contains("Vorangegangene Kommentare")')->count() > 0);
    }
    #endregion
}
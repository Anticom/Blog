<?php
/**
 * DefaultControllerTest.php
 *
 * @author    Timo M
 * @namespace Anticom\ShowcaseBundle\Tests\Controller
 * @package   Test\Functional\Controller
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DefaultControllerTest
 */
class DefaultControllerTest extends WebTestCase {
    #region tests
    /**
     * Try to access the launch page unauthenticated
     */
    public function testIndex() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Lorem ipsum")')->count() > 0);
    }

    /**
     * Try to access the launch page authenticated
     *
     * @depends testIndex
     */
    public function testIndexAuthenticated() {
        $client  = static::createClient(array(), SecurityControllerTest::$auth);
        $crawler = $client->request('GET', '/');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("abmelden")')->count() > 0);
    }

    /**
     * Try to access the impress page (ununauthenticated)
     *
     * @depends testIndex
     */
    public function testImpress() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/impress');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Impressum")')->count() > 0);
    }

    /**
     * Try to access the contact page (unauthenticated)
     *
     * @depends testIndex
     */
    public function testContact() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/contact');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Kontakt")')->count() > 0);
    }
    #endregion
}

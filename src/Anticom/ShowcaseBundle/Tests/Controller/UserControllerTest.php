<?php
/**
 * UserControllerTest.php
 *
 * @author    Timo M
 * @namespace Anticom\ShowcaseBundle\Tests\Controller
 * @package   Test\Functional\Controller
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class UserControllerTest
 */
class UserControllerTest extends WebTestCase {
    #region tests
    /**
     * Try to view Profile
     */
    public function testProfile() {
        $this->markTestIncomplete('Not yet implemented');

        $client  = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($crawler->filter('html:contains("Neuen Blogeintrag anlegen")')->count() > 0);
    }

    /**
     * Try to sign up
     */
    public function testRegister() {
        $this->markTestIncomplete('Not yet implemented');

        $client  = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($crawler->filter('html:contains("Neuen Blogeintrag anlegen")')->count() > 0);
    }
    #endregion
} 
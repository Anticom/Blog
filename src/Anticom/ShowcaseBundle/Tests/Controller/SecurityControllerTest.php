<?php
/**
 * SecurityControllerTest.php
 *
 * @author    Timo M
 * @namespace Anticom\ShowcaseBundle\Tests\Controller
 * @package   Test\Functional\Controller
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Anticom\ShowcaseBundle\Tests\Messages;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class SecurityControllerTest
 */
class SecurityControllerTest extends WebTestCase {
    /**
     * @var array Valid auth information
     */
    public static $auth = array(
        'PHP_AUTH_USER' => 'demo1',
        'PHP_AUTH_PW'   => 'demo1',
    );

    #region tests
    /**
     * Try to login with invalid credentials
     */
    public function testLoginFailure() {
        $client = static::createClient();
        $client->request('GET', '/login');

        //https required
        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();

        $crawler           = $client->getCrawler();
        $buttonCrawlerNode = $crawler->selectButton('login_submit');
        $form              = $buttonCrawlerNode->form(
            array(
                '_username' => 'demo1',
                '_password' => 'wrong password'
            )
        );
        $client->submit($form);

        $response = $client->getResponse();
        $this->assertTrue($response->isRedirect(), Messages::REDIRECT);
        $client->followRedirect();
        $this->assertTrue($client->getCrawler()->filter('html:contains("Benutzername oder Passwort falsch!")')->count() > 0, Messages::FLASH_MESSAGE . ': Missing `bad credentials` message');
    }

    /**
     * Try to login with correct credentials
     *
     * @depends testLoginFailure
     */
    public function testLoginSuccess() {
        $client = static::createClient();
        $client->request('GET', '/login');

        //https required
        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();

        $crawler           = $client->getCrawler();
        $buttonCrawlerNode = $crawler->selectButton('login_submit');
        $form              = $buttonCrawlerNode->form(
            array(
                '_username' => 'demo1',
                '_password' => 'demo1'
            )
        );
        $client->submit($form);

        $response = $client->getResponse();
        $this->assertTrue($response->isRedirect(), Messages::REDIRECT);
        $client->followRedirect();

        $crawler = $client->getCrawler();
        $this->assertTrue($crawler->filter('html:contains("Lorem ipsum dolor")')->count() > 0, 'Unable to find index page dummy text (Lorem ipsum...)');
    }

    /**
     * Try to log out
     */
    public function testLogout() {
        $this->markTestIncomplete('Bug');

        $client  = static::createClient(array(), self::$auth);
        $crawler = $client->request('GET', '/');

        $link = $crawler->filter('a:contains("abmelden")')->eq(0)->link();
        $client->click($link);

        $response = $client->getResponse();
        $this->assertTrue($response->isRedirect(), Messages::REDIRECT);
        $client->followRedirect();

        $crawler = $client->getCrawler();
        $this->assertTrue($crawler->filter('a:contains("Anmelden")')->count() > 0, 'Unable to locate login link in navbar. This should indicate you\'re logged out now');
        $this->assertTrue($crawler->filter('html:contains("Lorem ipsum dolor")')->count() > 0, 'Unable to find index page dummy text (Lorem ipsum...)');
    }
    #endregion
}
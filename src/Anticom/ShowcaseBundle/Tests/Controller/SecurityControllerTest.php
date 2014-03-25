<?php

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase {
    public static $auth = array(
        'PHP_AUTH_USER' => 'demo1',
        'PHP_AUTH_PW'   => 'demo1',
    );

    public function testLoginFailure() {
        $client            = static::createClient();
        $crawler           = $client->request('GET', '/login');
        $buttonCrawlerNode = $crawler->filter('#login_submit');
        $form              = $buttonCrawlerNode->form(
            array(
                '_username' => 'demo1',
                '_password' => 'wrong password'
            )
        );
        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/login'));
        $this->assertTrue($client->getCrawler()->filter('html:contains("Bad credentials")')->count() > 0);
    }

    /**
     * @depends testLoginFailure
     */
    public function testLoginSuccess() {
        $client            = static::createClient();
        $crawler           = $client->request('GET', '/login');
        $buttonCrawlerNode = $crawler->selectButton('login_submit');
        $form              = $buttonCrawlerNode->form(
            array(
                '_username' => 'demo1',
                '_password' => 'demo1'
            )
        );
        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/'));
    }

    public function testLogout() {
        $this->markTestIncomplete('Not implemented properly yet');

        $client  = static::createClient(array(), self::$auth);
        $crawler = $client->request('GET', '/');

        $link = $crawler->filter('a:contains("abmelden")')->eq(0)->link();
        $crawler = $client->click($link);
        $this->assertTrue($crawler->filter('html:contains("Lorem ipsum dolor")')->count() > 0);
    }
}
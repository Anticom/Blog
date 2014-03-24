<?php

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase {
    public static $auth = [
        'PHP_AUTH_USER' => 'demo1',
        'PHP_AUTH_PW'   => 'demo1',
    ];

    public function testLoginFailure() {
        $client            = static::createClient();
        $crawler           = $client->request('GET', '/login');
        $buttonCrawlerNode = $crawler->selectButton('submit');
        $form              = $buttonCrawlerNode->form(
            [
                '_username' => 'demo1',
                '_password' => 'wrong password'
            ]
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
        $buttonCrawlerNode = $crawler->selectButton('submit');
        $form              = $buttonCrawlerNode->form(
            [
                '_username' => 'demo1',
                '_password' => 'demo1'
            ]
        );
        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/'));
    }

    /**
     * @depends testLoginSuccess
     */
    public function testLogout() {
        $this->markTestIncomplete('Not yet implemented');

        $client  = static::createClient([], self::$auth);
        $crawler = $client->request('GET', '/');
        $this->assertTrue($crawler->filter('html:contains("Lorem ipsum dolor")')->count() > 0);

        /*
        $link = $crawler->filter('a:contains("abmelden")')->eq(1)->link();
        $crawler = $client->click($link);
        $client->getContainer();
        */
    }
}
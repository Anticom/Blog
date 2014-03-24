<?php

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase {
    public function testLoginFailure() {
        $this->markTestIncomplete('Not yet implemented');

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

    public function testLoginSuccess() {
        $this->markTestIncomplete('Not yet implemented');

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

        $client  = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($crawler->filter('html:contains("Neuen Blogeintrag anlegen")')->count() > 0);
    }
}
<?php

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase {
    public function testLogin() {
        $this->markTestIncomplete('Not yet implemented');

        $client  = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($crawler->filter('html:contains("Neuen Blogeintrag anlegen")')->count() > 0);
    }

    /**
     * @depends testLogin
     */
    public function testLogout() {
        $this->markTestIncomplete('Not yet implemented');

        $client  = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($crawler->filter('html:contains("Neuen Blogeintrag anlegen")')->count() > 0);
    }
}
<?php

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase {
    public function testIndex() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($crawler->filter('html:contains("Lorem ipsum")')->count() > 0);
    }

    /**
     * @depends testIndex
     */
    public function testImpress() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/impress');
        $this->assertTrue($crawler->filter('html:contains("Impressum")')->count() > 0);
    }

    /**
     * @depends testIndex
     */
    public function testContact() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/contact');
        $this->assertTrue($crawler->filter('html:contains("Kontakt")')->count() > 0);
    }
}

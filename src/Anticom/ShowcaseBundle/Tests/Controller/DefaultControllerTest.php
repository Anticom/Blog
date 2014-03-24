<?php

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase {
    public function testIndex() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Lorem ipsum")')->count() > 0);
    }

    /**
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
     * @depends testIndex
     */
    public function testContact() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/contact');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Kontakt")')->count() > 0);
    }
}

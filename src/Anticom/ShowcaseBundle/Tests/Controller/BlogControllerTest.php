<?php

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase {
    public function testList() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog');
        $this->assertTrue($crawler->filter('html:contains("Das ist der Body vom Demo Eintrag 1")')->count() > 0);
    }

    public function testShow() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog/show/');
        $this->assertTrue($crawler->filter('html:contains("Demo Eintrag 1")')->count() > 0);
    }

    public function testNew() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($crawler->filter('html:contains("Neuen Blogeintrag anlegen")')->count() > 0);
    }

    public function testEdit() {
        $this->markTestIncomplete('Not yet implemented');

        $client  = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($crawler->filter('html:contains("Blogeintrag bearbeiten")')->count() > 0);
    }
}
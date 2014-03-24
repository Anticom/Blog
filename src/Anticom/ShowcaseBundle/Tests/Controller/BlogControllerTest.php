<?php

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase {
    private static $auth = [
        'PHP_AUTH_USER' => 'demo1',
        'PHP_AUTH_PW'   => 'demo1'
    ];

    public function testList() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog');
        $this->assertTrue($crawler->filter('html:contains("Das ist der Body vom Demo Eintrag 1")')->count() > 0);
    }

    public function testShow() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog/show/1');
        $this->assertTrue($crawler->filter('html:contains("Demo Eintrag 1")')->count() > 0);
    }

    public function testNewDenied() {
        $client = static::createClient();
        $client->request('GET', '/blog/new');
        $this->assertTrue($client->getResponse()->isRedirect('/login'));
    }

    public function testNewAuthenticated() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog/new', [], [], self::$auth);
        $this->assertTrue($crawler->filter('html:contains("Neuen Blogeintrag anlegen")')->count() > 0);
    }

    public function testEditDenied() {
        $client = static::createClient();
        $client->request('GET', '/blog/edit/1');
        $this->assertTrue($client->getResponse()->isRedirect('/login'));
    }

    public function testEditAuthenticated() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog/edit/1', [], [], self::$auth);
        $this->assertTrue($crawler->filter('html:contains("Blogeintrag bearbeiten")')->count() > 0);
    }
}
<?php

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase {
    #region tests
    public function testNewDenied() {
        $client = static::createClient();
        $client->request('GET', '/blog/comment/new/1');

        $response = $client->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertTrue($response->isRedirect('/login'));
    }

    public function testNewAuthenticated() {
        $client  = static::createClient(array(), SecurityControllerTest::$auth);
        $crawler = $client->request('GET', '/blog/comment/new/1');
        $this->assertTrue($crawler->filter('html:contains("Neuen Kommentar verfassen")')->count() > 0);
    }

    public function testNewAuthenticated404() {
        $client  = static::createClient(array(), SecurityControllerTest::$auth);
        $client->request('GET', '/blog/comment/new/0');

        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @depends testNewAuthenticated
     */
    public function testNewWithParentAuthenticated() {
        $client  = static::createClient(array(), SecurityControllerTest::$auth);
        $crawler = $client->request('GET', '/blog/comment/new/1/1');
        $this->assertTrue($crawler->filter('html:contains("Vorangegangene Kommentare")')->count() > 0);
    }
    #endregion
}
<?php

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase {
    public function testNewDenied() {
        $client = static::createClient();
        $client->request('GET', '/blog/comment/new/1');

        $response = $client->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertTrue($response->isRedirect('/login'));
    }

    public function testNewAuthenticated() {
        $client  = static::createClient([], SecurityControllerTest::$auth);
        $crawler = $client->request('GET', '/blog/comment/new/1');
        $this->assertTrue($crawler->filter('html:contains("Neuen Kommentar verfassen")')->count() > 0);
    }
}
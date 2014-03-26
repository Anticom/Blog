<?php

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Anticom\ShowcaseBundle\Tests\Tools;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase {
    #region setup
    /**
     * @beforeClass
     */
    public static function loadFixtures() {
        Tools::runCommand(
            static::createClient(),
            'doctrine:fixtures:load'
        );
    }
    #endregion

    #region tests
    public function testList() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Das ist der Body vom Demo Eintrag 1")')->count() > 0);
    }

    public function testShow404() {
        $client = static::createClient();
        $client->request('GET', '/blog/show/0');

        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testShow() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog/show/1');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Demo Eintrag 1")')->count() > 0);
    }

    public function testNewDenied() {
        $client = static::createClient();
        $client->request('GET', '/blog/new');

        $response = $client->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertTrue($response->isRedirect('/login'));
    }

    public function testNewAuthenticated() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog/new', array(), array(), SecurityControllerTest::$auth);

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Neuen Blogeintrag anlegen")')->count() > 0);
    }

    public function testNewAutheticatedSubmit() {
        $this->markTestIncomplete('CRFS token issue');

        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog/new', array(), array(), SecurityControllerTest::$auth);

        $buttonCrawlerNode = $crawler->selectButton('blog_entry_submit');
        $form              = $buttonCrawlerNode->form(
            array(
                'blog_entry[_token]' => $crawler->filter('form #blog_entry__token')->attr('value'),
                'blog_entry[title]' => 'Title provided by test class',
                'blog_entry[body]'  => 'Body provided by test class',
                'blog_entry[submit]' => ''
            )
        );
        $client->submit($form);

        $response = $client->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Ihr Blogeintrag wurde erfolgreich gespeichert")')->count() > 0);
    }

    public function testEditDenied() {
        $client = static::createClient();
        $client->request('GET', '/blog/edit/1');

        $response = $client->getResponse();
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertTrue($response->isRedirect('/login'));
    }

    public function testEditAuthenticated() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog/edit/1', array(), array(), SecurityControllerTest::$auth);

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Blogeintrag bearbeiten")')->count() > 0);
    }
    #endregion
}

<?php

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Anticom\ShowcaseBundle\Entity\BlogEntry;
use Anticom\ShowcaseBundle\Tests\Messages;
use Anticom\ShowcaseBundle\Tests\Tools;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase {
    #region setup
    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    private static $fixturesLoaded = false;

    /**
     * {@inheritDoc}
     */
    public function setUp() {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        if(!static::$fixturesLoaded) {
            Tools::runCommands(
                static::createClient(),
                array(
                    'doctrine:schema:drop -n --force',
                    'doctrine:schema:create -n',
                    'doctrine:fixtures:load -n'
                )
            );

            static::$fixturesLoaded = true;
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown() {
        parent::tearDown();
        $this->em->close();
    }
    #endregion

    #region tests
    public function testList() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), Messages::STATUS_CODE);
        $this->assertTrue($crawler->filter('html:contains("Das ist der Body vom Demo Eintrag 1")')->count() > 0, 'Unable to find body');
    }

    public function testShow404() {
        $client = static::createClient();
        $client->request('GET', '/blog/show/0');

        $response = $client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), Messages::STATUS_CODE);
    }

    public function testShow() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog/show/1');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), Messages::STATUS_CODE);
        $this->assertTrue($crawler->filter('html:contains("Demo Eintrag 1")')->count() > 0, 'Unable to find body');
    }

    public function testNewDenied() {
        $client = static::createClient();
        $client->request('GET', '/blog/new');

        $response = $client->getResponse();
        $this->assertEquals(302, $response->getStatusCode(), Messages::STATUS_CODE);
        $this->assertTrue($response->isRedirect('/login'), Messages::REDIRECT);
    }

    public function testNewAuthenticated() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog/new', array(), array(), SecurityControllerTest::$auth);

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), Messages::STATUS_CODE);
        $this->assertTrue($crawler->filter('html:contains("Neuen Blogeintrag anlegen")')->count() > 0, 'Unable to locate header indicating creation of blog entry');
    }

    /**
     * @depends testNewAuthenticated
     */
    public function testNewAutheticatedSubmit() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog/new', array(), array(), SecurityControllerTest::$auth);

        $buttonCrawlerNode = $crawler->selectButton('blog_entry_submit');
        $form              = $buttonCrawlerNode->form(
            array(
                'blog_entry[_token]' => $crawler->filter('form #blog_entry__token')->attr('value'),
                'blog_entry[title]'  => 'Title provided by test class',
                'blog_entry[body]'   => 'Body provided by test class',
                'blog_entry[submit]' => ''
            )
        );
        $client->submit($form);

        $response = $client->getResponse();
        $this->assertTrue($response->isRedirect(), Messages::REDIRECT);
        $this->assertEquals(302, $response->getStatusCode(), Messages::STATUS_CODE);
        $client->followRedirect();
        $crawler = $client->getCrawler();
        $this->assertTrue($crawler->filter('html:contains("Ihr Blogeintrag wurde erfolgreich gespeichert")')->count() > 0, Messages::FLASH_MESSAGE);
    }

    public function testEditDenied() {
        $client = static::createClient();
        $client->request('GET', '/blog/edit/1');

        $response = $client->getResponse();
        $this->assertEquals(302, $response->getStatusCode(), Messages::STATUS_CODE);
        $this->assertTrue($response->isRedirect('/login'), Messages::REDIRECT);
    }

    public function testEditAuthenticated() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog/edit/1', array(), array(), SecurityControllerTest::$auth);

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), Messages::STATUS_CODE);
        $this->assertTrue($crawler->filter('html:contains("Blogeintrag bearbeiten")')->count() > 0, 'Unable to locate header indicating edit of blog entry');
    }

    /**
     * @depends testEditAuthenticated
     */
    public function testEditAuthenticatedSubmit() {
        //get last created BlogEntry
        /** @var BlogEntry $lastBlogEntry */
        $lastBlogEntry = $this->em->getRepository('AnticomShowcaseBundle:BlogEntry')->findOneBy(array(), array('id' => 'DESC'));

        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog/edit/'.$lastBlogEntry->getId(), array(), array(), SecurityControllerTest::$auth);

        $buttonCrawlerNode = $crawler->selectButton('blog_entry_submit');
        $form              = $buttonCrawlerNode->form(
            array(
                'blog_entry[_token]' => $crawler->filter('form #blog_entry__token')->attr('value'),
                'blog_entry[title]'  => 'Title provided by test class',
                'blog_entry[body]'   => 'Body now modiefied by test class',
                'blog_entry[submit]' => ''
            )
        );
        $client->submit($form);

        $response = $client->getResponse();
        $this->assertTrue($response->isRedirect(), Messages::REDIRECT);
        $this->assertEquals(302, $response->getStatusCode(), Messages::STATUS_CODE);
        $client->followRedirect();
        
        $crawler = $client->getCrawler();
        $this->assertTrue($crawler->filter('html:contains("Ihr Blogeintrag wurde erfolgreich aktuallisiert!")')->count() > 0, Messages::FLASH_MESSAGE);
    }

    public function testDeleteDenied() {
        $client = static::createClient();
        $client->request('GET', '/blog/delete/1');

        $response = $client->getResponse();
        $this->assertEquals(302, $response->getStatusCode(), Messages::STATUS_CODE);
        $this->assertTrue($response->isRedirect('/login'), Messages::REDIRECT);
    }

    public function testDeleteAuthenticated() {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog/delete/1', array(), array(), SecurityControllerTest::$auth);

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), Messages::STATUS_CODE);
        $this->assertTrue($crawler->filter('html:contains("Blogeintrag löschen")')->count() > 0, 'Unable to locate header indicating deletion of blog entry');
    }

    /**
     * @depends testDeleteAuthenticated
     */
    public function testDeleteAuthenticatedSubmit() {
        //get last created BlogEntry
        /** @var BlogEntry $lastBlogEntry */
        $lastBlogEntry = $this->em->getRepository('AnticomShowcaseBundle:BlogEntry')->findOneBy(array(), array('id' => 'DESC'));

        $client  = static::createClient();
        $crawler = $client->request('GET', '/blog/delete/'.$lastBlogEntry->getId(), array(), array(), SecurityControllerTest::$auth);

        $buttonCrawlerNode = $crawler->selectButton('form_confirm');
        $form              = $buttonCrawlerNode->form(
            array(
                'form[confirm]' => ''
            )
        );
        $client->submit($form);

        $response = $client->getResponse();
        $this->assertTrue($response->isRedirect(), Messages::REDIRECT);
        $this->assertEquals(302, $response->getStatusCode(), Messages::STATUS_CODE);
        $client->followRedirect();
        $crawler = $client->getCrawler();
        $this->assertTrue($crawler->filter('html:contains("Ihr Blogeintrag wurde erfolgreich gelöscht!")')->count() > 0, Messages::FLASH_MESSAGE);
    }
    #endregion
}

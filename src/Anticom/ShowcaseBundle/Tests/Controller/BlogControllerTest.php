<?php

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

class BlogControllerTest extends WebTestCase {
    /**
     * @beforeClass
     */
    public static function loadFixtures() {
        static::runCommand(
            static::createClient(),
            'doctrine:fixtures:load'
        );
    }

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

    #region auxiliaries
    public static function runCommand(Client $client, $command) {
        $application = new Application($client->getKernel());
        $application->setAutoExit(false);

        $fp     = tmpfile();
        $input  = new StringInput($command);
        $output = new StreamOutput($fp);

        $application->run($input, $output);

        fseek($fp, 0);
        $output = '';
        while(!feof($fp)) {
            $output = fread($fp, 4096);
        }
        fclose($fp);

        return $output;
    }
    #endregion
}
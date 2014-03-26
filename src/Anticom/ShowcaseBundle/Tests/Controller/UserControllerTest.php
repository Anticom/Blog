<?php

namespace Anticom\ShowcaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase {
    #region tests
    public function testProfile() {
        $this->markTestIncomplete('Not yet implemented');

        $client  = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($crawler->filter('html:contains("Neuen Blogeintrag anlegen")')->count() > 0);
    }

    public function testRegister() {
        $this->markTestIncomplete('Not yet implemented');

        $client  = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($crawler->filter('html:contains("Neuen Blogeintrag anlegen")')->count() > 0);
    }
    #endregion
} 
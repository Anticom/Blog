<?php
/**
 * BlogEntryRepositoryTest.php
 *
 * @author    Timo M
 * @namespace Anticom\ShowcaseBundle\Tests\Entity
 * @package   Test\Unit\Entity
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Anticom\ShowcaseBundle\Tests\Entity;

use Anticom\ShowcaseBundle\Entity\BlogEntry;
use Anticom\ShowcaseBundle\Entity\BlogEntryRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class BlogEntryRepositoryTest
 *
 * @coversDefaultClass \Anticom\ShowcaseBundle\Entity\BlogEntryRepository
 */
class BlogEntryRepositoryTest extends WebTestCase {
    #region setup
    /** @var \Doctrine\ORM\EntityManager Common EntityManager */
    private $em;
    /** @var  BlogEntryRepository Common BlogEntryRepository */
    protected $blogEntryRepository;

    /**
     * Called before every test
     */
    public function setUp() {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        /** @var EntityManager $em */
        $em = $this->em;

        $this->blogEntryRepository = $em->getRepository('AnticomShowcaseBundle:BlogEntry');
    }

    /**
     * Called after every test
     */
    protected function tearDown() {
        parent::tearDown();
        $this->em->close();
    }
    #endregion

    #region tests
    /**
     * Test FindNext
     */
    public function testFindNext() {
        /**
         * @var BlogEntry $current
         * @var BlogEntry $next
         */
        $current = $this->blogEntryRepository->find(1);
        $next    = $this->blogEntryRepository->find(2);

        $this->assertEquals(
            $next->getId(),
            $this->blogEntryRepository->findNext($current)->getId()
        );
    }

    /**
     * Test FindPrev
     */
    public function testFindPrev() {
        /**
         * @var BlogEntry $current
         * @var BlogEntry $prev
         */
        $current = $this->blogEntryRepository->find(2);
        $prev    = $this->blogEntryRepository->find(1);

        $this->assertEquals(
            $prev->getId(),
            $this->blogEntryRepository->findPrev($current)->getId()
        );
    }

    /**
     * Test FindByPage
     */
    public function testFindByPage() {
        $expected = $this->blogEntryRepository->findBy(array(), array('id' => 'ASC'), 10);
        $actual   = $this->blogEntryRepository->findByPage(1, 10);

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test GetPageInfo
     */
    public function testGetPageInfo() {
        $pageCount = $this->blogEntryRepository->getPageCount(10);
        $expected  = array(
            'current' => 1,
            'count'   => $pageCount,
            'hasPrev' => false,
            'hasNext' => 1 < $pageCount
        );
        $actual    = $this->blogEntryRepository->getPageInfo(1, 10);

        $this->assertEquals($expected, $actual);
    }
    #endregion
}
 
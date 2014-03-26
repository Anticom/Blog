<?php
/**
 * User: Timo Mühlbach
 * Date: 26.03.14
 * Time: 10:43
 */

namespace Anticom\ShowcaseBundle\Tests\Entity;

use Anticom\ShowcaseBundle\Entity\BlogEntry;
use Anticom\ShowcaseBundle\Entity\BlogEntryRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @coversDefaultClass \Anticom\ShowcaseBundle\Entity\BlogEntryRepository
 */
class BlogEntryRepositoryTest extends WebTestCase {
    #region setup
    /** @var \Doctrine\ORM\EntityManager */
    private $em;
    /** @var  BlogEntryRepository */
    protected $blogEntryRepository;

    /**
     * {@inheritDoc}
     */
    public function setUp() {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->blogEntryRepository = $this->em->getRepository('AnticomShowcaseBundle:BlogEntry');
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

    public function testFindByPage() {
        $expected = $this->blogEntryRepository->findBy(array(), array('id' => 'ASC'), 10);
        $actual   = $this->blogEntryRepository->findByPage(1, 10);

        $this->assertEquals($expected, $actual);
    }

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
 
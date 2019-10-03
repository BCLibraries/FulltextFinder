<?php

use BCLib\FulltextFinder\FullTextFinder;

class FullTextFinderTest extends \PHPUnit\Framework\TestCase
{
    protected static $citations;

    /**
     * @var \BCLib\FulltextFinder\FullTextService|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    public $fulltext_service;

    /**
     * @var \BCLib\FulltextFinder\LibKey\LibKeyClient|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $libkey;

    /**
     * @var \BCLib\FulltextFinder\Crossref\CrossrefClient|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $crossref;

    /**
     * @var FullTextFinder
     */
    private $finder;

    public function setUp()
    {
        $this->fulltext_service = Mockery::mock(\BCLib\FulltextFinder\FullTextService::class);
        $this->libkey = Mockery::mock(\BCLib\FulltextFinder\LibKey\LibKeyClient::class);
        $this->crossref = Mockery::mock(\BCLib\FulltextFinder\Crossref\CrossrefClient::class);
        $this->finder = new BCLib\FulltextFinder\FullTextFinder($this->fulltext_service);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public static function setUpBeforeClass(): void
    {
        $citation_file_content = file_get_contents(__DIR__ . '/citations.json');
        self::$citations = json_decode($citation_file_content);
    }

    public function testGetDOIFindsDOIWhenPresent()
    {
        $citations_with_dois = array_filter(self::$citations, [$this, 'citationContainsDoi']);
        foreach ($citations_with_dois as $citation) {
            $this->assertEquals($citation->doi, $this->finder->getDOI($citation->text));
        }
    }

    public function testGetDOIReturnsNullWhenNotPresent()
    {
        $citations_without_dois = array_filter(self::$citations, [$this, 'citationDoesNotContainDoi']);
        foreach ($citations_without_dois as $citation) {
            $this->assertNull($this->finder->getDOI($citation->text));
        }
    }

    public function testDOIInTextTriggersFindByDOI()
    {
        $this->fulltext_service->expects()->findByDOI('10.1002/tox.20155');
        $this->finder->find('The DOI we are looking for is 10.1002/tox.20155');

        // Success if we haven't thrown an exception.
        $this->assertTrue(true);
    }

    private static function citationContainsDoi($citation): bool
    {
        return $citation->doiInText;
    }

    private static function citationDoesNotContainDoi($citation): bool
    {
        return !$citation->doiInText;
    }
}

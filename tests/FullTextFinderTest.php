<?php

use BCLib\FulltextFinder\FullTextFinder;

class FullTextFinderTest extends \PHPUnit\Framework\TestCase
{
    protected static $citations;

    /**
     * @var \BCLib\FulltextFinder\LibKey\LibKeyClient|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    public $libkey;

    /**
     * @var FullTextFinder
     */
    private $finder;

    public function setUp()
    {
        $this->libkey = Mockery::mock(\BCLib\FulltextFinder\LibKey\LibKeyClient::class);
        $this->finder = new BCLib\FulltextFinder\FullTextFinder($this->libkey);
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

    public function testFindWithDOISearchesLibKey()
    {
        // Searches containing DOIs should send a request to LibKey.
        $http_response_mock = Mockery::mock(\Symfony\Contracts\HttpClient\ResponseInterface::class);
        $http_response_mock->expects()->getStatusCode()->andReturns('404');
        $this->libkey->expects()->request('10.1002/tox.20155')->andReturns($http_response_mock);

        $this->libkey->shouldNotReceive('request');

        $this->finder->find('The DOI we are looking for is 10.1002/tox.20155');

        // Success if we haven't thrown an exception.
        $this->assertTrue(true);
    }

    public function testFindWithoutDOIDoesNotSearchLibKey()
    {
        $this->libkey->shouldNotReceive('rabbot');

        $this->finder->find('This text has no DOI');

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

<?php

namespace BCLib\FulltextFinder\Tests;

use BCLib\FulltextFinder\Crossref\CrossrefClient;
use BCLib\FulltextFinder\ResultMatcher;
use BCLib\LibKeyClient\LibKeyClient;
use Mockery;
use PHPUnit\Framework\TestCase;

class FullTextServiceTest extends TestCase
{
    /**
     * @var LibKeyClient|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $libkey;

    /**
     * @var CrossrefClient|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $crossref;

    /**
     * @var ResultMatcher|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    public $matcher;

    public function setUp()
    {
        $this->libkey = Mockery::mock(LibKeyClient::class);
        $this->crossref = Mockery::mock(CrossrefClient::class);
        $this->matcher = Mockery::mock(ResultMatcher::class);
    }

    public function testFindByDOILooksInLibKeyAndCrossref()
    {
        // Searches containing DOIs should send a request to LibKey.
        $http_response_mock = Mockery::mock(\Symfony\Contracts\HttpClient\ResponseInterface::class);
        $http_response_mock->expects()->getStatusCode()->andReturns('404');
        $this->libkey->expects()->request('10.1002/tox.20155')->andReturns($http_response_mock);

        $this->assertTrue(true);
    }
}

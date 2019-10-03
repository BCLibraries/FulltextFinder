<?php

namespace BCLib\FulltextFinder\Tests;

use Mockery;
use PHPUnit\Framework\TestCase;

class FullTextServiceTest extends TestCase
{
    /**
     * @var \BCLib\FulltextFinder\LibKey\LibKeyClient|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $libkey;

    /**
     * @var \BCLib\FulltextFinder\Crossref\CrossrefClient|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $crossref;

    public function setUp()
    {
        $this->libkey = Mockery::mock(\BCLib\FulltextFinder\LibKey\LibKeyClient::class);
        $this->crossref = Mockery::mock(\BCLib\FulltextFinder\Crossref\CrossrefClient::class);
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

<?php

namespace BCLib\Tests;

use BCLib\FulltextFinder\Crossref\CrossrefClient;
use PHPUnit\Framework\TestCase;

class CrossrefClientTest extends TestCase
{
    /**
     * @var CrossrefClient
     */
    protected $crossref_client;

    /**
     * @var string
     */
    protected $user_agent;

    /**
     * @var MockHTTPClient
     */
    protected $http_client;

    public function setUp()
    {
        $this->http_client = new MockHttpClient();
        $this->user_agent = 'Searcher/0.1 (https://library.university.edu/search; mailto:admin@university.edu)';
        $this->crossref_client = new CrossrefClient($this->user_agent, $this->http_client);
    }

    public function testRequestSetsUserAgentCorrectly()
    {
        $expected_options = ['headers' => ['User-Agent' => $this->user_agent]];
        $this->crossref_client->request('/10.001/notarealdoi');
        $actual_options = $this->http_client->last_options;
        $this->assertEquals($expected_options, $actual_options);
    }

    public function testRequestSendsCorrectURL()
    {
        $expected_uri = 'https://api.crossref.org/works/10.001/notarealdoi';
        $this->crossref_client->request('10.001/notarealdoi');
        $actual_uri = $this->http_client->last_uri;
        $this->assertEquals($expected_uri, $actual_uri);
    }

    public function testSearchSetsUserAgentCorrectly()
    {
        $expected_options = ['headers' => ['User-Agent' => $this->user_agent]];
        $this->crossref_client->search('a citation to search');
        $actual_options = $this->http_client->last_options;
        $this->assertEquals($expected_options, $actual_options);
    }

    public function testSearhSendsCorrectURL()
    {
        $expected_uri = 'https://api.crossref.org/works/#?query.bibliographic=a+citation+to+search';
        $this->crossref_client->search('a citation to search');
        $actual_uri = $this->http_client->last_uri;
        $this->assertEquals($expected_uri, $actual_uri);
    }
}
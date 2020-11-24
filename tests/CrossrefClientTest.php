<?php

namespace BCLib\Tests;

use BCLib\FulltextFinder\Crossref\CrossrefClient;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/FullTextFinderMockHTTPClient.php';

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
     * @var FullTextFinderMockHTTPClient
     */
    protected $http_client;

    public function setUp(): void
    {
        $this->http_client = new FullTextFinderMockHTTPClient();
        $this->user_agent = 'Searcher/0.1 (https://library.university.edu/search; mailto:admin@university.edu)';
        $this->crossref_client = new CrossrefClient($this->user_agent, $this->http_client);
    }

    public function testRequestSetsUserAgentCorrectly()
    {
        $expected_options = [
            'headers' => [
                'User-Agent' => $this->user_agent,
                'Accept' => 'application/json'
            ]
        ];
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

    public function testSearchSetsNoUserAgentByDefault()
    {
        $this->crossref_client = new CrossrefClient(null, $this->http_client);
        $expected_options = ['headers' => ['Accept' => 'application/json']];
        $this->crossref_client->search('a citation to search');
        $actual_options = $this->http_client->last_options;
        $this->assertEquals($expected_options, $actual_options);
    }

    public function testSearhSendsCorrectURL()
    {
        $expected_uri = 'https://api.crossref.org/works?query.bibliographic=a+citation+to+search&rows=1';
        $this->crossref_client->search('a citation to search');
        $actual_uri = $this->http_client->last_uri;
        $this->assertEquals($expected_uri, $actual_uri);
    }
}

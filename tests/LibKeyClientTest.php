<?php

namespace BCLib\Tests;

use BCLib\FulltextFinder\LibKey\LibKeyClient;
use PHPUnit\Framework\TestCase;

require_once __DIR__.'/MockHTTPClient.php';

class LibKeyClientTest extends TestCase
{
    /**
     * @var string
     */
    protected $api_key;

    /**
     * @var string
     */
    protected $library_id;

    /**
     * @var MockHttpClient
     */
    protected $http_client;

    /**
     * @var LibKeyClient
     */
    protected $libkey_client;

    public function setUp()
    {
        $this->http_client = new MockHttpClient();
        $this->api_key = 'API-KEY-HERE';
        $this->library_id = '123';
        $this->libkey_client = new LibKeyClient($this->library_id, $this->api_key, $this->http_client);
    }

    public function testRequestSetsAuthorizationCorrectly()
    {
        $expected_options = ['auth_bearer' => $this->api_key];
        $this->libkey_client->request('/10.001/notarealdoi');
        $actual_options = $this->http_client->last_options;
        $this->assertEquals($expected_options, $actual_options);
    }

    public function testRequestSendsCorrectURL()
    {
        $expected_uri = "https://public-api.thirdiron.com/public/v1/libraries/{$this->library_id}/articles/doi/10.001/notarealdoi?include=journal";
        $this->libkey_client->request('10.001/notarealdoi');
        $actual_uri = $this->http_client->last_uri;
        $this->assertEquals($expected_uri, $actual_uri);
    }
}

<?php

namespace BCLib\FulltextFinder\LibKey;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class LibKeyClient
{
    /**
     * @var string
     */
    private $library_id;

    /**
     * @var string
     */
    private $libkey_apikey;

    /**
     * @var HttpClientInterface
     */
    private $http_client;

    public function __construct(
        string $library_id,
        string $libkey_apikey,
        HttpClientInterface $http_client
    ) {
        $this->library_id = $library_id;
        $this->libkey_apikey = $libkey_apikey;
        $this->http_client = $http_client;
    }

    /**
     * Send a request for a DOI
     *
     * Returns a ResponseInterface instead of parsed text so that multiple requests can be made concurrently to
     * different services using the Symfony HttpClientInterface.
     *
     * @param string $doi
     * @return ResponseInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function request(string $doi): ResponseInterface
    {
        $uri = "https://public-api.thirdiron.com/public/v1/libraries/{$this->library_id}/articles/doi/$doi?include=journal";
        $request_options = ['auth_bearer' => $this->libkey_apikey];
        return $this->http_client->request('GET', $uri, $request_options);
    }
}
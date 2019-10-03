<?php

namespace BCLib\FulltextFinder\LibKey;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
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
     * @throws LibKeyLookupException
     * @return ResponseInterface
     */
    public function request(string $doi): ResponseInterface
    {
        $uri = "https://public-api.thirdiron.com/public/v1/libraries/{$this->library_id}/articles/doi/$doi?include=journal";
        $request_options = ['auth_bearer' => $this->libkey_apikey];
        try {
            return $this->http_client->request('GET', $uri, $request_options);
        } catch (TransportExceptionInterface $e) {
            throw new LibKeyLookupException("Error fetching from LibKey <$uri>", $e->getCode(), $e);
        }
    }

    /**
     * @param ResponseInterface $response
     * @return LibKeyResponse
     * @throws LibKeyLookupException
     */
    public function parse(ResponseInterface $response): LibKeyResponse
    {
        try {
            if ($response->getStatusCode() === 200) {
                return LibKeyParser::parse($response->getContent());
            }
        } catch (ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
            $error_url = $response->getInfo()['url'];
            throw new LibKeyLookupException("Error fetching from LibKey <$error_url>", $e->getCode(), $e);
        }

        return new LibKeyResponse();
    }
}
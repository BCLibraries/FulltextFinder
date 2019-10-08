<?php

namespace BCLib\FulltextFinder\Crossref;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class CrossrefClient
{
    /**
     * @var array
     */
    private $request_options;

    /**
     * @var HttpClientInterface
     */
    private $http_client;

    public function __construct(string $user_agent, HttpClientInterface $http_client)
    {
        $this->http_client = $http_client;
        $this->request_options = [
            'headers' => [
                'User-Agent' => $user_agent,
                'Accept' => 'application/json'
            ]
        ];
    }

    /**
     * @param string $doi
     * @return ResponseInterface
     * @throws CrossrefLookupException
     */
    public function request(string $doi): ResponseInterface
    {
        try {
            $uri = "https://api.crossref.org/works/$doi";
            return $this->http_client->request('GET', $uri, $this->request_options);
        } catch (TransportExceptionInterface $e) {
            throw new CrossrefLookupException("Error fetching from Crossref <$uri>", $e->getCode(), $e);
        }
    }

    /**
     * @param string $search_string
     * @return ResponseInterface
     */
    public function search(string $search_string): ResponseInterface
    {
        try {
            $search_string = urlencode($search_string);
            $uri = "https://api.crossref.org/works/#?query.bibliographic=$search_string";
            return $this->http_client->request('GET', $uri, $this->request_options);
        } catch (TransportExceptionInterface $e) {
            throw new CrossrefLookupException("Error fetching from Crossref <$uri>", $e->getCode(), $e);
        }
    }

    /**
     * @param ResponseInterface $response
     * @return CrossrefResponse
     * @throws CrossrefLookupException
     */
    public function parse(ResponseInterface $response): CrossrefResponse
    {
        try {
            if ($response->getStatusCode() === 200) {
                return CrossrefParser::parse($response->getContent());
            }
        } catch (ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
            $error_url = $response->getInfo()['url'];
            throw new CrossrefLookupException("Error fetching from Crossref <$error_url>", $e->getCode(), $e);
        }

        return new CrossrefResponse();
    }
}
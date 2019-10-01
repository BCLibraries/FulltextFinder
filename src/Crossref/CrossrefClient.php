<?php

namespace BCLib\FulltextFinder\Crossref;

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
                'User-Agent' => $user_agent
            ]
        ];
    }

    public function request(string $doi): ResponseInterface
    {
        $uri = "https://api.crossref.org/works/$doi";
        return $this->http_client->request('GET', $uri, $this->request_options);
    }

    public function search(string $search_string): ResponseInterface
    {
        $search_string = urlencode($search_string);
        $uri = "https://api.crossref.org/works/#?query.bibliographic=$search_string";
        return $this->http_client->request('GET', $uri, $this->request_options);
    }
}
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

    /**
     * CrossrefClient constructor.
     *
     * @param string|null $user_agent set to null to use Crossref Public API
     * @param HttpClientInterface $http_client
     */
    public function __construct(?string $user_agent, HttpClientInterface $http_client)
    {
        $this->http_client = $http_client;
        $this->request_options = [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ];

        if ($user_agent) {
            $this->request_options['headers']['User-Agent'] = $user_agent;
        }
    }

    /**
     * @param string $doi
     * @return ResponseInterface
     * @throws CrossrefLookupException
     */
    public function request(string $doi): ResponseInterface
    {
        $uri = "https://api.crossref.org/works/$doi";
        try {
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
        $search_string = urlencode($search_string);
        $uri = "https://api.crossref.org/works?query.bibliographic=$search_string&rows=1";
        try {
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
        $ret_val = new CrossrefResponse();

        try {
            if ($response->getStatusCode() === 200) {
                $ret_val = CrossrefParser::parse($response->getContent());
                $info = $response->getInfo();
                $ret_val->setHttpStatusCode($info['http_code']);
                $ret_val->setTotalTime($info['total_time']);
            }
        } catch (ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
            $error_url = $response->getInfo()['url'];
            throw new CrossrefLookupException("Error fetching from Crossref <$error_url>", $e->getCode(), $e);
        }

        return $ret_val;
    }
}
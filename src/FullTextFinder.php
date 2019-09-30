<?php

namespace BCLib\FulltextFinder;

use BCLib\FulltextFinder\LibKey\LibKeyClient;
use BCLib\FulltextFinder\LibKey\LibKeyParser;
use Symfony\Component\HttpClient\CurlHttpClient;

class FullTextFinder
{
    // See https://www.crossref.org/blog/dois-and-matching-regular-expressions/.
    private const DOI_REGEXES = [
        '/10.\d{4,9}\/[-._;\/\(\)\:A-Z0-9]+/i', // Catches most modern DOIs
        '/10.1002[^\s]+/' // Catches older Wiley DOIs
    ];

    /**
     * @var LibKeyClient
     */
    private $libkey;

    public static function build(string $libkey_library_id, string $libkey_apikey)
    {
        $libkey_client = new LibKeyClient($libkey_library_id, $libkey_apikey, new CurlHttpClient());
        return new FullTextFinder($libkey_client);
    }

    public function __construct(LibKeyClient $libkey)
    {
        $this->libkey = $libkey;
    }

    /**
     * Find the full text referenced in a search string
     *
     * @param string $search_string
     * @return LibKey\LibKeyResponse|null
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function find(string $search_string): ?LibKey\LibKeyResponse
    {
        if ($doi = $this->getDOI($search_string)) {
            echo "SEARCHING FOR $doi\n";

            $api_response = $this->libkey->request($doi);

            if ($api_response->getStatusCode() === 200) {
                return LibKeyParser::parse($api_response->getContent());
            }
        }

        return null;
    }

    /**
     * Extract a DOI from a string
     **/
    public function getDOI(string $search_string): ?string
    {
        $matches = [];
        foreach (self::DOI_REGEXES as $regex) {
            if (preg_match($regex, $search_string, $matches)) {

                // Strip trailing periods.
                return rtrim($matches[0], '.');
            }
        }
        return null;
    }

}
<?php

namespace BCLib\FulltextFinder;

use BCLib\FulltextFinder\Crossref\CrossrefClient;
use BCLib\LibKeyClient\LibKeyClient;
use Symfony\Component\HttpClient\CurlHttpClient;

class FullTextFinder
{
    // See https://www.crossref.org/blog/dois-and-matching-regular-expressions/.
    private const DOI_REGEXES = [
        '/10.\d{4,9}\/[-._;\/\(\)\:<>A-Z0-9]+/i', // Catches most modern DOIs
        '/10.1002[^\s]+/' // Catches older Wiley DOIs
    ];

    /**
     * @var FullTextService
     */
    private $fulltext_service;

    /**
     * Build a FullTextFinder
     *
     * @param string $libkey_library_id
     * @param string $libkey_apikey
     * @param string|null $crossref_client_user_agent omit to use Crossref Public API
     * @return FullTextFinder
     */
    public static function build(
        string $libkey_library_id,
        string $libkey_apikey,
        string $crossref_client_user_agent = null
    ): FullTextFinder {
        $http = new CurlHttpClient();

        $libkey = new LibKeyClient($libkey_library_id, $libkey_apikey, $http);
        $crossref = new CrossrefClient($crossref_client_user_agent, $http);

        $full_text_service = new FullTextService($crossref, $libkey);

        return new FullTextFinder($full_text_service);
    }

    public function __construct(FullTextService $fulltext_service)
    {
        $this->fulltext_service = $fulltext_service;
    }

    /**
     * Find the full text referenced in a search string
     *
     * @param string $search_string
     * @return FinderResponse|null
     */
    public function find(string $search_string): ?FinderResponse
    {
        if ($doi = $this->getDOI($search_string)) {
            return $this->fulltext_service->findByDOI($doi);
        }
        return null;
    }

    /**
     * Extract a DOI from a string
     *
     * @param string $search_string
     * @return string|null
     */
    public function getDOI(string $search_string): ?string
    {
        $matches = [];
        $decoded_search_string = urldecode($search_string);
        foreach (self::DOI_REGEXES as $regex) {
            if (preg_match($regex, $decoded_search_string, $matches)) {

                // Strip trailing periods.
                return rtrim($matches[0], '.');
            }
        }
        return null;
    }


}

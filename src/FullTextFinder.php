<?php

namespace BCLib\FulltextFinder;

use BCLib\FulltextFinder\Crossref\CrossrefClient;
use BCLib\FulltextFinder\Crossref\CrossrefResponse;
use BCLib\LibKeyClient\LibKeyClient;
use BCLib\LibKeyClient\LibKeyResponse;
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
     * @var Config
     */
    private $config;

    /**
     * Build a FullTextFinder
     *
     * @param string $libkey_library_id
     * @param string $libkey_apikey
     * @param Config $config Optional configuration values
     * @return FullTextFinder
     */
    public static function build(
        string $libkey_library_id,
        string $libkey_apikey,
        Config $config = null
    ): FullTextFinder {
        $http = new CurlHttpClient();
        $config = $config ?? new Config();

        $libkey = new LibKeyClient($libkey_library_id, $libkey_apikey, $http);
        $crossref = new CrossrefClient($config->getUserAgent(), $http);

        $full_text_service = new FullTextService($crossref, $libkey);

        return new FullTextFinder($full_text_service, $config);
    }

    public function __construct(FullTextService $fulltext_service, Config $config)
    {
        $this->fulltext_service = $fulltext_service;
        $this->config = $config;
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

        if (strlen($search_string) > $this->config->getFindByCitationMinLength()) {
           return $this->fulltext_service->findByCitation($search_string);
        }

        return new FinderResponse(new CrossrefResponse(), new LibKeyResponse());
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

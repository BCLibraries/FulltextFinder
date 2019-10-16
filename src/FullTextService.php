<?php

namespace BCLib\FulltextFinder;

use BCLib\FulltextFinder\Crossref\CrossrefClient;
use BCLib\FulltextFinder\Crossref\CrossrefLookupException;
use BCLib\FulltextFinder\Crossref\CrossrefResponse;
use BCLib\LibKeyClient\LibKeyClient;
use BCLib\LibKeyClient\LibKeyLookupException;
use BCLib\LibKeyClient\LibKeyResponse;

class FullTextService
{
    /**
     * @var CrossrefClient
     */
    private $crossref;

    /**
     * @var LibKeyClient
     */
    private $libkey;

    /**
     * @var int
     */
    private $min_crossref_score;

    public function __construct(CrossrefClient $crossref, LibKeyClient $libkey, int $min_crossref_score = 50)
    {
        $this->crossref = $crossref;
        $this->libkey = $libkey;
        $this->min_crossref_score = $min_crossref_score;
    }

    /**
     * @param string $doi
     * @return FinderResponse
     * @throws FullTextFinderException
     */
    public function findByDOI(string $doi): FinderResponse
    {
        try {
            $libkey_api_response = $this->libkey->request($doi);
            $crossref_api_response = $this->crossref->request($doi);

            $libkey_parsed = $this->libkey->parse($libkey_api_response);
            $crossref_parsed = $this->crossref->parse($crossref_api_response);

            $crossref_info = $crossref_api_response->getInfo();
            $crossref_parsed->setTotalTime($crossref_info['total_time']);
            $crossref_parsed->setHttpStatusCode($crossref_info['http_code']);

            return new FinderResponse($crossref_parsed, $libkey_parsed);
        } catch (LibKeyLookupException|CrossrefLookupException $e) {
            throw new FullTextFinderException($e->getMessage(), $e->getCode(), $e);
        }

    }

    public function findByCitation(string $search_string): FinderResponse
    {
        try {
            $crossref_api_response = $this->crossref->search($search_string);
            $crossref_parsed = $this->crossref->parse($crossref_api_response);
            $crossref_info = $crossref_api_response->getInfo();
            $crossref_parsed->setTotalTime($crossref_info['total_time']);
            $crossref_parsed->setHttpStatusCode($crossref_info['http_code']);

            if ($crossref_parsed->getScore() < $this->min_crossref_score) {
                return new FinderResponse(new CrossrefResponse(), new LibKeyResponse());
            }

            $libkey_api_response = $this->libkey->request($crossref_parsed->getDOI());
            $libkey_parsed = $this->libkey->parse($libkey_api_response);

            if (! $libkey_parsed) {
                $libkey_parsed = new LibKeyResponse();
            }

            return new FinderResponse($crossref_parsed, $libkey_parsed);

        } catch (LibKeyLookupException|CrossrefLookupException $e) {
            throw new FullTextFinderException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
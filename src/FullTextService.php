<?php

namespace BCLib\FulltextFinder;

use BCLib\FulltextFinder\Crossref\CrossrefClient;
use BCLib\FulltextFinder\Crossref\CrossrefLookupException;
use BCLib\LibKeyClient\LibKeyClient;
use BCLib\LibKeyClient\LibKeyLookupException;

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

    public function __construct(CrossrefClient $crossref, LibKeyClient $libkey)
    {
        $this->crossref = $crossref;
        $this->libkey = $libkey;
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

            return new FinderResponse($crossref_parsed, $libkey_parsed);
        } catch (LibKeyLookupException|CrossrefLookupException $e) {
            throw new FullTextFinderException($e->getMessage(), $e->getCode(), $e);
        }

    }
}
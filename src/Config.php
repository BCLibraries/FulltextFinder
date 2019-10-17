<?php

namespace BCLib\FulltextFinder;

/**
 * Optional configuration values for FullTextFinder
 *
 * Available options are:
 *
 *     * UserAgent - The User-Agent header sent to the Crossref API. Crossref requires a User-Agent header to use its
 *                   "Polite API" pool, which can provide more consistent performance. For User-Agent requirements, see
 *                   {@link [https://github.com/CrossRef/rest-api-doc#meta] [the Crossref docs]}. If the User-Agent
 *                   is not set appropriately or is set to NULL, Crossref requests will be made in the public API pool.
 *                   default: NULL
 *
 *     * FindByCitationMinLength - The minimum length of a search string in characters before find-by-citation will
 *                                 be applied. Searches under this length will look for a DOI in the string but will
 *                                 not query Crossref if a DOI is not found.
 *                                 default: 20
 *
 * @package BCLib\FulltextFinder
 */
class Config
{
    /** @var string|null */
    private $user_agent;

    /** @var int */
    private $find_by_citation_min_length = 20;

    public function getUserAgent(): ?string
    {
        return $this->user_agent;
    }

    /**
     * @param string|null $user_agent
     * @return Config
     */
    public function setUserAgent(?string $user_agent): Config
    {
        $this->user_agent = $user_agent;
        return $this;
    }

    public function getFindByCitationMinLength(): int
    {
        return $this->find_by_citation_min_length;
    }

    /**
     * Set minimum length of search string before performing a citation search
     *
     * @param int $find_by_citation_min_length
     * @return Config
     */
    public function setFindByCitationMinLength(int $find_by_citation_min_length): Config
    {
        $this->find_by_citation_min_length = $find_by_citation_min_length;
        return $this;
    }


}
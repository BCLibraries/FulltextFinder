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
 *     * FindByCitationMinMatchScore - The minimum Crossref score to automatically match a result.
 *
 *     * FindByCitationMinTitleSimilarity - The minimum title similarity (as a percentage) to match a result with a
 *                                          Crossref score below the minimum.
 *
 * @package BCLib\FulltextFinder
 */
class Config
{
    /** @var string|null */
    private $user_agent;

    /** @var int */
    private $find_by_citation_min_length = 20;

    /** @var int */
    private $find_by_citation_min_match_score = 50;

    /** @var int */
    private $find_by_citation_min_title_similarity = 95;

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
     * @return self
     */
    public function setFindByCitationMinLength(int $find_by_citation_min_length): Config
    {
        $this->find_by_citation_min_length = $find_by_citation_min_length;
        return $this;
    }

    public function getFindByCitationMinMatchScore(): int
    {
        return $this->find_by_citation_min_match_score;
    }

    /**
     * Set minimum Crossref match score or automatic match
     *
     * @param int $find_by_citation_min_match_score
     * @return self
     */
    public function setFindByCitationMinMatchScore(int $find_by_citation_min_match_score): Config
    {
        $this->find_by_citation_min_match_score = $find_by_citation_min_match_score;
        return $this;
    }

    public function getFindByCitationMinTitleSimilarity(): int
    {
        return $this->find_by_citation_min_title_similarity;
    }

    /**
     * Set the minimum similarity between search string and title
     *
     * Searches with low Crossref match scores are checked by title against the top
     * result. This score determines how close a match will trigger success.
     *
     * @param int $percentage
     * @return self
     */
    public function setFindByCitationMinTitleSimilarity(int $percentage): Config
    {
        $this->find_by_citation_min_title_similarity = $percentage;
        return $this;
    }

}
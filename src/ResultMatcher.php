<?php

namespace BCLib\FulltextFinder;

use BCLib\FulltextFinder\Crossref\CrossrefResponse;

/**
 * Checks Crossref results as matches against search strings
 *
 * @package BCLib\FulltextFinder
 */
class ResultMatcher
{
    /** @var int */
    private $min_score;

    /** @var int */
    private $min_title_length;

    /** @var int */
    private $min_title_match_percentage;

    public function __construct(int $min_score = 50, int $min_title_length = 25, int $min_title_match_percentage = 95)
    {
        $this->min_score = $min_score;
        $this->min_title_length = $min_title_length;
        $this->min_title_match_percentage = $min_title_match_percentage;
    }

    /**
     * Is a Crossref response an appropriate match?
     *
     * @param CrossrefResponse $response
     * @param string $search_string
     * @return bool
     */
    public function isMatch(CrossrefResponse $response, string $search_string): bool
    {
        return $response->getScore() >= $this->min_score;
    }
}
<?php

namespace BCLib\FulltextFinder;

use BCLib\FulltextFinder\Crossref\CrossrefResponse;

/**
 * Checks Crossref results as matches against search strings
 *
 * Crossref provides a match score for each result against a particular search string, but
 * this score is not always sufficient to decide if a result should be shown to a user or
 * not. The Crossref bibliographic search particularly fails with exact title matches that
 * might not contain other parts of the citation.
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

    public function __construct(int $min_score, int $min_title_length = 25, int $min_title_match_percentage = 95)
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
        // Crossref relevance is higher than minimum? Return true.
        if ($response->getScore() >= $this->min_score) {
            return true;
        }

        // Strip clutter.
        $normalized_search_string = $this->normalize($search_string);

        // Don't bother matching against short search strings.
        if (strlen($normalized_search_string) < $this->min_title_length) {
            return false;
        }

        // Don't bother continuing if there isn't a title.
        if ($response->getTitles() === []) {
            return false;
        }

        // Is the title a close match for the search string? Find all possible
        // title candidates and match.
        $title_candidates = $this->findTitleCandidates($response->getTitles()[0]);
        foreach ($title_candidates as $title) {
            if ($this->textIsSimilar($normalized_search_string, $title)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Normalize string for comparison
     *
     * Lowercases string, removes punctuation, and collapses spaces.
     *
     * @param string $string
     * @return string
     */
    private function normalize(string $string): string
    {
        $string = strtolower($string);
        $string = preg_replace('/[^[:alnum:][:space:]]/', '', $string);
        return preg_replace('/\s+/', ' ', $string);
    }

    /**
     * Are two texts similar?
     *
     * @param string $text_one
     * @param string $text_two
     * @return bool
     */
    private function textIsSimilar(string $text_one, string $text_two): bool
    {
        similar_text($text_one, $text_two, $match_percentage);
        return $match_percentage > $this->min_title_match_percentage;
    }

    /**
     * Build a list of potential titles to match against
     *
     * We should test against:
     *
     *    * the full title ("The neglected otters in China: Distribution change in the past 400 years")
     *    * the main title ("The neglected otters in China")
     *    * the subtitle ("Distribution change in the past 400 years")
     *
     * @param string $full_title
     * @return string[] normalized list of title candidates
     */
    private function findTitleCandidates(string $full_title): array
    {
        $possible_titles = explode(':', $full_title);
        $possible_titles = preg_split('/[:\?]/', $full_title);
        if (count($possible_titles) > 1) {
            $possible_titles[] = $full_title;
        }
        return array_map([$this, 'normalize'], $possible_titles);
    }
}
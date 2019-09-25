<?php

namespace BCLib\FulltextFinder;

class SearchText
{
    /**
     * @var string
     */
    private $text;

    // See https://www.crossref.org/blog/dois-and-matching-regular-expressions/.
    private const REGEXES = [
        '/10.\d{4,9}\/[-._;\/\(\)\:A-Z0-9]+/i', // Catches most modern DOIs
        '/10.1002[^\s]+/' // Catches older Wiley DOIs
    ];

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function getDOI(): ?string
    {
        $matches = [];
        foreach (self::REGEXES as $regex) {
            if (preg_match($regex, $this->text, $matches)) {

                // Strip trailing periods.
                return rtrim($matches[0], '.');
            }
        }
        return null;
    }

}
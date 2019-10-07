<?php

namespace BCLib\FulltextFinder\LibKey;

/**
 * Build a LibKeyResponse from raw json
 */
class LibKeyParser
{
    /**
     * Parse a LibKey API response
     *
     * @param string $json the raw JSON string
     * @return LibKeyResponse
     */
    public static function parse(string $json): LibKeyResponse
    {
        $json = json_decode($json, false);
        $data = $json->data;

        $response = new LibKeyResponse();

        $response->setId($data->id)
            ->setType($data->type)
            ->setTitle($data->title)
            ->setDate($data->date)
            ->setAuthors($data->authors)
            ->setInPress($data->inPress)
            ->setFullTextFile($data->fullTextFile)
            ->setContentLocation($data->contentLocation)
            ->setAvailableThroughBrowzine($data->availableThroughBrowzine)
            ->setStartPage($data->startPage)
            ->setEndPage($data->endPage)
            ->setBrowzineWebLink($data->browzineWebLink);

        if (isset($json->included)) {
            $response->setJournals(array_map(self::class . '::parseJournal', $json->included));
        }

        return $response;
    }

    /**
     * Parse a single journal
     *
     * @param \stdClass $json
     * @return Journal
     */
    private static function parseJournal(\stdClass $json): Journal
    {
        $journal = new Journal();
        return $journal->setId($json->id)
            ->setType($json->type)
            ->setTitle($json->title)
            ->setIssn($json->issn)
            ->setSJRValue($json->sjrValue)
            ->setCoverImageUrl($json->coverImageUrl)
            ->setBrowzineEnabled($json->browzineEnabled)
            ->setBrowzineWebLink($json->browzineWebLink);
    }
}
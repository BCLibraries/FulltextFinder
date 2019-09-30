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

        $response->id = $data->id;
        $response->type = $data->type;
        $response->title = $data->title;
        $response->date = $data->date;
        $response->authors = $data->authors;
        $response->in_press = $data->inPress;
        $response->full_text_file = $data->fullTextFile;
        $response->content_location = $data->contentLocation;
        $response->available_through_browzine = $data->availableThroughBrowzine;
        $response->start_page = $data->startPage;
        $response->end_page = $data->endPage;
        $response->browzine_web_link = $data->browzineWebLink;

        $response->journals = array_map(self::class . '::parseJournal', $json->included);

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
        $journal->id = $json->id;
        $journal->type = $json->type;
        $journal->title = $json->title;
        $journal->issn = $json->issn;
        $journal->sjr_value = $json->sjrValue;
        $journal->cover_image_url = $json->coverImageUrl;
        $journal->browzine_enabled = $json->browzineEnabled;
        $journal->browzine_web_link = $json->browzineWebLink;

        return $journal;
    }
}
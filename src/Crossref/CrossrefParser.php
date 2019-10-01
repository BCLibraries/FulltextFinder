<?php

namespace BCLib\FulltextFinder\Crossref;

class CrossrefParser
{
    public static function parse(string $json): CrossrefResponse
    {
        $json = json_decode($json, false);
        $message = $json->message;

        $response = new CrossrefResponse();
        $response->doi = $message->DOI ?? null;
        $response->title = $message->title ?? [];
        $response->subtitle = $message->subtitle ?? [];
        $response->short_title = $message->{'short-title'} ?? [];
        $response->type = $message->type ?? null;
        $response->container_title = $message->{'container-title'} ?? [];
        $response->short_container_title = $message->{'short-container-title'} ?? [];

        $response->publisher = $message->publisher ?? null;
        $response->volume = $message->volume ?? null;
        $response->issue = $message->issue ?? null;
        $response->score = $message->score ?? null;
        $response->alternative_id = $message->{'alternative-id'} ?? [];

        if (isset($message->{'journal-issue'})) {
            $response->published_print_date = $message->{'journal-issue'}->{'published-print'}->{'date-parts'} ?? null;
        }

        $response->author = array_map(self::class . '::parseAuthor', $message->author);
        $response->reference = array_map(self::class . '::parseReference', $message->reference);

        return $response;
    }

    private static function parseAuthor(\stdClass $json): Author
    {
        $author = new Author();
        $author->given = $json->given ?? null;
        $author->family = $json->family ?? null;
        $author->sequence = $json->sequence ?? null;
        $author->orcid = $json->ORCID ?? null;
        $author->affiliation = $json->affiliation ?? [];
        $author->authenticated_orcid = $json->{'authenticated-orcid'} ?? null;
        return $author;
    }

    private static function parseReference(\stdClass $json): Reference
    {
        $ref = new Reference();
        $ref->key = $json->key ?? null;
        $ref->doi = $json->DOI ?? null;
        $ref->unstructured = $json->unstructured ?? null;
        $ref->author = $json->author ?? null;
        $ref->year = $json->year ?? null;
        $ref->edition = $json->edition ?? null;
        $ref->volume = $json->volume ?? null;
        $ref->issue = $json->issue ?? null;
        $ref->first_page = $json->{'first-page'} ?? null;
        $ref->journal_title = $json->{'journal-title'} ?? null;
        $ref->volume_title = $json->{'volume-title'} ?? null;
        return $ref;
    }

}
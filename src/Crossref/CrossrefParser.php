<?php

namespace BCLib\FulltextFinder\Crossref;

class CrossrefParser
{
    public static function parse(string $json): CrossrefResponse
    {
        $json = json_decode($json, false);
        $message = $json->message;

        $response = new CrossrefResponse();

        // Crossref data is sparse and fields are often not populated, so null-check everything.
        $response->setDOI($message->DOI ?? null)
            ->setTitles($message->title ?? [])
            ->setSubtitles($message->subtitle ?? [])
            ->setShortTitles($message->{'short-title'} ?? [])
            ->setType($message->type ?? null)
            ->setContainerTitles($message->{'container-title'} ?? [])
            ->setShortContainerTitles($message->{'short-container-title'} ?? [])
            ->setPublisher($message->publisher ?? null)
            ->setVolume($message->volume ?? null)
            ->setIssue($message->issue ?? null)
            ->setPage($message->page ?? null)
            ->setScore($message->score ?? null)
            ->setAlternativeIds($message->{'alternative-id'} ?? []);

        if (isset($message->author)) {
            $response->setAuthors(array_map(self::class . '::parseAuthor', $message->author));
        }

        if (isset($message->reference)) {
            $response->setReferences(array_map(self::class . '::parseReference', $message->reference));
        }

        if (isset($message->{'journal-issue'})) {
            $date = $message->{'journal-issue'}->{'published-print'}->{'date-parts'} ?? [];
            if (isset($date[0])) {
                $response->setPublishedPrintDate($date[0]);
            }
        }

        if (isset($message->{'published-online'})) {
            $date = $message->{'published-online'}->{'date-parts'} ?? [];
            if (isset($date[0])) {
                $response->setPublishedOnlineDate($date[0]);
            }
        }

        return $response;
    }

    private static function parseAuthor(\stdClass $json): Author
    {
        $author = new Author();
        return $author->setGivenName($json->given ?? null)
            ->setFamilyName($json->family ?? null)
            ->setSequence($json->sequence ?? null)
            ->setORCID($json->ORCID ?? null)
            ->setAffiliation($json->affiliation ?? [])
            ->setAuthenticatedORCID($json->{'authenticated-orcid'} ?? null);
    }

    private static function parseReference(\stdClass $json): Reference
    {
        $ref = new Reference();
        return $ref->setKey($json->key ?? null)
            ->setDoi($json->DOI ?? null)
            ->setUnstructured($json->unstructured ?? null)
            ->setAuthor($json->author ?? null)
            ->setYear($json->year ?? null)
            ->setEdition($json->edition ?? null)
            ->setVolume($json->volume ?? null)
            ->setIssue($json->issue ?? null)
            ->setFirstPage($json->{'first-page'} ?? null)
            ->setJournalTitle($json->{'journal-title'} ?? null)
            ->setVolumeTitle($json->{'volume-title'} ?? null);
    }

}
<?php

use BCLib\FulltextFinder\SearchText;

class SearchTextTest extends \PHPUnit\Framework\TestCase
{
    protected static $citations;

    public static function setUpBeforeClass(): void
    {
        $citation_file_content = file_get_contents(__DIR__ . '/citations.json');
        self::$citations = json_decode($citation_file_content);
    }

    public function testGetDOIFindsDOIWhenPresent()
    {
        $citations_with_dois = array_filter(self::$citations, [$this,'citationContainsDoi'] );
        foreach ($citations_with_dois as $citation) {
            $text = new SearchText($citation->text);
            $this->assertEquals($citation->doi, $text->getDOI());
        }
    }

    public function testGetDOIReturnsNullWhenNotPresent()
    {
        $citations_without_dois = array_filter(self::$citations, [$this,'citationDoesNotContainDoi'] );
        foreach ($citations_without_dois as $citation) {
            $text = new SearchText($citation->text);
            $this->assertNull($text->getDOI());
        }
    }

    private static function citationContainsDoi($citation): bool
    {
        return $citation->doiInText;
    }

    private static function citationDoesNotContainDoi($citation): bool
    {
        return ! $citation->doiInText;
    }
}

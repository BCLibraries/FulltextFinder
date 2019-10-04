<?php

namespace BCLib\Tests;

use BCLib\FulltextFinder\LibKey\LibKeyParser;
use PHPUnit\Framework\TestCase;

class LibKeyParserTest extends TestCase
{
    /**
     * @var \BCLib\FulltextFinder\LibKey\LibKeyParser
     */
    private $parser;

    /**
     * @var false|string
     */
    private $json;

    public function setUp(): void
    {
        $this->parser = new \BCLib\FulltextFinder\LibKey\LibKeyParser();
        $this->json = file_get_contents(__DIR__ . '/libkey-response-01.json');
    }

    public function testParseParsesCorrectly()
    {
        $response = LibKeyParser::parse($this->json);

        // Data
        $this->assertEquals(151576387, $response->getId());
        $this->assertEquals('articles', $response->getType());
        $this->assertEquals('Cooperative problem solving in giant otters (Pteronura brasiliensis) and Asian small-clawed otters (Aonyx cinerea)',
            $response->getTitle());
        $this->assertEquals('2017-08-24', $response->getDate());
        $this->assertEquals('Schmelz, Martin; Duguid, Shona; Bohn, Manuel; Völter, Christoph J.', $response->getAuthors());
        $this->assertFalse($response->isInPress());
        $this->assertEquals('https://libkey.io/libraries/431/articles/151576387/full-text-file?utm_source=api_536',
            $response->getFullTextFile());
        $this->assertEquals('https://libkey.io/libraries/431/articles/151576387',
            $response->getContentLocation());
        $this->assertTrue($response->isAvailableThroughBrowzine());
        $this->assertEquals('1107', $response->getStartPage());
        $this->assertEquals('1114', $response->getEndPage());
        $this->assertEquals('https://browzine.com/libraries/431/journals/2512/issues/103325497?showArticleInContext=doi:10.1007%2Fs10071-017-1126-2&utm_source=api_536',
            $response->getBrowzineWebLink());

        // Journal
        $journal = $response->getJournals()[0];
        $this->assertEquals(2512, $journal->getId());
        $this->assertEquals('journals', $journal->getType());
        $this->assertEquals('Animal Cognition', $journal->getTitle());
        $this->assertEquals('14359448', $journal->getISSN());
        $this->assertEquals(1.233, $journal->getSJRValue());
        $this->assertEquals('https://assets.thirdiron.com/images/covers/1435-9448.png', $journal->getCoverImageUrl());
        $this->assertTrue($journal->isBrowzineEnabled());
        $this->assertEquals('https://browzine.com/libraries/431/journals/2512?utm_source=api_536',
            $journal->getBrowzineWebLink());
    }
}
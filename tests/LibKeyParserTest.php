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
        $this->assertEquals(151576387, $response->id);
        $this->assertEquals('articles', $response->type);
        $this->assertEquals('Cooperative problem solving in giant otters (Pteronura brasiliensis) and Asian small-clawed otters (Aonyx cinerea)',
            $response->title);
        $this->assertEquals('2017-08-24', $response->date);
        $this->assertEquals('Schmelz, Martin; Duguid, Shona; Bohn, Manuel; Völter, Christoph J.', $response->authors);
        $this->assertFalse($response->in_press);
        $this->assertEquals('https://libkey.io/libraries/431/articles/151576387/full-text-file?utm_source=api_536',
            $response->full_text_file);
        $this->assertEquals('https://libkey.io/libraries/431/articles/151576387',
            $response->content_location);
        $this->assertTrue($response->available_through_browzine);
        $this->assertEquals('1107', $response->start_page);
        $this->assertEquals('1114', $response->end_page);
        $this->assertEquals('https://browzine.com/libraries/431/journals/2512/issues/103325497?showArticleInContext=doi:10.1007%2Fs10071-017-1126-2&utm_source=api_536',
            $response->browzine_web_link);

        // Journal
        $journal = $response->journals[0];
        $this->assertEquals(2512, $journal->id);
        $this->assertEquals('journals', $journal->type);
        $this->assertEquals('Animal Cognition', $journal->title);
        $this->assertEquals('14359448', $journal->issn);
        $this->assertEquals(1.233, $journal->sjr_value);
        $this->assertEquals('https://assets.thirdiron.com/images/covers/1435-9448.png', $journal->cover_image_url);
        $this->assertTrue($journal->browzine_enabled);
        $this->assertEquals('https://browzine.com/libraries/431/journals/2512?utm_source=api_536',
            $journal->browzine_web_link);

    }
}
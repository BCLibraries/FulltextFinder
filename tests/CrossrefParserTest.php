<?php

namespace BCLib\FulltextFinder\Tests;

use BCLib\FulltextFinder\Crossref\CrossrefParser;
use PHPUnit\Framework\TestCase;

class CrossrefParserTest extends TestCase
{
    /**
     * @var CrossrefParser
     */
    public $parser;

    /**
     * @var false|string
     */
    public $json;

    public function setUp()
    {
        $this->parser = new CrossrefParser();
        $this->json = file_get_contents(__DIR__ . '/crossref-response-01.json');
    }

    public function testParseParsesMessageCorrectly()
    {
        $response = CrossrefParser::parse($this->json);

        $this->assertEquals('10.1007/s10071-017-1126-2', $response->doi);
        $this->assertEquals([
            'Cooperative problem solving in giant otters (Pteronura brasiliensis) and Asian small-clawed otters (Aonyx cinerea)'
        ], $response->title);
        $this->assertEquals(['Example Subtitle'], $response->subtitle);
        $this->assertEquals(['Example Short Title'], $response->short_title);
        $this->assertEquals('journal-article', $response->type);
        $this->assertEquals(['Animal Cognition'], $response->container_title);
        $this->assertEquals(['Anim Cogn'], $response->short_container_title);
        $this->assertEquals('Springer Nature', $response->publisher);
        $this->assertEquals('20', $response->volume);
        $this->assertEquals('6', $response->issue);

        $this->assertEquals(1.0, $response->score);
        $this->assertEquals([[2017, 11]], $response->published_print_date);

        $this->assertEquals(['1126'], $response->alternative_id);
    }

    public function testParseParsesAuthorsCorrectly()
    {
        $response = CrossrefParser::parse($this->json);
        $authors = $response->author;

        $this->assertCount(4, $authors);
        $this->assertEquals('Martin', $authors[0]->given);
        $this->assertEquals('Schmelz', $authors[0]->family);
        $this->assertEquals('first', $authors[0]->sequence);

        $this->assertEquals('http://orcid.org/0000-0003-4844-0673', $authors[1]->orcid);
        $this->assertFalse($authors[1]->authenticated_orcid);

        $this->assertEquals('Völter', $authors[3]->family);

    }

    public function testParseParsesReferencesCorrectly()
    {
        $response = CrossrefParser::parse($this->json);
        $references = $response->reference;

        $this->assertCount(36, $references);
        $this->assertEquals('1', $references[0]->issue);
        $this->assertEquals('1126_CR1', $references[0]->key);
        $this->assertEquals('1', $references[0]->first_page);
        $this->assertEquals('10.18637/jss.v067.i01', $references[0]->doi);
        $this->assertEquals('67', $references[0]->volume);
        $this->assertEquals('D Bates', $references[0]->author);
        $this->assertEquals('Bates D, Machler M, Bolker BM, Walker SC (2015) Fitting linear mixed-effects models using lme4. J Stat Softw 67(1):1–48. doi: 10.18637/jss.v067.i01',
            $references[0]->unstructured);
        $this->assertEquals('J Stat Softw', $references[0]->journal_title);

        $this->assertEquals('An introduction to generalized linear models', $references[5]->volume_title);
        $this->assertEquals('3',$references[5]->edition);
    }

}

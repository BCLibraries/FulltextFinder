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

    public function setUp(): void
    {
        $this->parser = new CrossrefParser();
        $this->json = file_get_contents(__DIR__ . '/crossref-response-01.json');
    }

    public function testParseParsesMessageCorrectly()
    {
        $response = CrossrefParser::parse($this->json);

        $this->assertEquals('10.1007/s10071-017-1126-2', $response->getDOI());
        $this->assertEquals([
            'Cooperative problem solving in giant otters (Pteronura brasiliensis) and Asian small-clawed otters (Aonyx cinerea)'
        ], $response->getTitles());
        $this->assertEquals(['Example Subtitle'], $response->getSubtitles());
        $this->assertEquals(['Example Short Title'], $response->getShortTitles());
        $this->assertEquals('journal-article', $response->getType());
        $this->assertEquals(['Animal Cognition'], $response->getContainerTitles());
        $this->assertEquals(['Anim Cogn'], $response->getShortContainerTitles());
        $this->assertEquals('Springer Nature', $response->getPublisher());
        $this->assertEquals('20', $response->getVolume());
        $this->assertEquals('6', $response->getIssue());

        $this->assertEquals(1.0, $response->getScore());
        $this->assertEquals([2017, 11], $response->getPublishedPrintDate());
        $this->assertEquals([2017, 8, 24], $response->getPublishedOnlineDate());

        $this->assertEquals(['1126'], $response->getAlternativeIds());
    }

    public function testParseParsesAuthorsCorrectly()
    {
        $response = CrossrefParser::parse($this->json);
        $authors = $response->getAuthors();

        $this->assertCount(4, $authors);
        $this->assertEquals('Martin', $authors[0]->getGivenName());
        $this->assertEquals('Schmelz', $authors[0]->getFamilyName());
        $this->assertEquals('first', $authors[0]->getSequence());

        $this->assertEquals('http://orcid.org/0000-0003-4844-0673', $authors[1]->getORCID());
        $this->assertFalse($authors[1]->isAuthenticatedORCID());

        $this->assertEquals('Völter', $authors[3]->getFamilyName());

    }

    public function testParseParsesReferencesCorrectly()
    {
        $response = CrossrefParser::parse($this->json);
        $references = $response->getReferences();

        $this->assertCount(36, $references);
        $this->assertEquals('1', $references[0]->getIssue());
        $this->assertEquals('1126_CR1', $references[0]->getKey());
        $this->assertEquals('1', $references[0]->getFirstPage());
        $this->assertEquals('10.18637/jss.v067.i01', $references[0]->getDOI());
        $this->assertEquals('67', $references[0]->getVolume());
        $this->assertEquals('D Bates', $references[0]->getAuthor());
        $this->assertEquals('Bates D, Machler M, Bolker BM, Walker SC (2015) Fitting linear mixed-effects models using lme4. J Stat Softw 67(1):1–48. doi: 10.18637/jss.v067.i01',
            $references[0]->getUnstructured());
        $this->assertEquals('J Stat Softw', $references[0]->getJournalTitle());

        $this->assertEquals('An introduction to generalized linear models', $references[5]->getVolumeTitle());
        $this->assertEquals('3', $references[5]->getEdition());
    }

}

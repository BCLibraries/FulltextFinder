<?php

namespace BCLib\FulltextFinder\Tests;

use BCLib\FulltextFinder\Crossref\Author;
use BCLib\FulltextFinder\Crossref\CrossrefResponse;
use BCLib\FulltextFinder\FinderResponse;
use BCLib\FulltextFinder\LibKey\LibKeyResponse;
use PHPUnit\Framework\TestCase;

class FinderResponseTest extends TestCase
{
    /**
     * @var FinderResponse
     */
    private $response;

    /**
     * @var CrossrefResponse
     */
    private $crossref;

    /**
     * @var Author
     */
    private $author_1;

    /**
     * @var LibKeyResponse
     */
    private $libkey;

    public function setUp()
    {
        $this->crossref = new CrossrefResponse();
        $this->crossref->title = 'Title of article';
        $this->crossref->volume = '12';
        $this->crossref->issue = '4';

        $this->author_1 = new Author();
        $this->author_1->given = 'Benjamin';
        $this->author_1->family = 'Florin';
        $this->crossref->author = [$this->author_1];

        $this->libkey = \Mockery::mock(LibKeyResponse::class);
        $this->libkey->full_text_file = 'https://link.to/full/text.pdf';

        $this->response = new FinderResponse($this->crossref, $this->libkey);
    }

    public function testFieldsSetCorrectly()
    {
        $this->assertEquals('Title of article', $this->response->getTitle());
        $this->assertEquals('12', $this->response->getVolume());
        $this->assertEquals('4', $this->response->getIssue());

        $this->assertEquals('https://link.to/full/text.pdf', $this->response->getFullText());

        $this->assertEquals([$this->author_1], $this->response->getAuthors());
    }
}

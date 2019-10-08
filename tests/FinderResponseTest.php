<?php

namespace BCLib\FulltextFinder\Tests;

use BCLib\FulltextFinder\Crossref\Author;
use BCLib\FulltextFinder\Crossref\CrossrefResponse;
use BCLib\FulltextFinder\FinderResponse;
use BCLib\LibKeyClient\LibKeyResponse;
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
        $this->crossref->setTitles(['Title of article']);
        $this->crossref->setVolume('12');
        $this->crossref->setIssue('4');

        $this->author_1 = new Author();
        $this->author_1->setGivenName('Benjamin')
            ->setFamilyName('Florin');
        $this->crossref->setAuthors([$this->author_1]);

        $this->libkey = new \BCLib\LibKeyClient\LibKeyResponse();
        $this->libkey->setFullTextFile('https://link.to/full/text.pdf');

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

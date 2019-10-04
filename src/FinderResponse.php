<?php

namespace BCLib\FulltextFinder;

use BCLib\FulltextFinder\Crossref\CrossrefResponse;
use BCLib\FulltextFinder\LibKey\LibKeyResponse;

class FinderResponse
{
    /**
     * @var CrossrefResponse
     */
    private $crossref;

    /**
     * @var LibKeyResponse
     */
    private $libkey;

    public function __construct(CrossrefResponse $crossref, LibKeyResponse $libkey)
    {
        $this->crossref = $crossref;
        $this->libkey = $libkey;
    }

    public function getCrossrefData(): CrossrefResponse
    {
        return $this->crossref;
    }

    public function getLibKeyData(): LibKeyResponse
    {
        return $this->libkey;
    }

    public function getTitle(): ?string
    {
        return $this->crossref->getTitles()[0] ?? null;
    }

    /**
     * @return Crossref\Author[]
     */
    public function getAuthors(): array
    {
        return $this->crossref->getAuthors();
    }

    public function getFullText(): ?string
    {
        return $this->libkey->getFullTextFile();
    }

    public function getVolume(): ?string
    {
        return $this->crossref->getVolume();
    }

    public function getIssue(): ?string
    {
        return $this->crossref->getIssue();
    }
}
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

    public function getTitle(): ?string
    {
        return $this->crossref->title[0] ?? null;
    }

    /**
     * @return Crossref\Author[]
     */
    public function getAuthors(): array
    {
        return $this->crossref->author;
    }

    public function getFullText(): ?string
    {
        return $this->libkey->full_text_file;
    }

    public function getVolume(): ?string
    {
        return $this->crossref->volume;
    }

    public function getIssue(): ?string
    {
        return $this->crossref->issue;
    }
}
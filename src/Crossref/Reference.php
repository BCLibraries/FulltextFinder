<?php

namespace BCLib\FulltextFinder\Crossref;

class Reference
{
    /** @var string|null */
    private $key;

    /** @var string|null */
    private $doi;

    /** @var string|null */
    private $unstructured;

    /** @var string|null */
    private $author;

    /** @var string|null */
    private $year;

    /** @var string|null */
    private $volume;

    /** @var string|null */
    private $edition;

    /** @var string|null */
    private $issue;

    /** @var string|null */
    private $first_page;

    /** @var string|null */
    private $journal_title;

    /** @var string|null */
    private $volume_title;

    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param string|null $key
     * @return Reference
     */
    public function setKey(?string $key): Reference
    {
        $this->key = $key;
        return $this;
    }

    public function getDOI(): ?string
    {
        return $this->doi;
    }

    /**
     * @param string|null $doi
     * @return Reference
     */
    public function setDoi(?string $doi): Reference
    {
        $this->doi = $doi;
        return $this;
    }

    public function getUnstructured(): ?string
    {
        return $this->unstructured;
    }

    /**
     * @param string|null $unstructured
     * @return Reference
     */
    public function setUnstructured(?string $unstructured): Reference
    {
        $this->unstructured = $unstructured;
        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string|null $author
     * @return Reference
     */
    public function setAuthor(?string $author): Reference
    {
        $this->author = $author;
        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    /**
     * @param string|null $year
     * @return Reference
     */
    public function setYear(?string $year): Reference
    {
        $this->year = $year;
        return $this;
    }

    public function getVolume(): ?string
    {
        return $this->volume;
    }

    /**
     * @param string|null $volume
     * @return Reference
     */
    public function setVolume(?string $volume): Reference
    {
        $this->volume = $volume;
        return $this;
    }

    public function getEdition(): ?string
    {
        return $this->edition;
    }

    /**
     * @param string|null $edition
     * @return Reference
     */
    public function setEdition(?string $edition): Reference
    {
        $this->edition = $edition;
        return $this;
    }

    public function getIssue(): ?string
    {
        return $this->issue;
    }

    /**
     * @param string|null $issue
     * @return Reference
     */
    public function setIssue(?string $issue): Reference
    {
        $this->issue = $issue;
        return $this;
    }

    public function getFirstPage(): ?string
    {
        return $this->first_page;
    }

    /**
     * @param string|null $first_page
     * @return Reference
     */
    public function setFirstPage(?string $first_page): Reference
    {
        $this->first_page = $first_page;
        return $this;
    }

    public function getJournalTitle(): ?string
    {
        return $this->journal_title;
    }

    /**
     * @param string|null $journal_title
     * @return Reference
     */
    public function setJournalTitle(?string $journal_title): Reference
    {
        $this->journal_title = $journal_title;
        return $this;
    }

    public function getVolumeTitle(): ?string
    {
        return $this->volume_title;
    }

    /**
     * @param string|null $volume_title
     * @return Reference
     */
    public function setVolumeTitle(?string $volume_title): Reference
    {
        $this->volume_title = $volume_title;
        return $this;
    }


}
<?php

namespace BCLib\FulltextFinder\Crossref;

class CrossrefResponse
{
    /** @var string|null */
    private $doi;

    /** @var string[] */
    private $titles = [];

    /** @var string[] */
    private $subtitles = [];

    /** @var string[]|null */
    private $short_titles = [];

    /** @var Author[] */
    private $authors = [];

    /** @var string|null */
    private $type;

    /** @var string[] */
    private $container_titles = [];

    /** @var string[] */
    private $short_container_titles = [];

    /** @var string|null */
    private $publisher;

    /** @var string|null */
    private $volume;

    /** @var string|null */
    private $issue;

    /** @var string|null */
    private $page;

    /** @var float|null */
    private $score;

    /** @var int[] */
    private $published_print_date = [];

    /** @var string[] */
    private $alternative_ids = [];

    /** @var Reference[] */
    private $references = [];

    /** @var int|null */
    private $reference_count;

    /** @var int|null */
    private $is_referenced_by_count;

    public function getDOI(): ?string
    {
        return $this->doi;
    }

    /**
     * @param string|null $doi
     * @return CrossrefResponse
     */
    public function setDOI(?string $doi): CrossrefResponse
    {
        $this->doi = $doi;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getTitles(): array
    {
        return $this->titles;
    }

    /**
     * @param string[] $titles
     * @return CrossrefResponse
     */
    public function setTitles(array $titles): CrossrefResponse
    {
        $this->titles = $titles;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getSubtitles(): array
    {
        return $this->subtitles;
    }

    /**
     * @param string[] $subtitles
     * @return CrossrefResponse
     */
    public function setSubtitles(array $subtitles): CrossrefResponse
    {
        $this->subtitles = $subtitles;
        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getShortTitles(): ?array
    {
        return $this->short_titles;
    }

    /**
     * @param string[]|null $short_titles
     * @return CrossrefResponse
     */
    public function setShortTitles(?array $short_titles): CrossrefResponse
    {
        $this->short_titles = $short_titles;
        return $this;
    }

    /**
     * @return Author[]
     */
    public function getAuthors(): array
    {
        return $this->authors;
    }

    /**
     * @param Author[] $authors
     * @return CrossrefResponse
     */
    public function setAuthors(array $authors): CrossrefResponse
    {
        $this->authors = $authors;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return CrossrefResponse
     */
    public function setType(?string $type): CrossrefResponse
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getContainerTitles(): array
    {
        return $this->container_titles;
    }

    /**
     * @param string[] $container_titles
     * @return CrossrefResponse
     */
    public function setContainerTitles(array $container_titles): CrossrefResponse
    {
        $this->container_titles = $container_titles;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getShortContainerTitles(): array
    {
        return $this->short_container_titles;
    }

    /**
     * @param string[] $short_container_titles
     * @return CrossrefResponse
     */
    public function setShortContainerTitles(array $short_container_titles): CrossrefResponse
    {
        $this->short_container_titles = $short_container_titles;
        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    /**
     * @param string|null $publisher
     * @return CrossrefResponse
     */
    public function setPublisher(?string $publisher): CrossrefResponse
    {
        $this->publisher = $publisher;
        return $this;
    }

    public function getVolume(): ?string
    {
        return $this->volume;
    }

    /**
     * @param string|null $volume
     * @return CrossrefResponse
     */
    public function setVolume(?string $volume): CrossrefResponse
    {
        $this->volume = $volume;
        return $this;
    }

    public function getIssue(): ?string
    {
        return $this->issue;
    }

    /**
     * @param string|null $issue
     * @return CrossrefResponse
     */
    public function setIssue(?string $issue): CrossrefResponse
    {
        $this->issue = $issue;
        return $this;
    }

    public function getPage(): ?string
    {
        return $this->page;
    }

    /**
     * @param string|null $page
     * @return CrossrefResponse
     */
    public function setPage(?string $page): CrossrefResponse
    {
        $this->page = $page;
        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    /**
     * @param float|null $score
     * @return CrossrefResponse
     */
    public function setScore(?float $score): CrossrefResponse
    {
        $this->score = $score;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getPublishedPrintDate(): array
    {
        return $this->published_print_date;
    }

    /**
     * @param int[] $published_print_date
     * @return CrossrefResponse
     */
    public function setPublishedPrintDate(?array $published_print_date): CrossrefResponse
    {
        $this->published_print_date = $published_print_date;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getAlternativeIds(): array
    {
        return $this->alternative_ids;
    }

    /**
     * @param string[] $alternative_ids
     * @return CrossrefResponse
     */
    public function setAlternativeIds(array $alternative_ids): CrossrefResponse
    {
        $this->alternative_ids = $alternative_ids;
        return $this;
    }

    /**
     * @return Reference[]
     */
    public function getReferences(): array
    {
        return $this->references;
    }

    /**
     * @param Reference[] $references
     * @return CrossrefResponse
     */
    public function setReferences(array $references): CrossrefResponse
    {
        $this->references = $references;
        return $this;
    }

    public function getReferenceCount(): ?int
    {
        return $this->reference_count;
    }

    /**
     * @param int|null $reference_count
     * @return CrossrefResponse
     */
    public function setReferenceCount(?int $reference_count): CrossrefResponse
    {
        $this->reference_count = $reference_count;
        return $this;
    }

    public function getIsReferencedByCount(): ?int
    {
        return $this->is_referenced_by_count;
    }

    /**
     * @param int|null $is_referenced_by_count
     * @return CrossrefResponse
     */
    public function setIsReferencedByCount(?int $is_referenced_by_count): CrossrefResponse
    {
        $this->is_referenced_by_count = $is_referenced_by_count;
        return $this;
    }
}
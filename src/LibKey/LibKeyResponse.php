<?php

namespace BCLib\FulltextFinder\LibKey;

/**
 * API response from LibKey
 *
 * Use this as a value object for LibKey API responses instead of the bare stdClass from json_decode. Gives us the
 * benefit of better IDE/static analysis, a more logical structure, and the ability to manipulate the response during
 * parsing if necessary.
 */
class LibKeyResponse
{
    /** @var int */
    private $id;

    /** @var string */
    private $type;

    /** @var string */
    private $title;

    /** @var string */
    private $date;

    /** @var string */
    private $authors;

    /** @var bool */
    private $in_press = false;

    /** @var string|null */
    private $full_text_file;

    /** @var string|null */
    private $content_location;

    /** @var bool */
    private $available_through_browzine;

    /** @var string|null */
    private $start_page;

    /** @var string|null */
    private $end_page;

    /** @var string|null */
    private $browzine_web_link;

    /** @var Journal[] */
    private $journals;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return LibKeyResponse
     */
    public function setId(int $id): LibKeyResponse
    {
        $this->id = $id;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return LibKeyResponse
     */
    public function setType(string $type): LibKeyResponse
    {
        $this->type = $type;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return LibKeyResponse
     */
    public function setTitle(string $title): LibKeyResponse
    {
        $this->title = $title;
        return $this;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     * @return LibKeyResponse
     */
    public function setDate(string $date): LibKeyResponse
    {
        $this->date = $date;
        return $this;
    }

    public function getAuthors(): string
    {
        return $this->authors;
    }

    /**
     * @param string $authors
     * @return LibKeyResponse
     */
    public function setAuthors(string $authors): LibKeyResponse
    {
        $this->authors = $authors;
        return $this;
    }

    public function isInPress(): bool
    {
        return $this->in_press;
    }

    /**
     * @param bool $in_press
     * @return LibKeyResponse
     */
    public function setInPress(bool $in_press): LibKeyResponse
    {
        $this->in_press = $in_press;
        return $this;
    }

    public function getFullTextFile(): ?string
    {
        return $this->full_text_file;
    }

    /**
     * @param string|null $full_text_file
     * @return LibKeyResponse
     */
    public function setFullTextFile(?string $full_text_file): LibKeyResponse
    {
        $this->full_text_file = $full_text_file;
        return $this;
    }

    public function getContentLocation(): ?string
    {
        return $this->content_location;
    }

    /**
     * @param string|null $content_location
     * @return LibKeyResponse
     */
    public function setContentLocation(?string $content_location): LibKeyResponse
    {
        $this->content_location = $content_location;
        return $this;
    }

    public function isAvailableThroughBrowzine(): bool
    {
        return $this->available_through_browzine;
    }

    /**
     * @param bool $available_through_browzine
     * @return LibKeyResponse
     */
    public function setAvailableThroughBrowzine(bool $available_through_browzine): LibKeyResponse
    {
        $this->available_through_browzine = $available_through_browzine;
        return $this;
    }

    public function getStartPage(): ?string
    {
        return $this->start_page;
    }

    /**
     * @param string|null $start_page
     * @return LibKeyResponse
     */
    public function setStartPage(?string $start_page): LibKeyResponse
    {
        $this->start_page = $start_page;
        return $this;
    }

    public function getEndPage(): ?string
    {
        return $this->end_page;
    }

    /**
     * @param string|null $end_page
     * @return LibKeyResponse
     */
    public function setEndPage(?string $end_page): LibKeyResponse
    {
        $this->end_page = $end_page;
        return $this;
    }

    public function getBrowzineWebLink(): ?string
    {
        return $this->browzine_web_link;
    }

    /**
     * @param string|null $browzine_web_link
     * @return LibKeyResponse
     */
    public function setBrowzineWebLink(?string $browzine_web_link): LibKeyResponse
    {
        $this->browzine_web_link = $browzine_web_link;
        return $this;
    }

    /**
     * @return Journal[]
     */
    public function getJournals(): array
    {
        return $this->journals;
    }

    /**
     * @param Journal[] $journals
     * @return LibKeyResponse
     */
    public function setJournals(array $journals): LibKeyResponse
    {
        $this->journals = $journals;
        return $this;
    }
}
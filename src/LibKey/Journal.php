<?php

namespace BCLib\FulltextFinder\LibKey;

/**
 * API Journal from LibKey
 *
 * Use this as a value object for LibKey API journals instead of the bare stdClass from json_decode. Gives us the
 * benefit of better IDE/static analysis, a more logical structure, and the ability to manipulate the response during
 * parsing if necessary.
 */
class Journal
{
    /** @var int */
    private $id;

    /** @var string|null */
    private $type;

    /** @var string|null */
    private $title;

    /** @var string|null */
    private $issn;

    /** @var float|null */
    private $sjr_value;

    /** @var string|null */
    private $cover_image_url;

    /** @var bool */
    private $browzine_enabled;

    /** @var string|null */
    private $browzine_web_link;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Journal
     */
    public function setId(int $id): Journal
    {
        $this->id = $id;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Journal
     */
    public function setType(?string $type): Journal
    {
        $this->type = $type;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Journal
     */
    public function setTitle(?string $title): Journal
    {
        $this->title = $title;
        return $this;
    }

    public function getISSN(): ?string
    {
        return $this->issn;
    }

    /**
     * @param string|null $issn
     * @return Journal
     */
    public function setISSN(?string $issn): Journal
    {
        $this->issn = $issn;
        return $this;
    }

    public function getSJRValue(): ?float
    {
        return $this->sjr_value;
    }

    /**
     * @param float|null $sjr_value
     * @return Journal
     */
    public function setSJRValue(?float $sjr_value): Journal
    {
        $this->sjr_value = $sjr_value;
        return $this;
    }

    public function getCoverImageUrl(): ?string
    {
        return $this->cover_image_url;
    }

    /**
     * @param string|null $cover_image_url
     * @return Journal
     */
    public function setCoverImageUrl(?string $cover_image_url): Journal
    {
        $this->cover_image_url = $cover_image_url;
        return $this;
    }

    public function isBrowzineEnabled(): bool
    {
        return $this->browzine_enabled;
    }

    /**
     * @param bool|null $browzine_enabled
     * @return Journal
     */
    public function setBrowzineEnabled(?bool $browzine_enabled): Journal
    {
        $this->browzine_enabled = isset($browzine_enabled) && $browzine_enabled;
        return $this;
    }

    public function getBrowzineWebLink(): ?string
    {
        return $this->browzine_web_link;
    }

    /**
     * @param string|null $browzine_web_link
     * @return Journal
     */
    public function setBrowzineWebLink(?string $browzine_web_link): Journal
    {
        $this->browzine_web_link = $browzine_web_link;
        return $this;
    }
}
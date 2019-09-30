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
    public $id;

    /** @var string */
    public $type;

    /** @var string */
    public $title;

    /** @var string */
    public $issn;

    /** @var float */
    public $sjr_value;

    /** @var string */
    public $cover_image_url;

    /** @var bool */
    public $browzine_enabled;

    /** @var string */
    public $browzine_web_link;
}
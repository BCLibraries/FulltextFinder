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
    public $id;

    /** @var string */
    public $type;

    /** @var string */
    public $title;

    /** @var string */
    public $date;

    /** @var string */
    public $authors;

    /** @var bool */
    public $in_press;

    /** @var string */
    public $full_text_file;

    /** @var string */
    public $content_location;

    /** @var bool */
    public $available_through_browzine;

    /** @var string */
    public $start_page;

    /** @var string */
    public $end_page;

    /** @var string */
    public $browzine_web_link;

    /** @var Journal[] */
    public $journals;
}
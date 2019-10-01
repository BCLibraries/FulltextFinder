<?php

namespace BCLib\FulltextFinder\Crossref;

class CrossrefResponse
{
    /** @var string */
    public $doi;

    /** @var string[] */
    public $title = [];

    /** @var string[] */
    public $subtitle = [];

    /** @var string */
    public $short_title = [];

    /** @var Author[] */
    public $author = [];

    /** @var string */
    public $type;

    /** @var string[] */
    public $container_title = [];

    /** @var string[] */
    public $short_container_title = [];

    /** @var string */
    public $publisher;

    /** @var string */
    public $volume;

    /** @var string */
    public $issue;

    /** @var string */
    public $page;

    /** @var float */
    public $score;

    /** @var int[] */
    public $published_print_date = [];

    /** @var string[] */
    public $alternative_id = [];

    /** @var Reference[] */
    public $reference = [];

    /** @var int */
    public $reference_count;

    /** @var int */
    public $is_referenced_by_count;
}
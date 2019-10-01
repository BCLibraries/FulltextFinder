<?php

namespace BCLib\FulltextFinder\Crossref;

class Author
{
    /** @var string */
    public $given;

    /** @var string */
    public $family;

    /** @var string */
    public $sequence;

    /** @var string */
    public $orcid;

    /** @var bool */
    public $authenticated_orcid;

    /** @var string[] */
    public $affiliation = [];

}
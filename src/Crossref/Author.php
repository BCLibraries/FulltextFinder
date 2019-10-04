<?php

namespace BCLib\FulltextFinder\Crossref;

class Author
{
    /** @var string */
    private $given_name;

    /** @var string */
    private $family_name;

    /** @var string */
    private $sequence;

    /** @var string */
    private $orcid;

    /** @var bool */
    private $authenticated_orcid;

    /** @var string[] */
    private $affiliation = [];

    public function getGivenName(): ?string
    {
        return $this->given_name;
    }

    /**
     * @param string $given_name
     * @return Author
     */
    public function setGivenName(?string $given_name): Author
    {
        $this->given_name = $given_name;
        return $this;
    }

    public function getFamilyName(): ?string
    {
        return $this->family_name;
    }

    /**
     * @param string $family_name
     * @return Author
     */
    public function setFamilyName(?string $family_name): Author
    {
        $this->family_name = $family_name;
        return $this;
    }

    public function getSequence(): ?string
    {
        return $this->sequence;
    }

    /**
     * @param string $sequence
     * @return Author
     */
    public function setSequence(?string $sequence): Author
    {
        $this->sequence = $sequence;
        return $this;
    }

    public function getORCID(): ?string
    {
        return $this->orcid;
    }

    /**
     * @param string $orcid
     * @return Author
     */
    public function setORCID(?string $orcid): Author
    {
        $this->orcid = $orcid;
        return $this;
    }

    public function isAuthenticatedORCID(): ?bool
    {
        return $this->authenticated_orcid;
    }

    /**
     * @param bool $authenticated_orcid
     * @return Author
     */
    public function setAuthenticatedORCID(?bool $authenticated_orcid): Author
    {
        $this->authenticated_orcid = $authenticated_orcid;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getAffiliation(): array
    {
        return $this->affiliation;
    }

    /**
     * @param string[] $affiliation
     * @return Author
     */
    public function setAffiliation(array $affiliation): Author
    {
        $this->affiliation = $affiliation;
        return $this;
    }

}
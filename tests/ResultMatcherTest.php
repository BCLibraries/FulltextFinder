<?php

namespace BCLib\FulltextFinder\Tests;

use BCLib\FulltextFinder\Crossref\CrossrefResponse;
use BCLib\FulltextFinder\ResultMatcher;
use PHPUnit\Framework\TestCase;

class ResultMatcherTest extends TestCase
{

    /** @var ResultMatcher */
    public $matcher;

    public function setUp(): void
    {
        $this->matcher = new ResultMatcher(50);
    }

    public function testMatchWhenExceedsMinScore(): void
    {
        $response = \Mockery::mock(CrossrefResponse::class);
        $response->shouldReceive('getScore')
            ->andReturn('75');
        $this->assertTrue($this->matcher->isMatch($response, 'placeholder'));
    }

    public function testNonMatchReturnsFalse(): void
    {
        $titles = ['The neglected otters in China: Distribution change in the past 400 years'];
        $search_string = 'Where will it cross next? Optimal management of road collision risk for otters in Italy';

        $response = \Mockery::mock(CrossrefResponse::class);
        $response->shouldReceive('getScore')
            ->andReturn('30');
        $response->shouldReceive('getTitles')
            ->andReturn($titles);
        $this->assertFalse($this->matcher->isMatch($response, $search_string));
    }
}

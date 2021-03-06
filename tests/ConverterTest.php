<?php

namespace Mateusjatene\RssToJson\Tests;

use Mateusjatene\RssToJson\Converter;
use Mateusjatene\RssToJson\RssToJson;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    /** @test */
    public function it_parses_a_json_field()
    {
        $converter = Converter::from($this->getXML());

        $expected = json_decode($this->getExpectedJsonFeed(), true);

        $this->assertEquals($expected, $converter->toArray());
    }

    protected function getXML()
    {
        return file_get_contents(__DIR__ . '/rss_feed.xml');
    }

    protected function getExpectedJsonFeed()
    {
        return file_get_contents(__DIR__ . '/json_feed.json');
    }
}

<?php

namespace Mateusjatene\RssToJson;

use Carbon\Carbon;
use SimpleXMLElement;

class Converter
{
    protected $author;

    protected $input;

    protected $isParsed = false;

    protected $version = 'https://jsonfeed.org/version/1';

    public function __construct($input)
    {
        $this->input = $input;
    }

    public static function from($input)
    {
        return new static($input);
    }

    public function parse()
    {
        $xml = new SimpleXMLElement($this->input, LIBXML_NOCDATA);

        $this->author = (string) $xml->channel->managingEditor;

        $topLevel = $this->buildTopLevel($xml->channel);

        $items = $this->buildItems((array) $xml->channel);

        $this->parsed = $topLevel + ['items' => $items];

        return $this;
    }

    public function buildItems(array $xml)
    {
        return array_map(function ($xml) {
            return [
                'id' => (string) $xml->link,
                'url' => (string) $xml->link,
                'title' => (string) $xml->title,
                'content_html' => (string) $xml->description,
                'summary' => (string) $xml->description,
                'date_published' => Carbon::parse((string) $xml->pubDate)->toRfc3339String(),
                'author' => [
                    'name' => $this->author,
                ],
            ];
        }, $xml['item']);
    }

    public function buildTopLevel($xml)
    {
        return [
            'version' => $this->version,
            'title' => (string) $xml->title,
            'description' => (string) $xml->description,
            'home_page_url' => (string) $xml->link,
            'author' => [
                'name' => (string) $xml->managingEditor,
            ],
        ];
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        if (!$this->isParsed) {
            $this->parse();
        }

        return $this->parsed;
    }
}

<?php

namespace Mateusjatene\RssToJson;

class Converter
{
    private $input;

    public function __construct($input)
    {

        $this->input = $input;
    }

    public static function from($input)
    {
        return new static($input);
    }

    public function toJson()
    {
        return json_encode([]);
    }

    public function toArray()
    {
        return [];
    }
}

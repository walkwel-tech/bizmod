<?php

namespace App\Helpers;

use App\Traits\PerformsSEO;

class SelectObject {
    use PerformsSEO;

    public $title;
    public $description;
    public $value;

    public function __construct($value, $title = null, $description = null)
    {
        $this->value = $value;
        $this->title = $title ?? $this->value;
        $this->description = $description;
    }

    public function getKey ()
    {
        return $this->value;
    }

    public function getAttribute ($attributeName)
    {
        return $this->$attributeName;
    }
}

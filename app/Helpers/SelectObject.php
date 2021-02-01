<?php

namespace App\Helpers;

use App\Traits\PerformsSEO;

class SelectObject {
    use PerformsSEO;

    public $title;
    public $description;

    public function __construct($title, $description = null)
    {
        $this->title = $title;
        $this->description = $description;
    }

    public function getKey ()
    {
        return $this->title;
    }


    public function getAttribute ($attributeName)
    {
        return $this->$attributeName;
    }
}

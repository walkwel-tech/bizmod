<?php

namespace App\Helpers;

use Illuminate\Contracts\Support\Arrayable;

class TemplateConfiguration implements Arrayable {
    public $business;
    public $code;

    public function __construct($business, $code)
    {
        $this->business = $business;
        $this->code = $code;
    }

    public function setBusinessPosition ($x, $y)
    {
        $this->business['position']['x'] = $x;
        $this->business['position']['y'] = $y;
    }

    public function getBusinessPosition ()
    {
        return $this->business['position'];
    }

    public function getBusinessPositionX ()
    {
        return $this->getBusinessPosition()['x'];
    }

    public function getBusinessPositionY ()
    {
        return $this->getBusinessPosition()['y'];
    }

    public function setCodeTextColor ($color)
    {
        $this->code['text']['color'] = $color;
    }

    public function getCodeText ()
    {
        return $this->code['text'] ?? static::getDefaultTextConfiguration();
    }

    public function getCodeTextColor ()
    {
        return $this->getCodeText()['color'];
    }

    public function setCodePosition ($x, $y)
    {
        $this->code['position']['x'] = $x;
        $this->code['position']['y'] = $y;
    }

    public function getCodePosition ()
    {
        return $this->code['position'];
    }

    public function getCodePositionX ()
    {
        return $this->getCodePosition()['x'];
    }

    public function getCodePositionY ()
    {
        return $this->getCodePosition()['y'];
    }

    public function toArray ()
    {
        return [
            'business' => $this->business,
            'code' => $this->code
        ];
    }

    public static function getDefaultTextConfiguration ()
    {
        return [
            'color' => 'rgb(0,0,0)'
        ];
    }
}

<?php

namespace App\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Str;

class TemplateConfiguration implements Arrayable {
    public $business;
    public $code;

    public function __construct($business, $code)
    {
        $this->business = $business;
        $this->code = $code;
    }

    public function __call($name, $arguments)
    {
        $data_arr = explode('_', Str::snake($name));

        $type = $data_arr[0];
        $context = $data_arr[1];
        $property = $data_arr[2];
        $offset = $data_arr[3];
        if($type=='set'){

        } else {
            return $this->$context[$property][$offset] ?? static::getDefaultConfiguration($context,$property)[$offset];
        }

    }

    public function toArray ()
    {
        return [
            'business' => $this->business,
            'code' => $this->code
        ];
    }

    public static function getDefaultConfiguration ($type = 'code',$property = null)
    {
        $conf = [
            'business' => [
                'position'=> [
                    'x' => 10,
                    'y' => 20,
                ],
                'text'=> [
                    'size' => 20,
                    'color' => "#000000",
                    'spacing' => 10,
                ]

            ],
            'code' => [
                'position'=> [
                    'x' => 10,
                    'y' => 20,
                ],
                'text'=> [
                    'size' => 20,
                    'color' => "#000000",
                    'spacing' => 10,
                ]

            ]

        ];
        if($property){
            return $conf[$type][$property];
        } else {
            return $conf[$type];
        }

    }

    // public function setBusinessPosition ($x, $y)
    // {
    //     $this->business['position']['x'] = $x;
    //     $this->business['position']['y'] = $y;
    // }

    // public function getBusinessPosition ()
    // {
    //     return $this->business['position'] ?? static::getDefaultPositionConfiguration('business');
    // }

    // public function getBusinessPositionX ()
    // {
    //     return $this->getBusinessPosition()['x'];
    // }

    // public function getBusinessPositionY ()
    // {
    //     return $this->getBusinessPosition()['y'];
    // }

    // public function setBusinessTextColor ($color)
    // {
    //     $this->business['text']['color'] = $color;
    // }

    // public function getBusinessText ()
    // {
    //     return $this->business['text'] ?? static::getDefaultTextConfiguration();
    // }

    // public function getBusinessTextColor ()
    // {
    //     return $this->getBusinessText()['color'];
    // }

    // public function setCodeTextColor ($color)
    // {
    //     $this->code['text']['color'] = $color;
    // }

    // public function getCodeText ()
    // {
    //     return $this->code['text'] ?? static::getDefaultTextConfiguration();
    // }

    // public function getCodeTextColor ()
    // {
    //     return $this->getCodeText()['color'];
    // }

    // public function setCodePosition ($x, $y)
    // {
    //     $this->code['position']['x'] = $x;
    //     $this->code['position']['y'] = $y;
    // }

    // public function getCodePosition ()
    // {
    //     return $this->code['position'] ?? static::getDefaultPositionConfiguration('code');
    // }

    // public function getCodePositionX ()
    // {
    //     return $this->getCodePosition()['x'];
    // }

    // public function getCodePositionY ()
    // {
    //     return $this->getCodePosition()['y'];
    // }





    // public static function getDefaultPositionConfiguration ($type = 'code')
    // {
    //     $conf = [
    //         'business' => [
    //             'x' => 10,
    //             'y' => 20,
    //         ],
    //         'code' => [
    //             'x' => 10,
    //             'y' => 180,
    //         ],
    //     ];

    //     return $conf[$type];
    // }

    // public static function getDefaultTextConfiguration ()
    // {
    //     return [
    //         'color' => '#000000',
    //         'size' => '16px',
    //         'spacing' => '8px',
    //     ];
    // }
}

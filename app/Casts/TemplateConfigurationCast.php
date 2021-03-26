<?php

namespace App\Casts;

use App\Helpers\TemplateConfiguration;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class TemplateConfigurationCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $valueFromDB
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, $key, $valueFromDB, $attributes)
    {
        $decodedValue= json_decode($valueFromDB, true);

        return new TemplateConfiguration(
            $decodedValue['business'] ?? [],
            $decodedValue['code'] ?? [],
            $decodedValue['expire'] ?? []
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, $key, $dataInMemory, $attributes)
    {
        return json_encode($dataInMemory);
    }
}

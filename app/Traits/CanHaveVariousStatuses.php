<?php

namespace App\Traits;

trait CanHaveVariousStatuses {

    public function getStatusTextAttribute()
    {
        return $this->getCurrentStatusValue();
    }

    public function getCurrentStatusValue()
    {
        $status = strtolower($this->getAttribute($this->getStatusColumnName()));

        return static::getAvailableStatuses()->get($status);
    }

    public function getStatusColumnName()
    {
        return 'status';
    }

    public function validateStatusAttribute($value)
    {
        $value = strtolower($value);

        return static::getAvailableStatuses()->has($value);
    }

    public static function getAvailableStatusValues()
    {
        return static::getAvailableStatuses()->keys();
    }

    public static function getDefaultStatusValue()
    {
        return static::getAvailableStatusValues()->first();
    }

    public static function getDefaultStatus()
    {
        return static::getAvailableStatuses()->first();
    }

    public static function getAvailableStatuses ()
    {
        $Statuses = collect([
            'draft' => 'Draft',
            'private' => 'Private',
            'published' => 'Published',
            'taken-down' => 'Taken Down',
        ]);

        return $Statuses;
    }

    public static function determineStatusValueFromText($text) {
        return self::getAvailableStatuses()->flip()->get($text) ?? self::getDefaultStatusValue();
    }
}

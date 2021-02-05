<?php

namespace App\Traits;

use Carbon\Carbon;

trait ScopesDateRangeBetween {

    public function scopeDateRangeBetween($query, $column, $dateStart, $dateEnd) {
        $dS = new Carbon($dateStart);
        $dE = new Carbon($dateEnd);

        $query->whereBetween($column, [$dS->startOfDay(), $dE->endOfDay()]);

        return $query;
    }

    public function scopeCreatedWithinLastMonth ($query)
    {
        return $query->createdBetween(now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth());
    }

    public function scopeCreatedWithinThisMonth ($query)
    {
        return $query->createdBetween(now()->startOfMonth(), now()->endOfMonth());
    }

    public function scopeCreatedBetween ($query, $dateStart, $dateEnd)
    {
        return $query->dateRangeBetween('created_at', $dateStart, $dateEnd);
    }

    public function scopeUpdatedBetween ($query, $dateStart, $dateEnd)
    {
        return $query->dateRangeBetween('updated_at', $dateStart, $dateEnd);
    }
    public static function calculateCreationAverage ($query = null)
    {
        if($query) {
            $thisMonth = (clone $query)->createdWithinThisMonth()->count();
            $lastMonth = (clone $query)->createdWithinLastMonth()->count();
        } else {
            $thisMonth = static::createdWithinThisMonth()->count();
            $lastMonth = static::createdWithinLastMonth()->count();
        }

        return [
            'current' => $thisMonth,
            'last' => $lastMonth,
            'average' => ($lastMonth > 0) ? round($thisMonth / $lastMonth *100 , 2) : $thisMonth * 100
        ];
    }
}

<?php

namespace App;

use App\Traits\HasAccessClients;
use App\Traits\HasCountryInfo;
use App\Traits\ScopesDateRangeBetween;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Bus;

class Client extends Model
{
    use HasFactory;
    use HasCountryInfo;
    use HasAccessClients;
    use SoftDeletes;
    use HasFactory;
    use ScopesDateRangeBetween;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'country_name',
        'country_code',
        'zip'
    ];

    protected $appends = [
        'claimed_code'
    ];


    public function relatesToCountry(Country $country)
    {
        return $country->name === $this->country_name;
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_name', 'name');
    }

    public function codes()
    {
        return $this->hasMany(Code::class);
    }

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'codes')
            ->distinct();
    }

    public function getBusinessTitlesAttribute ()
    {
        return $this->businesses->map(function ($business, $key) {
            return $business->getSEOTitle();
        })->join(', ');
    }

    public function getClaimedCodeAttribute()
    {
        return trim($this->codes()->pluck('code')->join(', '));
    }
}

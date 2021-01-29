<?php

namespace App;

use App\Traits\HasCountryInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use HasCountryInfo;
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
            'first_name',
            'last_name',
            'email',
            'phone',
            'country_name',
            'country_code',
            'zip'
    ];


    public function relatesToCountry (Country $country)
    {
        return $country->name === $this->country_name;
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_name', 'name');
    }

    public function codes ()
    {
        return $this->hasMany(Code::class);
    }
}

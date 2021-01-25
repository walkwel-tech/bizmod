<?php

namespace App;

use App\Traits\PerformsBasicSEO;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use PerformsBasicSEO;

    //region Properties
    protected $fillable = [
        'code',
        'name',
        'phonecode',
    ];
    protected $appends = [
    ];
    protected $dates = [
    ];
    protected $casts = [
    ];
    //endregion Properties

    //region Object Methods

    //region Mutators
    //endregion Mutators

    //region Accessors
    //endregion Accessors

    //endregion Object Methods

    //region Relationships
    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function cities()
    {
        return $this->hasManyThrough(City::class, State::class);
    }

    //endregion Relationships


    //region Local Scopes
    public function scopeName($query, $nameOfCountry)
    {
        return $query->where('name', 'like', $nameOfCountry);
    }
    //endregion Local Scopes


    //region Static Methods

    public static function getTitleAttributeColumnName()
    {
        return 'name';
    }
    //endregion Static Methods

}

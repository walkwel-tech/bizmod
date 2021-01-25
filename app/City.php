<?php

namespace App;

use App\Traits\PerformsBasicSEO;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use PerformsBasicSEO;

    //region Properties
    protected $fillable = [
        'name',
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
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->state->country();
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

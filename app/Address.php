<?php

namespace App;

use App\Traits\HasLocationInfo;
use App\Traits\PerformsSEO;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use App\Traits\ScopesSlug;
use Spatie\Sluggable\SlugOptions;

class Address extends Model
{
    use HasSlug;
    use ScopesSlug;
    use HasLocationInfo;
    use PerformsSEO;

    //region Properties
    protected $fillable = [
        'title',
        'description',
        'line_1',
        'line_2',
        'zip',
        'phone',
        'country_id',
        'state_id',
        'city_id',
        'locatable_type',
        'locatable_id',
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

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
            ->usingSeparator('-');
    }
    //endregion Object Methods

    //region Relationships

    public function locatable()
    {
        return $this->morphTo();
    }

    //endregion Relationships


    //region Local Scopes
    //endregion Local Scopes


    //region Static Methods
    public static function makeNewForLocation($countryName, $stateName, $cityName, $prefix = null)
    {
        $locationInfo = [$countryName, $stateName, $cityName];

        $address = new self;
        $line_1[] = $prefix;
        $line_1[] = implode(', ', array_filter($locationInfo, function($v){ return $v; }));

        $address->line_1 = implode(' ', array_filter($line_1, function($v){ return $v; }));
        $address->setLocationByName($countryName, $stateName, $cityName);

        return $address;
    }
    //endregion Static Methods

}

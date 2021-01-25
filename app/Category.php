<?php

namespace App;

use App\Traits\PerformsSEO;
use App\Traits\ScopesSlug;
use App\Traits\WalkwelSlugMaker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;


class Category extends Model
{
    use SoftDeletes;
    use HasSlug;
    use WalkwelSlugMaker;
    use HasFactory;
    use ScopesSlug;
    use PerformsSEO;

    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->getSlugColumnName();
    }


    public function services() {
        return $this->belongsToMany(Service::class);
    }

}

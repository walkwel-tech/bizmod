<?php

namespace App;

use Str;
use App\Traits\PerformsSEO;
use App\Traits\ScopesSlug;
use App\Traits\WalkwelSlugMaker;
use App\Traits\CanBeOwned;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;

class Business extends Model
{
    use SoftDeletes;
    use HasSlug;
    use WalkwelSlugMaker;
    use HasFactory;
    use ScopesSlug;
    use PerformsSEO;
    use CanBeOwned;

    protected $fillable = [
        'title',
        'description',
        'prefix',
        'owner_id',
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

    public function setPrefixAttribute($value)
    {
        $this->attributes['prefix'] = strtoupper($value);
    }


}

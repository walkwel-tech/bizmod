<?php

namespace App;

use Str;
use App\Traits\PerformsSEO;
use App\Traits\ScopesSlug;
use App\Traits\WalkwelSlugMaker;
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

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function getOwnerTitle($limitCharacters = null, $end = '...')
    {
        $title = $this->owner->first_name;

        return ($limitCharacters)
                ? Str::limit($title, $limitCharacters, $end)
                : $title;
    }

    public static function getOwnerAttributeColumnName()
    {
        return 'owner_id';
    }

}

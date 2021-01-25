<?php

namespace App;

use App\Traits\PerformsSEO;
use App\Traits\ScopesSlug;
use App\Traits\WalkwelSlugMaker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;
    use WalkwelSlugMaker;
    use HasFactory;
    use ScopesSlug;
    use PerformsSEO;

    protected $fillable = [
        'title',
        'description',
        'amount'
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

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function service_orders() {
        return $this->hasMany(ServiceOrder::class);
    }

    public function hasCategory(Category $category) {
        return $this->categories->contains($category);
    }

    public function steps() {
        return $this->hasMany(Step::class);
    }
}

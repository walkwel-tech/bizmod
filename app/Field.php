<?php

namespace App;

use App\Traits\PerformsSEO;
use App\Traits\ScopesSlug;
use App\Traits\WalkwelSlugMaker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;

class Field extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;
    use WalkwelSlugMaker;
    use ScopesSlug;
    use PerformsSEO;

    protected $fillable = [
        'title',
        'name',
        'type',
        'mapped_to',
        'placeholder',
        'required',
        'validations',
        'step_id'
    ];

    protected $casts = [
        'required' => 'boolean',
        'validations' => 'array',
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

    public function step()
    {
        return $this->belongsTo(Step::class);
    }
}

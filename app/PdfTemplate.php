<?php

namespace App;

use App\Casts\TemplateConfigurationCast;
use Str;
use App\Traits\PerformsSEO;
use App\Traits\ScopesSlug;
use App\Traits\WalkwelSlugMaker;
use App\Traits\CanBeOwned;
use App\Traits\HasAddresses;
use App\Traits\ScopesDateRangeBetween;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;

class PdfTemplate extends Model
{
    use SoftDeletes;
    use HasSlug;
    use WalkwelSlugMaker;
    use HasFactory;
    use ScopesSlug;
    use PerformsSEO;
    use CanBeOwned;
    use HasAddresses;
    use ScopesDateRangeBetween;

    protected $fillable = [
        'title',
        'description',
        'path'
    ];

    protected $casts = [
        'configuration' => TemplateConfigurationCast::class,
    ];


    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function getRouteKeyName()
    {
        return $this->getSlugColumnName();
    }
}

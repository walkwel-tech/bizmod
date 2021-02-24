<?php

namespace App;

use App\Casts\TemplateConfigurationCast;
use Str;
use App\Traits\PerformsSEO;
use App\Traits\ScopesSlug;
use App\Traits\WalkwelSlugMaker;
use App\Traits\CanBeOwned;
use App\Traits\HasAccess;
use App\Traits\HasAddresses;
use App\Traits\ResolveRouteBinding;
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
    use HasAccess;
    use PerformsSEO;
    use ResolveRouteBinding;
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

    protected $appends = [
        'is_assigned'
    ];


    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function codes()
    {
        return $this->hasMany(Code::class);
    }

    public function getIsAssignedAttribute()
    {
        return $this->codes()->exists();
    }

    public function getRouteKeyName()
    {
        return $this->getSlugColumnName();
    }
}

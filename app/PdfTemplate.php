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
        'type',
        'path'
    ];

    protected $casts = [
        'configuration' => TemplateConfigurationCast::class,
    ];

    protected $appends = [
        'is_assigned',
        'selected_type'
    ];

    public  function getSelectedTypeAttribute ()
    {
        return ucwords($this->type);
    }


    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function digital_codes()
    {
        return $this->hasMany(Code::class,'digital_template_id');
    }

    public function print_codes()
    {
        return $this->hasMany(Code::class,'print_ready_template_id');
    }

    public function getIsAssignedAttribute()
    {
        return ($this->digital_codes()->exists()) ? $this->digital_codes()->exists() : $this->print_codes()->exists() ;
    }

    public function getRouteKeyName()
    {
        return $this->getSlugColumnName();
    }
    public static function getRandomTypeValue ()
    {
        return static::getAvailableTypesValues()->random();
    }

    public static function getAvailableTypesValues ()
    {
        return static::getAvailableTypes()->keys();
    }

    public static function getAvailableTypes ()
    {
        $values = [
            'digital' => 'Digital',
            'print ready' => 'Print Ready'
        ];

        return collect($values);
    }
}

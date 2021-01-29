<?php

namespace App;

use App\Traits\PerformsSEO;
use App\Traits\ScopesSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\SchemalessAttributes;

class Code extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasFactory;
    use ScopesSlug;
    use PerformsSEO;

    protected $casts = [
        'claim_details' => 'array',
    ];

    protected $fillable = [
        'batch_no',
        'code',
        'business_id'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'code';
    }


    public function getClaimDetailsAttribute(): SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'claim_details');
    }

    public function scopeWithClaimDetails(): Builder
    {
        return SchemalessAttributes::scopeWithSchemalessAttributes('claim_details');
    }

    public function setBatchNoAttribute($value)
    {
        $this->attributes['batch_no'] = strtoupper(substr($value, 0, 8));
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper(substr($value, 0, 12));
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function scopeClaimed ($query)
    {
        $query->whereNotNull('claimed_on');

        return $query;
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}

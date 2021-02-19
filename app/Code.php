<?php

namespace App;

use App\Exceptions\CodeUnavailableException;
use App\Traits\PerformsSEO;
use App\Traits\ResolveRouteBinding;
use App\Traits\ScopesDateRangeBetween;
use App\Traits\ScopesSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\SchemalessAttributes;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class Code extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasFactory;
    use ScopesSlug;
    use PerformsSEO;
    use ResolveRouteBinding;
    use ScopesDateRangeBetween;

    protected $casts = [
        'claim_details' => 'array',
    ];

    protected $appends = [
        'status',
        'message',
    ];

    protected $fillable = [
        'batch_no',
        'code',
        'business_id',
        'description'
    ];


    public function getStatusAttribute ()
    {
        if($this->isAvailableToClaim())
        {
            return 'available';
        } else {
            return ($this->client_id) ? 'applied' : 'unavailable';
        }
        return 'unavailable';
    }


    public function getMessageAttribute ()
    {
        return static::getMessageForStatus($this->status);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return static::getTitleAttributeColumnName();
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    // public function resolveRouteBinding($value, $field = null)
    // {
    //     if (auth()->user()->hasRole('super')) {
    //         return $this->withTrashed()->where($this->getRouteKeyName(), $value)->firstOrFail();
    //     } else {
    //         return $this->where($this->getRouteKeyName(), $value)->firstOrFail();
    //     }
    // }

    public function getClaimDetailsAttribute(): SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'claim_details');
    }

    public function isAvailableToClaim ()
    {
        return is_null($this->claimed_on);
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

    public function template()
    {
        return $this->belongsTo(PdfTemplate::class,'pdf_template_id');
    }

    public function scopeReportingData ($query)
    {
        return $query->selectRaw('year(created_at) year, DATE_FORMAT(created_at, "%m") month_number, DATE_FORMAT(created_at, "%b") month, count(*) records')
            ->groupBy('year', 'month', 'month_number')
            ->orderBy('year', 'asc')
            ->orderBy('month_number', 'asc');
    }

    public function scopeReportingDataYearly ($query)
    {
        return $query->selectRaw('year(created_at) year, count(*) records')
        ->groupBy('year')
        ->orderBy('year', 'asc');
    }

    public function scopeClaimed ($query)
    {
        $query->whereNotNull('claimed_on');

        return $query;
    }

    public function scopeUnclaimed ($query)
    {
        $query->whereNull('claimed_on');

        return $query;
    }

    public function scopeCode ($query, $code)
    {
        return $query->where('code', $code);
    }

    public function scopeClaimedBetween ($query, $dateStart, $dateEnd)
    {
        return $query->dateRangeBetween('claimed_on', $dateStart, $dateEnd);
    }

    public function client()
    {
        return $this->belongsTo(Client::class)->withDefault();
    }

    public static function getTitleAttributeColumnName() {
        return 'code';
    }

    public static function getMessageForStatus ($status = '')
    {
        $messages = [
            'available' => 'Code Available.',
            'unavailable' => 'Code is Not Available.',
            'applied' => 'Code Applied.',
            'expired' => 'Code has been expired',
        ];

        return $messages[$status] ?? 'Code is Invalid';
    }

    public function applyCodeForClient (Client $client, array $claimDetails, $claimDate = null)
    {
        throw_if(
            !$this->isAvailableToClaim(),
            new CodeUnavailableException(static::getMessageForStatus('unavailable'))
        );

        $this->client_id = $client->id;
        $this->claimed_on = $claimDate ?? now();

        $this->claim_details = $claimDetails;

        $this->save();

        return $this;
    }

}

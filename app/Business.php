<?php

namespace App;

use Str;
use App\Traits\PerformsSEO;
use App\Traits\ScopesSlug;
use App\Traits\WalkwelSlugMaker;
use App\Traits\CanBeOwned;
use App\Traits\HasAccess;
use App\Traits\HasAddresses;
use App\Traits\ScopesDateRangeBetween;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Sluggable\HasSlug;

class Business extends Authenticatable
{
    use SoftDeletes;
    use HasSlug;
    use WalkwelSlugMaker;
    use HasFactory;
    use ScopesSlug;
    use HasAccess;
    use PerformsSEO {
        PerformsSEO::getSEOTitle as getOriginalSEOTitle;
    }
    use CanBeOwned;
    use HasAddresses;
    use ScopesDateRangeBetween;
    use HasApiTokens;

    protected $fillable = [
        'title',
        'description',
        'prefix',
        'owner_id',
        'sender_id',
        'b_id',
        'slug',
    ];

    protected $appends = [
        'next_batch',
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

    public function getSEOTitle($limitCharacters = null, $end = '...')
    {
        $title = $this->getAttribute(static::getTitleAttributeColumnName());

        $title = ($limitCharacters)
                ? Str::limit($title, $limitCharacters, $end)
                : $title;


        return "{$title} ({$this->prefix})";
    }


    public function getNextBatchAttribute()
    {
        $c = $this->batch_no ?? "{$this->prefix}000";
        return ++$c;
    }


    public function setBatchNoAttribute($value)
    {
        $this->attributes['batch_no'] = strtoupper(substr($value, 0, 8));
    }
    public function setPrefixAttribute($value)
    {
        $this->attributes['prefix'] = strtoupper($value);
    }

    public function codes()
    {
        return $this->hasMany(Code::class);
    }

    public function clients ()
    {
        return $this->belongsToMany(Client::class, 'codes')->distinct();
    }

    public function templates()
    {
        return $this->hasMany(PdfTemplate::class);
    }

    public function claimedCodes()
    {
        return $this->hasMany(Code::class)->claimed();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->as('role')->using(BusinessUser::class)->withPivot('access');
    }

    // generate random codes
    public function generateRandomCodes($noOfCodes = 10000, $batchNo = null, $prefix = null, $digitalTemplateId = null,$printTemplateId = null, $expireOn , $prefixMaxLength = 3 )
    {

        $this->batch_no = $batchNo ? $batchNo : $this->next_batch;
        $prefix = $prefix ?? $this->batch_no;
        $prefixLength = $prefixMaxLength - strlen($prefix);
        $prefix = substr(strtoupper($prefix . static::randomAlphabets($prefixLength)), 0, $prefixMaxLength);

        $codes = collect();
        while ($noOfCodes > $codes->count()) {
            $codes->push(new Code([
                'batch_no' => $this->batch_no,
                'code' => $prefix . static::getRandomString(3, 3),
                'digital_template_id' => $digitalTemplateId,
                'print_ready_template_id' => $printTemplateId,
                'expire_on' => $expireOn,
                'claim_details' => [],
            ]));
        }

        // filter the array with unique value
        $codes = $codes->unique('code');
        //dd($codes);
        $this->codes()->saveMany($codes);
        $this->save();

        return $codes;
    }


    public static function getRandomString($numeric_length, $alphabet_length)
    {
        $numbers = static::randomNumbers($numeric_length);
        $alphabets = static::randomAlphabets($alphabet_length);
        $string = $numbers . $alphabets;

        return $string;
    }


    public static function randomAlphabets($length)
    {
        $alphabets = "ABCDEFGHIJKLMNPQRSTUVWXYZ";

        if ($length <= 0) {
            return '';
        }

        // Shufle the $alphabets and returns substring of specified length
        return substr(
            str_shuffle($alphabets),
            0,
            $length
        );
    }

    public static function randomNumbers($length)
    {
        $numbers = "123456789";

        // Shufle the $numbers and returns substring of specified length
        return substr(
            str_shuffle($numbers),
            0,
            $length
        );
    }

}

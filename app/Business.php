<?php

namespace App;

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

class Business extends Model
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
        'prefix',
        'owner_id',
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

    public function templates()
    {
        return $this->hasMany(PdfTemplate::class);
    }

    public function claimedCodes()
    {
        return $this->hasMany(Code::class)->claimed();
    }

    // generate random codes
    public function generateRandomCodes($noOfCodes = 10000, $batchNo = null, $prefix = null, $pdfTemplateId = null, $prefixMaxLength = 3 )
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
                'pdf_template_id' => $pdfTemplateId,
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

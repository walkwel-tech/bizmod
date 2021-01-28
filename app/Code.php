<?php

namespace App;

use App\Traits\PerformsSEO;
use App\Traits\ScopesSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Code extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasFactory;
    use ScopesSlug;
    use PerformsSEO;

    protected $casts = [
        'claim_details' => 'json',
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

    public function setBatchNoAttribute($value)
    {
        // $prefix = $this->business ? $this->business->prefix : 'NIF';
        // $batch = str_pad(strtoupper(substr($value, 0, 5)), 8, $prefix, STR_PAD_RIGHT);
        $batchNo = ($value) ? $value : $this->business->next_batch;
        $batchLen = strlen($batchNo);
        if ($batchLen < 8) {
            $batchNo .= static::randomNumbers($batchLen - 8);
        }
        $this->attributes['batch_no'] = substr($batchNo, 0, 8);
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper(substr($value, 0, 12));
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }


    // generate random codes
    public static function generateRandomCodes($batchNo, $noOfCodes = 10000, $prefix = null, $prefixMaxLength = 3)
    {
        $prefix = $prefix ?? $batchNo;
        $prefixLength = $prefixMaxLength - strlen($prefix);
        $prefix = substr(strtoupper($prefix . static::randomAlphabets($prefixLength)), 0, $prefixMaxLength);

        $codes = collect();
        while ($noOfCodes > $codes->count()) {
            $codes->push([
                'batch_no' => $batchNo,
                'code' => $prefix . static::getRandomString(3, 3),
            ]);
        }

        // filter the array with unique value
        $codes = $codes->unique('code');

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

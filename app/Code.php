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

    protected $fillable = [
        'batch_no',
        'code'
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
        $this->attributes['batch_no'] = str_pad(strtoupper(substr($value, 0, 5)),8,"QWE", STR_PAD_LEFT);
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper(substr($value, 0, 12));
    }

    public function business() {
        return $this->belongsTo(Business::class);
    }

}

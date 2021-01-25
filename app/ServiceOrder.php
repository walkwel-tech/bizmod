<?php

namespace App;

use App\Traits\PerformsSEO;
use App\Traits\ScopesSlug;
use App\Traits\WalkwelSlugMaker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;

class ServiceOrder extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;
    use WalkwelSlugMaker;
    use HasFactory;
    use ScopesSlug;
    use PerformsSEO;

    protected $fillable = [
        'customer_name',
        'user_id',
        'service_id',
        'amount',
        'service_id',
        'from_at',
        'to_at',
        'address',
        'pincode',
        'phone_number',
        'status'
    ];
    protected $dates = ['from_at', 'to_at'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->getSlugColumnName();
    }

    public function services() {
        return $this->belongsTo(Service::class);
    }

    public function users() {
        return $this->belongsTo(User::class);
    }

    public function hasCategory(Category $category) {
        return $this->categories->contains($category);
    }
}

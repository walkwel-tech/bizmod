<?php

namespace App;

use App\Http\Requests\BusinessStoreRequest;
use App\Traits\HasAddresses;
use App\Traits\HasAvatar;
use App\Traits\PerformsSEO;
use App\Traits\WalkwelSlugMaker;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Sluggable\HasSlug;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasAvatar;
    use SoftDeletes;
    use HasFactory;
    use PerformsSEO;
    use HasRoles;
    use WalkwelSlugMaker;
    use HasAddresses;
    use HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that are calculated and not stored.
     *
     * @var array
     */
    protected $appends = [
        'name',
    ];

    //region Model Methods

    //region Accessors
    public function getNameAttribute()
    {
        $name = $this->first_name;
        if ($this->last_name) {
            $name .= ' ' . $this->last_name;
        }

        return $name;
    }
    //endregion Accessors

    //region Mutators
    //endregion Mutators


    //region Additional

    public function getSlugSeed()
    {
        return $this->email;
    }

    public function getSecondaryInfo()
    {
        return $this->email;
    }

    public function getAvatarRouteName()
    {
        return 'user.avatar.get';
    }

    /**
     * Get the name of the "disabled at" column.
     *
     * @return string
     */
    public function getDisabledAtColumn()
    {
        return 'email_verified_at';
    }

    protected function getSlugColumnName()
    {
        return 'username';
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->getSlugColumnName();
    }

    //endregion Additional

    //endregion Model Methods

    //region Relations
    public function projects ()
    {
        return $this->belongsToMany(Project::class)->withPivot([
            'role',
            'created_at',
            'updated_at',
        ])->withTimestamps()
        ->as('role')
        ->using(ProjectRole::class);
    }

    public function bids ()
    {
        return $this->hasManyThrough(
            Bid::class,
            ProjectRole::class,
            'user_id',
            'project_user_id',
            'id',
            'project_id'
        );
    }

    //endregion Relations

    //region Local Scopes
    public function scopeEmail($query, $email)
    {
        $query->where('email', $email);

        return $query;
    }
    //endregion Local Scopes

    //region Static Methods
    public static function getTitleAttributeColumnName()
    {
        return 'first_name';
    }
    //endregion Static Methods

    public function identities() {
        return $this->hasMany('App\SocialIdentity');
    }

    public function businesses() {
        return $this->hasMany(Business::class,'owner_id');
    }


}

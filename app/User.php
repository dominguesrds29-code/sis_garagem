<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'name', 'pst_specialty', 'integration_id'
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

    public const ID_FIELD = 'id';
    public const NAME_FIELD = 'name';

    public function scopeInactive($query)
    {
        return $query->onlyTrashed();
    }

    public function fieldList()
    {
        return [
            ['name' => 'id', 'label' => '#', 'query' => true, 'table' => true],
            ['name' => 'pst_specialty', 'label' => 'PST/ESPD', 'query' => true, 'table' => true],
            ['name' => 'name', 'label' => 'Nome', 'query' => true, 'table' => true],
            ['name' => 'email', 'label' => 'E-mail', 'query' => true, 'table' => true],
        ];
    }

    public function getdataValidateAttribute()
    {
        $ignore = ',NULL,id';

        if($this->id){
            $ignore = ','.$this->id.',id';
        }

        return [
            'email' => 'required|unique:roles,name'.$ignore,
            'name' => 'required',
            'roles' => 'required',
            'password' => 'sometimes|confirmed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}

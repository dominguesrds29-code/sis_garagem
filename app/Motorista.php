<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motorista extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'cnh_number', 'cnh_category', 'cnh_validate', 'authorization_date', 'status'
    ];

    protected $appends = ['dataValidate'];

    const AUTHORIZATION_ACTIVE = 1;
    const AUTHORIZATION_INACTIVE = 0;

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::AUTHORIZATION_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::AUTHORIZATION_INACTIVE);
    }

    public function getdataValidateAttribute()
    {
        return [
            'user_id' => 'required',
            'cnh_number' => 'required',
            'cnh_category' => 'required',
            'cnh_validate' => 'required|date',
            'authorization_date' => 'required|date',
            'status' => 'boolean',
        ];
    }
}

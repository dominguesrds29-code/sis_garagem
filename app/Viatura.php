<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Viatura extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'modelo', 'combustivel', 'kilometragem', 'situacao'
    ];

    protected $appends = ['ex_combustivel, dataValidate'];

    const ACTIVE = 'Ativa';
    const INACTIVE = 'Recolhida';

    public function scopeActive($query)
    {
        return $query->where('situacao', self::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('situacao', self::INACTIVE);
    }

    public function getDataValidateAttribute()
    {
        return [
            'modelo' => 'required',
            'combustivel' => 'required',
            'situacao' => 'required|in:Ativa,Recolhida',
            'kilometragem' => 'sometimes|integer',
        ];
    }

    public function getExCombustivelAttribute()
    {
        return explode(',', $this->combustivel);
    }

    public function setCombustivelAttribute($value)
    {
        return $this->attributes['combustivel'] = implode(',', $value);
    }
}

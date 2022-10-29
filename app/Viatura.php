<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public const ID_FIELD = 'id';
    public const NAME_FIELD = 'modelo';

    public function fieldList()
    {
        return [
            ['name' => 'id', 'label' => '#', 'query' => true, 'table' => true],
            ['name' => 'modelo', 'label' => 'Modelo', 'query' => true, 'table' => true],
            ['name' => 'combustivel', 'label' => 'Combustível', 'query' => true, 'table' => true],
            ['name' => 'kilometragem', 'label' => 'Km', 'query' => true, 'table' => true],
            ['name' => 'situacao', 'label' => 'Situação', 'query' => true, 'table' => true],
        ];
    }

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
        $ignore = ',NULL,id';

        if($this->id){
            $ignore = ','.$this->id.',id';
        }

        return [
            'modelo' => 'required|unique:viaturas,modelo'.$ignore,
            'combustivel' => 'required',
            'situacao' => 'required|in:Ativa,Recolhida',
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

    public function solicitacoes() : HasMany
    {
        return $this->hasMany(Solicitacao::class, 'viatura_id', 'id');
    }
}

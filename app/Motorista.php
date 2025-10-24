<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motorista extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'user_war_name', 'cnh_number', 'cnh_category', 'cnh_validate', 'authorization_date', 'status'
    ];

    protected $appends = ['dataValidate'];

    const AUTHORIZATION_ACTIVE = 1;
    const AUTHORIZATION_INACTIVE = 0;

    public const ID_FIELD = 'id';
    public const NAME_FIELD = 'user_war_name';

    public function solicitacoes() : HasMany
    {
        return $this->hasMany(Solicitacao::class, 'motorista_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::AUTHORIZATION_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::AUTHORIZATION_INACTIVE);
    }

    public function fieldList()
    {
        return [
            ['name' => 'id', 'label' => '#', 'query' => true, 'table' => true],
            ['name' => 'user_war_name', 'label' => 'Nome', 'query' => true, 'table' => true],
            ['name' => 'cnh_number', 'label' => 'CNH', 'query' => true, 'table' => true],
            ['name' => 'cnh_category', 'label' => 'Categoria', 'query' => true, 'table' => true],
            ['name' => 'cnh_validate', 'label' => 'Validade CNH', 'query' => true, 'table' => true],
            ['name' => 'authorization_date', 'label' => 'Validade Autorização', 'query' => true, 'table' => true],
        ];
    }

    public function getExCnhCategoryAttribute()
    {
        return explode(',', $this->cnh_category);
    }

    public function setCnhCategoryAttribute($value)
    {
        return $this->attributes['cnh_category'] = implode(',', $value);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value ? 1 : 0;
    }

    public function getExCnhValidateAttribute()
    {
        return date('d/m/Y', strtotime($this->cnh_validate));
    }

    public function getExAuthorizationDateAttribute()
    {
        return date('d/m/Y', strtotime($this->authorization_date));
    }

    public function saidas() : HasMany
    {
        return $this->hasMany(SaidaViatura::class, 'motorista_id', 'id');
    }

    public function getdataValidateAttribute()
    {
        $ignore = ',NULL,id';

        if($this->id){
            $ignore = ','.$this->id.',id';
        }

        return [
            'user_war_name' => 'required',
            'cnh_number' => 'required|unique:motoristas,cnh_number'.$ignore,
            'cnh_category' => 'required',
            'cnh_validate' => 'required|date',
            'authorization_date' => 'required|date'
        ];
    }

}

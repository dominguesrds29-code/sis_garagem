<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaidaViatura extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'viatura_id', 'motorista_id', 'ocupantes', 'destino', 'missao', 'hodometro_saida', 'hora_saida', 'hodometro_retorno', 'hora_retorno', 'status',
    ];

    const ACTIVE = 1;
    const COMPLETE = 0;

    public const ID_FIELD = 'id';
    public const NAME_FIELD = 'destino';

    public function fieldList()
    {
        return [
            ['name' => 'id', 'label' => '#', 'query' => true, 'table' => true],
            ['name' => 'viatura_id', 'label' => 'Viatura', 'query' => true, 'table' => true],
            ['name' => 'motorista_id', 'label' => 'Motorista', 'query' => true, 'table' => true],
            ['name' => 'ocupantes', 'label' => 'Ocupantes', 'query' => true, 'table' => false],
            ['name' => 'destino', 'label' => 'Destino', 'query' => true, 'table' => false],
            ['name' => 'missao', 'label' => 'Missão', 'query' => true, 'table' => false],
            ['name' => 'hodometro_saida', 'label' => 'Hodômetro Saída', 'query' => true, 'table' => true],
            ['name' => 'hora_saida', 'label' => 'Hora Saída', 'query' => true, 'table' => true],
            ['name' => 'hodometro_retorno', 'label' => 'Hodômetro Retorno', 'query' => true, 'table' => true],
            ['name' => 'hora_retorno', 'label' => 'Hora Retorno', 'query' => true, 'table' => true],
            ['name' => 'total_percorrido', 'label' => 'TOTAL PERCORRIDO (KM)', 'query' => false, 'table' => true, 'orderable' => false],
            ['name' => 'status', 'label' => 'Status', 'query' => true, 'table' => true],
            ['name' => 'created_at', 'label' => 'Criado em', 'query' => true, 'table' => true],
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::COMPLETE);
    }

    public function getHoraSaidaAttribute()
    {
        return date('H:i', strtotime($this->attributes['hora_saida']));
    }

    public function getHoraRetornoAttribute()
    {
        return date('H:i', strtotime($this->attributes['hora_retorno']));
    }

    public function viatura() : HasOne
    {
        return $this->hasOne(Viatura::class, 'id', 'viatura_id');
    }

    public function motorista() : HasOne
    {
        return $this->hasOne(Motorista::class, 'id', 'motorista_id');
    }

    public function getDataValidateAttribute()
    {
        return [
            'viatura_id' => 'required',
            'motorista_id' => 'required',
            'destino' => 'required',
            'hodometro_saida' => 'required|numeric',
            'hora_saida' => 'required|date_format:H:i',
            'hodometro_retorno' => 'sometimes|numeric|gte:hodometro_saida',
            'hora_retorno' => 'sometimes|required_with:hodometro_retorno|date_format:H:i',
        ];
    }
}

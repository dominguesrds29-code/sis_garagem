<?php

namespace App;

use App\Support\DateTools;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitacao extends Model
{
    use SoftDeletes, DateTools;

    protected $fillable = [
        'user_id', 'dt_inicio', 'hora_inicio', 'dt_final', 'hora_final', 'viatura_id', 'solicitante', 'motorista_id', 'destino', 'missao',
        'itinerario', 'passageiros', 'arquivo'
    ];

    protected $appends = ['saida', 'retorno'];

    const STATUS_REALIZADA = 1;
    const STATUS_CANCELADA = 2;

    const AGUARDANDO = 0;
    const AUTORIZADA = 1;
    const NEGADA = 2;

    const ARQUIVADA = 1;

    public const ID_FIELD = 'id';
    public const NAME_FIELD = 'name';

    public function viatura(): BelongsTo
    {
        return $this->belongsTo(Viatura::class, 'viatura_id', 'id');
    }

    public function motorista(): BelongsTo
    {
        return $this->belongsTo(Motorista::class, 'motorista_id', 'id');
    }

    public function scopeWaiting($query)
    {
        return $query->where('encarregado_aut', self::AGUARDANDO)->Orwhere('chefe_aut', self::AGUARDANDO);
    }

    public function scopeRealizada($query)
    {
        return $query->where('status_missao', self::STATUS_REALIZADA);
    }

    public function scopeCancelada($query)
    {
        return $query->where('status_missao', self::STATUS_CANCELADA);
    }

    public function fieldList($history = false)
    {
        $fiedList = [
            ['name' => 'id', 'label' => '#', 'query' => true, 'table' => true],
            ['name' => 'solicitante', 'label' => 'Solicitante', 'query' => true, 'table' => true],
            ['name' => 'dt_inicio', 'label' => 'Saida', 'query' => true, 'table' => true],
            ['name' => 'dt_final', 'label' => 'Retorno', 'query' => true, 'table' => true],
            ['name' => 'viatura_id', 'label' => 'Viatura', 'query' => true, 'table' => true],
            ['name' => 'motorista_id', 'label' => 'Motorista', 'query' => true, 'table' => true],
            ['name' => 'encarregado_aut', 'label' => 'Encarregado', 'query' => true, 'table' => true],
            ['name' => 'chefe_aut', 'label' => 'Chefe', 'query' => true, 'table' => true],
            ['name' => 'status_missao', 'label' => 'Status', 'query' => true, 'table' => true],
        ];

        if(!$history){
            $fiedList[] = ['name' => 'created_at', 'label' => 'Solicitado em', 'query' => true, 'table' => true];

        } else {
            $fiedList[] = ['name' => 'arquivo', 'label' => 'Arquivado em', 'query' => true, 'table' => true];
        }

        return $fiedList;
    }

    public function getSolicitanteNameAttribute()
    {
        return $this->userRequest->war_name;
    }

    public function getSaidaAttribute()
    {
        return date('d/m/Y', strtotime($this->dt_inicio)) . ' ' . date('H:i', strtotime($this->hora_inicio));
    }

    public function getRetornoAttribute()
    {
        return date('d/m/Y', strtotime($this->dt_final)) . ' ' . date('H:i', strtotime($this->hora_final));
    }

    public function getDestinoMissaoAttribute()
    {
        return $this->destino . '/' . $this->missao;
    }

    public function getDataValidateAttribute()
    {
        return [
            'dt_inicio' => 'required',
            'hora_inicio' => 'required',
            'dt_final' => 'required',
            'hora_final' => 'required',
            'viatura_id' => 'required|integer',
            'motorista_id' => 'required|integer',
            'destino' => 'required',
            'missao' => 'required',
            'itinerario' => 'required'
        ];
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logger extends Model
{
    use HasFactory;

    protected $table = 'log';
    protected $primaryKey = 'log_id';

    protected $fillable = [
        'log_acao', 'log_user', 'log_data', 'log_type'
    ];

    public const TYPE_CREATE = 'CREATE';
    public const TYPE_UPDATE = 'UPDATE';
    public const TYPE_DELETE = 'DELETE';
}

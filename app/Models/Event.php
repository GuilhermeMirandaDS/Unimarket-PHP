<?php

namespace App\Models;

use CodeIgniter\Model;

class Event extends Model
{
    protected $table            = 'events';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'nome',
        'data',
        'horario',
        'link',
        'local',
        'images',
        'imageCard',
        'descricao'
    ];

    protected $useTimestamps = false;
    protected array $casts = ['images' => '?json', 'imageCard' => '?json'];
}
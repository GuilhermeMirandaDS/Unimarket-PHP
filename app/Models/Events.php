<?php

namespace App\Models;

use CodeIgniter\Model;

class Events extends Model
{
    protected $table            = 'events';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'nome',
        'data',
        'images',
        'descricao'
    ];

    protected $useTimestamps = false;
    protected array $casts = ['images' => 'json'];
}
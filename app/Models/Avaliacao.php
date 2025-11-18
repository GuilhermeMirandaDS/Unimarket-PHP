<?php

namespace App\Models;

use CodeIgniter\Model;

class Avaliacao extends Model
{
    protected $table            = 'avaliacoes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'id',
        'user',
        'product',
        'comentario',
        'estrelas'
    ];

    protected $useTimestamps = false;
}
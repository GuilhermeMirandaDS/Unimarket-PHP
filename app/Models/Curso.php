<?php

namespace App\Models;

use CodeIgniter\Model;

class Curso extends Model
{
    protected $table            = 'cursos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'nome'
    ];

    protected $useTimestamps = false;
}
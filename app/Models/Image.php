<?php

namespace App\Models;

use CodeIgniter\Model;

class Image extends Model
{
    protected $table            = 'images';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'name',
        'path'
    ];

    protected $useTimestamps = false;
}
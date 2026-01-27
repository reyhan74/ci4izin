<?php

namespace App\Models;

use CodeIgniter\Model;
class UserizinModel extends Model
{
    protected $table      = 'userizin';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username',
        'email',
        'password',
        'role'
    ];

    protected $useTimestamps = true;
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'userizin';
protected $allowedFields = ['nama', 'email', 'password', 'role'];

}
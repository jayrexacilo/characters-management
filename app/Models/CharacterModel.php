<?php

namespace App\Models;

use CodeIgniter\Model;

class CharacterModel extends Model
{
    protected $table = 'characters';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'character_id', 'data'];

    protected $useTimestamps = true; // Handles created_at and updated_at automatically
}

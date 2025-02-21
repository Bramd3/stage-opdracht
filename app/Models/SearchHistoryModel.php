<?php

namespace App\Models;

use CodeIgniter\Model;

class SearchHistoryModel extends Model
{
    protected $table      = 'search_history'; // Tabelnaam in de database
    protected $primaryKey = 'id'; // Primaire sleutel van de tabel
    
    protected $allowedFields = [ // Velden die massaal toegewezen mogen worden
        'kvk_number', 'branch_number', 'trade_name', 'business_activity', 'created_at', 'updated_at'
    ];
    
    protected $useTimestamps = true; // Automatisch timestamps (created_at, updated_at) beheren
}

<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class KvkModel extends Model
{
    protected $table = 'kvk_data'; // Tabelnaam in de database
    protected $primaryKey = 'id'; // Primaire sleutel van de tabel
    
    protected $allowedFields = [ // Velden die massaal toegewezen mogen worden
        'kvk_number', 'branch_number', 'trade_name', 'business_activity'
    ];
 
    protected $useTimestamps = true; // Automatisch timestamps gebruiken (created_at, updated_at)
}

<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class KvkModel extends Model
{
    protected $table = 'kvk_data'; // Database table name
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kvk_number', 'branch_number', 'trade_name', 'business_activity'
    ];
 
    protected $useTimestamps = true;
}
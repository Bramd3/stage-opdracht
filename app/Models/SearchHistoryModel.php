<?php

namespace App\Models;

use CodeIgniter\Model;

class SearchHistoryModel extends Model
{
    protected $table      = 'search_history';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kvk_number', 'branch_number', 'trade_name', 'business_activity', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}

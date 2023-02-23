<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreatLots extends Model
{
    use HasFactory;
    protected $table = 'creative_lots';
    protected $fillable=['user_id', 'brand_id', 'lot_number', 'project_name', 'verticle', 'client_bucket', 'work_initiate_date', 'Comitted_initiate_date', 'status'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotsStatus extends Model
{
    use HasFactory;

    protected $fillable=[
        
        'lot_id',
        'status',
    ];

    protected $table = 'lot_status';
    
}

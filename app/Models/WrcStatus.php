<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WrcStatus extends Model
{
    use HasFactory;

     protected $fillable=[
        
        'wrc_id',
        'status',
    ];

    protected $table = 'wrc_status';

    public static function wrcStatus($filter = []){

    }
    
}

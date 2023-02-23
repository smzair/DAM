<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipments extends Model
{
    use HasFactory;

    protected $fillable=[
        'equipment_name',
        'vendor',
        'cost',
        'opt_start_date',
        'opt_end_date',
    ];

    protected $table = 'equipments';

}

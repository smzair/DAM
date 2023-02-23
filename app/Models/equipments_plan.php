<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipments_plan extends Model

{
    use HasFactory;

    protected $fillable=[
        'equipment_id',
        'plan_id',
    ];

    protected $table = 'equipments_plan';

}

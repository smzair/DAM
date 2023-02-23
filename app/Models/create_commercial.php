<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class create_commercial extends Model
{
    use HasFactory;

    // SELECT `id`, `user_id`, `brand_id`, `product_type`, `type_of_service`, `kind_of_work`, `per_qty_value`, `created_at`, `updated_at` FROM `create_commercial` WHERE 1
    protected $fillable = [
        'user_id', 'brand_id', 'product_type', 'type_of_service', 'kind_of_work', 'per_qty_value',
    ];

    protected $table = 'create_commercial';

}
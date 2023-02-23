<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogCommercial extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'user_id', 'brand_id', 'market_place', 'type_of_service', 'CommercialSKU'
    ];

    protected $table = 'create_commercial_catalog';
}

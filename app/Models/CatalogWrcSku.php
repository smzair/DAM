<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogWrcSku extends Model
{
    use HasFactory;
    protected $table = 'catalog_wrc_skus';
    protected $fillable = [
        'sku_code', 'style', 'type_of_service', 'wrc_id', 'batch_no'
    ];
}

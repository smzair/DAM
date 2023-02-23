<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreativeWrcSkus extends Model
{
    use HasFactory;
    protected $table = 'creative_wrc_skus';
    protected $fillable=['sku_code', 'project_name', 'kind_of_work', 'wrc_id'];
}

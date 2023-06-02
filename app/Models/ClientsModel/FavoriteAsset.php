<?php

namespace App\Models\ClientsModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteAsset extends Model
{
  use HasFactory;
  protected $table = 'favorite_assets';
  protected $fillable = ['user_id', 'brand_id', 'lot_id', 'wrc_id', 'service', 'module', 'type', 'other_data_id', 'other_data','created_by'];
}

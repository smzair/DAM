<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsolidatedLot extends Model
{
    use HasFactory;
    protected $fillable = [
        'shoot', 'creative_graphic', 'cataloging', 'user_id', 'brand_id'
    ];

    protected $table = 'consolidated_lot';

    public static function getConsolidatedLot(){
        $response = ConsolidatedLot::orderBy('id','DESC')
        ->leftJoin('brands', 'brands.id','consolidated_lot.brand_id')
        ->leftJoin('users', 'users.id','consolidated_lot.user_id')
        ->select('consolidated_lot.*','users.Company as company_name','brands.name as brand_name')
        ->get();
        return $response;
    }
}

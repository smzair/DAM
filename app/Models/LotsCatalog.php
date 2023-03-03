<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotsCatalog extends Model
{
    use HasFactory;
    protected $table = 'lots_catalog';

    protected $fillable = [
        'id', 'user_id', 'brand_id', 'lot_number' , 'serviceType', 'requestType', 'reqReceviedDate' ,'reqReceviedDate'
    ];

    // get Creative Lots Wrcs with allocation
    public function WrcListWithAllocation(){
        return $this->hasMany('App\Models\CatlogWrc','lot_id','id')->with('WrcAllocationList:*');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use DB;

class Brands extends Model
{ 
    use HasFactory,LogsActivity;

    protected $guarded =[ ];
    protected $primaryKey = 'id';
    protected $table = 'brands';
    public function user()
    {


     return $this->belongsToMany('App\Models\Users');
 }

 public function getActivitylogOptions(): LogOptions
 {
    return LogOptions::defaults();
}
}


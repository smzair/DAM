<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Dayplan extends Model
{
    use HasFactory,LogsActivity;

    protected $fillable=[
        'date',
        'studio',
        'photographer',
        'stylist',
        'makeupartist',
        'rawqc',
        'model',
        'agency',
        'assistant',
    ];

    protected $table = 'dayplan';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

}

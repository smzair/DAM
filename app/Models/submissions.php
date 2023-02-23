<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class submissions extends Model
{
    use HasFactory;
    
     protected $fillable = [
        'wrc_id',
        'firstAngle',
        'fullAngle',
        'submission_date',
    ];
    protected $table = 'submission';

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults();
    }
}

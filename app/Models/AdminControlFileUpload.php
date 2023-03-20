<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminControlFileUpload extends Model
{
    use HasFactory;
    protected $table = 'admin_control_file_uploads';
    protected $fillable = [
        'lot_id', 'wrc_id' , 'file_path', 'filename','uploaded_by','updated_by',
    ];
}

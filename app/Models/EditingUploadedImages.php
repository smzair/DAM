<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditingUploadedImages extends Model
{
    use HasFactory;
    protected $table = 'editing_uploaded_images';
    protected $fillable = [
        'id', 'wrc_id', 'user_id', 'allocation_id', 'file_path', 'filename'
    ];
}

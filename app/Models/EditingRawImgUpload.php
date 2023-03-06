<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditingRawImgUpload extends Model
{
    use HasFactory;
    protected $table = 'editing_raw_img_uploads';
    protected $fillable = ['wrc_id', 'filename', 'file_path'];

}

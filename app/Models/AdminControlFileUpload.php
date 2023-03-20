<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminControlFileUpload extends Model
{
    use HasFactory;
    protected $table = 'admin_control_file_uploads';
    protected $fillable = [
        'lot_id', 'wrc_id' , 'file_path', 'filename','uploaded_by','updated_by',
    ];

    public static function AdminControlUploadedFiles(){
        $UploadedFiles_query = AdminControlFileUpload::
        
        leftjoin('users as uploaded_user', 'uploaded_user.id' , '=' , 'admin_control_file_uploads.uploaded_by' )->
        select(
            'admin_control_file_uploads.*',
            'uploaded_user.name as uploaded_by',
            DB::raw("case when admin_control_file_uploads.service = 'lots' then (select lots.lot_id from lots where lots.id = admin_control_file_uploads.lot_id) when admin_control_file_uploads.service = 'creative' then (select creative_lots.lot_number from creative_lots where creative_lots.id = admin_control_file_uploads.lot_id) when admin_control_file_uploads.service = 'cataloging' then (select lots_catalog.lot_number from lots_catalog where lots_catalog.id = admin_control_file_uploads.lot_id) else (select editor_lots.lot_number from editor_lots where editor_lots.id = admin_control_file_uploads.lot_id) end as lot_number"),

            DB::raw("CASE 
            when admin_control_file_uploads.service = 'lots' then (select wrc.wrc_id from wrc where wrc.id = admin_control_file_uploads.wrc_id) 
            when admin_control_file_uploads.service = 'creative' then (select creative_wrc.wrc_number from creative_wrc where creative_wrc.id = admin_control_file_uploads.wrc_id) 
            when admin_control_file_uploads.service = 'cataloging' then (select catlog_wrc.wrc_number from catlog_wrc where catlog_wrc.id = admin_control_file_uploads.wrc_id) 
            else (select editing_wrcs.wrc_number from editing_wrcs where editing_wrcs.id = admin_control_file_uploads.wrc_id) end as wrc_number"),

        );
        $AdminControlUploadedFiles = $UploadedFiles_query->get()->toArray();
        // dd($AdminControlUploadedFiles);
        return $AdminControlUploadedFiles;
    }
}

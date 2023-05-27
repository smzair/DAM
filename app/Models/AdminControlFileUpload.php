<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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
            DB::raw("case when admin_control_file_uploads.service = 'Shoot' then (select lots.lot_id from lots where lots.id = admin_control_file_uploads.lot_id) when admin_control_file_uploads.service = 'creative' then (select creative_lots.lot_number from creative_lots where creative_lots.id = admin_control_file_uploads.lot_id) when admin_control_file_uploads.service = 'cataloging' then (select lots_catalog.lot_number from lots_catalog where lots_catalog.id = admin_control_file_uploads.lot_id) else (select editor_lots.lot_number from editor_lots where editor_lots.id = admin_control_file_uploads.lot_id) end as lot_number"),
            DB::raw("CASE when admin_control_file_uploads.service = 'Shoot' then (select wrc.wrc_id from wrc where wrc.id = admin_control_file_uploads.wrc_id) when admin_control_file_uploads.service = 'creative' then (select creative_wrc.wrc_number from creative_wrc where creative_wrc.id = admin_control_file_uploads.wrc_id) when admin_control_file_uploads.service = 'cataloging' then (select catlog_wrc.wrc_number from catlog_wrc where catlog_wrc.id = admin_control_file_uploads.wrc_id) else (select editing_wrcs.wrc_number from editing_wrcs where editing_wrcs.id = admin_control_file_uploads.wrc_id) end as wrc_number")
        );
        $AdminControlUploadedFiles = $UploadedFiles_query->get()->toArray();
        return $AdminControlUploadedFiles;
    }

    public static function AdminControlUploadedFileListForClient(){
        $parent_client_id = $user_id = Auth::id();
		if (Auth::user()->dam_enable != 1) {
			request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
			return redirect()->route('home');
		}
		$roledata = getUsersRole($user_id);
		$role_name = "";

		if ($roledata != null) {
			$role_id = $roledata->role_id;
			$role_name = $roledata->role_name;
		}
        $brand_data = DB::table('brands_user')->where('user_id' , $user_id)->get()->pluck('brand_id')->toArray();
        
        if ($role_name == 'Sub Client') {
			$parent_user_data = DB::table('users')->where('id', $user_id)->first(['parent_client_id', 'id']);
			$parent_client_id = $parent_user_data->parent_client_id;
		}

        $UploadedFiles_query = AdminControlFileUpload::
        whereIn('admin_control_file_uploads.brand_id', $brand_data)->where('admin_control_file_uploads.user_id', $parent_client_id)->
        leftjoin('users as uploaded_user', 'uploaded_user.id' , '=' , 'admin_control_file_uploads.uploaded_by' )->
        select(
            'admin_control_file_uploads.*',
            'uploaded_user.name as uploaded_by',
            DB::raw("case when admin_control_file_uploads.service = 'Shoot' then (select lots.lot_id from lots where lots.id = admin_control_file_uploads.lot_id) when admin_control_file_uploads.service = 'creative' then (select creative_lots.lot_number from creative_lots where creative_lots.id = admin_control_file_uploads.lot_id) when admin_control_file_uploads.service = 'cataloging' then (select lots_catalog.lot_number from lots_catalog where lots_catalog.id = admin_control_file_uploads.lot_id) else (select editor_lots.lot_number from editor_lots where editor_lots.id = admin_control_file_uploads.lot_id) end as lot_number"),
            DB::raw("CASE when admin_control_file_uploads.service = 'Shoot' then (select wrc.wrc_id from wrc where wrc.id = admin_control_file_uploads.wrc_id) when admin_control_file_uploads.service = 'creative' then (select creative_wrc.wrc_number from creative_wrc where creative_wrc.id = admin_control_file_uploads.wrc_id) when admin_control_file_uploads.service = 'cataloging' then (select catlog_wrc.wrc_number from catlog_wrc where catlog_wrc.id = admin_control_file_uploads.wrc_id) else (select editing_wrcs.wrc_number from editing_wrcs where editing_wrcs.id = admin_control_file_uploads.wrc_id) end as wrc_number")
        );
        $AdminControlUploadedFileListForClient = $UploadedFiles_query->get()->toArray();
        return $AdminControlUploadedFileListForClient;
    }
}

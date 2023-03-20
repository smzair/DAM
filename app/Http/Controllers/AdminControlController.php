<?php

namespace App\Http\Controllers;

use App\Models\AdminControlFileUpload;
use App\Models\CatlogWrc;
use App\Models\CreativeWrcModel;
use App\Models\EditingWrc;
use App\Models\Wrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminControlController extends Controller
{
    // get data for create
    public function Index()
    {
        return view('admin.Admin-Contol.Admin-Contol-File-Upload');
    }

    public function getLotNumber(Request $request){
        $service_id = $request->service_id;
        if($service_id == 1){ 
            // Shoot
            $lot_query = DB::table('lots')->
            select('lots.id', 'lots.lot_id as lot_number');
            
        }else if($service_id == 2){
            // Creative
            $lot_query = DB::table('creative_lots')->
            select('creative_lots.id', 'creative_lots.lot_number');
        }else if($service_id == 3){
            // Cataloging
            $lot_query = DB::table('lots_catalog')->
            select('lots_catalog.id', 'lots_catalog.lot_number');
        }else if($service_id == 4){
            // Editing
            $lot_query = DB::table('editor_lots')->
            select('editor_lots.id', 'editor_lots.lot_number');
        }
        $data = $lot_query->get()->toArray();
        echo json_encode($data);
    }

    public function getWrcNumber(Request $request){
        $service_id = $request->service_id;
        $lot_id = $request->lot_id_is;

        if($service_id == 1){  // Shoot
            $lot_query = DB::table('wrc')->
            where('lot_id', '=',$lot_id)->
            select('wrc.id', 'wrc.wrc_id as wrc_number');
        }else if($service_id == 2){ // Creative
            $lot_query = DB::table('creative_wrc')->
            where('lot_id', '=',$lot_id)->
            select('creative_wrc.id', 'creative_wrc.wrc_number');
        }else if($service_id == 3){  // Cataloging
            $lot_query = DB::table('catlog_wrc')->
            where('lot_id', '=',$lot_id)->
            select('catlog_wrc.id', 'catlog_wrc.wrc_number');
        }else if($service_id == 4){  // Editing
            $lot_query = DB::table('editing_wrcs')->
            where('lot_id', '=',$lot_id)->
            select('editing_wrcs.id', 'editing_wrcs.wrc_number');
        }
        $data = $lot_query->get()->toArray();
        echo json_encode($data);
    }

    public function SaveAdminControlFile(Request $request){
        $service_id = $request->service;
        $lot_id = $request->lot_id;
        $wrc_id = $request->wrc;
        $file_upload = $request->file('file_upload');

        if($service_id == 1){  // Shoot
            $service = 'Shoot';
            $wrc_query = Wrc::leftjoin('lots','lots.id', 'wrc.lot_id')->
            where('wrc.id', '=',$wrc_id)->
            where('lot_id', '=',$lot_id)->
            select('wrc.id', 'wrc.wrc_id as wrc_number' , 'lots.created_at', 'lots.brand_id', 'lots.user_id', 'lots.lot_id as lot_number' );

        }else if($service_id == 2){ // Creative
            $service = 'Creative';
            $wrc_query = CreativeWrcModel::leftjoin('creative_lots','creative_lots.id', 'creative_wrc.lot_id')->
            where('creative_wrc.id', '=',$wrc_id)->
            where('lot_id', '=',$lot_id)->
            select('creative_wrc.id', 'creative_wrc.wrc_number' , 'creative_lots.created_at', 'creative_lots.brand_id', 'creative_lots.user_id', 'creative_lots.lot_number');
            
        }else if($service_id == 3){  // Cataloging
            $service = 'Cataloging';
            $wrc_query = CatlogWrc::leftjoin('lots_catalog','lots_catalog.id', 'catlog_wrc.lot_id')->
            where('catlog_wrc.id', '=',$wrc_id)->
            where('lot_id', '=',$lot_id)->
            select('catlog_wrc.id', 'catlog_wrc.wrc_number' , 'lots_catalog.created_at', 'lots_catalog.brand_id', 'lots_catalog.user_id', 'lots_catalog.lot_number');
            
        }else if($service_id == 4){  // Editing
            $service = 'Editing';
            $wrc_query = EditingWrc::leftjoin('editor_lots','editor_lots.id', 'editing_wrcs.lot_id')->
            where('editing_wrcs.id', '=',$wrc_id)->
            where('lot_id', '=',$lot_id)->
            select('editing_wrcs.id', 'editing_wrcs.wrc_number' , 'editor_lots.created_at', 'editor_lots.brand_id', 'editor_lots.user_id', 'editor_lots.lot_number');
        }

        $data = $wrc_query->first()->toArray();
        $wrc_number = $data['wrc_number'];
        $lot_number = $data['lot_number'];
        $user_id = $data['user_id'];
        $brand_id = $data['brand_id'];
        $created_at = $data['created_at'];
        $file_path = "AdminControlFile/".$service."/" . date('Y', strtotime($created_at)) . "/" . date('M', strtotime($created_at)) . "/" . $lot_number . "/" . $wrc_number . "/" ;
        
        $filename = $file_upload->getClientOriginalName();
        $file_upload->move($file_path, $filename);
        $file_update_status = false;
        $file_save_status = false;

        if (file_exists($file_path . $filename)) {
            $file_upload_status = true;
            $AdminControlFileUpload = AdminControlFileUpload::
            where('lot_id','=',$lot_id)->
            where('wrc_id','=',$wrc_id)->
            where('service','=',$service)->
            where('filename','=',$filename)->
            where('file_path','=',$file_path)->
            get()->toArray();

            if(count($AdminControlFileUpload) > 0){
                $update_AdminControlFileUpload =  AdminControlFileUpload::find($AdminControlFileUpload[0]['id']);
                $update_AdminControlFileUpload->file_path = $file_path;
                $update_AdminControlFileUpload->filename = $filename;
                $update_AdminControlFileUpload->user_id = $user_id;
                $update_AdminControlFileUpload->brand_id = $brand_id;
                $update_AdminControlFileUpload->updated_by = Auth::id();
                $update_AdminControlFileUpload->updated_at = date('Y-m-d H:i:s');
                $file_update_status = $update_AdminControlFileUpload->update();
            }else{
                $save_AdminControlFileUpload = new AdminControlFileUpload();
                $save_AdminControlFileUpload->lot_id = $lot_id;
                $save_AdminControlFileUpload->wrc_id = $wrc_id;
                $save_AdminControlFileUpload->user_id = $user_id;
                $save_AdminControlFileUpload->brand_id = $brand_id;
                $save_AdminControlFileUpload->service = $service;
                $save_AdminControlFileUpload->file_path = $file_path;
                $save_AdminControlFileUpload->filename = $filename;
                $save_AdminControlFileUpload->uploaded_by = Auth::id();
                $save_AdminControlFileUpload->updated_by = Auth::id();
                $file_save_status = $save_AdminControlFileUpload->save();
            }
        }else{
            $file_upload_status = false;
        }

        $massage = "file uploaded";
        $data = array(
            'file_upload_status' => $file_upload_status,
            'file_count' => count($AdminControlFileUpload),
            'massage' => $massage
        );
        return json_encode($data);
    }

    public function AdminControlUploadedFiles(){
        $AdminControlUploadedFiles = AdminControlFileUpload::AdminControlUploadedFiles();

        return view('admin.Admin-Contol.Admin-Contol-File-Uploaded-Files')->with('data',$AdminControlUploadedFiles);

    }


}

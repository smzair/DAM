<?php

namespace App\Http\Controllers;

use App\Models\EditingAllocation;
use App\Models\EditingRawImgUpload;
use App\Models\EditingUploadedImages;
use App\Models\EditingWrc;
use App\Models\NotificationModel\ClientNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageUploadController extends Controller
{
    public function index()
    {
        $wrcs =  EditingWrc::OrderBy('editing_wrcs.updated_at', 'DESC')
        ->leftJoin('editor_lots', 'editor_lots.id', 'editing_wrcs.lot_id')
        ->leftJoin('editors_commercials', 'editors_commercials.id', 'editing_wrcs.commercial_id')
        ->leftJoin('users', 'users.id', 'editor_lots.user_id')
        ->leftJoin('brands', 'brands.id', 'editor_lots.brand_id')
        ->select(
            'editing_wrcs.*',
            'editing_wrcs.id as wrc_id',
            'editor_lots.user_id',
            'editor_lots.brand_id',
            'editor_lots.lot_number',
            'editors_commercials.type_of_service',
            'users.Company as Company_name',
            'brands.name'
        )->get()->toArray();
        return view('Imageupload.Editing-Wrc-RawImage-Upload')->with('wrcs', $wrcs);
    }

    // 
    public function EditingRawImageUpload(Request $request){
        $wrc_id = $request->wrcid;
        $lot_id = $request->lot_id;
        $lot_text = $request->lot_text;
        $wrc_text = $request->wrc_text;
        $uploded_count = 0;
        $exist_count = 0;
        $sendfiles = $request->file('sku_images');

        $EditingWrc = EditingWrc::where(['editing_wrcs.lot_id' => $lot_id, 'editing_wrcs.id' => $wrc_id])->
        leftjoin('editor_lots','editor_lots.id' , '=' , 'editing_wrcs.lot_id')->
        select('editor_lots.user_id','editor_lots.brand_id','editor_lots.lot_number','editing_wrcs.*')->
        first();
        
        $uploaded_img_qty = $EditingWrc->uploaded_img_qty;
        $file_path = $EditingWrc->file_path;
        if($file_path == '' || $file_path == null){
            $file_path = "editing_raw_img_uploads/" . date('Y') . "/" . date('M') . "/" . $lot_text . "/" . $wrc_text . "/" ;
        }
        $message = "Somthing Went Wrong";
        $imgQty = $EditingWrc->imgQty;
        
        foreach ($sendfiles as $file) {
            $filename = $file->getClientOriginalName();
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $skutext = str_replace("." . $ext, "", $filename);
            $pos = strripos("$skutext", "_");
            $sku_code = substr($skutext, 0, $pos);
            $path = $file_path.$sku_code . "/";

            if (!file_exists($path . $filename)) {
                $is_saved = $file->move($path, $filename);
                if (file_exists($is_saved)){
                    // $EditingRawImgUpload = new EditingRawImgUpload();
                    // $EditingRawImgUpload->wrc_id = $wrc_id;
                    // $EditingRawImgUpload->filename = $filename;
                    // $EditingRawImgUpload->file_path = $path;
                    // $EditingRawImgUpload->save();
                    $uploded_count++;
                    
                    
                    if($uploaded_img_qty + $uploded_count == $imgQty){

                        $save_ClientNotification_data = array(
                            'user_id' => $EditingWrc->user_id,
                            'brand_id' => $EditingWrc->brand_id,
                            'wrc_number' => $EditingWrc->wrc_number,
                            'service' => 'Editing',
                            'subject' => 'Raw Upload',
                        );
                        // $save_status = ClientNotification::save_ClientNotification($save_ClientNotification_data);
                    }
                }
            } else {
                $is_saved = $file->move($path, $filename);
                $exist_count++;
            }

            if (file_exists($is_saved)) {
                $EditingRawImgUpload = EditingRawImgUpload::updateOrCreate(
                    ['wrc_id' => $wrc_id, 'filename' => $filename],
                    ['file_path' => $path]
                );
            }

            if ($uploded_count > 0) {
                $message = $uploded_count . " Image upload successfully!! ";
                if($exist_count > 0){
                    $message .= $exist_count . " Image Exist!!";
                }
            } 
        }
        if ($exist_count > 0  && $uploded_count == 0) {
            $message = $exist_count . " Image Exist!!";
        }
        

        $tot_uploaded_img_qty = $uploaded_img_qty + $uploded_count;
        $EditingWrc =  EditingWrc::find($wrc_id);
        $EditingWrc->uploaded_img_qty = $tot_uploaded_img_qty;
        $EditingWrc->raw_img_file_path = $file_path;
        $status = $EditingWrc->update();

        $res_dat = array(
            "status" => $status,
            "message" => $message,
            "wrc_id" => $wrc_id,
            "uploded_count" => $uploded_count,
            "exist_count" => $exist_count,
            "tot_uploaded_img_qty" => $tot_uploaded_img_qty,
        );
        echo $response = json_encode($res_dat);
    }

    // EditingEditedImageUpload
    public function EditingEditedImageUpload(Request $request)
    {
        $wrc_id = $request->wrcid;
        $lot_id = $request->lot_id;
        $lot_text = $request->lot_text;
        $wrc_text = $request->wrc_text;
        $allocation_id = $request->allocation_id_is;
        $uploded_count = 0;
        $exist_count = 0;
        $sendfiles = $request->file('sku_images');

        $EditingAllocation = EditingAllocation::where(['id' => $allocation_id])->first();
        $user_id = $EditingAllocation->user_id;
        $uploaded_qty = $EditingAllocation->uploaded_qty;
        $allocated_qty = $EditingAllocation->allocated_qty;
        $file_path = $EditingAllocation->file_path;

        $uploaded_img_file_path_is = "edited_img_uploads/" . date('Y') . "/" . date('M') . "/" . $lot_text . "/" . $wrc_text . "/";

        if ($file_path == '' || $file_path == null) {
            $users_data = DB::table('users')->where([['users.id', '=', $user_id]])->pluck('name', 'id')->toArray();
            $user_name = str_replace(" ", "-", $users_data[$user_id]) ;
            $file_path = $uploaded_img_file_path_is . $user_name . "/";
        }

        $message = "Somthing Went Wrong";
        foreach ($sendfiles as $file) {
            $filename = $file->getClientOriginalName();
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $skutext = str_replace("." . $ext, "", $filename);
            $pos = strripos("$skutext", "_");
            $sku_code = substr($skutext, 0, $pos);
            $path = $file_path . $sku_code . "/";

            if (!file_exists($path . $filename)) {

                if($allocated_qty != ($uploded_count + $uploaded_qty)){
                    $is_saved = $file->move($path, $filename);
                    if (file_exists($is_saved)) {
                        $EditingRawImgUpload = new EditingUploadedImages();
                        $EditingRawImgUpload->user_id = $user_id;
                        $EditingRawImgUpload->allocation_id = $allocation_id;
                        $EditingRawImgUpload->wrc_id = $wrc_id;
                        $EditingRawImgUpload->filename = $filename;
                        $EditingRawImgUpload->file_path = $path;
                        $EditingRawImgUpload->save();
                        $uploded_count++;
                    }
                }else{
                    $message = "Uploading complted";
                }
            } else {
                $exist_count++;
            }
            if ($uploded_count > 0 && ($allocated_qty != ($uploded_count + $uploaded_qty))) {
                $message = $uploded_count . " Image upload successfully!! ";
                if ($exist_count > 0) {
                    $message .= $exist_count . " Image Exist!!";
                }
            }
        }
        if ($exist_count > 0  && $uploded_count == 0) {
            $message = $exist_count . " Image Exist!!";
        }

        $tot_uploaded_img_qty = $uploaded_qty + $uploded_count;
        $EditingAllocation_up =  EditingAllocation::find($allocation_id);
        $EditingAllocation_up->uploaded_qty = $tot_uploaded_img_qty;
        $EditingAllocation_up->file_path = $file_path;
        $status = $EditingAllocation_up->update();

        $EditingWrc =  EditingWrc::find($wrc_id);
        $uploaded_img_file_path = $EditingAllocation->uploaded_img_file_path;
        if($uploaded_img_file_path == '' || $uploaded_img_file_path == null){
            $uploaded_img_file_path = $uploaded_img_file_path_is;
            $EditingWrc->uploaded_img_file_path = $uploaded_img_file_path;
            $update_wrc_status = $EditingWrc->update();
        }

        $upload_compete_status = 0;
        if($tot_uploaded_img_qty >= $allocated_qty){
            $upload_compete_status = 1;
        }

        $res_dat = array(
            "status" => $status,
            "message" => $message,
            "wrc_id" => $wrc_id,
            "uploded_count" => $uploded_count,
            "exist_count" => $exist_count,
            "tot_uploaded_img_qty" => $tot_uploaded_img_qty,
            "upload_compete_status" => $upload_compete_status,
        );
        echo $response = json_encode($res_dat);
    }

}

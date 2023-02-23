<?php

namespace App\Http\Controllers;

use App\Models\EditingAllocation;
use App\Models\EditingUploadLink;
use App\Models\EditingWrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class EditingUploadLinkController extends Controller
{

    // show Editing allocation upload blade
    function upload()
    {
        $login_user_id_is = 11;
        $user_role = 'Editor';
        $allocationList = EditingAllocation::get_Editing_Allocation_List($login_user_id_is);
        $allocated_wrc_list_by_user = EditingAllocation::allocated_wrc_list_by_user($login_user_id_is);
        return view('Allocation.editing_upload_panel')->with('allocationList', $allocationList)->with('user_role', $user_role)->with('login_user_id_is', $login_user_id_is);
    }

    // Save And Update Link
    function Editing_upload_link(Request $request)
    {
        $response = EditingUploadLink::Editing_upload_link($request);
        $action = $request->action;
        $check_create = json_decode( json_encode($response));

        if($check_create->up_status > 0 &&  $action == 'comp'){
            /****** send notification start */
            $editor_allocation_data = EditingAllocation::where('id',$request->allocation_id_is)->first(['wrc_id','user_id']);
            $wrc_id = $editor_allocation_data != null ? $editor_allocation_data->wrc_id : 0;
            $user_id = $editor_allocation_data != null ? $editor_allocation_data->user_id : 0;
            $wrc_data = EditingWrc::where('id',$wrc_id)->first(['wrc_number']);
            $wrc_number = $wrc_data != null ? $wrc_data->wrc_number : "";

            $user_id = 9;
            // $user_id = Auth::user()->id;
            $logged_in_user_data = DB::table('users')->where('id', $user_id )->first(['name']);
            $uploaded_by_user_name = $logged_in_user_data != null ? $logged_in_user_data->name : " ";

            $data = new stdClass();
            $data->wrc_number = $wrc_number;
            $data->uploaded_by_user_name = $uploaded_by_user_name;
            $data->uploaded_detail = $request->final_link;
            $creation_type = 'completeTaskInUploadEditingFinalLink';
            $this->send_notification($data, $creation_type);
            /****** send notification end*******/
        }

        echo json_encode($response);
    }

    // get Editing uploaded link 
    function get_Editing_Uploaded_link(Request $request)
    {
        $allocation_id = $request->allocation_id;
        $response = EditingUploadLink::get_editing_uploaded_link($allocation_id);
        if ($response == 0) {
            echo $response;
        } else {
            echo json_encode($response);
        }
    }
}

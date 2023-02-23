<?php

namespace App\Http\Controllers;

use App\Models\EditingClientAR;
use Illuminate\Http\Request;

class EditingClientARController extends Controller
{
     // Editing Wrc List for client Approval & Rejection
    public function index()
    {
        $tsak_status_is = 2; // catalog ready for Submission
        $Editing_Wrc_list_for_Submission = EditingClientAR::EditingClientARList();
        return view('client-ar.Editing-Wrc-client-ar')->with('data_list', $Editing_Wrc_list_for_Submission);
    }

    // Editing Wrc client Approval or Rejection
    public function Editing_reject_approve_wrc(Request $request)
    {
        $response = EditingClientAR::Editing_reject_approve_wrc($request);
        echo json_encode($response);
    }
}

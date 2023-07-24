<?php

namespace App\Http\Controllers;

use App\Models\EditingSubmission;
use Illuminate\Http\Request;

class EditingSubmissionController extends Controller
{
    //
    // Editing Wrc list for Submission done in qc panel
    public function index()
    {
        $tsak_status_is = 1; // Editing ready for Submission
        $Editing_Wrc_list_ready_for_Submission = EditingSubmission::Editing_Wrc_Submission_list($tsak_status_is);
        // dd($Editing_Wrc_list_ready_for_Submission);
        return view('Submission.Editing-Ready-For-Submission')->with('Editing_Wrc_list_ready_for_Submission', $Editing_Wrc_list_ready_for_Submission);
    }


    public function comp_Editing_Submission(Request $request)
    {
        echo $responce = EditingSubmission::comp_submission($request);
    }

    public function Editing_Submission_Done()
    {
        $tsak_status_is = 2; // Editing submission done
        $Editing_Wrc_Submission_Done_list = EditingSubmission::Editing_Wrc_Submission_list($tsak_status_is);
        // dd($Editing_Wrc_Submission_Done_list);
        return view('Submission.Editing-submission-done')->with('Editing_Wrc_Submission_Done_list', $Editing_Wrc_Submission_Done_list);
    }


    public function comp_submission_details(Request $request)
    {
        $wrc_id = $request->wrc_id;
        echo  $responce = EditingSubmission::comp_submission_details($wrc_id);
    }
}
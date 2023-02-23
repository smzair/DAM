<?php

namespace App\Http\Controllers;

use App\Models\CatalogSubmission;
use App\Models\CatlaogQc;
use Illuminate\Http\Request;

class CatalogSubmissionController extends Controller
{
    /*** Display a listing of the resource. */
    // catalog Wrc list for ready for Submission done in qc panel
    public function index()
    {
        // dd('fdsfkg');
        $tsak_status_is = 2; // catalog ready for Submission

        $catalog_Wrc_list_for_Submission = CatalogSubmission::catalog_Wrc_list_for_Submission($tsak_status_is);
        // dd($catalog_Wrc_list_for_Submission);
        return view('Submission.catalog-submission')->with('catalog_Wrc_list_for_Submission', $catalog_Wrc_list_for_Submission);
    }
    
    
    public function comp_submission(Request $request){
        $wrc_id = $request->wrc_id;
        $catalog_allocation_ids = $request->catalog_allocation_ids;
        $submission_date = date('Y-m-d');
        echo $responce = CatalogSubmission::comp_submission($wrc_id, $submission_date, $catalog_allocation_ids);

    }

    public function catalog_submission_done()
    {
        $tsak_status_is = 3; // catalog submission done
        $catalog_Wrc_list_for_Submission = CatalogSubmission::catalog_Wrc_list_for_Submission($tsak_status_is);
        // dd($catalog_Wrc_list_for_Submission);
        return view('Submission.catalog-submission-done')->with('catalog_Wrc_list_for_Submission', $catalog_Wrc_list_for_Submission);
    }


    public function comp_submission_details(Request $request){
        $wrc_id = $request->wrc_id;
       echo  $responce = CatalogSubmission::comp_submission_details($wrc_id);


    }
}

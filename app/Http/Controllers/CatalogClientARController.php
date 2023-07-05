<?php

namespace App\Http\Controllers;

use App\Models\CatalogClientApprovalRejection;
use App\Models\CatalogSubmission;
use Illuminate\Http\Request;

class CatalogClientARController extends Controller
{
    public function index()
    {
        $tsak_status_is = 2; // catalog ready for Submission
        $catalog_Wrc_list_for_Submission = CatalogClientApprovalRejection::catalog_client_cr_list();
        return view('client-ar.catalog-client-ar')->with('data_list', $catalog_Wrc_list_for_Submission);
    }

    // reject_wrc

    public function wrc_reject_approve_wrc(Request $request)
    {
        $rejection_reason = $request->rejection_reason;
        $ar_status = $request->ar_status;
        $wrc_id = $request->wrc_id;

        echo $response = CatalogClientApprovalRejection::wrc_reject_approve_wrc($request);

    }
}

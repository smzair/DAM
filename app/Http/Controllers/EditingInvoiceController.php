<?php

namespace App\Http\Controllers;

use App\Models\EditingSubmission;
use App\Models\EditingWrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditingInvoiceController extends Controller
{
    public function index()
    {
        $Editing_Wrc_list_for_Invoice = EditingSubmission::Editing_Wrc_list_for_Invoice();
        // dd($catalog_Wrc_list_for_Submission);
        return view('Invoice.Editing-Invoice')->with('Editing_Wrc_list_for_Invoice', $Editing_Wrc_list_for_Invoice);
    }

    public function SaveEditingInvoiceNumber(Request $request)
    {
        // dd($request->all());
        echo $response = EditingSubmission::SaveEditingInvoiceNumber($request);
    }

    public function SaveEditingBulkInvoice(Request $request)
    {

        DB::beginTransaction();
        $file_error = $_FILES['invoice_sheet']['error'];
        $file_type = $_FILES['invoice_sheet']['type'];

        if ($file_error == 0 && $file_type == 'text/csv') {
            $handle = fopen($_FILES['invoice_sheet']['tmp_name'], "r");
            $count = 1;

            try {
                $update_arr = [];

                while ($csvLine = fgetcsv($handle, 1000, ",")) {
                    // Add a condition to stop header insertion
                    if ($count <= 1) {
                        $count++;
                        continue;
                    }
                    $count++;

                    $wrc_number = $csvLine[0];
                    $invoice_number = $csvLine[1];

                    $EditingWrc = EditingWrc::where('wrc_number', $wrc_number)->pluck('id')->toArray();
                    if (count($EditingWrc) > 0) {
                        $wrc_id = $EditingWrc['0'];
                        $update_status = EditingWrc::where('id', $wrc_id)->update(['invoice_number' => $invoice_number]);
                        array_push($update_arr, $update_status);
                    }
                }
                if (array_sum($update_arr) == count($update_arr) && count($update_arr) > 0) {
                    DB::commit();
                    request()->session()->flash('success', 'Editing Wrc Invoice Updated!!!');
                } else {
                    request()->session()->flash('error', 'Please try again!!');
                    DB::rollback();
                }
            } catch (\Exception $e) {
                throw $e;
                DB::rollback();
                request()->session()->flash('error', 'Somthing went wrong!! Please try again!!');
            }
        } else {
            request()->session()->flash('error', 'File format not Supported!!');
        }
        return redirect()->route('EditingInvoice');
    }
}

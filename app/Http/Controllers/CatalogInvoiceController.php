<?php

namespace App\Http\Controllers;

use App\Models\CatalogSubmission;
use App\Models\CatalogWrcBatch;
use App\Models\CatlogWrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogInvoiceController extends Controller
{
    //

    public function index()
    {
        $tsak_status_is = 3; // catalog submission done
        $catalog_Wrc_list_for_Submission = CatalogSubmission::catalog_Wrc_For_Invoice($tsak_status_is);
        // dd($catalog_Wrc_list_for_Submission);
        return view('Invoice.catalog-Invoice')->with('catalog_Wrc_list_for_Submission', $catalog_Wrc_list_for_Submission);
    }

    public function SaveCatalogInvoiceNumber(Request $request)
    {
        // dd($request->all());
        echo $response = CatalogSubmission::SaveCatalogInvoiceNumber($request);
    }

    public function SaveCataLogBulkInvoice(Request $request)
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
                    $batch_no = $csvLine[1] != 'None' ? $csvLine[1] : '0';
                    $invoiceNumber = $csvLine[2];

                    if(is_numeric($batch_no)){
                        $CatlogWrc = CatlogWrc::where('wrc_number', $wrc_number)->pluck('id')->toArray();
                        if(count($CatlogWrc) > 0 ){
                            $wrc_id = $CatlogWrc['0'];
                            $update_status = CatalogWrcBatch::where('wrc_id', $wrc_id)->where('batch_no', $batch_no)->update(['invoiceNumber' => $invoiceNumber]);
                            array_push($update_arr , $update_status);
                        }
                    }
                }
                if(array_sum($update_arr) == count($update_arr) && count($update_arr) > 0){
                    DB::commit();
                    request()->session()->flash('success', 'Catlog Wrc Invoice Updated!!!');
                }else{
                    request()->session()->flash('error', 'Please try again!!');
                    DB::rollback();
                }
            } catch (\Exception $e) {
                DB::rollback();
                request()->session()->flash('error', 'Somthing went wrong!! Please try again!!');
            }
        }else{
            request()->session()->flash('error', 'File format not Supported!!');
        }
        return redirect()->route('CatalogInvoice');
    }

    


}

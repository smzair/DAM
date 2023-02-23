<?php

namespace App\Http\Controllers;

use App\Models\CreativeWrcBatch;
use App\Models\CreativeWrcModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WrcInvoiceNumber extends Controller
{
    public function Index()
    {
     $wrcs =  CreativeWrcModel::OrderBy('creative_wrc.id','ASC')
     ->leftJoin('creative_lots', 'creative_lots.id', 'creative_wrc.lot_id')
     ->leftJoin('users', 'users.id', 'creative_lots.user_id')
     ->leftJoin('brands', 'brands.id', 'creative_lots.brand_id')
     ->leftJoin('creative_wrc_batch', 'creative_wrc_batch.wrc_id', 'creative_wrc.id')
     ->orderBy('creative_wrc_batch.id', 'DESC')
     ->groupBy('creative_wrc_batch.wrc_id')
     ->groupBy('creative_wrc_batch.batch_no')
     ->leftJoin('create_commercial as create_commercial',function($join)
     {
         $join->on('create_commercial.user_id','=','creative_lots.user_id');
         $join->on('create_commercial.brand_id','=','creative_lots.brand_id');
     })
     ->leftJoin('creative_submissions', function($join){
        $join->on('creative_submissions.wrc_id', '=', 'creative_wrc_batch.wrc_id');
        $join->on('creative_submissions.batch_no', '=', 'creative_wrc_batch.batch_no');
    })
 
    ->where('creative_submissions.Status',1)
     ->select('creative_wrc.*','creative_wrc_batch.invoice_no','creative_lots.user_id','creative_lots.brand_id','creative_lots.lot_number','users.Company as Company_name','brands.name','create_commercial.kind_of_work','create_commercial.per_qty_value',DB::raw('MAX(creative_wrc_batch.batch_no) as batch_no'))
     ->get();
     foreach( $wrcs as $key => $val){
        $submission_count = DB::table('creative_allocation')->where('user_id',$val['user_id'])->where('wrc_id',$val['id'])->sum('allocated_qty');
        $val['submission_count'] = $submission_count;
     }
        //  dd($wrcs);
      return view('UpdateInvoiceNumberPanel.Update-Invoice-Number')->with('wrcs',$wrcs);
    }

    // update invoice no in creative wrc
    public function updateWrcInvoice(Request $request){

        if($request->hasFile('invoice_no_sheet')) {
            $invoice_no_sheet = $request->file('invoice_no_sheet');
            // Validate if the uploaded file is a csv file
            if ($invoice_no_sheet->getClientOriginalExtension() == 'csv') {
                $handle = fopen($_FILES['invoice_no_sheet']['tmp_name'], "r");
                $header = true;
                $count = 1;
                while ($csvLine = fgetcsv($handle, 1000, ",")) {
                    // Add a condition to stop header insertion
                    if ($count <= 1) {
                        $count++;
                        continue;
                    }
                    $wrc_number = $csvLine[0];
                    $batch_no = is_int($csvLine[1]) ? 0 : $csvLine[1];
                    $wrc_invoice_no = $csvLine[2];
        
                    $creative_wrc = CreativeWrcModel::orderby('id','DESC')->where('wrc_number',$wrc_number)->get('id')->first();
                    $wrc_id = $creative_wrc != null ? $creative_wrc->id : 0;
                    if($wrc_number != null && $batch_no != null && $wrc_invoice_no != null){
                        CreativeWrcBatch::where('wrc_id', $wrc_id)->where('batch_no', $batch_no)->update(['invoice_no'=> $wrc_invoice_no ]);
                    }
        
                }
                request()->session()->flash('success', 'Wrc Invoice No. Successfully Updated');
                return $this->Index();
            } else {
                request()->session()->flash('error', 'Uploaded file is not a csv file');
                return $this->Index();
            }
        }else{
            $wrc_id = $request->wrc_id;
            $batch_no = $request->batch_no == 'None' ? 0 : $request->batch_no;
            $wrc_invoice_no = $request->wrc_invoice_no;
            $update_invoice_no = false;

            if( $wrc_invoice_no){
                $update_invoice_no = CreativeWrcBatch::where('wrc_id', $wrc_id)->where('batch_no', $batch_no)->update(['invoice_no'=> $wrc_invoice_no ]);
            }

            if($update_invoice_no){
                request()->session()->flash('success','Wrc Invoice No. Successfully Updated');
            }
            else{
                request()->session()->flash('error','Please try again!!');
            }

            return $this->Index();
        }
        
    }
}

<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditingWrc extends Model
{
    use HasFactory;
    protected $table = 'editing_wrcs';
    protected $fillable = [ 'lot_id','commercial_id', 'wrc_number',  'imgQty', 'documentType', 'documentUrl', ];


    // Store a newly created resource in storage.
    public static function storedata($request)
    {
        $s_type_arr = explode(" ", $request->s_type);
        $count = count($s_type_arr);
        $s_type_is = "";
        $s_type_is .= $s_type_arr[0][0];
        if($count > 0){
            $s_type_is .= $s_type_arr[$count - 1][0];
        }
        $wrcs = EditingWrc::where(['lot_id' => $request->lot_id])->get();
        $wrcCount = $wrcs->count();

        $c_short = $request->c_short;
        $short_name = $request->short_name;
        $user_id = $request->user_id;
        $brand_id = $request->brand_id;
        $lot_id = $request->lot_id;
        $commercial_id = $request->commercial_id;
        $imgQty = $request->imgQty;
        $documentType = $request->docType;
        $documentUrl = $request->documentUrl;
        $sku_sheet = $_FILES['sku_sheet'];
        $wrc_number_is = $c_short . $short_name . $s_type_is . $lot_id . '-' . chr($wrcCount + 65);
        $wrc_number = strtoupper($wrc_number_is);
        
        if($documentType == 1){
            if ($request->hasFile('sku_sheet')) {
                $sku_sheet = $request->file('sku_sheet');
                if ($sku_sheet->getClientOriginalExtension() === "csv" || $sku_sheet->getClientOriginalExtension() === "xlsx") {
                    $fileName = "sku_sheet".date('YmdHis').".". $sku_sheet->getClientOriginalExtension();
                    $path = $sku_sheet->storeAs("public/Uploaded_SKU", $fileName, 'local');
                    $documentUrl = $fileName;
                } 
            }
        }
        
        $EditingWrc = new EditingWrc();
        $EditingWrc->lot_id = $lot_id;
        $EditingWrc->commercial_id = $commercial_id;
        $EditingWrc->wrc_number = $wrc_number;
        $EditingWrc->imgQty = $imgQty;
        $EditingWrc->documentType = $documentType;
        $EditingWrc->documentUrl = $documentUrl;
        $status = $EditingWrc->save();
        
        $id =  $EditingWrc->id;

        if ($status) {
            request()->session()->flash('success', 'Wrc Created Successfully!!');
        } else {
            $wrc_number = "";
            request()->session()->flash('false', 'Please try again!!');
        }

        $EditingWrc = (object) [
            'id' => 0,
            'user_id' => '',
            'brand_id' => '',
            'lot_id' => '',
            'commercial_id' => '',
            'wrc_number' => $wrc_number,
            'imgQty' => '',
            'documentType' => '0',
            'documentUrl' => '',
            'documentUrl' => '',
        ];
        $sku_details = array(
            'unique_Count' => 0,
            'variant_Count' => 0,
            'total_Count' => 0,
        );
        return view('Wrc.Editing_wrc_create')->with('EditingWrc', $EditingWrc)->with('sku_details', $sku_details);
    }

    // Update resource in storage.
    public static function updatedata($request)
    {

        $s_type_arr = explode(" ", $request->s_type);
        $count = count($s_type_arr);
        $s_type_is = "";
        $s_type_is .= $s_type_arr[0][0];
        if ($count > 0) {
            $s_type_is .= $s_type_arr[$count - 1][0];
        }
        $wrcs = EditingWrc::where(['lot_id' => $request->lot_id])->get();
        $wrcCount = $wrcs->count();
        
        $id = $request->id;
        $lot_id = $request->lot_id;
        $c_short = $request->c_short;
        $short_name = $request->short_name;
        $commercial_id = $request->commercial_id;
        $imgQty = $request->imgQty;
        $documentType = $request->docType;
        $documentUrl = $request->documentUrl;
        $sku_sheet = $_FILES['sku_sheet'];
        $wrc_number = $c_short . $short_name . $s_type_is . $lot_id . '-' . chr($wrcCount + 65);


        if ($documentType == 1) {
            if ($request->hasFile('sku_sheet')) {
                $sku_sheet = $request->file('sku_sheet');
                if ($sku_sheet->getClientOriginalExtension() === "csv" || $sku_sheet->getClientOriginalExtension() === "xlsx") {
                    $fileName = "sku_sheet" . date('YmdHis') . "." . $sku_sheet->getClientOriginalExtension();
                    $path = $sku_sheet->storeAs("public/Uploaded_SKU", $fileName, 'local');
                    $documentUrl = $fileName;
                }else{
                    $documentUrl = $request->documentUrl;
                }
            }else{
                $documentUrl = $request->documentUrl;
            }
        }

        $EditingWrc =  EditingWrc::find($id);
        $EditingWrc->lot_id = $lot_id;
        $EditingWrc->commercial_id = $commercial_id;
        // $EditingWrc->wrc_number = $wrc_number;
        $EditingWrc->imgQty = $imgQty;
        $EditingWrc->documentType = $documentType;
        $EditingWrc->documentUrl = $documentUrl;
        $status = $EditingWrc->update();

        if ($status) {
            request()->session()->flash('success', 'Wrc Updated Successfully!!');
        } else {
            $wrc_number = "";
            request()->session()->flash('false', 'Please try again!!');
        }

        return redirect()->route('EditingWrcEdit', [$id]);

    }


}

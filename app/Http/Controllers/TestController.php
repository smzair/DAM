<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use ZipArchive;
use Zip;
use App\Models\Skus;
use App\Models\uploadraw;
use App\Models\Wrc;
use App\Models\skusStatus;


class TestController extends Controller
{
    public function file(){

        return view('assesment.test');
    }

    public function textData(Request $request){

        $selectedLot = $request->selected_lot;
        $selectedWrc = $request->selected_wrc;

        $data = json_encode(array('selected_wrc' => $selectedWrc,'selected_lot' => $selectedLot));

        $fh = fopen('data.json', 'w');
        fwrite($fh, $data);
        fclose($fh);
        echo "success";
        exit();

    }

    public function fileUplaod(Request $request){
        $skuInfoArr = [];
        $skuNotFound= [];
        $skuFoundAc = [];
        $skuFoundRe = [];
        $allowFileExtension = ['jpg','png','jpeg'];
        $selected_wrc_upload = $request->selected_wrc_upload;
        $selected_lot_upload = $request->selected_lot_upload;
        $wrcInfo = Wrc::where(['wrc_id'=> $selected_wrc_upload])->first();
        $wrcId = $wrcInfo->id;
        $file = $request->file('skusheet');
        $directoryName = $file->getClientOriginalName();
        $file->move(base_path('public/test'), $directoryName);
        $filepath = base_path('test/'. $directoryName);
        $newDirectoryName = str_replace(".zip", "", $directoryName);
        $zip = Zip::open($filepath);
        $zip->extract(public_path() . '/test/exfol/' . $newDirectoryName);
        $directoryList = $zip->listFiles();
        if(count($directoryList) > 0) {
            foreach ($directoryList as $path) {
                $pathArr = explode('/', $path);
                if(count($pathArr) == 3) {
                    $skuStatus = '1';
                    $skuCode = $pathArr[1]; 
                    $fileName = $pathArr[2];
                    $skuCodeLength = strlen($skuCode);
                    $skuCodeExt = substr($skuCode, -2);
                    if($skuCodeExt == '_R') {
                     $skuCode =  substr($skuCode, 0, $skuCodeLength - 2);
                     $skuStatus = '0';
                 }
                 $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                 if(in_array($ext, $allowFileExtension)) {
                    $skuIndex = $wrcId . '_' . $skuCode;
                    if(!in_array($skuIndex, $skuInfoArr)) {
                        $skuInfo = Skus::where(['wrc_id'=> $wrcId,'sku_code' => $skuCode])->first();                       
                        if(isset($skuInfo->id)){                                
                            $skuInfo->status = $skuStatus;
                            $skuInfo->save(); 
                            $rawImgCount = uploadraw::where(['sku_id'=>$skuInfo->id])->count()+1;
                            $skuInfoArr[$skuIndex] = $skuInfo;
                            if($skuStatus == '0') {
                                $skuFoundRe[$skuCode] = $skuCode;
                            }else{
                                $skuFoundAc[$skuCode] = $skuCode;
                            }
                        }else{
                            $skuNotFound[$skuCode] = $skuCode;
                        }
                    }
                    if(!empty($skuInfoArr[$skuIndex])) { 
                       $path="raw_img_directory/". date('Y') . "/" . date('M') . "/" . $selected_lot_upload ."/".$selected_wrc_upload."/".$skuInfoArr[$skuIndex]->sku_code;
                       $saveFilePath = $skuInfoArr[$skuIndex]->sku_code . '_' . $rawImgCount . '.' . $ext;
                       $key = $path . '/' . $saveFilePath;
                       $sourceSku = $skuInfoArr[$skuIndex]->sku_code;
                       if($skuStatus == '0') {
                        $sourceSku .= '_R';
                    }
                    $sourcePath = public_path() . '/test/exfol/'.$newDirectoryName . '/'.$newDirectoryName . '/' . $sourceSku . '/' . $fileName;
                    $result = s3postObject($key, $sourcePath);

                    $rawUpload= new uploadraw();
                    $rawUpload->filename=$result['ObjectURL'];
                    $rawUpload->sku_id=$skuInfoArr[$skuIndex]->id;

                    $rawUpload->save();
                    $rawImgCount++;

                    $skuId = $skuInfoArr[$skuIndex]->id;

                    $skuFound = skusStatus::where(['sku_id' => $skuId,'status'=>'ready_for_allocation'])->get();
                    if(count($skuFound) != 0){
                    }else{
                        $sku = Skus::find(['id' => $skuId])->first();
                        $sku->current_status = 'ready_for_allocation';
                        $sku->save(); 

                        $statusEngine = new skusStatus();
                        $statusEngine->sku_id = $skuId;
                        $statusEngine->status = 'ready_for_allocation';
                        $statusEngine->save();
                    }


                }
            }
        }
    }
    $countskuFoundAc = count($skuFoundAc);
    $countskuFoundRe = count($skuFoundRe);
    $countarticle = count($skuFoundRe) + count($skuFoundAc);
    $foldersnotfound = count($skuNotFound);
    $html =  view('Img.img_sku_data',compact('countskuFoundAc', 'skuNotFound','foldersnotfound','countskuFoundRe','countarticle'));
    
    return $html;

}

}




}




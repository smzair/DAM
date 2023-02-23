<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\allocation;
use App\Models\editing;
use App\Models\Wrc;
use Illuminate\Support\Facades\Auth;
use ZipArchive;
use File;
use App\Models\flipkart_editing;
use Carbon;
use App\Models\Skus;
use App\Models\editorSubmission;
use App\Models\Lots;


class editingController extends Controller
{
    public function Index(){

        $userId = Auth::id();   
        $allocations = allocation::getAllocation($filter = ['user_id' => $userId, 'skip_alloted' => false,'lot_done' => '1' ]);

        $allocationList = [];

        foreach($allocations as $allocation){

            $allocationList[$allocation->lot_id]['lot_id'] = $allocation->lot_id;
            $allocationList[$allocation->lot_id]['lotid'] = $allocation->lotid;

            $allocationList[$allocation->lot_id]['client_id'] = $allocation->client_id;
            $allocationList[$allocation->lot_id]['Company'] = $allocation->Company;
             $allocationList[$allocation->lot_id]['brand'] = $allocation->brand_name;

            $allocationList[$allocation->lot_id]['wrcs'][$allocation->wrc_id]['wrc_id'] = $allocation->wrc_id;
            $allocationList[$allocation->lot_id]['wrcs'][$allocation->wrc_id]['wrcid'] = $allocation->wrcid;
            $allocationList[$allocation->lot_id]['wrcs'][$allocation->wrc_id]['type_of_shoot'] = $allocation->type_of_shoot;
            $allocationList[$allocation->lot_id]['wrcs'][$allocation->wrc_id]['type_of_clothing'] = $allocation->type_of_clothing;
            $allocationList[$allocation->lot_id]['wrcs'][$allocation->wrc_id]['adaptation_1'] = $allocation->adaptation_1;
            $allocationList[$allocation->lot_id]['wrcs'][$allocation->wrc_id]['adaptation_2'] = $allocation->adaptation_2;
            $allocationList[$allocation->lot_id]['wrcs'][$allocation->wrc_id]['adaptation_3'] = $allocation->adaptation_3;
            $allocationList[$allocation->lot_id]['wrcs'][$allocation->wrc_id]['adaptation_4'] = $allocation->adaptation_4;
            $allocationList[$allocation->lot_id]['wrcs'][$allocation->wrc_id]['adaptation_5'] = $allocation->adaptation_5;
            $allocationList[$allocation->lot_id]['wrcs'][$allocation->wrc_id]['sku_codes'][$allocation->sku_id] = $allocation->sku_code;
            $allocationList[$allocation->lot_id]['wrcs'][$allocation->wrc_id]['sku'][$allocation->sku_id]['sku_code'] = $allocation->sku_code;
            $allocationList[$allocation->lot_id]['wrcs'][$allocation->wrc_id]['sku'][$allocation->sku_id]['created_at'] = $allocation->created_at;
            $lotPath = "raw_img_directory/". date('Y', strtotime($allocation->created_at)) . "/" . date('M', strtotime($allocation->created_at)) . "/" . $allocation->lot_id . "/";
            $allocationList[$allocation->lot_id]['lot_path'] = $lotPath;
            $wrcPath = $lotPath . $allocation->wrc_id  ;
            $allocationList[$allocation->lot_id]['wrcs'][$allocation->wrc_id]['wrc_path']= $wrcPath;
            $path = $wrcPath ;
            $allocationList[$allocation->lot_id]['wrcs'][$allocation->wrc_id]['sku'][$allocation->sku_id]['uploadraw']['file_path'][] = $path;
            $allocationList[$allocation->lot_id]['wrcs'][$allocation->wrc_id]['sku'][$allocation->sku_id]['uploadraw']['uploadraw_id'][] = $allocation->uploadraw_id;
        }
        foreach($allocationList as $lot_id => $lotinfo){

            if(!isset($allocationList[$lot_id]['wrc_count'])){
                $allocationList[$lot_id]['wrc_count'] = 0;
                $allocationList[$lot_id]['wrc_id'] = 0;
            }
            if(!isset($allocationList[$lot_id]['sku_count'])){
                $allocationList[$lot_id]['sku_count'] = 0;
            }
            if(!isset($allocationList[$lot_id]['image_count'])){
                $allocationList[$lot_id]['image_count'] = 0;
            }

            foreach($lotinfo['wrcs'] as $wrc){
                $allocationList[$lot_id]['wrc_id'] = $lotinfo['wrcs'];

                foreach($wrc['sku'] as $sku){
                    $allocationList[$lot_id]['image_count'] += count($sku['uploadraw']['file_path']);
                }

                $allocationList[$lot_id]['sku_count'] += count($wrc['sku']);
            }

            $allocationList[$lot_id]['wrc_count'] += count($lotinfo['wrcs']);
        }

        $sr = 1;
        
        return view('edit-allocate.editorspanel',compact('allocationList', 'sr'));

    }


    public function findWrc(Request $request){

        $userId = Auth::id(); 
        $lotId= $request->lot_id; 
        $wrcinfo = allocation::getAllocation($filter = ['user_id' => $userId,'lot_id'=> $lotId, 'skip_alloted' => false,'group'=>true]);



        $wrcin = '<option value="" disabled selected >Select WRC</option>';

        foreach($wrcinfo as $wrc){
            $wrcin .= '<option value="'.$wrc->wrcid.'" >'.$wrc->wrc_id. '</option>';
        }

        return response()->json(['wrc_html' => $wrcin]);

    }

    public function findCom(Request $request){

        $wrcId = $request->wrc_id;
        $coms= Wrc:: getwrcInfo($filter = ['id'=> $wrcId]);

        $cominfo = '<option value="" disabled selected >Select Adaptation</option>';
        foreach($coms as $com){

         $cominfo .= '<option value=""adaptation_1" >'.$com->adaptation_1. ' </option>';
         $cominfo .= '<option value="adaptation_2 ">'.$com->adaptation_2. ' </option>';
         $cominfo .= '<option value="adaptation_3" >'.$com->adaptation_3. ' </option>';
         $cominfo .= '<option value="adaptation_4" >'.$com->adaptation_4. ' </option>';
         $cominfo .= '<option value="adaptation_5" >'.$com->adaptation_5. ' </option>';

     }
     return response()->json(['com_html' => $cominfo]);



 }

 
 public function editedImgUpload(Request $request) { 

    $wrcId = $request->wrc_id;
    $userId = Auth::id();  

    $allocations = allocation::getAllocation($filter = ['user_id' => $userId,'wrc_id'=> $wrcId, 'skip_alloted' => false]);

    $fileName='';

    if(count($allocations) > 0){

        foreach($allocations as $allo){
           $fileName=$allo->wrc_id; 
           $downloadPath = "downloads-raw-image/". date('Y', strtotime($allo->created_at)). "/" . date('M', strtotime($allo->created_at)) . "/" . $allo->lot_id . "/" . $allo->wrc_id;
           $targetPath = $downloadPath . "/". $allo->sku_code;

           \File::makeDirectory($targetPath, $mode = 0777, true, true);

           $sourcePath=  "raw_img_directory/". date('Y', strtotime($allo->created_at)) . "/" . date('M', strtotime($allo->created_at)) . "/" . $allo->lot_id . "/" . $allo->wrc_id . "/" . $allo->sku_code."/".$allo->filename;

           \File::copy($sourcePath, $targetPath."/".$allo->filename);

       }
   }

   $fileName .= ".zip";
   $zip = new ZipArchive;

   if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
    $this->addContent($zip, $downloadPath);
    $zip->close();

    return response()->download($fileName)->deleteFileAfterSend(true);
}

}


private function addContent(\ZipArchive $zip, string $path)
{
 /** @var SplFileInfo[] $files */
 $iterator = new \RecursiveIteratorIterator(
    new \RecursiveDirectoryIterator(
        $path,
        \FilesystemIterator::FOLLOW_SYMLINKS
    ),
    \RecursiveIteratorIterator::SELF_FIRST     );
 
 while ($iterator->valid()) {
   if (!$iterator->isDot()) {
       $filePath = $iterator->getPathName();
       $relativePath = substr($filePath, strlen($path) + 1);

       if (!$iterator->isDir()) {
           $zip->addFile($filePath, $relativePath);
       } else {
           if ($relativePath !== false) {
               $zip->addEmptyDir($relativePath);
           }
       }
   }
   $iterator->next();
}
}


public function imgUpload(Request $request){

    $status = false;
    $message = "SKU Code did not match to exisiting record !";

    $lotid=$request->lotid;
    $wrcid=$request->wrcid;
    $skucodes=$request->skucodes;
    $adaptations=$request->adaptations;
    $lot_text=$request->lot_text;
    $wrc_text=$request->wrc_text;
    $adaptations_text=$request->adaptations_text;
$count = 0;
    if(empty($lotid)){
        $message = "Please select Lot Id";
    }else if(empty($lotid)){
        $message = "Please select Lot Id";
    }else if(empty($lotid)){
        $message = "Please select Lot Id";
    }else{

        $input=$request->all();
        if($files=$request->file('sku_images')){

            $skucodes = (!empty($skucodes)) ? explode(' | ', $skucodes) : array();

            foreach($files as $file){
                $filename=$file->getClientOriginalName();
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $skutext = str_replace("." . $ext, "", $filename);
                $pos = strripos("$skutext","_");
                $sku_code = substr($skutext, 0, $pos);
                $path="edited_img_directory/". date('Y') . "/" . date('M') . "/" . $lot_text . "/". $wrc_text . "/" . $adaptations_text . "/" . $sku_code . "/";
                $skuObj = Skus::where(["sku_code" => $sku_code, 'lot_id' => $lotid, 'wrc_id' => $wrcid])->first();
                if(!empty($skuObj)){
                    $file->move($path, $filename);
                    $skuId = $skuObj->id;
                    $Upload= new editorSubmission();
                    $Upload->filename=$filename;
                    $Upload->sku_id=$skuObj->id;
                    $Upload->adaptation=$adaptations_text;
                    $Upload->save();
                    $status = true;
                    $message = "Image upload successfully!";

                    if(!in_array($sku_code, $skucodes)){
                        $skucodes[] = $sku_code;
                         $count = count($skucodes);
                    }
                }
            }
            // notification
            return response()->json(['status' => $status, 'message' => $message, 'sku_codes' => implode(' | ', $skucodes),'count' => $count]);
        }
    }
    return response()->json(['status' => $status, 'message' => $message]);
}

 public function lotDone(Request $request){

    $lotId = $request->lotid;
    $lots= Lots::find($lotId);
          $lots->lot_done = '1';
          $lots->save();
    echo "success";
    
    }

 public function wrcReject(Request $request){
    $Id = $request->id;
    $status = $request->qc;
    $wrc  = Skus::where('id','=',$Id)->first();
    
   $wrcId = $wrc->wrc_id;
   $wrcs = Wrc::find($wrcId);
   $wrcs->edt_rejection = '0';
    $wrcs->save();
   
    $skus= Skus::find($Id);
    $skus->edt_rejection = $status;
    $skus->save();
echo "success";
    }
    
    
    public function flipkartUpload(Request $request){

    $user_id = 77;
    $brand_id = 0 ;
    $PendingLots = Lots::where(['s_type' => "ED",'brand_id' => '16','user_id' => $user_id,'lot_done' => '0'])->latest()->get();

    return view('edit-allocate.flipkartupload',compact('PendingLots'));
    
    }

    public function getWrcs(Request $request){

    $id = $request->lot_id;
    $wrcs = Wrc:: where('lot_id','=',$id)->get();


    $html = '<option value = "">Please Select</option>';

    foreach ($wrcs as $wrc) {
        $html .= '<option value="'. $wrc->id .'">' . $wrc->wrc_id . '</option>';
    }
    return  $html;
    }

    public function getFiles(Request $request){
    
    $id = $request->wrc_id;
    $wrcs = flipkart_editing::where('wrc_id','=',$id)->get();
    $html = '<option value = "">Please Select</option>';

    foreach ($wrcs as $wrc) {
        $html .= '<option value="'. $wrc->id .'">'.$wrc->recivedFilename . ' | | '.timeFormat($wrc->created_at).'</option>';
    }
    return  $html;

    }

    public function imagecount(Request $request){
    
    $flipkartid = $request->flip_id;
    $wrcid = $request->wrc_id;
    $lotid = $request->lot_id;
    $imagecount = $request->imageCount;
    $rejectedimagecount = $request->rejectedimageCount;

    $lot = Lots::where('id','=',$lotid)->get()->first();
    $thislotId = $lot->lot_id; 
    $wrc = Wrc::where('id','=',$wrcid)->get()->first();
    $wrcNumber = $wrc->wrc_id; 
    $filenamewithextension = $request->file('zip')->getClientOriginalName();
        //get filename without extension
    $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        //get file extension
    $extension = $request->file('zip')->getClientOriginalExtension();
        //filename to store
    $filenametostore = $filename.'_'.uniqid().'.'.$extension;
    $file = flipkart_editing::where('id','=',$flipkartid)->get()->first();
    $filePath = "Flipkart/EditorUploads/"  . date('Y', strtotime($file->created_at)) . "/" . date('M', strtotime($file->created_at)) . "/". date('d', strtotime($file->created_at)) . "/" .$thislotId."/".$wrcNumber."/".$filenametostore;
    Storage::disk('ftp')->put($filePath, fopen($request->file('zip'), 'r+'));
    $obj = flipkart_editing::findOrfail($flipkartid);
    $obj->sentFilename = $filenametostore;
    $obj->save();

    $request->session()->put('message', 'Zip File Uploaded Successfully');

    }

    public function image(Request $request){
        
        $responseData = array('count' => false);
        $flip = $request->flip_id;
        $Aprrovedimgcounts = $request->count;
        $rejectedimgcounts = $request->rejectedimagecount;
        $missingimagecounts = $request->missingimagecount;
        $count = $Aprrovedimgcounts + $rejectedimgcounts + $missingimagecounts;
        $imgCount = flipkart_editing::where('id','=',$flip)->get()->first();
        $imgCounts = $imgCount->imageCount;
        if($imgCounts != $count){

            $responseData['count'] = true;
        }
        return response()->json($responseData,200);        

    }


    public function flipkartTable(Request $request){
        
        $flipkart_data = flipkart_editing::getFlipInfo(['group'=>true, 'fwrc_done' => '0']);
        $totalImgCount = [];
        foreach ($flipkart_data as $flip) {
            $index = $flip->id;
            $wrcs = flipkart_editing::where('wrc_id','=',$flip->wrcId)->sum('imageCount');
            $totalImgCount[$index]['lot_id']= $flip->lot_id;
            $totalImgCount[$index]['wrc_id']= $flip->wrc_id;
            $totalImgCount[$index]['imgcount']= $wrcs;
            $totalImgCount[$index]['created_at']= $flip->created_at;
            $totalImgCount[$index]['wrcId']= $flip->wrcId;
            $totalImgCount[$index]['lotId']= $flip->lotId;
            $totalImgCount[$index]['fstart']= $flip->fstarted;
        }

        return view('edit-allocate.flipkart_editingtable',compact('totalImgCount'));

    }

    public function getwrcFile(Request $request){

        $wrcId = $request->wrc_id;
        $files =flipkart_editing::where('wrc_id','=',$wrcId)->where('sentFilename','!=',Null)->get();
        $totalfile =flipkart_editing::where('wrc_id','=',$wrcId)->get();
        $sr=1;
        $pending = count($totalfile) - count($files);
        $html = view('edit-allocate.wrcuploads',compact('files','pending','sr'));
        
        return $html ;
        }

    public function DownloadFile(Request $request){
        $wrcId = $request->wrc_id; 
        $allFiles =flipkart_editing::where('wrc_id','=',$wrcId)->get();
        $all = [];
        foreach($allFiles as $file){
        $index = $file->id;
        $lotId = Lots::where('id','=',$file->lot_id)->get()->first();
        $wrcId = wrc::where('id','=',$file->wrc_id)->get()->first();
        $path = "Flipkart/ClientUploads/"  . date('Y', strtotime($file->created_at)) . "/" . date('M', strtotime($file->created_at)) . "/". date('d', strtotime($file->created_at)) . "/";
        $all[$index]['filename']= $file->recivedFilename;
        $all[$index]['count']= $file->imageCount;
        $all[$index]['created_at']= $file->created_at;
        $all[$index]['filepath'] =  $path . $lotId->lot_id . "/". $wrcId->wrc_id . "/". $file->recivedFilename;    
        $all[$index]['fileId'] = $file->id;
                }

                $sr=1;
        $html = view('edit-allocate.dynamicdown',compact('all','sr'));
                
                return $html ;
            }



        public function wrcDone(Request $request){
            $mytime = date('Y-m-d');
            $id = $request->wrc_id;
            $wrc = wrc::findOrFail($id);
            $wrc->fwrc_done = '1';
            $wrc->fwrcdone_date = $mytime;
            $wrc->save();
            $request->session()->put('message', 'WRC Marked Completed Successfully');
        }
    
        public function EditingStarted(Request $request){
        
        $mytime = date('Y-m-d');
        $id = $request->wrc_id;
        $wrc = wrc::findOrFail($id);
        $wrc->fstarted = '1';
        $wrc->fwrcstarted_date = $mytime;
        $wrc->save();
        $request->session()->put('message', 'Work on WRC Started Successfully');



        }


}

<?php

namespace App\Http\Controllers;

use App\Models\ClientActivityLog;
use App\Models\EditingAllocation;
use App\Models\EditingWrc;
use App\Models\EditorLotModel;
use App\Models\Lots;
use Illuminate\Http\Request;
use ZipArchive;

class ImageDownloadController extends Controller
{

  private function addContent(\ZipArchive $zip, string $path)
  {
    /** @var SplFileInfo[] $files */
    $iterator = new \RecursiveIteratorIterator(
      new \RecursiveDirectoryIterator(
        $path,
        \FilesystemIterator::FOLLOW_SYMLINKS
      ),
      \RecursiveIteratorIterator::SELF_FIRST
    );

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

  //Editing Raw Image Download 
  public function Editing_Raw_Image_Download($wrc_id = 0)
  {
    $wrcId = base64_decode($wrc_id);
    $wrcinfo =    $EditingWrc =  EditingWrc::find($wrcId);
    $fileName = $wrcinfo->wrc_number . ".zip";
    $raw_img_file_path = $wrcinfo->raw_img_file_path;
    $zip = new ZipArchive;
    if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
      $this->addContent($zip, $raw_img_file_path);
      $zip->close();
      return response()->download($fileName)->deleteFileAfterSend(true);
    }
  }

  // User Edited Image Download user and wrc wice
  public function Editing_User_Edited_Image_Download($allocation_id_is = 0)
  {
    $allocation_id = base64_decode($allocation_id_is);
    $EditingAllocation =  EditingAllocation::find($allocation_id);
    $file_path = $EditingAllocation->file_path;
    $file_path_arr = explode('/', $file_path);
    $fileName = $file_path_arr[4] . ".zip";
    $zip = new ZipArchive;
    if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
      $this->addContent($zip, $file_path);
      $zip->close();
      return response()->download($fileName)->deleteFileAfterSend(true);
    }
  }

  //Shoot lot Raw Image zip Download
  public function download_Shoot_Lot_raw($lot_id)
  {
    $lot_id = $lot_id; // lot id
    $lot_data = Lots::where('id', $lot_id)->first(['lot_id', 'created_at']);

    $lot_no = $lot_data != null ? $lot_data['lot_id'] : "-";
    $lot_created_at = $lot_data != null ? $lot_data['created_at'] : "-";

    $fileName = $lot_no . ".zip";

    $path =  "raw_img_directory/" . date('Y', strtotime($lot_created_at)) . "/" . date('M', strtotime($lot_created_at)) . "/" . $lot_no;

    $zip = new ZipArchive;
    if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
      if (file_exists($path)) {
        $this->addContent($zip, $path);
        $zip->close();

        $all_data_in_arr = array(
          'fileName' => $fileName,
          'path' => $path,
        );
        $data_array = array(
          'log_name' => 'File Manger - Shoot Raw Images Download',
          'description' => 'Shoot Lot Raw Images Download for lot_no ' . $lot_no,
          'event' => 'Shoot Lot Raw Images Download',
          'subject_type' => 'App\Models\Lots',
          'subject_id' => '0',
          'properties' => [$all_data_in_arr],
        );
        ClientActivityLog::saveClient_activity_logs($data_array);
        return response()->download($fileName)->deleteFileAfterSend(true);
      } else {
        return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
      }
    }
  }

  //Shoot lot Raw Image zip Download
  public function download_Shoot_Lot_edited($lot_id)
  {
    $lot_id = $lot_id;
    $lot_data = Lots::where('id', $lot_id)->first(['lot_id', 'created_at']);

    $lot_no = $lot_data != null ? $lot_data['lot_id'] : "-";
    $lot_created_at = $lot_data != null ? $lot_data['created_at'] : "-";

    $fileName = $lot_no . ".zip";
    $path =  "edited_img_directory/" . date('Y', strtotime($lot_created_at)) . "/" . date('M', strtotime($lot_created_at)) . "/" . $lot_no;

    $zip = new ZipArchive;

    if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
      if (file_exists($path)) {
        $this->addContent($zip, $path);
        $zip->close();

        $all_data_in_arr = array(
          'fileName' => $fileName,
          'path' => $path,
        );
        $data_array = array(
          'log_name' => 'File Manger - Shoot Edited Images Download',
          'description' => 'Shoot Lot Edited Images Download for lot_no ' . $lot_no,
          'event' => 'Shoot Lot Edited Images Download',
          'subject_type' => 'App\Models\Lots',
          'subject_id' => '0',
          'properties' => [$all_data_in_arr],
        );
        ClientActivityLog::saveClient_activity_logs($data_array);
        return response()->download($fileName)->deleteFileAfterSend(true);
      } else {
        return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
      }
    }
  }

  //Shoot lot Edited Image zip Download based on wrc id
  public function download_Shoot_lot_Edited_wrc($wrc_id ,$is_multipal = '')
  {
    $wrc_id = base64_decode($wrc_id); // lot id
    $lot_data_arr = Lots::leftJoin('wrc','wrc.lot_id', '=' , 'lots.id')->whereNotNull('lots.id')->
    where('wrc.id', '=', $wrc_id)->get(['lots.lot_id', 'lots.created_at' , 'wrc.wrc_id as wrc_number'])->toArray();

    if(count($lot_data_arr) > 0){
      $lot_data = $lot_data_arr[0];
      $lot_no = $lot_data['lot_id'];
      $lot_created_at = $lot_data['created_at'];
      $wrc_number = $lot_data['wrc_number'];
      
      $fileName = $wrc_number . ".zip";
      $path =  "edited_img_directory/" . date('Y', strtotime($lot_created_at)) . "/" . date('M', strtotime($lot_created_at)) . "/" . $lot_no."/" . $wrc_number;
      
      // dd($path);
      $zip = new ZipArchive;
      if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
        if (file_exists($path)) {
          $this->addContent($zip, $path);
          $zip->close();
  
          $all_data_in_arr = array(
            'fileName' => $fileName,
            'path' => $path,
          );
          $data_array = array(
            'log_name' => 'File Manger - Shoot Edited Images Download',
            'description' => 'Shoot Lot Edited Images Download for wrc ' . $wrc_number,
            'event' => 'Shoot Lot Edited Images Download',
            'subject_type' => 'App\Models\Lots',
            'subject_id' => '0',
            'properties' => [$all_data_in_arr],
          );
          ClientActivityLog::saveClient_activity_logs($data_array);
          return response()->download($fileName)->deleteFileAfterSend(true);
        } else {
          if($is_multipal == ''){
            return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
          }else{
            return "error";
          }
        }
      }else{
        if($is_multipal == ''){
          return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
        }else{
          return "error";
        }
      }
    }else{
      if($is_multipal == ''){
        return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, Invailid Wrc id');
      }else{
        return "error";
      }
    }
  }

  //Shoot lot Edited Image zip Download based on wrc id and adaptation
  public function download_Shoot_lot_Edited_adaptation ($wrc_id , $adaptation , $sku_id = '')
  {
    $wrc_id = base64_decode($wrc_id); 
    $adaptation = base64_decode($adaptation);

    $lot_data_arr = Lots::leftJoin('wrc','wrc.lot_id', '=' , 'lots.id')->whereNotNull('lots.id')->
    where('wrc.id', '=', $wrc_id)->get(['lots.lot_id', 'lots.created_at' , 'wrc.wrc_id as wrc_number'])->toArray();

    if(count($lot_data_arr) > 0){
      $lot_data = $lot_data_arr[0];
      $lot_no = $lot_data['lot_id'];
      $lot_created_at = $lot_data['created_at'];
      $wrc_number = $lot_data['wrc_number'];
      
      $fileName = $wrc_number."-".$adaptation . ".zip";
      $path =  "edited_img_directory/" . date('Y', strtotime($lot_created_at)) . "/" . date('M', strtotime($lot_created_at)) . "/" . $lot_no."/" . $wrc_number."/" . $adaptation;

      if($sku_id != ""){
        $sku_id = base64_decode($sku_id);
        $path = $path."/" . $sku_id;
        $fileName = $wrc_number."-".$sku_id . ".zip";
      }
      // dd($fileName , $path  , $adaptation);
      
      $zip = new ZipArchive;
      if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
        if (file_exists($path)) {
          $this->addContent($zip, $path);
          $zip->close();
  
          $all_data_in_arr = array(
            'fileName' => $fileName,
            'path' => $path,
          );
          $data_array = array(
            'log_name' => 'File Manger - Shoot Edited Images Download',
            'description' => 'Shoot Lot Edited Images Download for lot_no ' . $lot_no,
            'event' => 'Shoot Lot Edited Images Download',
            'subject_type' => 'App\Models\Lots',
            'subject_id' => '0',
            'properties' => [$all_data_in_arr],
          );
          ClientActivityLog::saveClient_activity_logs($data_array);
          return response()->download($fileName)->deleteFileAfterSend(true);
        } else {
          return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
        }
      }else{
        return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
      }
    }else{
      return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, Invailid Wrc id');
    }
  }

  //Shoot lot Edited Image zip Download based on wrc id and sku code
  public function download_Shoot_lot_raw_sku ($wrc_id , $sku_id = '')
  {
    $wrc_id = base64_decode($wrc_id); 
    $lot_data_arr = Lots::leftJoin('wrc','wrc.lot_id', '=' , 'lots.id')->whereNotNull('lots.id')->
    where('wrc.id', '=', $wrc_id)->get(['lots.lot_id', 'lots.created_at' , 'wrc.wrc_id as wrc_number'])->toArray();

    if(count($lot_data_arr) > 0){
      $lot_data = $lot_data_arr[0];
      $lot_no = $lot_data['lot_id'];
      $lot_created_at = $lot_data['created_at'];
      $wrc_number = $lot_data['wrc_number'];
      
      $fileName = "Raw-".$wrc_number.".zip";
      $path =  "raw_img_directory/" . date('Y', strtotime($lot_created_at)) . "/" . date('M', strtotime($lot_created_at)) . "/" . $lot_no."/" . $wrc_number;
      
      if($sku_id != ""){
        $sku_id = base64_decode($sku_id);
        $path = $path."/".$sku_id;
        $fileName = "Raw-".$wrc_number."-".$sku_id.".zip";
      }
      $zip = new ZipArchive;
      if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
        if (file_exists($path)) {
          $this->addContent($zip, $path);
          $zip->close();
  
          $all_data_in_arr = array(
            'fileName' => $fileName,
            'path' => $path,
          );
          $data_array = array(
            'log_name' => 'File Manger - Shoot Edited Images Download',
            'description' => 'Shoot Lot Edited Images Download for lot_no ' . $lot_no,
            'event' => 'Shoot Lot Edited Images Download',
            'subject_type' => 'App\Models\Lots',
            'subject_id' => '0',
            'properties' => [$all_data_in_arr],
          );
          ClientActivityLog::saveClient_activity_logs($data_array);
          return response()->download($fileName)->deleteFileAfterSend(true);
        } else {
          return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
        }
      }else{
        return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
      }
    }else{
      return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, Invailid Wrc id');
    }
  }

  //Editing lot Raw Image zip Download
  public function download_Editing_Lot_raw($lot_id)
  {
    $lot_id = base64_decode($lot_id); // lot id
    // $lot_id = 11; // lot id
    $lot_data = EditingWrc::where('lot_id', '=' , $lot_id)->whereNotNull('raw_img_file_path')->
    get(['lot_id', 'wrc_number', 'raw_img_file_path' , 'uploaded_img_file_path'])->toArray();

    if(count($lot_data) > 0){

      $fileName = "";
      $path =  "";
      foreach ($lot_data as $key => $row) {
        $raw_img_file_path = $row['raw_img_file_path'];
        $raw_img_file_path_arr = explode('/',$raw_img_file_path);
        if($fileName == ''){
          $wrc_number = $row['wrc_number'];
          $path = str_replace("/".$wrc_number."/", '', $raw_img_file_path);
          $lot_no = $raw_img_file_path_arr[3];
          $fileName = $lot_no.".zip";
        }else{
          break;
        }
      }

      $zip = new ZipArchive;
      if ($fileName != "" && $zip->open($fileName, ZipArchive::CREATE) === TRUE) {
        if (file_exists($path)) {
          $this->addContent($zip, $path);
          $zip->close();

          $all_data_in_arr = array(
            'fileName' => $fileName,
            'path' => $path,
          );
          $data_array = array(
            'log_name' => 'File Manger - Editing Raw Images Download',
            'description' => 'Editing Lot Raw Images Download for lot_no ' . $lot_no,
            'event' => 'Editing Lot Raw Images Download',
            'subject_type' => 'App\Models\Lots',
            'subject_id' => '0',
            'properties' => [$all_data_in_arr],
          );
          ClientActivityLog::saveClient_activity_logs($data_array);
          return response()->download($fileName)->deleteFileAfterSend(true);
        } else {
          return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
        }
      }else {
        return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
      }
    }else {
      return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
    }
    
  }
  //Editing lot Raw Image zip Download
  public function download_Editing_Lot_edited($lot_id)
  {
    $lot_id = base64_decode($lot_id); // lot id
    $lot_data = EditingWrc::where('lot_id', '=' , $lot_id)->whereNotNull('uploaded_img_file_path')->
    get(['lot_id', 'wrc_number', 'raw_img_file_path' , 'uploaded_img_file_path'])->toArray();

    if(count($lot_data) > 0){
      $fileName = "";
      $path =  "";
      foreach ($lot_data as $key => $row) {
        $uploaded_img_file_path = $row['uploaded_img_file_path'];
        $raw_img_file_path_arr = explode('/',$uploaded_img_file_path);
        if($fileName == ''){
          $wrc_number = $row['wrc_number'];
          $path = str_replace("/".$wrc_number."/", '', $uploaded_img_file_path);
          $lot_no = $raw_img_file_path_arr[3];
          $fileName = $lot_no.".zip";
        }else{
          break;
        }
      }
      $zip = new ZipArchive;
      if ($fileName != "" && $zip->open($fileName, ZipArchive::CREATE) === TRUE) {
        if (file_exists($path)) {
          $this->addContent($zip, $path);
          $zip->close();

          $all_data_in_arr = array(
            'fileName' => $fileName,
            'path' => $path,
          );
          $data_array = array(
            'log_name' => 'File Manger - Editing Images Download',
            'description' => 'Editing Lot Edited Images Download for lot_no ' . $lot_no,
            'event' => 'Editing Lot Edited Images Download',
            'subject_type' => 'App\Models\Lots',
            'subject_id' => '0',
            'properties' => [$all_data_in_arr],
          );
          ClientActivityLog::saveClient_activity_logs($data_array);
          return response()->download($fileName)->deleteFileAfterSend(true);
        } else {
          return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
        }
      }else {
        return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
      }
    }else {
      return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
    }
    
  }

  //Editing lot Edited Image zip Download based on wrc id
  public function download_Editing_lot_Edited_wrc($wrc_id)
  {

    $wrc_id = base64_decode($wrc_id); // lot id
    $lot_data = EditingWrc::where('id', '=' , $wrc_id)->whereNotNull('uploaded_img_file_path')->
    get(['lot_id', 'wrc_number', 'raw_img_file_path' , 'uploaded_img_file_path'])->toArray();
    
    if(count($lot_data) > 0){
      $fileName = "";
      $path =  "";
      foreach ($lot_data as $key => $row) {
        $uploaded_img_file_path = $row['uploaded_img_file_path'];
        $raw_img_file_path_arr = explode('/',$uploaded_img_file_path);
        if($fileName == ''){
          $path = $uploaded_img_file_path;
          $wrc_number = $raw_img_file_path_arr[4];
          $fileName = $wrc_number.".zip";
        }else{
          break;
        }
      }
      $zip = new ZipArchive;
      if ($fileName != "" && $zip->open($fileName, ZipArchive::CREATE) === TRUE) {
        if (file_exists($path)) {
          $this->addContent($zip, $path);
          $zip->close();

          $all_data_in_arr = array(
            'fileName' => $fileName,
            'path' => $path,
          );
          $data_array = array(
            'log_name' => 'Editing Images Download',
            'description' => 'Editing Lot Edited Images Download for Wrc Number ' . $wrc_number,
            'event' => 'Editing Lot Edited wrc Images Download',
            'subject_type' => 'App\Models\Lots',
            'subject_id' => '0',
            'properties' => [$all_data_in_arr],
          );
          ClientActivityLog::saveClient_activity_logs($data_array);
          return response()->download($fileName)->deleteFileAfterSend(true);
        } else {
          return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
        }
      }else {
        return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
      }
    }else {
      return view('clients.ClientUserManagement.File_not_exist')->with('massage', 'Sorry, File does not exist in our server or may have been deleted!');
    }
    
  }
}

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
}

<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\EditingWrc;
use App\Models\Lots;
use Illuminate\Http\Request;
use ZipArchive;

class Files_controller extends Controller
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

	private function formatBytes($bytes, $precision = 2)
	{
		$units = ['B', 'KB', 'MB', 'GB', 'TB'];

		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);

		$bytes /= (1 << (10 * $pow));

		return round($bytes, $precision) . ' ' . $units[$pow];
	}

	//Editing lot Raw Image zip Download
	public function Editing_file_size(Request $request)
	{
		$id = $request['id'];
		$service = $request['service'];
		$img_type = $request['img_type'];

		$fileName = "";
		$ReadableSize = $path =  "";
		$is_file_get = false;

		if($service == 'lot'){
			$lot_id = base64_decode($id);
			if($img_type == 'Edited'){
				$lot_data = EditingWrc::where('lot_id', '=', $lot_id)->whereNotNull('uploaded_img_file_path')->get(['lot_id', 'wrc_number', 'raw_img_file_path', 'uploaded_img_file_path'])->toArray();
			}

			if (count($lot_data) > 0) {
				foreach ($lot_data as $key => $row) {
					$uploaded_img_file_path = $row['uploaded_img_file_path'];
					$raw_img_file_path_arr = explode('/', $uploaded_img_file_path);
					if ($fileName == '') {
						$wrc_number = $row['wrc_number'];
						$path = str_replace("/" . $wrc_number . "/", '', $uploaded_img_file_path);
						$lot_no = $raw_img_file_path_arr[3];
						$fileName = $lot_no . ".zip";
					} else {
						break;
					}
				}
			}
		}
		else if($service == 'wrc'){
			$wrc_id = base64_decode($id);
			if($img_type == 'Edited'){
				$lot_data = EditingWrc::where('id', '=', $wrc_id)->whereNotNull('uploaded_img_file_path')->get(['lot_id', 'wrc_number', 'raw_img_file_path', 'uploaded_img_file_path'])->toArray();
			}
	
			if (count($lot_data) > 0) {
				foreach ($lot_data as $key => $row) {
					$uploaded_img_file_path = $row['uploaded_img_file_path'];
					$raw_img_file_path_arr = explode('/', $uploaded_img_file_path);
					if ($fileName == '') {
						$wrc_number = $row['wrc_number'];
						$path = $uploaded_img_file_path;
						$fileName = $wrc_number . ".zip";
					} else {
						break;
					}
				}
			}
		}
		// dd( $fileName , $path , $request->all());


		$zip = new ZipArchive;
		if ($fileName != "" && $zip->open($fileName, ZipArchive::CREATE) === TRUE) {
			if (file_exists($path)) {
				$this->addContent($zip, $path);
				$zip->close();
				$fileSize = filesize($fileName);
				$is_file_get = true;
				unlink($fileName);
				$ReadableSize = $this->formatBytes($fileSize);
			} 
		} 

		$response = array('is_file_get' => $is_file_get, 'ReadableSize' => $ReadableSize );
		echo json_encode($response,true);
	}

//Shoot lot Raw Image zip Download
public function Shoot_file_size(Request $request)
{
	$id = $request['id'];
	$service = $request['service'];
	$img_type = $request['img_type'];

	$fileName = "";
	$ReadableSize = $path =  "";
	$is_file_get = false;

	if($service == 'lot'){
		$lot_id = base64_decode($id);
		$lot_data_arr = Lots::where('id', $lot_id)->get(['lot_id as lot_number', 'created_at'])->toArray();
		
		if (count($lot_data_arr) > 0) {				
			$lot_data = $lot_data_arr[0];
			$lot_no = $lot_data['lot_number'];
			$lot_created_at = $lot_data['created_at'];

			if($img_type == 'Edited'){
				$path =  "edited_img_directory/" . date('Y', strtotime($lot_created_at)) . "/" . date('M', strtotime($lot_created_at)) . "/" . $lot_no;
				$fileName = $lot_no . ".zip";
			}
		}
	}else if($service == 'wrc'){
		$wrc_id = base64_decode($id);

		$lot_data_arr = Lots::leftJoin('wrc','wrc.lot_id', '=' , 'lots.id')->whereNotNull('lots.id')->
    where('wrc.id', '=', $wrc_id)->get(['lots.lot_id', 'lots.created_at' , 'wrc.wrc_id as wrc_number'])->toArray();
		$lot_data = $lot_data_arr[0];
		$lot_no = $lot_data['lot_id'];
		$lot_created_at = $lot_data['created_at'];
		$wrc_number = $lot_data['wrc_number'];
		
		$fileName = $wrc_number . ".zip";
		$path =  "edited_img_directory/" . date('Y', strtotime($lot_created_at)) . "/" . date('M', strtotime($lot_created_at)) . "/" . $lot_no."/" . $wrc_number;
	}
	// dd( $fileName , $path , $request->all());

	// dd($request->all());

	$zip = new ZipArchive;
	if ($fileName != "" && $zip->open($fileName, ZipArchive::CREATE) === TRUE) {
		if (file_exists($path)) {
			$this->addContent($zip, $path);
			$zip->close();
			$fileSize = filesize($fileName);
			$is_file_get = true;
			unlink($fileName);
			$ReadableSize = $this->formatBytes($fileSize);
		} 
	} 
	$response = array('is_file_get' => $is_file_get, 'ReadableSize' => $ReadableSize );
	echo json_encode($response,true);
}

}

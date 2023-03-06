<?php

namespace App\Http\Controllers;

use App\Models\EditingAllocation;
use App\Models\EditingWrc;
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
        $file_path_arr = explode('/',$file_path);
        $fileName = $file_path_arr[4]. ".zip";
        $zip = new ZipArchive;
        if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
            $this->addContent($zip, $file_path);
            $zip->close();
            return response()->download($fileName)->deleteFileAfterSend(true);
        }
    }


}

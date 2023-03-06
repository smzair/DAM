<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Skus;
use App\Models\editorSubmission;
use App\Models\Wrc;
use File;
use ZipArchive;


class guest extends Controller
{
    public function firstAngleDownload(Request  $request, $wrc_id){
        $wrcId=base64_decode($wrc_id);
        $wrcinfo= Wrc::getwrcInfo(['id'=>$wrcId,'single'=>true]);
        $adaptation_1=$wrcinfo->adaptation_1;

        $submissions = editorSubmission::SubmissionInfo($filter = ['wrc_id'=>$wrcId,'qc'=> '1', 'adaptation' => $adaptation_1]);
        $finalSkus = array();
       
        foreach($submissions as $submission){
            $filename = $submission->filename;
            $filename = explode('.', $filename);
            $filename = $filename[0];
            $filename = explode('_', $filename);
            $fileNameSeq = $filename[1];

            if($fileNameSeq == 1){
                $finalSkus[$submission->sku_id] = $submission; 
            }
        }
        if(count($finalSkus) > 0){

            foreach($finalSkus as $sku){
            $targetPath = "downloads-first-angle/" . $sku->lot_id . "/" . $sku->wrc_id . "/" . $sku->adaptation . "/" . $sku->sku_code ;
            
            \File::makeDirectory($targetPath, $mode = 0777, true, true);
            
            $sourcePath= "edited_img_directory/". date('Y', strtotime($sku->created_at)) . "/" . date('M', strtotime($sku->created_at)) . "/" . $sku->lot_id . "/" . $sku->wrc_id . "/" . $sku->adaptation . "/" . $sku->sku_code . "/" . $sku->filename;
            
            \File::copy($sourcePath, $targetPath."/".$sku->filename);

         }
     }

     $fileName = $sku->wrc_id . ".zip";

     $zip = new ZipArchive;

     if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
            //echo "$path/$skucode";die; 
            // $files = File::files(public_path("$path/$skucode"));

            // foreach ($files as $key => $value) {

            //     $relativeNameInZipFile = basename($value);

            //     $zip->addFile($value, $relativeNameInZipFile);

            // }
        $this->addContent($zip, "downloads-first-angle/".$sku->lot_id . "/" . $sku->wrc_id  );
        $zip->close();

        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}



public function fullAngleDownload(Request  $request, $wrc_id){
    $wrcId=base64_decode($wrc_id);
    $wrcinfo= Wrc::getwrcInfo(['id'=>$wrcId, 'single' => true]);
    $submissions = editorSubmission::SubmissionInfo($filter = ['wrc_id'=>$wrcId,'qc'=> '1','single'=>true]);
    $fileName = $wrcinfo->wrc_id . ".zip";

    $path=  "edited_img_directory/". date('Y', strtotime($submissions->created_at)) . "/" . date('M', strtotime($submissions->created_at)) . "/" . $submissions->lot_id . "/" . $wrcinfo->wrc_id ;


    $zip = new ZipArchive;

    if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
        $this->addContent($zip, $path);
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

}

<?php

namespace App\Http\Controllers;

use App\Models\ClientActivityLog;
use App\Models\Lots;
use App\Models\Skus;
use App\Models\uploadraw;
use App\Models\Wrc;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Sku;
use ZipArchive;

class clientFileManager extends Controller
{
    function showPage(Request $request)
    {
        // Get the previous URL from the session
        $previousUrl = $request->session()->get('previous_url');
        // Store the current URL as the previous URL
        $request->session()->put('previous_url', $request->url());
        // Return the view for the current page, passing the previous URL to the view
        return $previousUrl;
    }

    public function clientRawImagesYear(Request $request){

        $monthly_data = array();
        $year = '';
        $lotData = array();
        $wrc_data = array();
        $sku_data = array();
        $file_data = array();

        $previousUrl = $this->showPage($request);

        $logged_in_user_id = Auth::id();
        // get all created year of upload raw images
        $all_years = uploadraw::select(DB::raw('YEAR(created_at) as year'))
                    ->orderBy('created_at', 'DESC')
                    ->groupBy('year')
                    ->get();
        // dd($all_years);
        if($all_years != null){
            $all_data_in_arr = $all_years->toArray();
        }else{
            $all_data_in_arr = [];
        }
        $data_array = array(
            'log_name' => 'File Manger - Shoot Raw', 
            'description' => count($all_data_in_arr).' Years Listed',
            'event' => 'Shoot Raw Year List', 
            'subject_type' => 'App\Models\editorSubmission', 
            'subject_id' => '0', 
            'properties' => $all_data_in_arr, 
        );
        ClientActivityLog::saveClient_activity_logs($data_array);     
        return view('clients.ClientFileManager.commonFileManager',compact('all_years','monthly_data','year','lotData','wrc_data','sku_data','file_data','previousUrl'));
    }

    public function getAllMonthsForClientRawImages(Request $request, $id){
        $year = $id;
        $all_years = array();
        $lotData = array();
        $wrc_data = array();
        $sku_data = array();
        $file_data = array();
        $previousUrl = $this->showPage($request);


        $monthly_data = uploadraw::select(DB::raw('DATE_FORMAT(created_at, "%b") as month'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', '=', $year)
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%b")'))
            ->orderBy(DB::raw('MONTH(created_at)'), 'ASC')
            ->get();
        if($monthly_data != null){
            $all_data_in_arr = $monthly_data->pluck('month')->toArray();
        }else{
            $all_data_in_arr = [];
        }
        $data_array = array(
            'log_name' => 'File Manger - Shoot Raw image', 
            'description' => count($all_data_in_arr).' Months Listed for '.$year,
            'event' => 'Shoot Raw image Month List', 
            'subject_type' => 'App\Models\editorSubmission', 
            'subject_id' => '0', 
            'properties' => $all_data_in_arr, 
        );
        // dd($all_data_in_arr , $data_array);
        ClientActivityLog::saveClient_activity_logs($data_array); 
        return view('clients.ClientFileManager.commonFileManager',compact('monthly_data','year','all_years','lotData','wrc_data','sku_data','file_data','previousUrl'));
    }

    // get lots based on year and month
    public function clientRawImages(Request $request, $id){

        $all_years = array();
        $monthly_data = array();
        $wrc_data = array();
        $sku_data = array();
        $file_data = array();

        $dateString = $id;// date in format ex:- Oct-2022
        $date = DateTime::createFromFormat('M-Y', $dateString);
        $formattedDate = $date->format('m-Y');

        list($month, $year) = explode("-", $formattedDate);// get month and date
         $month; // Output: Three letters of month
         $year; // Output: no of year ex:- 2023

        $logged_in_user_id = Auth::id();
        $previousUrl = $this->showPage($request);

        $lotData = DB::table('users')
            ->where('users.id', $logged_in_user_id)
            ->where('users.dam_enable', '1')
            ->join('brands_user', 'brands_user.user_id', 'users.id')
            ->join('brands', 'brands.id', 'brands_user.brand_id')
            ->join('lots', function($join) use ($month, $year) {
                $join->on('lots.user_id', '=', 'brands_user.user_id')
                    ->on('lots.brand_id', '=', 'brands_user.brand_id')
                    ->whereMonth('lots.created_at', '=', $month)
                    ->whereYear('lots.created_at', '=', $year);
        })->select('lots.*')->get();
        if($lotData != null){
            $all_data_in_arr = $lotData->pluck('lot_id','id')->toArray();
        }else{
            $all_data_in_arr = [];
        }
        $data_array = array(
            'log_name' => 'File Manger - Shoot Raw images', 
            'description' => count($all_data_in_arr).' Lots Listed in '.$dateString,
            'event' => 'Shoot Raw images Lots List', 
            'subject_type' => 'App\Models\Lots', 
            'subject_id' => '0', 
            'properties' => [$all_data_in_arr], 
        );
        ClientActivityLog::saveClient_activity_logs($data_array);
        return view('clients.ClientFileManager.commonFileManager',compact('lotData','all_years','monthly_data','year','wrc_data','sku_data','file_data','previousUrl'));
    }

    //get wrc based on lot id
    public function getWrcForClientRawImages(Request $request, $id){
        $all_years = array();
        $monthly_data = array();
        $year = '';
        $lotData = array();
        $sku_data = array();
        $file_data = array();
        $lot_id = $id;
        $previousUrl = $this->showPage($request);

        $logged_in_user_id = Auth::id();
        $wrc_data = Wrc::where('lot_id',$lot_id)->where('user_id',$logged_in_user_id)->get();
        if($wrc_data != null){
            $all_data_in_arr = $wrc_data->pluck('wrc_id','id')->toArray();
        }else{
            $all_data_in_arr = '';
        }
        $data_array = array(
            'log_name' => 'File Manger - Shoot Raw Images', 
            'description' => count($wrc_data).' Wrc Data viewed for lot_id '.$lot_id,
            'event' => 'Shoot Raw Images Wrc List', 
            'subject_type' => 'App\Models\Wrc', 
            'subject_id' => '0', 
            'properties' => [$all_data_in_arr], 
        );
        ClientActivityLog::saveClient_activity_logs($data_array);
        return view('clients.ClientFileManager.commonFileManager',compact('lotData','all_years','monthly_data','year','wrc_data','sku_data','file_data','previousUrl'));
    }

    public function getSkusForClientRawImages(Request $request, $id){
        $wrc_id = $id;
        $all_years = array();
        $monthly_data = array();
        $year = '';
        $lotData = array();
        $wrc_data = array();
        $sku_data = array();
        $file_data = array();
        $previousUrl = $this->showPage($request);

        $logged_in_user_id = Auth::id();
        $sku_data = Skus::where('wrc_id',$wrc_id)->where('user_id',$logged_in_user_id)->get();

        if($sku_data != null){
            $all_data_in_arr = $sku_data->pluck('sku_code','id')->toArray();
        }else{
            $all_data_in_arr = [];
        }   
        $data_array = array(
            'log_name' => 'File Manger - Shoot Raw Images', 
            'description' => count($sku_data).' skus viewed for adaptation '.$id,
            'event' => 'Shoot Raw Images skus List', 
            'subject_type' => 'App\Models\Skus', 
            'subject_id' => '0', 
            'properties' => [$all_data_in_arr], 
        );
        ClientActivityLog::saveClient_activity_logs($data_array);
        return view('clients.ClientFileManager.commonFileManager',compact('lotData','all_years','monthly_data','year','wrc_data','sku_data','file_data','previousUrl'));

    }

    // get upload raw images based on skus id
    public function getClientUploadRawImages(Request $request, $id){
        $sku_id = $id;
        $all_years = array();
        $monthly_data = array();
        $year = '';
        $lotData = array();
        $wrc_data = array();
        $sku_data = array();
        $previousUrl = $this->showPage($request);

        $file_data = uploadraw::where('uploadraw.sku_id',$id)

        
        ->leftJoin('sku', 'sku.id', 'uploadraw.sku_id')
        ->join('wrc', function($join) {
            $join->on('wrc.id', '=', 'sku.wrc_id');
            $join->on('wrc.user_id', '=', 'sku.user_id');
            $join->on('wrc.lot_id', '=', 'sku.lot_id');
        })
        ->join('lots', function($join) {
            $join->on('lots.user_id', '=', 'wrc.user_id');
            $join->on('lots.id', '=', 'wrc.lot_id');
        })
        ->select(
            'uploadraw.*',
            'wrc.wrc_id',
            'wrc.created_at as wrc_created_at',
            'lots.lot_id',
            'sku.sku_code'
        )
        ->get();
        if($file_data != null){
            $all_data_in_arr = $file_data->pluck('filename','id')->toArray();
        }else{
            $all_data_in_arr = [];
        }   
        $data_array = array(
            'log_name' => 'File Manger - Shoot Raw Images', 
            'description' => count($file_data).' Uploaded image viewed for sku '.$id,
            'event' => 'Shoot Raw Images List', 
            'subject_type' => 'App\Models\Skus', 
            'subject_id' => '0', 
            'properties' => [$all_data_in_arr], 
        );
        ClientActivityLog::saveClient_activity_logs($data_array);
        // dd($data_array , $all_data_in_arr);
        return view('clients.ClientFileManager.commonFileManager',compact('lotData','all_years','monthly_data','year','wrc_data','sku_data','file_data','previousUrl'));
    }
    // download lot data zip folder
    public function downloadLotData(Request $request, $id){ 
        // dd($id);
        $lot_id = $id; // lot id
        $lot_data = Lots::where('id',$lot_id)->first(['lot_id','created_at']);

        $lot_no = $lot_data != null ? $lot_data['lot_id'] : "-";
        $lot_created_at = $lot_data != null ? $lot_data['created_at'] : "-";

        // dd(['$lot_no', $lot_created_at]);

    
        $fileName = $lot_no . ".zip";

        $path=  "raw_img_directory/". date('Y', strtotime($lot_created_at)) . "/" . date('M', strtotime($lot_created_at)) . "/" . $lot_no ;


        $zip = new ZipArchive;

        if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
            if (file_exists($path)) {
                $this->addContent($zip, $path);
                $zip->close();
    
                return response()->download($fileName)->deleteFileAfterSend(true);
            } else {
                return abort(404, "Sorry, File does not exist in our server or may have been deleted!");
            }
        }


    }

    // download data based on year
    public function downloadYearData(Request $request, $id){ 
        // dd($id);
        $year = $id; // lot id
        $fileName = $year . ".zip";

        $path=  "raw_img_directory/". $year;


        $zip = new ZipArchive;

        if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
            if (file_exists($path)) {
                $this->addContent($zip, $path);
                $zip->close();
                return response()->download($fileName)->deleteFileAfterSend(true);
            } else {
                return abort(404, "Sorry, File does not exist in our server or may have been deleted!");
            }
        }


    }

    // download data based on wrc
    public function downloadDataBasedOnWrc(Request $request, $id){ 
        $wrc_id = $id; // lot id
        $wrc_data = Wrc::where('id',$wrc_id)->first(['wrc_id','created_at','lot_id']);
        $lot_id = $wrc_data != null ? $wrc_data['lot_id'] : "-";

        $wrc_no = $wrc_data != null ? $wrc_data['wrc_id'] : "-";
        $wrc_created_at = $wrc_data != null ? $wrc_data['created_at'] : "-";

        $lot_data = Lots::where('id',$lot_id)->first(['lot_id','created_at']);
        $lot_no = $lot_data != null ? $lot_data['lot_id'] : "-";

        $fileName = $wrc_no . ".zip";

        $path=  "raw_img_directory/". date('Y', strtotime($wrc_created_at)) . "/" . date('M', strtotime($wrc_created_at)) . "/" . $lot_no."/". $wrc_no ;


        $zip = new ZipArchive;

        if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
            if (file_exists($path)) {
                $this->addContent($zip, $path);
                $zip->close();
    
                return response()->download($fileName)->deleteFileAfterSend(true);
            } else {
                return abort(404, "Sorry, File does not exist in our server or may have been deleted!");
            }
        }


    }

    // download data based on month
    public function downloadDataBasedOnMonth(Request $request, $id){ 
        // dd($id);
        $year_month = $id; // lot id
        list($month, $year) = explode("-", $year_month);// get month and date
        $month; // Output: Three letters of month
        $year; // Output: no of year ex:- 2023
        $fileName = $year ."-".$month .".zip";

        $path=  "raw_img_directory/". $year."/".$month;


        $zip = new ZipArchive;

        if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
            if (file_exists($path)) {
                $this->addContent($zip, $path);
                $zip->close();
                return response()->download($fileName)->deleteFileAfterSend(true);
            } else {
                return abort(404, "Sorry, File does not exist in our server or may have been deleted!");
            }
        }


    }

    // download data based on sku
    public function downloadDataBasedOnSku(Request $request, $id){ 

        $sku_id = $id;
        $sku_data = Skus::where('id',$sku_id )->first(['lot_id','wrc_id','sku_code']);
        // dd($sku_id);
        $sku_code = $sku_data != null ? $sku_data['sku_code'] : "-";
        $lot_id = $sku_data != null ? $sku_data['lot_id'] : "-";
        $wrc_id = $sku_data != null ? $sku_data['wrc_id'] : "-";

        $wrc_data = Wrc::where('id',$wrc_id)->first(['wrc_id','created_at','lot_id']);

        $wrc_no = $wrc_data != null ? $wrc_data['wrc_id'] : "-";
        $wrc_created_at = $wrc_data != null ? $wrc_data['created_at'] : "-";

        $lot_data = Lots::where('id',$lot_id)->first(['lot_id','created_at']);
        $lot_no = $lot_data != null ? $lot_data['lot_id'] : "-";

        $fileName = $sku_code . ".zip";

        $path=  "raw_img_directory/". date('Y', strtotime($wrc_created_at)) . "/" . date('M', strtotime($wrc_created_at)) . "/" . $lot_no."/". $wrc_no."/". $sku_code ;


        $zip = new ZipArchive;

        if ($zip->open($fileName, ZipArchive::CREATE) === TRUE) {
            if (file_exists($path)) {
                $this->addContent($zip, $path);
                $zip->close();
    
                return response()->download($fileName)->deleteFileAfterSend(true);
            } else {
                return abort(404, "Sorry, File does not exist in our server or may have been deleted!");
            }
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

    public function commonSearch(Request $request){
        // dd($request['query']);
        $all_years = array();
        $monthly_data = array();
        $year = '';
        $lotData = array();
        $wrc_data = array();
        $sku_data = array();
        $file_data = array();
        $logged_in_user_id = Auth::id();
        $previousUrl = null;

        $searchValue = $request['query'];

        // dd( $searchValue);
        $year = 0000;// need to get dynamic 

        $all_years = uploadraw::select(DB::raw('DATE_FORMAT(created_at, "%Y") as year'))
                    ->whereRaw('DATE_FORMAT(created_at, "%Y") LIKE ?', ['%' . $searchValue . '%'])
                    ->orderBy('created_at', 'DESC')
                    ->groupBy('year')
                    ->get(['year']);

        $monthly_data = uploadraw::select(DB::raw('DATE_FORMAT(created_at, "%b") as month'), DB::raw('COUNT(*) as total'))
                    ->where(function($query) use ($searchValue) {
                        if ($searchValue) {
                            $query->where(DB::raw('UPPER(DATE_FORMAT(created_at, "%b"))'), 'LIKE', '%'.strtoupper($searchValue).'%');
                        }
                    })
                    ->groupBy(DB::raw('DATE_FORMAT(created_at, "%b")'))
                    ->orderBy(DB::raw('MONTH(created_at)'), 'ASC')
                    ->get();


        $lotData = DB::table('users')
            ->where('users.id', $logged_in_user_id)
            ->where('users.dam_enable', '1')
            ->join('brands_user', 'brands_user.user_id', 'users.id')
            ->join('brands', 'brands.id', 'brands_user.brand_id')
            ->join('lots', function($join) {
                $join->on('lots.user_id', '=', 'brands_user.user_id')
                    ->on('lots.brand_id', '=', 'brands_user.brand_id');
            })
            ->where('lots.lot_id', 'LIKE', '%'.$searchValue.'%')
            ->select('lots.lot_id','lots.id')
            ->get();

        $wrc_data = Wrc::where('wrc.wrc_id', 'LIKE', '%'.$searchValue.'%')->where('user_id',$logged_in_user_id)->get();
        $sku_data = Skus::where('sku.sku_code', 'LIKE', '%'.$searchValue.'%')->where('user_id',$logged_in_user_id)->get();

        // pre($all_years);
        // dd( $lotData);

        $file_data = uploadraw::leftJoin('sku', 'sku.id', 'uploadraw.sku_id')
        ->join('wrc', function($join) {
            $join->on('wrc.id', '=', 'sku.wrc_id');
            $join->on('wrc.user_id', '=', 'sku.user_id');
            $join->on('wrc.lot_id', '=', 'sku.lot_id');
        })
        ->join('lots', function($join) {
            $join->on('lots.user_id', '=', 'wrc.user_id');
            $join->on('lots.id', '=', 'wrc.lot_id');
        })
        ->select(
            'uploadraw.*',
            'wrc.wrc_id',
            'wrc.created_at as wrc_created_at',
            'lots.lot_id',
            'sku.sku_code'
        )
        ->where('uploadraw.filename', 'LIKE', '%'.$searchValue.'%')
        ->get();
        // dd($file_data);

          
        return view('clients.ClientFileManager.commonFileManager',compact('lotData','all_years','monthly_data','year','wrc_data','sku_data','file_data','previousUrl'));
    }

    

    
}

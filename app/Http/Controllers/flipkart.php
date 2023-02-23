<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use App\Models\Lots;
use App\Models\Wrc;
use App\Models\flipkart_editing;
use DB;
use Storage;
use Session;
use Carbon\Carbon;

class flipkart extends Controller
{

    public function index(){

        return view('clients.upimg');
    }

    public function download(){

        $flipkart_data = flipkart_editing::getFlipInfo(['group'=>true]);
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
            $totalImgCount[$index]['status']= $flip->fwrc_done;
            $totalImgCount[$index]['file']= $flip->sentFilename;
        }
        return view('clients.download',compact('totalImgCount'));

    }

    public function wrcComment(Request $request){

        $id = $request->wrc_id;

        $html = view('clients.dc',compact('id'));

        return $html;



    }

    public function wrcsaveComment(Request $request){
        $id = $request->wrc_id;
        $comment = $request->comment;
        $wrc = Wrc::findOrFail($id);

        $wrc->wrc_c=$comment;
        $wrc->save();

        $request->session()->put('message', 'Comment Saved Successfully');

        return redirect('/Downloads');
    }

    public function profile(){



        return view('clients.profile');

    }

     public function track(Request $request){
        
        $id = $request->id;
        $track = flipkart_editing::getFlipInfo(['group'=>true,'wrc_id' => $id])->first();
        $wrcs = flipkart_editing::where('wrc_id','=',$id)->sum('imageCount');

$remarks = $track->remarks;

$comments = $track->wrc_c;

        return view('clients.track',compact('track','wrcs','remarks','comments'));

    }

    public function uploadZip(Request $request){

        $count = $request->imageCount;
        $remarks = $request->remarks;
        $s_type = "ED";
        $Lot = Lots::latest()->first();
        $id = $Lot->id;
        $c_short = "FL";
        $short_name = "FL";
        $user_id = 77;
        $brand_id = 16 ;

        $lotId = 'ODN' . date('m') . date('Y') . "-" . $c_short . $short_name . $s_type . $id+1;

        $data = Lots::where(['s_type' => "ED",'user_id' => $user_id])
        ->whereMonth('created_at',Carbon::now()->month)->get()->first();

//////////////////////////////

        if($data != null){
            $available_ids = $data->id;
        }else{
            $available_ids = 0;
        }

//////////////////////////////



//////////////////////////////

        if($available_ids != 0){

            echo "data found";

            $lastLot = Lots::where(['s_type' => "ED",'user_id' => $user_id])
            ->whereMonth('created_at',Carbon::now()->month)->latest()->get()->first();

            $id = $lastLot->id;
            $wrcs = Wrc::where(['lot_id' => $id])->get();
            $wrcCount = count($wrcs);
            $wrcNumber = $c_short . $short_name . $s_type . $id . date('d') .'-' .chr($wrcCount + 65);

            $todaywrcs = Wrc::whereDate('created_at',Carbon::now())->get()->count();


//////////////////////////////

            if($todaywrcs == 0){

                $Wrc = new Wrc();
                $Wrc->user_id = $user_id;
                $Wrc->brand_id = $brand_id;
                $Wrc->lot_id = $id;
                $Wrc->wrc_id = $wrcNumber;
                $Wrc->commercial_id = 35;
                $Wrc->save();

                echo "wrc created";

            }else{

                echo "wrc not created";

            }

//////////////////////////////


        }else{

            echo "data not found";

            $Lot = new Lots();
            $Lot->s_type = $s_type;
            $Lot->user_id = $user_id;
            $Lot->brand_id = 16;
            $Lot->lot_id = $lotId;
            $Lot->save();

            $latestId = $Lot->id;
            $wrcs = Wrc::where(['lot_id' => $latestId])->get();
            $wrcCount = $wrcs->count();
            $wrcNumber = $c_short . $short_name . $s_type . $latestId. date('d') .'-' . chr($wrcCount + 65);

            $Wrc = new Wrc();
            $Wrc->user_id = $user_id;
            $Wrc->brand_id = $brand_id;
            $Wrc->lot_id = $latestId;
            $Wrc->wrc_id = $wrcNumber;
            $Wrc->commercial_id = 35;
            $Wrc->save();

        }
//////////////////////////////

        $lastLotno = Lots::where(['s_type' => "ED",'user_id' => $user_id])
        ->whereMonth('created_at',Carbon::now()->month)->latest()->get()->first();

        $latestId = $lastLotno->id;

        $thislotId = $lastLotno->lot_id;

        $wrcs = Wrc::where(['lot_id' => $latestId])->latest()->get()->first();
        $wrcsId = $wrcs->id;


        $filenamewithextension = $request->file('zip')->getClientOriginalName();

        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

        //get file extension
        $extension = $request->file('zip')->getClientOriginalExtension();

        //filename to store
        $filenametostore = $filename.'_'.uniqid().'.'.$extension;


        $flipkart_data =  new flipkart_editing();
        $flipkart_data->lot_id = $latestId;
        $flipkart_data->wrc_id = $wrcsId;
        $flipkart_data->imageCount = $count;
        $flipkart_data->recivedFilename = $filenametostore;   
        $flipkart_data->remarks = $remarks;
        $flipkart_data->save();

  $id=$flipkart_data->id;

   $files =flipkart_editing::where('id','=',$id)->get()->first();

        $filePath = "Flipkart/ClientUploads/"  . date('Y', strtotime($files->created_at)) . "/" . date('M', strtotime($files->created_at)) . "/". date('d', strtotime($files->created_at)) . "/". $thislotId."/".$wrcNumber."/";


       
       

       $receiver = new FileReceiver('zip', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            return 'Unable to uplaod Zip Successfully';
                   }

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $disk = Storage::disk('ftp');
            $path = $disk->putFileAs($filePath , $file, $filenametostore);

            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => asset('storage/' . $path),
                'filename' => $filenametostore
            ];
        }
 $request->session()->put('message', 'Zip Uploaded Successfully');
        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    

    }

/**
 * Create unique filename for uploaded file
 * @param UploadedFile $file
 * @return string
 */

public function fileEDownload(Request $request){

    $wrcId = $request->wrc_id; 
    $allFiles =flipkart_editing::where('wrc_id','=',$wrcId)->get();

    $all = [];

    foreach($allFiles as $file){
        $index = $file->id;
        $lotId = Lots::where('id','=',$file->lot_id)->get()->first();
        $wrcId = wrc::where('id','=',$file->wrc_id)->get()->first();
        $path = "Flipkart/EditorUploads/"  . date('Y', strtotime($file->created_at)) . "/" . date('M', strtotime($file->created_at)) . "/". date('d', strtotime($file->created_at)) . "/";
        $all[$index]['filename']= $file->sentFilename;
        $all[$index]['count']= $file->imageCount;
        $all[$index]['updated_at']= $file->updated_at;
        $all[$index]['filepath'] =  $path . $lotId->lot_id . "/". $wrcId->wrc_id . "/". $file->sentFilename;
    }
    $sr=1;
    $html = view('clients.edown',compact('all','sr'));
    return $html;
}

}
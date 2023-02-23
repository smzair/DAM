<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lots;
use App\Models\Wrc;
use App\Models\DB;
use App\Models\Commercials;
use App\Models\LotsStatus;
use App\Models\WrcStatus;   
use App\Models\Skus;
use App\Models\skusStatus;
use App\Mail\wrcNotify;
use Mail;

class wrcController extends Controller {

    public function index() {
        $users = User::latest()->get();
        
        return view('Wrc.createwrc', compact('users'));
    }

    public function getbrand(Request $request) {
        $brands = User::getUserInfo(['user_id' => $request->user_id]);
        $html = '<option value = "">Please Select</option>';

        foreach ($brands as $brand) {
            $html .= '<option value="' . $brand->brand_id . '" >' . $brand->brand_name . '</option>';
        }

        return response()->json(['html' => $html]);
    }

    public function getlots(Request $request) {

        $user_id = $request->user_id;
        $brand_id = $request->brand_id;

        $lots = Lots::getlotinfo(['user_id' => $user_id, 'brand_id' => $brand_id,'inwarding_status' => '1']);

        $lotsHtml = '<option value = "">Please Select</option>';

        foreach ($lots as $lot) {
            $lotsHtml .= '<option value="' . $lot->id . '" >' . $lot->lot_id . '</option>';
        }

        $coms = Commercials::where(['user_id' => $user_id, 'brand_id' => $brand_id])->orderby('product_category')->get();

        $comsHtml = '<option value = "">Please Select</option>';

        foreach ($coms as $com) {
            $comsHtml .= '<option value="' . $com->id . '" >' . $com->product_category . " | " . $com->type_of_shoot . " | " . $com->type_of_clothing . " | " . $com->gender ." | " . $com->commercial_value_per_sku . " | " . $com->adaptation . '</option>';
        }

        return response()->json(['lots_html' => $lotsHtml, 'coms_html' => $comsHtml]);
    }

    public function getCom(Request $request) {

        $user_id = $request->user_id;
        $brand_id = $request->brand_id;
        $lot_id = $request->lot_id;
        $com_id = $request->com_id;
        $comInfo = Commercials::where(['id' => $com_id])->first();

        $wrcs = Wrc::where(['lot_id' => $lot_id])->get();
        $wrcCount = $wrcs->count();
        $lotInfo = Lots::getlotinfo(['lot_id' => $lot_id, 'single' => true]);
        $wrcNumber = $lotInfo->c_short . $lotInfo->short_name . $lotInfo->s_type . $lotInfo->id . '-' . chr($wrcCount + 65);
        $html = view('Wrc.dwrc', compact('comInfo', 'wrcNumber'));
        return $html;
    }

    public function View() {

        $wrcs = Wrc::getwrcInfo($filter = []);
        return view('Wrc.viewwrc', compact('wrcs'));
    }


    public function clientAR() {

        $wrcs = Wrc::getwrcInfo($filter = ['wrc_current_AR' => TRUE]);
        return view('Wrc.clientAR', compact('wrcs'));
    }


    public function getRejection(Request $request) {

        $reject = $request->reject;
        $wrc = $request->wrc;

        return view('Wrc.dynamicRem', compact('reject', 'wrc'));
    }


    public function Clientapproval(Request $request) {


       $id = $request->wrc;
       $client_AR = $request->approved;

       $wrc = Wrc::findOrFail($id);
       $wrc->Client_AR = $client_AR;

       $wrc->save();

       $request->session()->put('message', 'Wrc Approved Registered Successfully');

   }

   public function Clientinvoice(Request $request) {

       $wrc = $request->wrc;

       return view('Wrc.invoice-dynamic', compact('wrc'));

   }


   public function Rejectcomment(Request $request) {

       $id = $request->wrc_id;
       $client_AR = $request->reject;
       $reason = $request->rejection_reason;
       $wrc = Wrc::findOrFail($id);
       $wrc->Client_AR = $client_AR;
       $wrc->reason = $reason;
       $wrc->save();

       $request->session()->put('message', 'Wrc Rejected Registered Successfully');

   }



   public function ClientinvoiceSave(Request $request) {

       $id = $request->wrc;
       $invoiceNo = $request->invoiceInput;
       $wrc = Wrc::findOrFail($id);
       $wrc->Invoice_no = $invoiceNo;
       $wrc->save();


       $request->session()->put('message', 'Wrc Invoice Number Registered Successfully');

   }

   public function invoiceNo() {

    $wrcs = Wrc::getwrcInfo($filter = []);
    $collection=[];

    foreach($wrcs as $wrc){
      $id=$wrc->id;
      $collection[$id]['wrc'] = $wrc;
      $collection[$id]['sku_count']= count(Skus::where('wrc_id','=',$id)->where('status','=',1)->get());
      $collection[$id]['total_com'] = $collection[$id]['sku_count']*$wrc->com;
  }

  $collections = json_decode(json_encode($collection), true);
  return view('Wrc.invoiceno', compact('collections'));
}


public function uSku(Request $request){
    $lotId = $request->lot;
    $handle = fopen($_FILES['skusheet']['tmp_name'], "r");
    $header = true;
    $notfound = [];
    $skuFound = [];
    $skuFoundmatched = [];
    $com_id = $request->com;
    $skuFoundnotmatched = [];
    $comInfo = Commercials::where(['id' => $com_id])->first();
    $category = $comInfo->product_category;
    $type_of_clothing = $comInfo->type_of_clothing;
    $gender = $comInfo->gender;
    

    while ($csvLine = fgetcsv($handle, 1000, ",")) {
        if ($header) {
            $header = false;
        } else{
            $skuObj[] = $csvLine[0];
        }  
    }

    foreach($skuObj as $sku){
        $skuf = Skus::where('sku_code','=',$sku)->where('lot_id','=',$lotId)->first();

        if(!empty($skuf)){
            $skuFound[$sku]= $skuf;

            if($category == $skuf->category and $type_of_clothing == $skuf->type_of_clothing and $gender == $skuf->gender){

                $skuFoundmatched[$sku] = $skuf;
            }

            if($category != $skuf->category || $type_of_clothing != $skuf->type_of_clothing || $gender != $skuf->gender){

                $skuFoundnotmatched[$sku] = $skuf;
            }
            
        }

        if($skuf == NULL){

            $notfound[$sku] = $sku;


        }

    }
    

    $skus = json_decode(json_encode($skuFoundmatched), true);



    $pendingSkus = count(Skus::where(['lot_id' => $lotId, 'wrc_id' => NULL])->get());

    $sr = 1;
    $sheet = 1;
    $html = view('Wrc.Lsku', compact('skus', 'skuFoundmatched','skuFoundnotmatched','sr', 'sheet', 'pendingSkus','skuFound','notfound'));
    return $html;

    exit();

}


public function saveWrc(Request $request) {

    $data = new Wrc();
    $data->brand_id = $request->brand_id;
    $data->user_id = $request->user_id;
    $data->lot_id = $request->lot_id;
    $data->wrc_id = $request->wrc_id;
    $data->commercial_id = $request->commercial_id;
    $data->ppt_approval = $request->ppt_approval;
    $data->model_approval = $request->model_approval;
    $data->inward_sheet = $request->inward_sheet;
    $data->special_approval = $request->special_approval;
    $data->initialised = 'ready_for_plan';
    $data->status = 'inwarding_done';
    $data->save();
    $wrcId = $data->id;
    $skuIds = $request->sku_id;
    $wrcNumber = $request->wrc_id;



    $am_mail = User::getUserInfo(['user_id' => $request->user_id])->pluck('am_email');
    $inward = Lots::where(['id' => $request->lot_id])->pluck('created_at');

    foreach ($skuIds as $skuId) {
        $skus = Skus::where(['id' => $skuId])->first();
        if (!empty($skus->wrc_id)) {
            $newsku = $skus->replicate();
            $newsku->wrc_id = $wrcId;
            $newsku->current_status = 'inwarding_done';
            $newsku->save();
            $replicatedskuId = $newsku->id;
            $statusEngine = new skusStatus();
            $statusEngine->sku_id = $replicatedskuId;
            $statusEngine->status = 'inwarding_done';
            $statusEngine->save();
        } else {
            $skus->wrc_id = $wrcId;
            $skus->current_status = 'inwarding_done';
            $skus->save();
            $statusEngine = new skusStatus();
            $statusEngine->sku_id = $skuId;
            $statusEngine->status = 'inwarding_done';
            $statusEngine->save();
        }
    }
    /* send notification start */
    $creation_type = 'WrcShoot';
    $data = Wrc::find($data->id);
    $this->send_notification($data, $creation_type);
    /******  send notification end*******/  
    $request->session()->put('message', 'Wrc Created Successfully');

}


public function getWrcDetails(Request $request) {
    $user_id = $request->user_id;
    $brand_id = $request->brand_id;
    $lot_id = $request->lot_id;
    $wrcs = Wrc::getwrcInfo(['lotid' => $lot_id]);
    $wrcCount = $wrcs->count();
    $lotInfo = Lots::getlotinfo(['lot_id' => $lot_id, 'single' => true]);
    $wrcNumber = $lotInfo->c_short . $lotInfo->short_name . $lotInfo->s_type . $lotInfo->id . '-' . chr($wrcCount + 65);
    
    $lot = $lotInfo->lot_id;

    $html = view('Wrc.wrchead', compact('wrcNumber', 'wrcs', 'lot'));
    return $html;
}


public function flatShot(Request $request){
  $id = $request->wrc_id;


  $wrc = Wrc::where(['id'=>$id])->first();
  $wrc->fl_shot = '1';
  $wrc->save();
  $com_id = $wrc->commercial_id;


  $com = Commercials::where(['id'=>$com_id])->first();
  $newcom = $com->replicate();
  $newcom->main_com = $com_id;
  $newcom->adaptation_1 = 'Myntra Premium';
  $newcom->adaptation_2 = NULL;
  $newcom->adaptation_3 = NULL;
  $newcom->adaptation_4 = NULL;
  $newcom->adaptation_5 = NULL;
  $newcom->specfic_adaptation = NULL;
  $newcom->commercial_value_per_sku='0';

  $newcom->save();
  $ncomId = $newcom->id;


  $newwrc = $wrc->replicate();
  $newwrc->wrc_id = $wrc->wrc_id .'-FL'; 
  $newwrc->commercial_id=$ncomId;
  $newwrc->fl_shot='1';
  $newwrc->save();

  $nwrcId = $newwrc->id;

  $skus = Skus::where(['wrc_id' => $id])->get();
  foreach ($skus as $sku) {
    $newsku = $sku->replicate();
    $newsku->wrc_id = $nwrcId;
    $newsku->current_status = 'inwarding_done';
    $newsku->save();
}



return 'success';

}



public function moodShot(Request $request){
    $id = $request->wrc_id;
    pr($id,1);
}


public function getComsku(Request $request) {
    $type_of_shoot = '';
    $lotId = $request->lot_id;
    $com_id = $request->com_id;
    if ($com_id != 0) {
        $comInfo = Commercials::where(['id' => $com_id])->first();
        $category = $comInfo->product_category;
        $type_of_shoot = $comInfo->type_of_shoot;
        $type_of_clothing = $comInfo->type_of_clothing;
        $gender = $comInfo->gender;
        $primary_adaptation = $comInfo->adaptation_1;
    }

    $skus = Skus::where('lot_id', '=', $lotId)->groupBy('lot_id', 'sku_code')->get(); 
    $pendingSkus = count(Skus::where(['lot_id' => $lotId, 'wrc_id' => NULL])->groupBy('sku_code')->get());

    $sr = 1;
    $sheet = 0;
    $html = view('Wrc.Lsku', compact('skus', 'sr','sheet','type_of_shoot', 'pendingSkus'));
    return $html;
}

}

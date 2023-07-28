<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Brands;
use App\Models\Commercials;
use App\Models\performceInforma;
use App\Models\PerformaItem;
use App\Models\preInvoice;
use App\Models\invoiceMOD;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Http\Response;
use NumberFormatter;
use DB;

class invoicingController extends Controller
{
    
    public function PI(){
        
          $brands = Brands::latest()->get();
        return view('Invoicing.performa',['brands' =>$brands ]);
    }
    
      public function findUser(Request $request) {

        $brand = $request->brandid;
        $user = User::getUserInfo(['brand_id' => $brand]);
     
        $userin = '<option value="" disabled selected >Select Company</option>';

        foreach ($user as $users) {
            $userin .= '<option value="' . $users->id . '" >' . $users->Company . '</option>';
        }

        return response()->json(['wrc_html' => $userin]);
    }

    public function findDetails(Request $request){
      $id = $request->user_id;
         $detail = User::find($id);
$html='';
if($request->In != NUll){
    
     $brand_id = $request->brandid;
  $invoice =  preInvoice::getperItem();
  $QcList = collect($invoice)->where('invoice_group_id','=','0')->where('user_id', '=', $id)->where('brand_id','=',$brand_id);

$html =  view('submission.invoice',compact('QcList'))->render();
//pr($invoice,1);
}

        return response()->json([
          'data' => $detail,
          'html' =>$html
        ]);
    }
    
    public function payDetails(Request $request){
        
        $List = [];
        foreach($request->wrc as $wrc){
             $invoice =  preInvoice::getperItem();
  $List[$wrc] = collect($invoice)->where('invoice_group_id','=','0')->where('wrc_id', '=', $wrc);

        } 
        
        $inwardTotal = 0;
$linkTotal = 0;

foreach ($List as $item) {
    foreach ($item as $invoice) {
        $inwardTotal += $invoice['com'] * $invoice['Inward_count'];
        $linkTotal += $invoice['com'] * $invoice['link_qty'];
    }
}

return response()->json([
          'inwardTotal' => $inwardTotal,
          'linkTotal' => $linkTotal,
            ]);
    
        // dd($inwardTotal,$linkTotal);
       

    }
    
    public function findcom(Request $request){
        $dataID = $request->service;
         $userId = $request->user_id;
         $brandId = $request->brand_id;
        
        $comsHtml = '<option value = "">Please Select</option>';
        
        $dropHtml = '<option value="" >Please Select</option>';
         if($dataID == 1 ){
             
              $coms = Commercials::where(['user_id' => $userId, 'brand_id' => $brandId])->orderby('product_category')->get();
              
               foreach ($coms as $com) {
            $comsHtml .= '<option  data-id="'.$com->commercial_value_per_sku.'" value="' . $com->id . '" >' . $com->product_category . " | " . $com->type_of_shoot . " | " . $com->type_of_clothing . " | " . $com->gender ." | " . $com->commercial_value_per_sku . " | " . $com->adaptation . '</option>';
        }
        $dropHtml .= '<option value="998382" >Photoshoots | 998382</option>';   
   
         }elseif($dataID == 2 ){
            $coms = DB::table('create_commercial')->where('user_id','=',$userId)->where('brand_id','=',$brandId)->get();
             foreach ($coms as $com) {
             $comsHtml .= '<option  data-id="'.$com->per_qty_value.'"  value="' . $com->id . '" >' . $com->project_name . " | " . $com->kind_of_work .  "| " . $com->per_qty_value . '</option>';
             }
    $dropHtml .= '<option value="998319" >Digital Marketing | 998319</option>';
        $dropHtml .= '<option value="998439" >A+ Content | 998439</option>';
    $dropHtml .= '<option value="998391" >Banners & Emailers Creations | 998391</option>';
       $dropHtml .= '<option value="998319" >Social Media Handle | 998319</option>';
         }elseif($dataID == 3 ){
              $coms = DB::table('create_commercial_catalog')->where('user_id','=',$userId)->where('brand_id','=',$brandId)->get();
             foreach ($coms as $com) {
             $comsHtml .= '<option data-id="'.$com->CommercialSKU.'" value="' . $com->id . '" >' . $com->type_of_service . " | " . $com->CommercialSKU . '</option>';
             }
        $dropHtml .= '<option value="998439" >Product Listing | 998439</option>';
        $dropHtml .= '<option value="998382" >Image Editing | 998382</option>';
        $dropHtml .= '<option value="998439" >Content writing | 998439</option>';
      
         }elseif($dataID == 4 ){
              $coms = DB::table('editors_commercials')->where('user_id','=',$userId)->where('brand_id','=',$brandId)->get();
             foreach ($coms as $com) {
             $comsHtml .= '<option  data-id="'.$com->CommercialPerImage.'" value="' . $com->id . '" >' . $com->type_of_service . " | " . $com->CommercialPerImage . '</option>';
             }
             
        $dropHtml .= '<option value="998382" >Image Editing| 998382</option>';
        
         }else{
             
         }
         
          return response()->json(['html' => $comsHtml,'drop' => $dropHtml]);
         
    }
    public function com(Request $request){
        $dataID = $request->service;
       $com= $request->com_id;

         if($dataID == 1 ){
             
              $coms = Commercials::where(['id' => $com])->first();
             
           
        $comsHtml = $coms->commercial_value_per_sku;
        
             
         }elseif($dataID == 2 ){
             $coms = DB::table('create_commercial')->where('id','=',$com)->first();
               $comsHtml = $coms->per_qty_value;
         }elseif($dataID == 3 ){
             
              $coms = DB::table('create_commercial_catalog')->where('id','=',$com)->first();
               $comsHtml = $coms->CommercialSKU;
         }elseif($dataID == 4 ){
             
              $coms = DB::table('editors_commercials')->where('id','=',$com)->first();
               $comsHtml = $coms->CommercialPerImage;
         }else{
             
         }
         
         return response()->json(['html' => $comsHtml]);
          
         
    }
   public function save(Request $request){
    
    // dd($request);
       
    $userId = $request->user_id;
    $brandId = $request->brand_id;
    $serviceId = $request->type_of_service;
    $state_name= $request->state_name;
    $state_code = $request->state_code;
    $commercial_id = $request->commercial;
    $extra_ch= $request->commercialg;
    $extra_title= $request->extratitle;
    $qtyg= $request->quantg;
    $qty = $request->quant;
    $hsn = $request->hsn_code;
    $exhsn = $request->hsn_codeg;
    $totalPrice = $request->total;
    $total = DB::table('performa')->get();
    $id = count($total) + 1;
    $pi_number = "PI/" .$id ."/". date('m')."/".date('d')."/".date("Y");

    $obj = new performceInforma();
    $obj->brand_id = $brandId;
    $obj->user_id = $userId;
    $obj->add_spoc = $request->sopc;
    $obj->state = $state_name;
    $obj->state_code = $state_code;
    $obj->pi_number = $pi_number;
    $obj->invoiceAmount = intval(filter_var($totalPrice, FILTER_SANITIZE_NUMBER_FLOAT))/100;
    $obj->save(); 
    // check if id value is set
   // dd($hsn,count($commercial_id), count($extra_ch)); // check loop count values
  if(!is_null($commercial_id)){
    for ($i = 0; $i < count($commercial_id); $i++) {
        $performaItem = new PerformaItem();
        $performaItem->performa_id = $obj->id;
        $performaItem->service_id = $serviceId[$i];
        $performaItem->extra_item = 0;
        $performaItem->ex_charge = 0;
        $performaItem->com_id = $commercial_id[$i];
        $performaItem->qty = $qty[$i];
        $performaItem->hsn_code = $hsn[$i];
        $performaItem->save();
    }
}

if(!is_null($extra_ch)){
    for ($i = 0; $i < count($extra_ch); $i++) {
        $performaItem = new PerformaItem();
        $performaItem->performa_id = $obj->id;
        $performaItem->service_id = 0;
        $performaItem->extra_item = $extra_title[$i];
        $performaItem->ex_charge = $extra_ch[$i];
        $performaItem->com_id = 0;
        $performaItem->qty = $qtyg[$i];
        $performaItem->hsn_code = 998382;
        $performaItem->save();
    }
}

      return redirect('/performaRequest');

      }
      
      public function viewRequest(){
          $list = performceInforma::getperformaInfo();
          //pr($list,1);
        
          $id = 1;
          return view('Invoicing.Requestperfoma',['list' =>$list,'id'=>$id ]);
      }
      
       public function viewappRequest(){
          $list = performceInforma::getperformaInfo()->where('approve','=',0);
     //pr($list,1);
        
          $id = 1;
          return view('Invoicing.approvalperforma',['list' =>$list,'id'=>$id ]);
      }
      public function perDetail(Request $request){
         $dataID =  $request->service;
         $performa =  $request->performa_id;
         
    $get = PerformaItem::getperformaItem(['performa' =>$performa]);

                   $performad = performceInforma::find($performa);
                   $amount = $performad->RcvdAmount;
     
         $id = 1;
         
       $html = view('Invoicing.dynamicModal',['id'=>$id,'list' =>$get ,'service' => $dataID,'performa'=>$performa,'amount'=>$amount]);
          return $html;
      }
      
      public function Piapprove($id){
          $performa = performceInforma::find($id);
          $performa->approve = "1";
          $performa->update();
          
          return "ok";
      }
      
       public function ProformaUpdate($id,$service){
           $dataID =$service;
          $performa = performceInforma::find($id);
          pr($performa,1);
          
           if($dataID == 1 ){
             
            
        $result = DB::table('PerformaItem')
        ->join('performa','performa.id','=','PerformaItem.performa_id')
        ->join('commercial', 'commercial.id', '=', 'PerformaItem.com_id')
        ->select('commercial.product_category','commercial.specfic_adaptation','commercial.type_of_shoot as type_of_service','commercial.type_of_clothing','commercial.gender','commercial.commercial_value_per_sku as com','PerformaItem.performa_id','PerformaItem.qty','PerformaItem.hsn_code',"PerformaItem.id")->where('performa_id','=',$performa)->get();
   
        
             
         }elseif($dataID == 2 ){
             
              
              $result = DB::table('PerformaItem')
        ->join('performa','performa.id','=','PerformaItem.performa_id')
        ->join('create_commercial', 'create_commercial.id', '=', 'PerformaItem.com_id')
        ->select('create_commercial.per_qty_value as com','create_commercial.kind_of_work as type_of_service','create_commercial.project_name','PerformaItem.performa_id','PerformaItem.qty','PerformaItem.hsn_code',"PerformaItem.id")->where('performa_id','=',$performa)->get();
   
         }elseif($dataID == 3 ){
             
              
              
               $result = DB::table('PerformaItem')
        ->join('performa','performa.id','=','PerformaItem.performa_id')
        ->join('create_commercial_catalog', 'create_commercial_catalog.id', '=', 'PerformaItem.com_id')
        ->select('create_commercial_catalog.type_of_service as type_of_service','create_commercial_catalog.CommercialSKU as com','PerformaItem.performa_id','PerformaItem.qty','PerformaItem.hsn_code',"PerformaItem.id")->where('performa_id','=',$performa)->get();
   
              
         }elseif($dataID == 4 ){
             
            
             $result = DB::table('PerformaItem')
        ->join('performa','performa.id','=','PerformaItem.performa_id')
        ->join('editors_commercials', 'editors_commercials.id', '=', 'PerformaItem.com_id')
        ->select('editors_commercials.type_of_service as type_of_service','editors_commercials.CommercialSKU as com','PerformaItem.performa_id','PerformaItem.qty','PerformaItem.hsn_code',"PerformaItem.id")->where('performa_id','=',$performa)->get();
   
        
             
         }else{
             
         }
         $sr = 1;
           return view('Invoicing.editperforma',['performa' =>$performa, 'PerformaItem' =>$PerformaItem]);
      }
      
     public function   viewPDF(Request $request)
{
    

    $performa =  $request->performa_id;
         
    $proforma = performceInforma::getperformaInfo(['performa' => $performa,'single'=>true]);
    $result = PerformaItem::getperformaItem(['performa' =>$performa]);
    $total  =  $proforma->invoiceAmount;
    $grandTotal = ($total*(18/100)) + $total;
  
     $formatter = new NumberFormatter('en_IN', NumberFormatter::SPELLOUT);
$formatter->setTextAttribute(NumberFormatter::DEFAULT_RULESET, "%spellout-numbering-verbose");
$words = ucfirst($formatter->format(round($grandTotal)));
    $id =1;
    $data = ['mainData' => $proforma,
    'grandtotal' =>$grandTotal,
    'inword'=>ucwords($words),
    'rowData'=>$result,
    'id'=>$id];
     //pr($data,1);
    

// Send the generated PDF to the browser for download
return view('Invoicing.proformaPDF', $data);
}


      
      public function generatePDF(Request $request)
{
    
    $dataID =  $request->service;
    $performa =  $request->performa_id;
         
    $proforma = performceInforma::getperformaInfo(['performa' => $performa,'single'=>true]);
    $result = PerformaItem::getperformaItem(['performa' =>$performa]);
    
    $total  =  $proforma->invoiceAmount;
    $grandTotal = ($total*(18/100)) + $total;
     $words = $this->convertNumberToWords(round($grandTotal));
     
     $formatter = new NumberFormatter('en_IN', NumberFormatter::SPELLOUT);
$formatter->setTextAttribute(NumberFormatter::DEFAULT_RULESET, "%spellout-numbering-verbose");
$words = ucfirst($formatter->format(round($grandTotal)));
     
     $id =1;
    $data = ['mainData' => $proforma,
    'grandtotal' =>$grandTotal,
    'inword'=>ucwords($words),
    'rowData'=>$result, 'id'=>$id];
     //pr($data,1);
      $pdf = new Dompdf();
    $pdf->setPaper('A3', 'portrait');

// Set the options for the PDF renderer
$options = $pdf->getOptions();
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);
$options->set('chroot', '/');
$options->set('defaultMediaType', 'print');
$options->set('enable_font_subsetting', true);



// Render the HTML view into a PDF document
$view = view('Invoicing.proformaPDF', $data)->render();
$pdf->loadHtml($view);
$pdf->render();

// Output the PDF document to the browser

    $output_file =  'performa_'.$performa.'.pdf';
file_put_contents($output_file, $pdf->output());

// Send the generated PDF to the browser for download
return response()->download($output_file);
}


      public function convertNumberToWords($number)
{
    $formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
    return ucfirst($formatter->format($number));
}

public function update(Request $request){
    $id = $request->id;
    $amount = $request->amount;
     $performa = DB::table('performa')->where('id','=',$id)->update(['RcvdAmount' => $amount]);
         
          
        return redirect('/performaRequest');
}
public function Reject(Request $request){
    $id = $request->id;

     $performa = DB::table('performa')->where('id','=',$id)->delete();
         
          
        return redirect('/performaRequest');
}


public function createInvoice(){
    
          $brands = Brands::latest()->get();
    return view('Invoice.CreateInvoices',['brands' =>$brands ]);
}

public function saveDetails(Request $request){

    $dataobj =  new invoiceMOD();
    $dataobj->brand_id = $request->brand_id;
    $dataobj->user_id = $request->user_id;
    $dataobj->total_amount = $request->totalA;
    $dataobj->save();
    
    $id = $dataobj->id;
    $i_number = "ODN/" .date("Y"). "-" .(date("Y") + 1)."/0".$id ;

     $data = DB::table('invoice')->where('id','=',$id)->update(['invoice_number' => $i_number]);
    
    foreach($request->wrcs as $wrc){
         $data = DB::table('pre_invoice')->where('wrc_id','=',$wrc)->update(['invoice_group_id' => $id]);
    }
   
   return "ok";
}

public function invoiceDetail(){
    
$list = invoiceMOD::getInvoiceInfo();
    $id = 1;
    
  //pr($list,1);
return view('Invoice.raisedInvoice',compact('list','id'));
 
}
public function getinDetails(Request $request){
    
        $Id = $request->invoice_id;
     $invoiceItem =  preInvoice::getperItem();
     $list = collect($invoiceItem)->where('invoice_group_id','=',$Id);
$sr = 1;
            $html = view('Invoicing.dynamicModalIn',['list'=>$list,'sr'=>$sr]);
            
            return $html;

}
public function updateInvoice(Request $request){
   
             $data = DB::table('invoice')->where('id','=',$request->id)->update(['status' => '1']);
                     
$list = invoiceMOD::getInvoiceInfo()->where('id','=',$request->id)->first();
$invoice = $list->invoice_number;
$id = $list->id;
$html = view('Invoicing.dynamicInvoice',compact('invoice','id'));
             
            return $html;

}

public function updateInvoiceno(Request $request){
    
    $id =$request->invoice_id;
    $invoice = $request->invoice_number;
     $dataobj = DB::table('invoice')->where('id','=',$id)->update(['invoice_number' => $invoice]);
    $data = DB::table('pre_invoice')->where('invoice_group_id','=',$id)->get();
    
    foreach($data as $datas){
        
          if($datas->service_id == 1 ){
             
              $wrcs = DB::table('wrc')->where('id','=',$datas->wrc_id)->update(['invoice_no' => $invoice]);
             
             
         }elseif($datas->service_id == 2 ){
             $coms = DB::table('creative_wrc')->where('id','=',$datas->wrc_id)->update(['invoice_number' => $invoice]);
               
         }elseif($datas->service_id == 3 ){
             
              $coms = DB::table('catlog_wrc')->where('id','=',$datas->wrc_id)->update(['invoice_number' => $invoice]);
              
         }elseif($datas->service_id == 4 ){
             
              $coms = DB::table('editing_wrcs')->where('id','=',$datas->wrc_id)->update(['invoice_number' => $invoice]);
               
         }
        
    }
    
    Return Redirect('/invoice-details');
}
public function invoiceRaised(){
    
     $com =  preInvoice::getperItem();
     $id = 1;
    // pr($com,1);
     return view('Invoice.wrcRaised',compact('com','id'));
}
}

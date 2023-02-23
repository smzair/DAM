<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\editorSubmission;
use DB;
use App\Models\Skus;
use App\Models\submissions;
use Carbon\Carbon;
use App\Models\Wrc;


class SubmissionController extends Controller {

    public function Qc() {
        $Qcs = editorSubmission::SubmissionInfo(['qcPending'=> TRUE]);
        $QcList = [];
        foreach ($Qcs as $Qc) {
            $index = $Qc->wrc_id;
            $inwardcount = Skus::where('wrc_id' ,'=', $Qc->wrcid)->get();
            $rejectcount = Skus::where('wrc_id' ,'=', $Qc->wrcid)->where('status', '=', 0 )->get();
            $QcList[$index]['id'] = $Qc->wrc_id;
            $QcList[$index]['lot_id'] = $Qc->lot_id;
            $QcList[$index]['Company'] = $Qc->Company;
            $QcList[$index]['brand'] = $Qc->name;
            $QcList[$index]['inward'] = count($inwardcount);
             $QcList[$index]['rejectcount'] = count($rejectcount);
            $QcList[$index]['product_category'] = $Qc->product_category;
            $QcList[$index]['type_of_shoot'] = $Qc->type_of_shoot;
            $QcList[$index]['wrc_id'] = $Qc->wrc_id;
            $QcList[$index]['esub'] = $Qc->editorSubmission_id;
            $QcList[$index]['skus'][$Qc->sku_id]['sku_id'] = $Qc->sku_id;
            $QcList[$index]['skus'][$Qc->sku_id]['sku_code'] = $Qc->sku_code;
            $QcList[$index]['skus'][$Qc->sku_id]['qc'] = $Qc->qc;
            $QcList[$index]['skus'][$Qc->sku_id]['category'] = $Qc->category;
            $QcList[$index]['adaptation'][$Qc->adaptation] = $Qc->adaptation;
            $QcList[$index]['skus'][$Qc->sku_id]['fileName'][] = $Qc->filename;
        }

        foreach ($QcList as $wrc_id => $wrcinfo) {

            if (!isset($QcList[$wrc_id]['sku_count'])) {
                $QcList[$wrc_id]['sku_count'] = 0;
            }

            if (!isset($QcList[$wrc_id]['image_count'])) {
                $QcList[$wrc_id]['image_count'] = 0;
            }



            foreach ($wrcinfo['skus'] as $sku) {
                $QcList[$wrc_id]['image_count'] += count($sku['fileName']);
            }

            $QcList[$wrc_id]['sku_count'] += count($wrcinfo['skus']);
        }

    
        $sr = 1;
        return view('Qc.qcpanel', compact('QcList', 'sr'));
    }
    
    
    
     public function qcDone() {
        $Qcs = editorSubmission::SubmissionInfo(['qcDone'=> TRUE]);
        $QcList = [];

        foreach ($Qcs as $Qc) {
            $index = $Qc->wrc_id;
            $inwardcount = Skus::where('wrc_id' ,'=', $Qc->wrcid)->get();
          $rejectcount = Skus::where('wrc_id' ,'=', $Qc->wrcid)->where('status', '=', 0 )->get();

            $QcList[$index]['id'] = $Qc->wrc_id;
            $QcList[$index]['lot_id'] = $Qc->lot_id;
            $QcList[$index]['Company'] = $Qc->Company;
            $QcList[$index]['brand'] = $Qc->name;
            $QcList[$index]['inward'] = count($inwardcount);
                         $QcList[$index]['rejectcount'] = count($rejectcount);
            $QcList[$index]['product_category'] = $Qc->product_category;
            $QcList[$index]['type_of_shoot'] = $Qc->type_of_shoot;
            $QcList[$index]['wrc_id'] = $Qc->wrc_id;
            $QcList[$index]['esub'] = $Qc->editorSubmission_id;
            $QcList[$index]['skus'][$Qc->sku_id]['sku_id'] = $Qc->sku_id;
            $QcList[$index]['skus'][$Qc->sku_id]['sku_code'] = $Qc->sku_code;
            $QcList[$index]['skus'][$Qc->sku_id]['qc'] = $Qc->qc;
            $QcList[$index]['skus'][$Qc->sku_id]['category'] = $Qc->category;
            $QcList[$index]['adaptation'][$Qc->adaptation] = $Qc->adaptation;
            $QcList[$index]['skus'][$Qc->sku_id]['fileName'][] = $Qc->filename;
        }

        foreach ($QcList as $wrc_id => $wrcinfo) {

            if (!isset($QcList[$wrc_id]['sku_count'])) {
                $QcList[$wrc_id]['sku_count'] = 0;
            }

            if (!isset($QcList[$wrc_id]['image_count'])) {
                $QcList[$wrc_id]['image_count'] = 0;
            }



            foreach ($wrcinfo['skus'] as $sku) {
                $QcList[$wrc_id]['image_count'] += count($sku['fileName']);
            }

            $QcList[$wrc_id]['sku_count'] += count($wrcinfo['skus']);
        }

       
        $sr = 1;
        return view('Qc.qcdone', compact('QcList', 'sr'));
    }

    public function Submission() {



        $Submissions = editorSubmission::SubmissionInfo($filter = ['qc' => '1','submission'=>'0']);

        $SubmissionList = [];

        foreach ($Submissions as $Submission) {
            $index = $Submission->wrc_id;
            $SubmissionList[$index]['id'] = $Submission->wrcid;
            $SubmissionList[$index]['lot_id'] = $Submission->lot_id;
            $SubmissionList[$index]['Company'] = $Submission->Company;
            $SubmissionList[$index]['brand'] = $Submission->name;
            $SubmissionList[$index]['product_category'] = $Submission->product_category;
            $SubmissionList[$index]['type_of_shoot'] = $Submission->type_of_shoot;
            $SubmissionList[$index]['wrc_id'] = $Submission->wrc_id;
            $SubmissionList[$index]['esub'] = $Submission->editorSubmission_id;
            $SubmissionList[$index]['qc'] = $Submission->qc;

            $SubmissionList[$index]['sku_id'] = $Submission->sku_id;
            $SubmissionList[$index]['skus'][$Submission->sku_id]['sku_code'] = $Submission->sku_code;
            $SubmissionList[$index]['skus'][$Submission->sku_id]['category'] = $Submission->category;
            $SubmissionList[$index]['adaptation'][$Submission->adaptation] = $Submission->adaptation;
            $SubmissionList[$index]['skus'][$Submission->sku_id]['fileName'][] = $Submission->filename;
        }

        foreach ($SubmissionList as $wrc_id => $wrcinfo) {

            if (!isset($SubmissionList[$wrc_id]['sku_count'])) {
                $SubmissionList[$wrc_id]['sku_count'] = 0;
                $SubmissionList[$wrc_id]['adapt_count'] = 0;
            }

            if (!isset($SubmissionList[$wrc_id]['image_count'])) {
                $SubmissionList[$wrc_id]['image_count'] = 0;
            }



            foreach ($wrcinfo['skus'] as $sku) {
                $SubmissionList[$wrc_id]['image_count'] += count($sku['fileName']);
            }

            $SubmissionList[$wrc_id]['sku_count'] += count($wrcinfo['skus']);
            $SubmissionList[$wrc_id]['adapt_count'] += count($wrcinfo['adaptation']);
        }
        $sr = 1;
        return view('submission.submissionpanel', compact('SubmissionList', 'sr'));
    }



    public function Submit() {



        $Submissions = editorSubmission::SubmitedInfo($filter = ['qc' => '1','submission'=>'1']);

        $SubmissionList = [];

        foreach ($Submissions as $Submission) {
            $index = $Submission->wrc_id;
            $SubmissionList[$index]['id'] = $Submission->wrcid;
            $SubmissionList[$index]['lot_id'] = $Submission->lot_id;
            $SubmissionList[$index]['Company'] = $Submission->Company;
            $SubmissionList[$index]['brand'] = $Submission->name;
            $SubmissionList[$index]['product_category'] = $Submission->product_category;
            $SubmissionList[$index]['type_of_shoot'] = $Submission->type_of_shoot;
            $SubmissionList[$index]['wrc_id'] = $Submission->wrc_id;
            $SubmissionList[$index]['esub'] = $Submission->editorSubmission_id;
            $SubmissionList[$index]['qc'] = $Submission->qc;
            $SubmissionList[$index]['submission'] = $Submission->submission_date;

            $SubmissionList[$index]['sku_id'] = $Submission->sku_id;
            $SubmissionList[$index]['skus'][$Submission->sku_id]['sku_code'] = $Submission->sku_code;
            $SubmissionList[$index]['skus'][$Submission->sku_id]['category'] = $Submission->category;
            $SubmissionList[$index]['adaptation'][$Submission->adaptation] = $Submission->adaptation;
            $SubmissionList[$index]['skus'][$Submission->sku_id]['fileName'][] = $Submission->filename;
        }

        foreach ($SubmissionList as $wrc_id => $wrcinfo) {

            if (!isset($SubmissionList[$wrc_id]['sku_count'])) {
                $SubmissionList[$wrc_id]['sku_count'] = 0;
                $SubmissionList[$wrc_id]['adapt_count'] = 0;
            }

            if (!isset($SubmissionList[$wrc_id]['image_count'])) {
                $SubmissionList[$wrc_id]['image_count'] = 0;
            }



            foreach ($wrcinfo['skus'] as $sku) {
                $SubmissionList[$wrc_id]['image_count'] += count($sku['fileName']);
            }

            $SubmissionList[$wrc_id]['sku_count'] += count($wrcinfo['skus']);
            $SubmissionList[$wrc_id]['adapt_count'] += count($wrcinfo['adaptation']);
        }
        $sr = 1;
        return view('submission.submited', compact('SubmissionList', 'sr'));
    }



    Public function dynamicSub(Request $request) {

        $wrcId = $request->wrc_id;
$submit = $request->submitted;

        $Submissions = editorSubmission::SubmissionInfo($filter = ['wrc_id' => $wrcId, 'qc' => '1']);

        $SubmissionList = [];

        foreach ($Submissions as $Submission) {
            $index = $Submission->wrc_id;
            $SubmissionList[$index]['id'] = $Submission->wrcid;
            $SubmissionList[$index]['lot_id'] = $Submission->lot_id;
            $SubmissionList[$index]['Company'] = $Submission->Company;
            $SubmissionList[$index]['client_id'] = $Submission->client_id;

            $SubmissionList[$index]['brand'] = $Submission->name;
            $SubmissionList[$index]['product_category'] = $Submission->product_category;
            $SubmissionList[$index]['type_of_shoot'] = $Submission->type_of_shoot;
            $SubmissionList[$index]['wrc_id'] = $Submission->wrc_id;

            $SubmissionList[$index]['esub'] = $Submission->editorSubmission_id;
            $SubmissionList[$index]['qc'] = $Submission->qc;

            $SubmissionList[$index]['skus'][$Submission->sku_id]['sku_id'] = $Submission->sku_id;
            $SubmissionList[$index]['skus'][$Submission->sku_id]['sku_code'] = $Submission->sku_code;
            $SubmissionList[$index]['skus'][$Submission->sku_id]['category'] = $Submission->category;
            $SubmissionList[$index]['adaptation'][$Submission->adaptation] = $Submission->adaptation;
            $SubmissionList[$index]['skus'][$Submission->sku_id]['fileName'][] = $Submission->filename;

            // $lotPath = "edited_img_directory/". date('Y', strtotime($Submission->created_at)) . "/" . date('M', strtotime($Submission->created_at)) . "/" . $Submission->lot_id . "/";
            // $SubmissionList[$Submission->lot_id]['lot_path'] = $lotPath;
            // $wrcPath = $lotPath . $Submission->wrc_id;
            // $SubmissionList[$Submission->lot_id]['wrcs'][$Submission->wrc_id]['wrc_path'] = $wrcPath;
            // $path = $wrcPath."/" .$Submission->adaptation. "/" . $Submission->sku_code . "/" . $Submission->filename;
            // $SubmissionList[$Submission->lot_id]['wrcs'][$Submission->wrc_id]['sku'][$Submission->sku_id]['uploadraw']['file_path'][] = $path;
            // $SubmissionList[$Submission->lot_id]['wrcs'][$Submission->wrc_id]['sku'][$Submission->sku_id]['uploadraw']['uploadraw_id'][] = $Submission->editorSubmission_id;
        }
        foreach ($SubmissionList as $wrc_id => $wrcinfo) {

            if (!isset($SubmissionList[$wrc_id]['sku_count'])) {
                $SubmissionList[$wrc_id]['sku_count'] = 0;
                $SubmissionList[$wrc_id]['adapt_count'] = 0;
            }

            if (!isset($SubmissionList[$wrc_id]['image_count'])) {
                $SubmissionList[$wrc_id]['image_count'] = 0;
            }

            foreach ($wrcinfo['skus'] as $sku) {
                $SubmissionList[$wrc_id]['image_count'] += count($sku['fileName']);
            }

            $SubmissionList[$wrc_id]['sku_count'] += count($wrcinfo['skus']);
            $SubmissionList[$wrc_id]['adapt_count'] += count($wrcinfo['adaptation']);
        }

        $SubmissionList = json_encode($SubmissionList);
        $SubmissionList = json_decode($SubmissionList);

        $inwarded = Skus::getskuInfo($filter = ['wrc_id' => $wrcId]);
        $inwarded_count = count($inwarded);
        $rejected_count = 0;
        
        foreach ($inwarded as $sku) {
            if ($sku->status == '0') {
                $rejected_count++;
            }
        }
       
        $encodedWrcId = base64_encode($wrcId);
       
        return view('submission.dynamic-submissionpanel', compact('SubmissionList', 'inwarded_count', 'rejected_count', 'encodedWrcId','wrcId'));
    }



    Public function  dynamicSubmit(Request $request) {

        $wrcId = $request->wrc_id;

        $Submissions = editorSubmission::SubmissionInfo($filter = ['wrc_id' => $wrcId, 'qc' => '1']);

        $SubmissionList = [];

        foreach ($Submissions as $Submission) {
            $index = $Submission->wrc_id;
            $SubmissionList[$index]['id'] = $Submission->wrcid;
            $SubmissionList[$index]['lot_id'] = $Submission->lot_id;
            $SubmissionList[$index]['Company'] = $Submission->Company;
            $SubmissionList[$index]['client_id'] = $Submission->client_id;
            $SubmissionList[$index]['brand'] = $Submission->name;
            $SubmissionList[$index]['product_category'] = $Submission->product_category;
            $SubmissionList[$index]['type_of_shoot'] = $Submission->type_of_shoot;
            $SubmissionList[$index]['wrc_id'] = $Submission->wrc_id;
            $SubmissionList[$index]['esub'] = $Submission->editorSubmission_id;
            $SubmissionList[$index]['qc'] = $Submission->qc;
            $SubmissionList[$index]['skus'][$Submission->sku_id]['sku_id'] = $Submission->sku_id;
            $SubmissionList[$index]['skus'][$Submission->sku_id]['sku_code'] = $Submission->sku_code;
            $SubmissionList[$index]['skus'][$Submission->sku_id]['category'] = $Submission->category;
            $SubmissionList[$index]['adaptation'][$Submission->adaptation] = $Submission->adaptation;
            $SubmissionList[$index]['skus'][$Submission->sku_id]['fileName'][] = $Submission->filename;
            // $lotPath = "edited_img_directory/". date('Y', strtotime($Submission->created_at)) . "/" . date('M', strtotime($Submission->created_at)) . "/" . $Submission->lot_id . "/";
            // $SubmissionList[$Submission->lot_id]['lot_path'] = $lotPath;
            // $wrcPath = $lotPath . $Submission->wrc_id;
            // $SubmissionList[$Submission->lot_id]['wrcs'][$Submission->wrc_id]['wrc_path'] = $wrcPath;
            // $path = $wrcPath."/" .$Submission->adaptation. "/" . $Submission->sku_code . "/" . $Submission->filename;
            // $SubmissionList[$Submission->lot_id]['wrcs'][$Submission->wrc_id]['sku'][$Submission->sku_id]['uploadraw']['file_path'][] = $path;
            // $SubmissionList[$Submission->lot_id]['wrcs'][$Submission->wrc_id]['sku'][$Submission->sku_id]['uploadraw']['uploadraw_id'][] = $Submission->editorSubmission_id;
        }
        foreach ($SubmissionList as $wrc_id => $wrcinfo) {

            if (!isset($SubmissionList[$wrc_id]['sku_count'])) {
                $SubmissionList[$wrc_id]['sku_count'] = 0;
                $SubmissionList[$wrc_id]['adapt_count'] = 0;
            }

            if (!isset($SubmissionList[$wrc_id]['image_count'])) {
                $SubmissionList[$wrc_id]['image_count'] = 0;
            }

            foreach ($wrcinfo['skus'] as $sku) {
                $SubmissionList[$wrc_id]['image_count'] += count($sku['fileName']);
            }

            $SubmissionList[$wrc_id]['sku_count'] += count($wrcinfo['skus']);
            $SubmissionList[$wrc_id]['adapt_count'] += count($wrcinfo['adaptation']);
        }

        $SubmissionList = json_encode($SubmissionList);
        $SubmissionList = json_decode($SubmissionList);

        $inwarded = Skus::getskuInfo($filter = ['wrc_id' => $wrcId]);
        $inwarded_count = count($inwarded);
        $rejected_count = 0;
        
        foreach ($inwarded as $sku) {
            if ($sku->status == '0') {
                $rejected_count++;
            }
        }
       
        $encodedWrcId = base64_encode($wrcId);
       
        return view('submission.dynamic-submission', compact('SubmissionList', 'inwarded_count', 'rejected_count', 'encodedWrcId','wrcId'));
    }


   

    public function statusQc(Request $request) {

        $skuId = $request->sku_id;
        $qcs = $request->qc;

        $sku = DB::table('editor_submission')->where('sku_id', $skuId)->update(['qc' => $qcs]);

        $skuFound = skusStatus::where(['sku_id' => $skuId, 'status' => 'qc_done'])->get();
        if (count($skuFound) != 0) {

        } else {
            $skuInfo = Skus::find(['id' => $skuId])->first();
            $skuInfo->current_status = 'qc_done';
            $skuInfo->save();

            // $statusEngine = new skusStatus();
            // $statusEngine->sku_id = $skuId;
            // $statusEngine->status = 'qc_done';
            // $statusEngine->save();
            // updateWrcStatus($skuInfo->wrc_id, $skuInfo->lot_id);
        }
        return response('success');
    }


public function firstsave(Request $request){
    
   $id= $request->wrc_id;
    
    $first = '1';
    $submission_date = Carbon::today();
    $full = '1';
      $obj = new submissions;
      $obj->wrc_id = $request->wrc_id;
      $obj->firstAngle = $first;
      $obj->fullAngle = $full;
      $obj->submission_date = $submission_date;
      $obj->save();
      
     $wrcs= Wrc::find(['id' => $id])->first();
     
     $wrcs->submission = '1';
     $wrcs->save();
}



}

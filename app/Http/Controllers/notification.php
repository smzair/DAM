
<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\Rawstatus;
use App\Mail\Qcstatus;
use App\Models\User;
use App\Models\Brands;
use App\Models\brands_user;
use App\Models\Commercials;
use App\Models\Lots;
use App\Models\Wrc;
use App\Models\Skus;
use App\Models\Dayplan;
use App\Models\planDate;
use App\Models\uploadraw;
use App\Models\allocation;
use App\Models\submissions;
use App\Models\editing;
use App\Models\editorSubmission;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Notifcations extends Controller
{
public function realTime(){

$noti = uploadraw::shootDone();
    $notis = json_decode(json_encode($noti), true);

$list = [];
foreach($noti as $notify){
$index = $notify->wrc_id;
$list[$index]['wrcid']=$notify->wrc_id;
$list[$index]['brand']=$notify->brand_name;
$list[$index]['ShootType']=$notify->type_of_shoot;
$list[$index]['product_category']=$notify->product_category;
$list[$index]['type_of_clothing']=$notify->type_of_clothing;
$list[$index]['sku'][$notify->sku_id]= $notify->sku_code;
$list[$index]['sku']['sku_codes'][$notify->sku_id]=$notify->sku_code;
$list[$index]['sku']['images'][$notify->sku_id][] = $notify->uploadraw_id;
$list[$index]['sku']['total_images'][$notify->sku_id]= count($list[$index]['sku']['images'][$notify->sku_id]);
}
  $data = [
    'list'=>$list];
    $users= ['syedzair96@gmail.com','vishal.d@odndigital.com'];

    Mail::to($users)->send(new Rawstatus($data));
    return "Email Sent";
 }


public function realTimeqc(){

        $Submissions = editorSubmission::SubmissionInfo($filter = ['qc' => '1','submission'=>'0']);

        $SubmissionList = [];

        foreach ($Submissions as $Submission) {
            $index = $Submission->wrc_id;
            $SubmissionList[$index]['lot_id'] = $Submission->lot_id;
            $SubmissionList[$index]['Company'] = $Submission->Company;
            $SubmissionList[$index]['brand'] = $Submission->name;
            $SubmissionList[$index]['product_category'] = $Submission->product_category;
            $SubmissionList[$index]['type_of_shoot'] = $Submission->type_of_shoot;
            $SubmissionList[$index]['wrc_id'] = $Submission->wrc_id;
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

        return view('emails.qcstatus', compact('SubmissionList'));
    }
}
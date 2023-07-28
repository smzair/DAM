<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ClientsControllers\ClientDashboardController;
use App\Http\Controllers\ClientsControllers\ClientDashboardControllerNew;
use App\Jobs\SearchDataCollection;
use App\Models\CatalogWrcMasterSheet;
use App\Models\ClientActivityLog;
use App\Models\CreativeSubmission;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lots;
use App\Models\performance;
use App\Models\uploadraw;
use App\Models\Skus;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $users = User::get()->count();
        $lots = Lots::get()->count();
        $raw = uploadraw::get()->count();
        $skus = Skus::get()->count();

        $user = Auth::user();
        $role = $user->roles->first();
        if ($user->roles->pluck( 'name' )->contains( 'Flipkart' )) {
            return view('clients.home',compact('user'));
        }
        $user_role = $user->roles->pluck('name');

        if($user->roles->pluck( 'name' )->contains( 'Client' ) || $user->roles->pluck( 'name' )->contains( 'Sub Client' )){
            // return ClientDashboardController::index();
            $roledata = getUsersRole($user->id);
            
            $user_ip = $request->ip();
            $data_array = array(
                'log_name' => $roledata->role_name.' Login', 
                'description' => $user->name.' logged in at '.date('d-m-Y h:i A').' with ip is '.$user_ip,
                'event' => 'Log in', 
                'subject_type' => 'App\Models\Users', 
                'subject_id' => '0', 
                'properties' => ['ip_address' => $user_ip
                ,'user_id' => $user->id
                ,'name' => $user->name
                ,'last_name' => $user->last_name
                ,'email' => $user->email
                ,'client_id' => $user->client_id
                ]
            );

            // dd($user ,$data_array);
            ClientActivityLog::saveClient_activity_logs($data_array);

            dispatch(new SearchDataCollection($user))->onQueue('search_data_collection_queue');
            return ClientDashboardControllerNew::index();
        }

        if ($role->name ==  'Performance') {
            $catalog = CatalogWrcMasterSheet::CatalogWrcMasterList();
            $arr = [];
            foreach ($catalog as $cat) {
                $index = $cat['wrc_id'];
                if ($cat['submission_id'] > 0) {
                    if ($cat['work_committed_date'] != '' && $cat['submission_date'] != '') {
                        if (date('Y-m-d', strtotime($cat['work_committed_date'])) < date('Y-m-d', strtotime($cat['submission_date']))) {
                            $cat['tat_status']  = 'Breached';
                        } else {
                            $cat['tat_status'] = 'TAT Within';
                        }
                    }
                } else {
                    $cat['tat_status'] = 'TAT Not Started';
                }

                if ($cat['rework_count'] == 0) {
                    $cat['internal_fta'] =  'FTA';
                } elseif ($cat['rework_count'] ==  "") {
                    $cat['internal_fta'] = 'NTA';
                } else {
                    $cat['internal_fta'] = 'NFTA';
                }
                if ($cat['ar_status'] == 0) {
                    $cat['external_fta'] =  'NFTA';
                } elseif ($cat['ar_status'] ==  "") {
                    $cat['external_fta'] = 'NTA';
                } else {
                    $cat['external_fta'] = 'FTA';
                }
                $arr[$index] = $cat;
            }
            $catalog = $arr;

            $catalog = collect($catalog);
            $activecatwrc = count($catalog->where('task_status', '!=', '3'));
            $totalcatwrc = count($catalog);
            $completedcatwrc = count($catalog->where('task_status', '=', '3'));

            $catTatbreach = count($catalog->where('tat_status', '=', 'Breached'));

            $catTatwithin = count($catalog->where('tat_status', '=', 'TAT Within'));
            $catTatns = count($catalog->where('tat_status', '=', 'TAT Not Started'));

            $catinNFTA = count($catalog->where('internal_fta', '=', 'NFTA'));
            $catexNFTA = count($catalog->where('external_fta', '=', 'NFTA'));

            $catinFTA = count($catalog->where('internal_fta', '=', 'FTA'));
            $catexFTA = count($catalog->where('external_fta', '=', 'FTA'));

            $totalFTA = $catinFTA + $catexFTA;
            $totalNFTA = $catinNFTA + $catexNFTA;
            //   pr($catalog,1);
            //dd($catTatwithin,$catTatns,$catTatbreach,$activecatwrc,$completedcatwrc,$totalcatwrc);


            /////    /////

            $wrcInfo =    performance::getShootMaster();

            $wrcInfo = collect($wrcInfo);

            $wrcs_active_breached = $wrcInfo->where('TAT_status', '=', 'TAT Breached');

            $wab_count = count($wrcs_active_breached);

            $wrc_active_within = $wrcInfo->where('TAT_status', '!=', 'TAT Breached');

            $wrc_active_withinfull = count($wrcInfo->where('Completed', '=', 'Completed'));
            $waw_count = count($wrc_active_within);

            $totalcompletedwrc = count($wrcInfo->where('statuses', '=', 'Submitted'));

            $wrc_active = count($wrcInfo->where('statuses', '=', 'Active'));

            $totalwrc = $totalcompletedwrc + $wrc_active;

            $tatcompletion = $totalcompletedwrc / $totalwrc * 100;
            //////WRC//////
            $studio_percentage_with = $waw_count / $wrc_active * 100;

            $studio_percentage_breach = $wab_count / $wrc_active * 100;


            $FTA = count($wrcInfo->where('External_fta', '=', 'FTA')->where('Internal_fta', '=', 'FTA'));
            $NFTA = count($wrcInfo->where('External_fta', '=', 'NFTA')->where('Internal_fta', '=', 'NFTA'));


            $external = count($wrcInfo->where('External_fta', '=', 'FTA'));
            $totalexternal = $external / $totalwrc * 100;
            $totalFtapercentage =  $FTA / $totalwrc * 100;
            $totalNFtapercentage =  $NFTA / $totalwrc * 100;

            $IFTA = count($wrcInfo->where('Internal_fta', '=', 'FTA'));
            $totalIFtapercentage =  $IFTA / $totalwrc * 100;

            return view('Performance.home', compact('totalcatwrc', 'activecatwrc', 'IFTA', 'totalIFtapercentage', 'wab_count', 'waw_count', 'totalwrc', 'wrc_active', 'studio_percentage_with', 'studio_percentage_breach', 'tatcompletion', 'NFTA', 'FTA', 'totalFtapercentage', 'totalNFtapercentage', 'external', 'totalexternal'));
        }


        return view('home', compact('users', 'lots', 'raw', 'skus'));
    }
    public function test1()
    {
        return view('test1');
    }
}

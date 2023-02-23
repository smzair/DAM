<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\activityLogs;

class logActivity extends Controller
{
  Public function Logs(){
    $lastActivity = Activity::all();
    return response() ->json([
     $lastActivity
   ], 200);
  }
  Public function Index(Request $request){
    $paginate = 15;
    $page = isset($request->page) ? $request->page : 1;
    $start = ($page - 1) * $paginate  + 1;

    $lastActivity = activityLogs::getLogs(['paginate' => $paginate, 'order_by' => 'DESC']);

    return view('extra.log',compact('lastActivity','start'));
  }
}

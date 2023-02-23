<?php

namespace App\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dailyCounts extends Model
{
    use HasFactory;

   protected $table = 'dailyCounts';


    public static function getCounts(){
        $result = DB::table('dailyCounts')
        ->select('dailyCounts.brands','dailyCounts.Commercials','dailyCounts.lotexist','dailyCounts.wrcexist','dailyCounts.Lots','dailyCounts.Wrcs','dailyCounts.plannedskus','dailyCounts.pendingplan','dailyCounts.pendingsku','dailyCounts.uploadrawpending','dailyCounts.shootdone','dailyCounts.pendallocation','dailyCounts.pendingfromediting','dailyCounts.editingcomplete','dailyCounts.qcdone','dailyCounts.qcpending','dailyCounts.submission','dailyCounts.sdate','dailyCounts.created_at','dailyCounts.compareLots','dailyCounts.comparewrcs','dailyCounts.comparepL','dailyCounts.compareWp','dailyCounts.compareplannedskus','dailyCounts.comparependingplan','dailyCounts.comparependingsku','dailyCounts.compareuploadrawpending','dailyCounts.compareshootdone','dailyCounts.comparependallocation','dailyCounts.comparependingfromediting','dailyCounts.compareeditingcomplete','dailyCounts.comapreqcdone','dailyCounts.compareqcpending','dailyCounts.comparesubmission','dailyCounts.created_at')
        ->where('dailyCounts.created_at', '>', Carbon::now()->startOfWeek())
        ->where('dailyCounts.created_at', '<', Carbon::now()->endOfWeek())
        ->orderBy('dailyCounts.created_at', 'asc');
        return $result->get();
        
    }

}

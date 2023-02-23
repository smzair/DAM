<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class flipkart_editing extends Model {

   
    protected $table = 'flipkart_editing';

      public static function getFlipInfo($filter = []) {
        $wheerArr = [];
        if (isset($filter['lot_id'])) {
            $wheerArr[] = ['lots.id', '=', $filter['lot_id']];
        }
        if (isset($filter['wrc_id'])) {
            $wheerArr[] = ['wrc.id', '=', $filter['wrc_id']];
        }
        if (isset($filter['flipkart_editing_id'])) {
            $wheerArr[] = ['flipkart_editing.id', '=', $filter['flipkart_editing_id']];
        }
        if(isset($filter['fwrc_done'])) {
            $wheerArr[] = ['wrc.fwrc_done', '=' ,$filter['fwrc_done']];
        }
        $result = DB::table('flipkart_editing')
                ->join('wrc', 'wrc.id', '=', 'flipkart_editing.wrc_id')
                ->join('lots', 'lots.id', '=', 'flipkart_editing.lot_id')
                ->select('lots.lot_id','wrc.wrc_c','wrc.fstarted','wrc.fwrcstarted_date', 'wrc.wrc_id','wrc.fwrc_done','wrc.fwrcdone_date','flipkart_editing.id','flipkart_editing.wrc_id as wrcId','flipkart_editing.lot_id as lotId','flipkart_editing.recivedFilename','flipkart_editing.sentFilename','flipkart_editing.remarks','flipkart_editing.imageCount','flipkart_editing.created_at','flipkart_editing.updated_at')
                ->where($wheerArr)
                ->orderBy('flipkart_editing.id', 'DESC');

        if (isset($filter['group'])) {
            return $result->groupBy('wrc.id')->get();
        }
        return $result->get();
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminControlController extends Controller
{
    // get data for create
    public function Index()
    {
        return view('admin.Control-panel.Catalog-wrc-create');
    }

    public function getLotNumber(Request $request){
        $service_id = $request->service_id;
        if($service_id == 1){ 
            // Shoot
            $lot_query = DB::table('lots')->
            select('lots.id', 'lots.lot_id as lot_number');
            
        }else if($service_id == 2){
            // Creative
            $lot_query = DB::table('creative_lots')->
            select('creative_lots.id', 'creative_lots.lot_number');
        }else if($service_id == 3){
            // Cataloging
            $lot_query = DB::table('lots_catalog')->
            select('lots_catalog.id', 'lots_catalog.lot_number');
        }else if($service_id == 4){
            // Editing
            $lot_query = DB::table('editor_lots')->
            select('editor_lots.id', 'editor_lots.lot_number');
        }
        $data = $lot_query->get()->toArray();
        echo json_encode($data);
    }

    public function getWrcNumber(Request $request){
        $service_id = $request->service_id;
        $lot_id = $request->lot_id_is;

        if($service_id == 1){  // Shoot
            $lot_query = DB::table('wrc')->
            where('lot_id', '=',$lot_id)->
            select('wrc.id', 'wrc.wrc_id as wrc_number');
        }else if($service_id == 2){ // Creative
            $lot_query = DB::table('creative_wrc')->
            where('lot_id', '=',$lot_id)->
            select('creative_wrc.id', 'creative_wrc.wrc_number');
        }else if($service_id == 3){  // Cataloging
            $lot_query = DB::table('catlog_wrc')->
            where('lot_id', '=',$lot_id)->
            select('catlog_wrc.id', 'catlog_wrc.wrc_number');
        }else if($service_id == 4){  // Editing
            $lot_query = DB::table('editing_wrcs')->
            where('lot_id', '=',$lot_id)->
            select('editing_wrcs.id', 'editing_wrcs.wrc_number');
        }
        $data = $lot_query->get()->toArray();
        echo json_encode($data);
    }
}

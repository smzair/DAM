<?php

namespace App\Http\Controllers;

use App\Models\ConsolidatedLot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsolidatedLotController extends Controller
{
    //

    public function view(){
        $users_data = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([ ['users.Company' ,'<>' ,NULL], ['roles.name','=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);
            // dd($users_data);

        $CreativeLots = (object) [
            'id'=>0,
            'user_id'=>'',
            'brand_id'=>'',
            'shoot' => '',
            'creative_graphic' => '',
            'shoot_form_data' => 0,
            'creative_graphic_form_data' => 0,
            'cataloging_form_data' => 0,
            'editor_lot_form_data' => 0,
            'cataloging' => '',
            'editor_lot_check' => ''
        ];
       
        return view('consolidatedLot-Panel.Consolidated-Lot')->with(['CreativeLots'=>$CreativeLots, 'users_data'=> $users_data, 'editor_data'=>[], 'creative_data'=>[], 'catlog_data'=>[], 'shoot_data'=>[]]);
    }

    // consolidated lot create

    public function create(Request $request){
        
        // dd($request);
        $lot_number  = null;
        $c_short = $request->c_short;
        $short_name = $request->short_name;
        $user_id = $request->user_id;
        $brand_id = $request->brand_id;
        $cgcheck = isset($request->cgcheck) ?   $request->cgcheck : 0; // Creative Graphics
        $catcheck = isset($request->catcheck) ? $request->catcheck : 0; // Cataloging
        $editor_lot_check = isset($request->editor_lot) ? $request->editor_lot : 0; // editor_lot
        $shootcheck = isset($request->shootcheck) ?   $request->shootcheck : 0; // Shoot

        $cgcheck_val = $cgcheck == 0 ? 0 : 1; // Creative Graphics
        $catcheck_val = $catcheck == 0 ? 0 : 1; // Cataloging
        $shootcheck_val = $shootcheck == 0 ? 0 : 1;// Shoot
        $editor_lot_check_val = $editor_lot_check == 0 ? 0 : 1;// Shoot

        $consolidatedLot = new ConsolidatedLot();
        $consolidatedLot->shoot = $shootcheck_val;
        $consolidatedLot->creative_graphic = $cgcheck_val;
        $consolidatedLot->cataloging = $catcheck_val;
        $consolidatedLot->editor_lot_check = $editor_lot_check_val;
        $consolidatedLot->user_id = $user_id;
        $consolidatedLot->brand_id = $brand_id;
        $consolidatedLot->save(); 

        $shoot_id = 0;
        $cg_id = 0;
        $cat_id = 0;
        $editor_lot_id = 0;

        // generate lot number 
        //  $lot_number = 'ODN' . date('dmY') ."-". $request->c_short . $request->short_name . $id;
        // dd(['shootcheck'=> $shootcheck_val, 'cgcheck'=> $cgcheck_val, 'catcheck'=>$catcheck_val]);

        // shoot entry 
        if($shootcheck_val == 1){
            $shoot_id = DB::table('lots')->insertGetId([
                'user_id' => $user_id,
                'brand_id' => $brand_id
            ]);
        }
        if( $shoot_id > 0){
            // lot number 
            $lot_number = 'ODN' . date('dmY') ."-". $c_short . $short_name . $shoot_id;

              // creative lot entry
            if($cgcheck_val == 1){
                $cg_id = DB::table('creative_lots')->insertGetId([
                    'user_id' => $user_id,
                    'brand_id' => $brand_id,
                    'linked_lot_id' => $shoot_id,
                    'linked_lot_id_add_from' => 'Shoot',
                    'lot_number' =>  strtoupper($lot_number)
                ]);
            }

             // catlog lot entry
            if($catcheck_val == 1){
                $cat_id = DB::table('lots_catalog')->insertGetId([
                    'user_id' => $user_id,
                    'brand_id' => $brand_id,
                    'linked_lot_id' => $shoot_id,
                    'linked_lot_id_add_from' => 'Shoot',
                    'lot_number' =>  strtoupper($lot_number)
                ]);
            }

              // editor  lot entry
              if($editor_lot_check_val == 1){
                    $editor_lot_id = DB::table('editor_lots')->insertGetId([
                        'user_id' => $user_id,
                        'brand_id' => $brand_id,
                        'linked_lot_id' => $shoot_id,
                        'linked_lot_id_add_from' => 'Shoot',
                        'lot_number' =>  strtoupper($lot_number)
                    ]);
                }

            // update lot number and linked lot id
            DB::table('lots')->where('id',$shoot_id)->update(
                [
                    'lot_id' => strtoupper($lot_number),
                    'linked_lot_id' => $cat_id,
                    'linked_lot_id_add_from' => 'Catlog',

                ]
            );
            $cgcheck_val = 0;
            $catcheck_val = 0;
        }


        // creative lot entry
        if($cgcheck_val == 1){

            $cg_id = DB::table('creative_lots')->insertGetId([
                'user_id' => $user_id,
                'brand_id' => $brand_id
            ]);
            if( $cg_id > 0){
                // lot number 
                $lot_number = 'ODN' . date('dmY') ."-". $c_short . $short_name . $cg_id;

                // catlog lot entry
                if($catcheck_val == 1){
                    $cat_id = DB::table('lots_catalog')->insertGetId([
                        'user_id' => $user_id,
                        'brand_id' => $brand_id,
                        'linked_lot_id' => $cg_id,
                        'linked_lot_id_add_from' => 'Creative',
                        'lot_number' =>  strtoupper($lot_number)
                    ]);
                }

                 // editor  lot entry
                if($editor_lot_check_val == 1){
                    $editor_lot_id = DB::table('editor_lots')->insertGetId([
                        'user_id' => $user_id,
                        'brand_id' => $brand_id,
                        'linked_lot_id' => $cg_id,
                        'linked_lot_id_add_from' => 'Creative',
                        'lot_number' =>  strtoupper($lot_number)
                    ]);
                }

                // update lot number and linked lot id
                DB::table('creative_lots')->where('id',$cg_id)->update(
                    [
                        'lot_number' => strtoupper($lot_number),
                        'linked_lot_id' => $cat_id,
                        'linked_lot_id_add_from' => 'Catlog'
                    ]
                );
            }

            $catcheck_val = 0;
           
        }

         // catlog lot entry
        if($catcheck_val == 1){
            $cat_id = DB::table('lots_catalog')->insertGetId([
                'user_id' => $user_id,
                'brand_id' => $brand_id
            ]);
            $lot_number = 'ODN' . date('dmY') ."-". $c_short . $short_name . $cat_id;

             // editor  lot entry
             if($editor_lot_check_val == 1){
                $editor_lot_id = DB::table('editor_lots')->insertGetId([
                    'user_id' => $user_id,
                    'brand_id' => $brand_id,
                    'linked_lot_id' => $cat_id,
                    'linked_lot_id_add_from' => 'Catlog',
                    'lot_number' =>  strtoupper($lot_number)
                ]);
            }

            // update lot number and linked lot id
            DB::table('lots_catalog')->where('id',$cg_id)->update(
                [
                    'lot_number' => strtoupper($lot_number),
                    'linked_lot_id' => $cat_id,
                    'linked_lot_id_add_from' => 'Catlog'
                ]
            );

            $editor_lot_check_val = 0;
        }

         // editor lot entry
         if($editor_lot_check_val == 1){
            $editor_lot_id = DB::table('editor_lots')->insertGetId([
                'user_id' => $user_id,
                'brand_id' => $brand_id
            ]);
            $lot_number = 'ODN' . date('dmY') ."-". $c_short . $short_name . $editor_lot_id;

          

            // update lot number and linked lot id
            DB::table('editor_lots')->where('id',$editor_lot_id)->update(
                [
                    'lot_number' => strtoupper($lot_number),
                    'linked_lot_id' => $editor_lot_id,
                    'linked_lot_id_add_from' => 'editorLot'
                ]
            );
        }


        // update linked_shoot_id, linked_creative_id, linked_catlog_id
        ConsolidatedLot::where('id',$consolidatedLot->id)->update(
            [
                'linked_shoot_id' => $shoot_id,
                'linked_creative_id' => $cg_id,
                'linked_catlog_id' => $cat_id,
                'linked_editor_lot_id' => $editor_lot_id,
                'lot_number' => strtoupper($lot_number)
            ]
        );

        if($consolidatedLot){
            request()->session()->flash('success','Lot Generated Successfully');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        
        return $this->continueTask($request,$consolidatedLot->id);

    }

    // consolidated lot view
    public function list(Request $request){
        $ConsolidatedLot = ConsolidatedLot::getConsolidatedLot();
        // dd( $ConsolidatedLot);
        return view('consolidatedLot-Panel.Consolidated-Lot-View')->with(['ConsolidatedLot'=>$ConsolidatedLot]);
    }

    // continue consolidated lot task 

    public function continueTask(Request $request, $id){
        $users_data = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([ ['users.Company' ,'<>' ,NULL], ['roles.name','=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);

        $CreativeLots = ConsolidatedLot::where('id',$id)->first();
        // dd($CreativeLots);

        $shoot_check = $CreativeLots['shoot'];
        $creative_graphic_check = $CreativeLots['creative_graphic'];
        $cataloging_check = $CreativeLots['cataloging'];
        $editor_lot_check = $CreativeLots['editor_lot_check'];

        $shoot_form_data = $CreativeLots['shoot_form_data'];
        $creative_graphic_form_data = $CreativeLots['creative_graphic_form_data'];
        $cataloging_form_data = $CreativeLots['cataloging_form_data'];
        $editor_lot_form_data = $CreativeLots['editor_lot_form_data'];

        $linked_shoot_id = $CreativeLots['linked_shoot_id'];
        $linked_creative_id = $CreativeLots['linked_creative_id'];
        $linked_catlog_id = $CreativeLots['linked_catlog_id'];
        $linked_editor_lot_id = $CreativeLots['linked_editor_lot_id'];

        $editor_data = [];
        $catlog_data = [];
        $creative_data = [];
        $shoot_data = [];

        if($editor_lot_check == 1 && $editor_lot_form_data == 1){
                $editor_data = DB::table('editor_lots')->where('id',$linked_editor_lot_id)->first(['request_name']);
        }
        if($cataloging_check == 1 && $cataloging_form_data == 1){
            $catlog_data = DB::table('lots_catalog')->where('id',$linked_catlog_id)->first();
        }

        if($creative_graphic_check == 1 && $creative_graphic_form_data == 1){
            $creative_data = DB::table('creative_lots')->where('id',$linked_creative_id)->first();
        }

        if($shoot_check == 1 && $shoot_form_data == 1){
            $shoot_data = DB::table('lots')->where('id',$linked_shoot_id)->first();
        }

        return view('consolidatedLot-Panel.Consolidated-Lot')->with(['CreativeLots'=>$CreativeLots, 'users_data'=> $users_data, 'editor_data'=> $editor_data, 'catlog_data'=> $catlog_data, 'creative_data'=> $creative_data, 'shoot_data'=> $shoot_data]);
    }

    public function createConsolidatedShoot(Request $request){

        $ConsolidatedLot = $request->consolidated_lot_id;
        $servicesType = $request->servicesType;
        $locationType = $request->locationType;
        $verticalType = $request->verticalType;
        $clientBucket = $request->clientBucket;
        $ConsolidatedLotData = ConsolidatedLot::where('id',$ConsolidatedLot)->first(['linked_shoot_id']);
        $linked_shoot_id = $ConsolidatedLotData != null ? $ConsolidatedLotData->linked_shoot_id : 0;

        if($linked_shoot_id > 0){
            DB::table('lots')->where('id',$linked_shoot_id)->update([
                's_type' =>  $servicesType,
                'location' =>  $locationType,
                'verticleType' =>  $verticalType,
                'clientBucket' =>  $clientBucket
            ]);
            ConsolidatedLot::where('id',$ConsolidatedLot)->update(['shoot_form_data' => 1]);
        }
        if($linked_shoot_id){
            request()->session()->flash('success','Shoot Data Saved Successfully');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return $this->continueTask($request,$ConsolidatedLot);
    }

    public function createConsolidatedCreativeGraphics(Request $request){
        // dd($request);
        $ConsolidatedLot = $request->consolidated_lot_id;
        $project_name = $request->project_name;
        $verticalType = $request->verticalType;
        $clientBucket = $request->clientBucket;
        $lot_delevery_days = $request->lot_delevery_days;
        $ConsolidatedLotData = ConsolidatedLot::where('id',$ConsolidatedLot)->first(['linked_creative_id']);
        $linked_creative_id = $ConsolidatedLotData != null ? $ConsolidatedLotData->linked_creative_id : 0;

        if($linked_creative_id > 0){
            DB::table('creative_lots')->where('id',$linked_creative_id)->update([
                'project_name' =>  $project_name,
                'verticle' =>  $verticalType,
                'client_bucket' =>  $clientBucket,
                'lot_delivery_days' =>  $lot_delevery_days
            ]);
            ConsolidatedLot::where('id',$ConsolidatedLot)->update(['creative_graphic_form_data' => 1]);
        }
        if($linked_creative_id){
            request()->session()->flash('success','Creative Graphics Data Saved Successfully');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return $this->continueTask($request,$ConsolidatedLot);
    }

    public function createConsolidatedCatlog(Request $request){
        // dd($request);
        $ConsolidatedLot = $request->consolidated_lot_id;
        $servicesType = $request->servicesType;
        $requestType = $request->requestType;
        $reqDate = $request->reqDate;
        $rawimgDate = $request->rawimgDate;
        $ConsolidatedLotData = ConsolidatedLot::where('id',$ConsolidatedLot)->first(['linked_catlog_id']);
        $linked_catlog_id = $ConsolidatedLotData != null ? $ConsolidatedLotData->linked_catlog_id : 0;
        // dd($linked_catlog_id);
        if($linked_catlog_id > 0){
            DB::table('lots_catalog')->where('id',$linked_catlog_id)->update([
                'serviceType' =>  $servicesType,
                'requestType' =>  $requestType,
                'reqReceviedDate' =>  date("Y-m-d", strtotime($reqDate)),
                'imgReceviedDate' =>  date("Y-m-d", strtotime($rawimgDate))
            ]);
            ConsolidatedLot::where('id',$ConsolidatedLot)->update(['cataloging_form_data' => 1]);
        }
        if($linked_catlog_id){
            request()->session()->flash('success','Cataloging Data Saved Successfully');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return $this->continueTask($request,$ConsolidatedLot);
    }

    public function createConsolidatedEditorLot(Request $request){
        // dd($request);
        $ConsolidatedLot = $request->consolidated_lot_id;
        $request_name = $request->request_name;
        $ConsolidatedLotData = ConsolidatedLot::where('id',$ConsolidatedLot)->first(['linked_editor_lot_id']);
        $linked_editor_lot_id = $ConsolidatedLotData != null ? $ConsolidatedLotData->linked_editor_lot_id : 0;

        if($linked_editor_lot_id > 0){
            DB::table('editor_lots')->where('id',$linked_editor_lot_id)->update([
                'request_name' =>  $request_name
            ]);
            ConsolidatedLot::where('id',$ConsolidatedLot)->update(['editor_lot_form_data' => 1]);
        }
        if($linked_editor_lot_id){
            request()->session()->flash('success','Editing Data Saved Successfully');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return $this->continueTask($request,$ConsolidatedLot);
    }
}

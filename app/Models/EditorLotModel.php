<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditorLotModel extends Model
{
    use HasFactory;
    protected $table = 'editor_lots';
    protected $fillable = ['user_id', 'brand_id', 'lot_number', 'request_name'];

    // get data for create lot
    public static function Index()
    {
        $users_data = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([['users.Company', '<>', NULL], ['roles.name', '=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);
        // dd($users_data);

        $EditorLots = (object) [
            'id' => 0,
            'user_id' => '',
            'brand_id' => '',
            'lot_number' => '',
            'request_name' => '',
            'status' => '',
            'button_name' => 'Create Lot',
            'route' => 'store_editor_lot'
        ];
        return view('EditorLotPanel.Editor-Create-Lot')->with('users_data', $users_data)->with('EditorLots', $EditorLots);
    }

    // store lot data
    public static function store($request)
    {
        $EditorLots = new EditorLotModel();
        $EditorLots->user_id = $request->user_id;
        $EditorLots->brand_id = $request->brand_id;
        $EditorLots->lot_number = "";
        $EditorLots->request_name = $request->request_name;
        $EditorLots->status = 'ready_for_inwarding';
        $EditorLots->save();

        $id =  $EditorLots->id;
        // $request->s_type
        $s_type =  $request->request_name;
        $request_name_array = explode(" ", $s_type);
        $count = count($request_name_array);
        $request_name = "";
        // foreach( $request_name_array  as $key=>$val){
        //     $request_name .= $val[0];
        // }

        $request_name .= $request_name_array[0][0];
        $request_name .= $request_name_array[$count - 1][0];

        // dd($request_name);
        $lot_number = 'ODN' . date('dmY') . "-" . $request->c_short . $request->short_name .  $request_name . $id;
        //update lot number

        EditorLotModel::where('id', $id)->update(['lot_number' => strtoupper($lot_number)]);
        if ($EditorLots) {
            request()->session()->flash('success', 'Lots Created Successfully');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
    }

    // lot listing data
    public static function getEditorLotData()
    {
        $lots = EditorLotModel::orderBy('id', 'DESC')
            ->leftJoin('users', 'users.id', 'editor_lots.user_id')
            ->leftJoin('brands', 'brands.id', 'editor_lots.brand_id')
            ->select('editor_lots.*', 'users.Company', 'users.client_id', 'brands.name')
            ->get();
        return view('EditorLotPanel.Editor-View-Lot')->with('lots', $lots);
    }

    public static function edit($request, $id)
    {
        $users_data = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([['users.Company', '<>', NULL], ['roles.name', '=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);

        $EditorLots =  EditorLotModel::find($id);
        if ($EditorLots) {
            $EditorLots->button_name = 'Update Lot';
            $EditorLots->route = 'editor_update_lot';
            return view('EditorLotPanel.Editor-Create-Lot')->with('users_data', $users_data)->with('EditorLots', $EditorLots);
        }
    }

    // get Editing Lots Wrcs 
    public function getEditingWrc(){
		return $this->hasMany('App\Models\EditingWrc','lot_id','id')->with('getEditingEditedImages:id,user_id,allocation_id,wrc_id,file_path,filename');
	}

    // get Shoot Lots Wrcs 
    public function getShootWrc(){
		return $this->hasMany('App\Models\Wrc','lot_id','id')->with('getWrcSkus:id,lot_id,wrc_id,sku_code,user_id,brand_id');
	}


}

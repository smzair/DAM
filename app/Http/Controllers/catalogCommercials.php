<?php

namespace App\Http\Controllers;

use App\Models\CatalogCommercial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class catalogCommercials extends Controller
{

    public function Index()
    {
        $commercial_data = (object) [
            'id' => '0',
            'user_id' => '',
            'brand_id' => '',
            'market_place' => '',
            'type_of_service' => '',
            'CommercialSKU' => '',
        ];
        $users_data = DB::table('users')
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
            ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
            ->where([['users.Company', '<>', NULL], ['roles.name', '=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);
        return view('commercial.Catalog_commercial')->with('users', $users_data)->with('commercial_data', $commercial_data);
    }

    // create function for save Commercial
    public function create(Request $request)
    {

        // dd($request->all());
        $id = $request->id;
        $btn_val = $request->save;
        $user_id = $request->user_id;
        $brand_id = $request->brand_id;
        $market_place = implode(',',$request->market_place);
        $type_of_service = $request->type_of_service;
        $CommercialSKU = $request->CommercialSKU;

        $create_commercial = new CatalogCommercial();
            // insert
        $create_commercial->user_id = $user_id;
        $create_commercial->brand_id = $brand_id;
        $create_commercial->market_place = $market_place;
        $create_commercial->type_of_service = $type_of_service;
        $create_commercial->CommercialSKU = $CommercialSKU;
        $status = $create_commercial->save();
        if ($status) {

            if ($btn_val == 1) {
                request()->session()->flash('success', 'Commercial Successfully added');
                $commercial_data = (object) [
                    'id' => '0',
                    'user_id' => '',
                    'brand_id' => '',
                    'market_place' => '',
                    'type_of_service' => '',
                    'CommercialSKU' => '',
                ];
            }

            if ($btn_val == 2) {
                request()->session()->flash('success', 'Commercial Successfully added Add new');
                $commercial_data = (object) [
                    'id' => $id,
                    'user_id' => $user_id,
                    'brand_id' => $brand_id,
                    'market_place' => '',
                    'type_of_service' => '',
                    'CommercialSKU' => '',
                ];
            }
        }
        if (!$status) {
            request()->session()->flash('false', 'Commercial Successfully added');
            $commercial_data = (object) [
                'id' => $id,
                'user_id' => $user_id,
                'brand_id' => $brand_id,
                'market_place' => '',
                'type_of_service' => '',
                'CommercialSKU' => '',
            ];
        }
        $users_data = DB::table('users')
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
        ->where([['users.Company', '<>', NULL], ['roles.name', '=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);
        return view('commercial.Catalog_commercial')->with('users', $users_data)->with('commercial_data', $commercial_data);
    
    }

    // function for listing all Commercial logs
    public function View()
    {
        $commercial_list = CatalogCommercial::leftJoin('brands', 'brands.id', '=', 'create_commercial_catalog.brand_id')
        ->leftJoin('users', 'create_commercial_catalog.user_id', 'users.id')
        ->select('create_commercial_catalog.id', 'create_commercial_catalog.brand_id', 'create_commercial_catalog.market_place', 'create_commercial_catalog.type_of_service', 'create_commercial_catalog.CommercialSKU', 'users.Company', 'brands.name')
        ->get();
        $num = 1;
        return view('commercial.Catalog_commercialView')->with('com', $commercial_list)->with('num', $num);
    }

    // sending data for selectd id to edit this
    public function edit($id)
    {
        $users_data = DB::table('users')
        ->leftJoin('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->leftJoin('roles', 'roles.id', 'model_has_roles.role_id')
        ->where([['users.Company', '<>', NULL], ['roles.name', '=', 'Client']])->get(['users.id', 'users.client_id', 'users.name', 'users.Company', 'users.c_short']);


        $commercial_data = CatalogCommercial::where('id',$id)->first();
        // $commercial_data = CatalogCommercial::find($id);
        
        // $commercial_data = (object) [
        //     'id' =>$data->id,
        //     'user_id' =>$data->user_id,
        //     'brand_id' =>$data->brand_id,
        //     'market_place' => $data->market_place,
        //     'type_of_service' => $data->type_of_service,
        //     'CommercialSKU' => $data->CommercialSKU,
        // ];
        // dd($commercial_data);
        
       
        return view('commercial.Catalog_commercial')->with('users', $users_data)->with('commercial_data', $commercial_data);

        // dd($id);
    }

    // create function for save and update Commercial
    public function update(Request $request)
    {
        $id = $request->id;
        $btn_val = $request->save;
        $user_id = $request->user_id;
        $brand_id = $request->brand_id;
        $market_place = implode(',',$request->market_place);
        $type_of_service = $request->type_of_service;
        $CommercialSKU = $request->CommercialSKU;

        $create_commercial =  CatalogCommercial::find($request->id);
        $create_commercial->user_id = $user_id;
        $create_commercial->brand_id = $brand_id;
        $create_commercial->market_place = $market_place;
        $create_commercial->type_of_service = $type_of_service;
        $create_commercial->CommercialSKU = $CommercialSKU;
        $status = $create_commercial->update();

        if ($status) {
            request()->session()->flash('success', 'Commercial Log Successfully Updated!!');
        }
        if (!$status) {
            // $commercial_data = CatalogCommercial::where('id', $id)->first();
            request()->session()->flash('false', 'Somthing went wrong try again!!!');
        }


        return redirect()->route('EDITCATALOG', [$id]);
        // return redirect()->route('EDITCATALOG', [$id])->with('users', $users_data)->with('commercial_data', $commercial_data);
    }

    
}
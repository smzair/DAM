<?php

namespace App\Http\Controllers;

use App\Models\CatalogCommercial;
use App\Models\create_commercial;
use App\Models\EditorsCommercial;
use App\Models\NewCommercialModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class NewCommercial extends Controller
{
    //

    public function Index()
    {
        $newCommercial = [
            'id' => 0,
            'commCompanyId' => '0',
            'commBrandId' => '0',
            'commClientID' => '',
            'c_short' => '',
            'short_name' => '',
            'commshootcheck' => '0',
            'commcgcheck' => '0',
            'commcatcheck' => '0',
            'commEditorcheck' =>'0',
            'shootCheckIsDone' => '0',
            'cgCheckIsDone' => '0',
            'catCheckIsDone' => '0',
            'editorCheckIsDone' => '0',
        ];
        $shootCommercialArr = [];
        $cgCommercialArr = [];
        $catlogingCommercialArr = [];
        $editorCommercialArr = [];

        $data_array = array(
            "shootCommercialArr" => $shootCommercialArr,
            "cgCommercialArr" => $cgCommercialArr,
            "catlogingCommercialArr" => $catlogingCommercialArr,
            "editorCommercialArr" => $editorCommercialArr,
        );

        return view('Consilidate-Commercial.Consilidate-Commercial')->with('newCommercial', $newCommercial)->with('data_array', $data_array);
    }

    // save newCommercial into db
    public function create(Request $request){

        $createNewCommercialIdIs = NewCommercialModel::createNewCommercial($request);

        if($createNewCommercialIdIs > 0){
            request()->session()->flash('success', 'Commercial  Successfully Added!!');
            return Redirect::route('EditNewCommercial', ['id' => $createNewCommercialIdIs]);
        }else{
            request()->session()->flash('false', 'Somthing went wrong try again!!!');
            return Redirect::route('NewCommercial');
        }

        // dd($createNewCommercialIdIs , $request->all());
    }

    // save newCommercial into db
    public function update(Request $request)
    {
        $id = $request->id;
        $createNewCommercialIdIs = NewCommercialModel::updateNewCommercial($request);
        if ($createNewCommercialIdIs == 0) {
            $createNewCommercialIdIs = $id;
        } else {
            // return Redirect::route('NewCommercial');
        }
        return Redirect::route('EditNewCommercial', ['id' => $createNewCommercialIdIs]);

        // dd($createNewCommercialIdIs , $request->all());
    }

    // listing newCommercialList 
    public function view(){

        $commercial_list = NewCommercialModel::leftJoin('brands', 'brands.id', '=', 'new_commercials.commBrandId')
            ->leftJoin('users', 'new_commercials.commCompanyId', 'users.id')
            ->select(
            'new_commercials.id',
            'new_commercials.commCompanyId',
            'new_commercials.commBrandId',
            'new_commercials.commClientID',
            'new_commercials.commshootcheck',
            'new_commercials.commcgcheck',
            'new_commercials.commcatcheck',
            'new_commercials.shootCheckIsDone',
            'new_commercials.cgCheckIsDone',
            'new_commercials.catCheckIsDone',
            'new_commercials.commEditorcheck',
            'new_commercials.editorCheckIsDone', 
            'users.Company as company', 
            'brands.name'
            )
            ->get();
        $num = 1;
        return view('Consilidate-Commercial.Consilidate-Commercial-List')->with('com', $commercial_list)->with('num', $num);

    }

    public function Edit($id)
    {
        $newCommercial = NewCommercialModel::where('new_commercials.id',$id)->
        leftJoin('brands', 'brands.id', '=', 'new_commercials.commBrandId')
        ->leftJoin('users', 'new_commercials.commCompanyId', 'users.id')
        ->select('new_commercials.id', 'new_commercials.*', 'users.Company as company', 'brands.name')
        ->first()->toArray();

        // dd($newCommercial);
        extract($newCommercial);
        $newCommercialId = $newCommercial['id'];
        $shootCommercialArr = [];
        $cgCommercialArr = [];
        $catlogingCommercialArr = [];
        $editorCommercialArr = [];
        if ($shootCheckIsDone == 2) {
            $result = DB::table('commercial')->where('newCommercialId', $newCommercialId)->get()->first();
            if($result != null){
                $shootCommercialArr = (array) $result;
                // $shootCommercialArr = $shootCommercialArr->toArray();
            }    
        }
        if ($cgCheckIsDone == 2) {
            $result = create_commercial::where('newCommercialId', $newCommercialId)->first();
            if ($result != null) {
                $cgCommercialArr = $result->toArray();
            }    
        }
        if ($catCheckIsDone == 2) {
            $result = CatalogCommercial::where('newCommercialId', $newCommercialId)->first();
            if ($result != null) {
                $catlogingCommercialArr = $result->toArray();
            }
        }
        if ($editorCheckIsDone == 2) {
            $result = EditorsCommercial::where('newCommercialId', $newCommercialId)->get()->first();
            if ($result != null) {
                $editorCommercialArr = $result->toArray();
            }
        }
        $data_array = array(
            "shootCommercialArr" => $shootCommercialArr,
            "cgCommercialArr" => $cgCommercialArr,
            "catlogingCommercialArr" => $catlogingCommercialArr,
            "editorCommercialArr" => $editorCommercialArr,
        );
        // dd($data_array);


        return view('Consilidate-Commercial.Consilidate-Commercial')->with('newCommercial', $newCommercial)->with('data_array', $data_array);
    }

    // Function for store new Shoot Commercial
    public function saveShootCommercial(Request $request)
    {
        $newCommercialId = $request->newCommercialId;
        $create_commercial_Id = NewCommercialModel::saveShootCommercial($request);
        if ($create_commercial_Id > 0) {
            request()->session()->flash('success', 'Shoot Commercial  Successfully Added!!');
        } else {
            request()->session()->flash('false', 'Somthing went wrong try again!!!');
        }
        return Redirect::route('EditNewCommercial', ['id' => $newCommercialId]);
    }
    
    // Function for store new Creative Commercial
    public function SaveCreativeCommercial(Request $request)
    {
        // dd($request->all());
        $newCommercialId = $request->newCommercialId;
        $create_commercial_Id = NewCommercialModel::SaveCreativeCommercial($request);

        if ($create_commercial_Id > 0) {
            request()->session()->flash('success', 'Creative Commercial  Successfully Added!!');
        } else {
            request()->session()->flash('false', 'Somthing went wrong try again!!!');
        }
        return Redirect::route('EditNewCommercial', ['id' => $newCommercialId]);
    }
    
    // Function for store new Cataloging Commercial
    public function SaveCatalogingCommercial(Request $request)
    {
        $newCommercialId = $request->newCommercialId;
        $create_Cataloging_Id = NewCommercialModel::SaveCatalogingCommercial($request);

        if ($create_Cataloging_Id > 0) {
            request()->session()->flash('success', 'Creative Cataloging  Successfully Added!!');
        } else {
            request()->session()->flash('false', 'Somthing went wrong try again!!!');
        }
        return Redirect::route('EditNewCommercial', ['id' => $newCommercialId]);
    }

    
    // Function for store new Editors Commercial
    public function SaveEditorCommercial(Request $request)
    {
        $newCommercialId = $request->newCommercialId;
        $create_Cataloging_Id = NewCommercialModel::SaveEditorCommercial($request);

        if ($create_Cataloging_Id > 0) {
            request()->session()->flash('success', 'Editor Commercial Successfully Added!!');
        } else {
            request()->session()->flash('false', 'Somthing went wrong try again!!!');
        }
        return Redirect::route('EditNewCommercial', ['id' => $newCommercialId]);
    }



}

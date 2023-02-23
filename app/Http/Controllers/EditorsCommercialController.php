<?php

namespace App\Http\Controllers;

use App\Models\EditorsCommercial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditorsCommercialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commercial_list = EditorsCommercial::CommercialList();
        $num = 1;
        return view('Editor.Editors-Commercial-View')->with('com', $commercial_list)->with('num', $num);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $commercial_data = (object) [
            'id' => '0',
            'company_id' => '',
            'brand_id' => '',
            'type_of_service' => '',
            'CommercialPerImage' => '',
        ];
        return view('Editor.Commercial-Editor')->with('commercial_data', $commercial_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $commercial_data = EditorsCommercial::savecommercial($request);
        return view('Editor.Commercial-Editor')->with('commercial_data', $commercial_data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $commercial_data = EditorsCommercial::editcommercial($id);
        return view('Editor.Commercial-Editor')->with('commercial_data', $commercial_data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $status = EditorsCommercial::updateCommercial($request);
        if ($status) {
            request()->session()->flash('success', 'Commercial Successfully Updated!!');
        }
        if (!$status) {
            request()->session()->flash('false', 'Somthing went wrong try again!!!');
        }
        return redirect()->route('EditCommercialEditor', [$id]);
        // dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

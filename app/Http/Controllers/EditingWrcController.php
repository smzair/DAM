<?php

namespace App\Http\Controllers;

use App\Models\CatlogWrc;
use App\Models\EditingWrc;
use App\Models\EditorLotModel;
use App\Models\EditorsCommercial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditingWrcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Editing-Wrc-list.blade
        $wrcs =  EditingWrc::OrderBy('editing_wrcs.updated_at', 'DESC')
        ->leftJoin('editor_lots', 'editor_lots.id', 'editing_wrcs.lot_id')
        ->leftJoin('users', 'users.id', 'editor_lots.user_id')
        ->leftJoin('brands', 'brands.id', 'editor_lots.brand_id')
        ->select(
            'editing_wrcs.*',
            'editor_lots.user_id',
            'editor_lots.brand_id',
            'editor_lots.lot_number',
            'users.Company as Company_name',
            'brands.name'
        )
            ->get();
        //    dd($wrcs);
        return view('Wrc.Editing-Wrc-list')->with('wrcs', $wrcs);
        // return view('Wrc.Editing-Wrc-list')->with('EditingWrc', $EditingWrc)->with('sku_details', $sku_details);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $EditingWrc = (object) [
            'id' => 0,
            'user_id' => '',
            'brand_id' => '',
            'lot_id' => '',
            'commercial_id' => '',
            'wrc_number' => '',
            'imgQty' => '',
            'documentType' => '0',
            'documentUrl' => '',
            'documentUrl' => '',
        ];
        $sku_details = array(
            'unique_Count' => 0,
            'variant_Count' => 0,
            'total_Count' => 0,
        );
        return view('Wrc.Editing_wrc_create')->with('EditingWrc', $EditingWrc)->with('sku_details', $sku_details);
    }

    /**Listing Lot Number and client Buket(comiercial) for Editing .
     *
     * @return \Illuminate\Http\Response
     */
    public function getLotNumber(Request $request)
    {
        $user_id = $request->user_id;
        $brand_id = $request->brand_id;
        $data = [];

        $lot_number_data = EditorLotModel::where('editor_lots.user_id', $user_id)->where('editor_lots.brand_id', $brand_id)
            ->leftJoin('brands', 'editor_lots.brand_id', 'brands.id')->select('editor_lots.*', 'brands.short_name')->get()->toArray();

        $commercial_data = EditorsCommercial::where('company_id', $user_id)->where('brand_id', $brand_id)->leftJoin('brands', 'editors_commercials.brand_id', 'brands.id')->select('editors_commercials.*')->get()->toArray();

        // dd('lot_number_data ',$lot_number_data, 'commercial_data', $commercial_data);

        $data = ["lot_number_data" => $lot_number_data, "commercial_data" => $commercial_data];
        echo json_encode($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          
        $status = EditingWrc::storedata($request);
        /* send notification start */
            $creation_type = 'WrcEditor';
            $data = EditingWrc::orderBy('id','DESC')->first(['wrc_number','imgQty']);
            $this->send_notification($data, $creation_type);
        /******  send notification end*******/
        return $status;
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

        $EditingWrc =  EditingWrc::find($id);
        $lot_id = $EditingWrc->lot_id;
        $lot = DB::table('editor_lots')->where('id', $lot_id)->first(['user_id', 'brand_id']);
        $user_id = $lot != null ? $lot->user_id : 0;
        $brand_id = $lot != null ? $lot->brand_id : 0;
        $EditingWrc->user_id = $user_id;
        $EditingWrc->brand_id = $brand_id;
        $sku_details = array(
            'unique_Count' => 0,
            'variant_Count' => 0,
            'total_Count' => 0,
        );
        return view('Wrc.Editing_wrc_create')->with('EditingWrc', $EditingWrc)->with('sku_details', $sku_details);
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
        return $status = EditingWrc::updatedata($request);
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

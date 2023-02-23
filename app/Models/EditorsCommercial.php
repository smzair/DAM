<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorsCommercial extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'company_id', 'brand_id', 'type_of_service', 'CommercialPerImage', 'newCommercialId',
    ];

    protected $table = 'editors_commercials';

    // Store a newly created resource in storage
    public static function savecommercial($request){
        $id = $request->id;
        $btn_val = $request->save;
        $company_id = $request->company_id;
        $brand_id = $request->brand_id;
        $type_of_service = $request->type_of_service;
        $CommercialPerImage = $request->CommercialPerImage;

        $EditorsCommercial = new EditorsCommercial();
        // dd($EditorsCommercial);
        $EditorsCommercial->company_id = $company_id;
        $EditorsCommercial->brand_id = $brand_id;
        $EditorsCommercial->type_of_service = $type_of_service;
        $EditorsCommercial->CommercialPerImage = $CommercialPerImage;
        $EditorsCommercial->newCommercialId = 0;
        $status = $EditorsCommercial->save();

        $btn_val = $request->save;

        if ($status) {
            if ($btn_val == 1) {
                request()->session()->flash('success', 'Commercial Successfully added');
                $commercial_data = (object) [
                    'id' => '0',
                    'company_id' => '',
                    'brand_id' => '',
                    'type_of_service' => '',
                    'CommercialPerImage' => '',
                ];
            }

            if ($btn_val == 2) {
                request()->session()->flash('success', 'Commercial added Successfully !! Add New Commercial !!');
                $commercial_data = (object) [
                    'id' => $id,
                    'company_id' => $company_id,
                    'brand_id' => $brand_id,
                    'type_of_service' => '',
                    'CommercialPerImage' => '',
                ];
            }
        }
        if (!$status) {
            request()->session()->flash('false', 'Commercial added Successfully !!');
            $commercial_data = (object) [
                'id' => $id,
                'company_id' => $company_id,
                'brand_id' => $brand_id,
                'market_place' => '',
                'type_of_service' => '',
                'CommercialPerImage' => '',
            ];
        }

        return $commercial_data;

    }

    // Display a listing of the resource.
    public static function CommercialList(){
       return $commercial_list = EditorsCommercial::leftJoin('brands', 'brands.id', '=', 'editors_commercials.brand_id')
        ->leftJoin('users', 'editors_commercials.company_id', 'users.id')
        ->select('editors_commercials.*', 'users.Company', 'brands.name')
        ->get();
    }

    // Show the form for editing the specified resource
    public static function editcommercial($id)
    {
        return $commercial_data = EditorsCommercial::where('id',$id)
        ->select('editors_commercials.*')
        ->get()->first();
    }

    // Update the specified resource in storage.
    public static function updateCommercial($request){
        $id = $request->id;
        $btn_val = $request->save;
        $company_id = $request->company_id;
        $brand_id = $request->brand_id;
        $type_of_service = $request->type_of_service;
        $CommercialPerImage = $request->CommercialPerImage;

        $EditorsCommercial = EditorsCommercial::find($request->id);
        $EditorsCommercial->company_id = $company_id;
        $EditorsCommercial->brand_id = $brand_id;
        $EditorsCommercial->type_of_service = $type_of_service;
        $EditorsCommercial->CommercialPerImage = $CommercialPerImage;
        return $status = $EditorsCommercial->update();
    }


    
}

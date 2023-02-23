<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NewCommercialModel extends Model
{
    use HasFactory;

    protected $table = 'new_commercials';

    protected $fillable = [
        'id', 
        'commCompanyId', 
        'commBrandId',
        'commClientID',
        'c_short',
        'short_name',
        'commshootcheck',
        'commcgcheck',
        'commcatcheck',
        'shootCheckIsDone',
        'cgCheckIsDone',
        'catCheckIsDone',
        'commEditorcheck',
        'editorCheckIsDone',
    ];

    // Save New Commercial into Db
    public static function createNewCommercial($request){
        // dd($request->all());
        $commCompanyId = $request->commCompanyId;
        $commBrandId = $request->commBrandId;
        $c_short = $request->c_short;
        $short_name = $request->short_name;
        $commClientID = $request->commClientID;
        $commshootcheck = request()->has('commshootcheck') ? $request->commshootcheck : 0;
        $commcgcheck = request()->has('commcgcheck') ? $request->commcgcheck : 0;
        $commcatcheck = request()->has('commcatcheck') ? $request->commcatcheck : 0;
        $commEditorcheck = request()->has('commEditorcheck') ? $request->commEditorcheck : 0;

        $shootCheckIsDone = $commshootcheck > 0 ? 1 : 0;
        $cgCheckIsDone = $commcgcheck > 0 ? 1 : 0;
        $catCheckIsDone = $commcatcheck > 0 ? 1 : 0;
        $editorCheckIsDone = $commEditorcheck > 0 ? 1 : 0;

        $createNewCommercial = new NewCommercialModel();
        $createNewCommercial->commCompanyId = $commCompanyId;
        $createNewCommercial->commBrandId = $commBrandId;
        $createNewCommercial->c_short = $c_short;
        $createNewCommercial->short_name = $short_name;
        $createNewCommercial->commClientID = $commClientID;
        $createNewCommercial->commshootcheck = $commshootcheck;
        $createNewCommercial->commcgcheck = $commcgcheck;
        $createNewCommercial->commcatcheck = $commcatcheck;
        $createNewCommercial->shootCheckIsDone = $shootCheckIsDone;
        $createNewCommercial->cgCheckIsDone = $cgCheckIsDone;
        $createNewCommercial->catCheckIsDone = $catCheckIsDone;
        $createNewCommercial->commEditorcheck = $commEditorcheck;
        $createNewCommercial->editorCheckIsDone = $editorCheckIsDone;
        $status = $createNewCommercial->save();

        if($status){
            $createNewCommercialIdIs = $createNewCommercial->id;
        }else{
            $createNewCommercialIdIs = 0;
        }
        return $createNewCommercialIdIs;
    }

    // update New Commercial into Db
    public static function updateNewCommercial($request)
    {
        $id = $request->id;
        $commCompanyId = $request->commCompanyId;
        $commBrandId = $request->commBrandId;
        $c_short = $request->c_short;
        $short_name = $request->short_name;
        $commClientID = $request->commClientID;
        $commshootcheck = request()->has('commshootcheck') ? $request->commshootcheck : 0;
        $commcgcheck = request()->has('commcgcheck') ? $request->commcgcheck : 0;
        $commcatcheck = request()->has('commcatcheck') ? $request->commcatcheck : 0;
        $commEditorcheck = request()->has('commEditorcheck') ? $request->commEditorcheck : 0;
        $shootCheckIsDone = $commshootcheck > 0 ? 1 : 0;
        $cgCheckIsDone = $commcgcheck > 0 ? 1 : 0;
        $catCheckIsDone = $commcatcheck > 0 ? 1 : 0;
        $editorCheckIsDone = $commEditorcheck > 0 ? 1 : 0;

        $createNewCommercial =  NewCommercialModel::find($request->id);
        $createNewCommercial->commCompanyId = $commCompanyId;
        $createNewCommercial->commBrandId = $commBrandId;
        $createNewCommercial->c_short = $c_short;
        $createNewCommercial->short_name = $short_name;
        $createNewCommercial->commClientID = $commClientID;
        $createNewCommercial->commshootcheck = $commshootcheck;
        $createNewCommercial->commcgcheck = $commcgcheck;
        $createNewCommercial->commcatcheck = $commcatcheck;
        $createNewCommercial->shootCheckIsDone = $shootCheckIsDone;
        $createNewCommercial->cgCheckIsDone = $cgCheckIsDone;
        $createNewCommercial->catCheckIsDone = $catCheckIsDone;
        $createNewCommercial->commEditorcheck = $commEditorcheck;
        $createNewCommercial->editorCheckIsDone = $editorCheckIsDone;
        $status = $createNewCommercial->update();

        if ($status) {
            $createNewCommercialIdIs = $id;
            request()->session()->flash('success', 'Commercial Successfully Updated!!');
        } else {
            $createNewCommercialIdIs = 0;
            request()->session()->flash('false', 'Somthing went wrong try again!!!');
        }
        return $createNewCommercialIdIs;
    }

    // store new Shoot Commercial
    public static function saveShootCommercial($request)
    {
        // SELECT `id`, `user_id`, `brand_id`, `flat_shot`, `extra_mood_shot`, `product_category`, `main_com`, `type_of_shoot`, `type_of_clothing`, `gender`, `adaptation_1`, `adaptation_2`, `adaptation_3`, `adaptation_4`, `adaptation_5`, `specfic_adaptation`, `commercial_value_per_sku`, `newCommercialId`, `comercial_c`, `created_at`, `updated_at` FROM `commercial` WHERE 1
        $newCommercialId = $request->newCommercialId;
        $user_id = $request->user_id;
        $brand_id = $request->brand_id;
        $product_category = $request->product_category;
        $type_of_shoot = $request->type_of_shoot;
        $type_of_clothing = $request->type_of_clothing;
        $gender = $request->gender;
        $adaptation_1 = $request->adaptation_1;
        $adaptation_2 = $request->adaptation_2;
        $adaptation_3 = $request->adaptation_3;
        $adaptation_4 = $request->adaptation_4;
        $adaptation_5 = $request->adaptation_5;
        $commercial_value_per_sku = $request->commercial_value_per_sku;

        // $create_commercial = new create_commercial();
        // $create_commercial->user_id = $user_id;
        // $create_commercial->brand_id = $brand_id;
        // $create_commercial->product_category = $product_category;
        // $create_commercial->type_of_shoot = $type_of_shoot;
        // $create_commercial->type_of_clothing = $type_of_clothing;
        // $create_commercial->gender = $gender;
        // $create_commercial->adaptation_1 = $adaptation_1;
        // $create_commercial->adaptation_2 = $adaptation_2;
        // $create_commercial->adaptation_3 = $adaptation_3;
        // $create_commercial->adaptation_4 = $adaptation_4;
        // $create_commercial->adaptation_5 = $adaptation_5;
        // $create_commercial->commercial_value_per_sku = $commercial_value_per_sku;
        // $create_commercial->newCommercialId = $newCommercialId;

        $now = new \DateTime();
        $data_arr = [
            'user_id' => $user_id,
            'brand_id' => $brand_id,
            'product_category' => $product_category,
            'type_of_shoot' => $type_of_shoot,
            'type_of_clothing' => $type_of_clothing,
            'gender' => $gender,
            'adaptation_1' => $adaptation_1,
            'adaptation_2' => $adaptation_2,
            'adaptation_3' => $adaptation_3,
            'adaptation_4' => $adaptation_4,
            'adaptation_5' => $adaptation_5,
            'commercial_value_per_sku' => $commercial_value_per_sku,
            'newCommercialId' => $newCommercialId,
            'created_at' => $now,
            'updated_at' => $now
        ];
        $create_shoot_Id = DB::table('commercial')->insertGetId($data_arr);

        if($create_shoot_Id > 0){
            $createNewCommercial =  NewCommercialModel::find($newCommercialId);
            $createNewCommercial->shootCheckIsDone = 2;
            $upstatus = $createNewCommercial->update();
        }
        // dd($create_shoot_Id,$data_arr, $request->all());
        return $create_shoot_Id;
    }
    // store new Creative Commercial
    public static function SaveCreativeCommercial($request)
    {
        $newCommercialId = $request->newCommercialId;
        $id = $request->id;
        $user_id = $request->user_id;
        $brand_id = $request->brand_id;
        $project_name = $request->commProjectName;
        $kind_of_work = $request->commWorkType;
        $per_qty_value = $request->commQty;
        $create_commercial = new create_commercial();

        $create_commercial->user_id = $user_id;
        $create_commercial->brand_id = $brand_id;
        $create_commercial->project_name = $project_name;
        $create_commercial->kind_of_work = $kind_of_work;
        $create_commercial->per_qty_value = $per_qty_value;
        $create_commercial->newCommercialId = $newCommercialId;
        $status = $create_commercial->save();

        if ($status) {
            $createNewCommercial =  NewCommercialModel::find($newCommercialId);
            $createNewCommercial->cgCheckIsDone = 2;
            $upstatus = $createNewCommercial->update();
            $create_commercial_Id = $create_commercial->id;
        } else {
            $create_commercial_Id = 0;
        }
        return $create_commercial_Id;
    }
    // store new Cataloging Commercial
    public static function SaveCatalogingCommercial($request)
    {

        $newCommercialId = $request->newCommercialId;
        $user_id = $request->user_id;
        $brand_id = $request->brand_id;
        $market_place = implode(',', $request->market_place);
        $type_of_service = $request->commctseviceType;
        $CommercialSKU = $request->commUnit;

        // dd($request->all());

        $create_commercial = new CatalogCommercial();
        $create_commercial->user_id = $user_id;
        $create_commercial->brand_id = $brand_id;
        $create_commercial->market_place = $market_place;
        $create_commercial->type_of_service = $type_of_service;
        $create_commercial->CommercialSKU = $CommercialSKU;
        $create_commercial->newCommercialId = $newCommercialId;
        $status = $create_commercial->save();

        if ($status) {
            $createNewCommercial =  NewCommercialModel::find($newCommercialId);
            $createNewCommercial->catCheckIsDone = 2;
            $upstatus = $createNewCommercial->update();
            $create_Cataloging_Id = $create_commercial->id;
        } else {
            $create_Cataloging_Id = 0;
        }
        return $create_Cataloging_Id;
    }

    // store new Cataloging Commercial
    public static function SaveEditorCommercial($request)
    {
        $newCommercialId = $request->newCommercialId;
        $company_id = $request->user_id;
        $brand_id = $request->brand_id;
        $type_of_service = $request->type_of_service;
        $CommercialPerImage = $request->CommercialPerImage;
        
        
        $create_commercial = new EditorsCommercial();
        // dd($request->all(), $create_commercial);
        $create_commercial->company_id = $company_id;
        $create_commercial->brand_id = $brand_id;
        $create_commercial->type_of_service = $type_of_service;
        $create_commercial->CommercialPerImage = $CommercialPerImage;
        $create_commercial->newCommercialId = $newCommercialId;
        $status = $create_commercial->save();

        if ($status) {
            $createNewCommercial =  NewCommercialModel::find($newCommercialId);
            $createNewCommercial->editorCheckIsDone = 2;
            $upstatus = $createNewCommercial->update();
            $create_Cataloging_Id = $create_commercial->id;
        } else {
            $create_Cataloging_Id = 0;
        }
        return $create_Cataloging_Id;
    }

}

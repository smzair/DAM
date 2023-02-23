<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Marketplace extends Model
{
    use HasFactory;
    protected $table = 'marketplaces';

    protected $fillable = [
        'id', 'marketPlace_name', 'link', 'username', 'password'
    ];

    public static function marketplace_Credentials_List($commercial_id, $market_place_ids){
        $market_place_ids = explode(',', $market_place_ids);
        $response = Marketplace::whereIn('id', $market_place_ids)->
        select('id', 'marketPlace_name', 'link', 'username', 'password')->
        get()->toArray();
        return $response;
    }

    public static function catalog_marketplace_Credentials_List($commercial_id, $market_place_ids)
    {
        $market_place_ids = explode(',', $market_place_ids);
        $response = Marketplace::
        // leftJoin('catalog_marketplace_credentials', 'catalog_marketplace_credentials.marketplace_id', 'marketplaces.id')->
        leftJoin('catalog_marketplace_credentials', function ($join) use ($commercial_id) {
            $join->on('catalog_marketplace_credentials.marketplace_id', '=', 'marketplaces.id');
            $join->where('catalog_marketplace_credentials.commercial_id', '=', $commercial_id)
                ->orWhere('catalog_marketplace_credentials.commercial_id', '=', NULL);
        })->

        whereIn('marketplaces.id', $market_place_ids)->
        where(function ($query) use ($commercial_id) {
            $query->where('catalog_marketplace_credentials.commercial_id', '=', $commercial_id)
                ->orWhere('catalog_marketplace_credentials.commercial_id', '=', NULL);
        })->
        select(
            'marketplaces.id',
            'marketplaces.marketPlace_name',
            'catalog_marketplace_credentials.id as credentials_id',
            'catalog_marketplace_credentials.link',
            'catalog_marketplace_credentials.username',
            'catalog_marketplace_credentials.password',
            )->
        get()->toArray();
        // dd($response);
        return $response;
    }

    public static function save_wrc_Credentials($data_arr, $commercial_id_is, $market_place_id_is)
    {
        $response = 0;
        $res_arr = [];
        $massage = "Somthing went Wrong please try again!!!";

        $resCredentials_id_arr = [];
        DB::beginTransaction();
        try {
            $commercial_id = $commercial_id_is;
            
            foreach ($data_arr as $data) {
                $marketplace_id = $data['marketPlace_id'];
                $credentials_id = $data['credentials_id'];
                $link           = $data['link'] == '' ? NULL : $data['link'];
                $username           = $data['username'] == '' ? NULL : $data['username'];
                $password           = $data['password'] == '' ? NULL : $data['password'];
                // dd($data);
                if($credentials_id > 0){
                    $storeData = CatalogMarketplaceCredentials::find($credentials_id);
                    // dd($storeData);
                    $storeData->link = $link;
                    $storeData->username = $username;
                    $storeData->password = $password;
                    $status = $storeData->update();
                    $massage = "Marketplace Credentials updated!!!";
                }else{
                    $massage = "Marketplace Credentials Saved!!!";
                    $saveData = new CatalogMarketplaceCredentials();
                    $saveData->marketplace_id = $marketplace_id;
                    $saveData->commercial_id = $commercial_id;
                    $saveData->link = $link;
                    $saveData->username = $username;
                    $saveData->password = $password;
                    $status = $saveData->save();
                    $credentials_id = 0;
                    if($status){
                        $credentials_id = $saveData->id;
                    }
                }

                $resCredentials_id_arr['credentials_id'.$marketplace_id] = $credentials_id;
                // dd($credentials_id);
                array_push($res_arr, $status);
                // array_push($resCredentials_id_arr, $credentials_id);
            }

            if(array_sum($res_arr) == count($res_arr)){
                DB::commit();
                $response = 1;
            }else{
                DB::rollback();
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }    
        return json_encode(array(
            'response' => $response,
            'res_arr' => $res_arr,
            'resCredentials_id_arr' => $resCredentials_id_arr,
            'massage' => $massage,
        ));
    }


}

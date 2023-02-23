<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Return_;

class CatalogMarketplaceCredentials extends Model
{
    use HasFactory;
    protected $table = 'catalog_marketplace_credentials';

    protected $fillable = [
        'marketplace_id', 'commercial_id', 'link', 'username', 'password'
    ];

    
    
    public static function get_c_data($user_id, $brand_id, $commercial_id = 0){
        $status = 0;
        $massage = "Somthing Went Wrong!!";
        $data = [];
        if($commercial_id == 0){
            $commercial_id = "";
            $commercial_data = CatalogCommercial::
            where([
                ['user_id', '=', $user_id],
                ['brand_id', '=', $brand_id],
            ])->
            select('id','user_id', 'brand_id', 'market_place', 'type_of_service')->
            get()->toArray();
            $cnt_data = count($commercial_data);

            $commercial_ids = [];
            if($cnt_data > 0){
                foreach ($commercial_data as $key => $row) {
                    $commercial_id_is = $row['id'];
                    array_push($commercial_ids, $commercial_id_is);
                }
            }
        }else{
            $commercial_ids = explode(',', $commercial_id);
        }

        $cnt_commercial_ids = count($commercial_ids);
        if($cnt_commercial_ids > 0){
            $data = CatalogMarketplaceCredentials::
            leftjoin('marketplaces', 'marketplaces.id', 'catalog_marketplace_credentials.marketplace_id')->
            whereIn('commercial_id', $commercial_ids)->
            select(
                'marketplaces.marketPlace_name',
                'catalog_marketplace_credentials.id as credentials_id',
                'catalog_marketplace_credentials.link',
                'catalog_marketplace_credentials.commercial_id',
                'catalog_marketplace_credentials.username',
                'catalog_marketplace_credentials.password',
            )->
            get()->toArray();
            if (count($data) > 0) {
                $status = 1;
                $massage = "Marketplace Credentials List get!!";
            }else{
                $massage = "Marketplace Credentials Not Found!!";
            }
        }else{
            $massage = "Somthing Went Wrong!!";
        }
        
        
        return json_encode(
            array(
                'status' => $status,
                'massage' => $massage,
                'data' => $data,
            )
        );
    }


    public static function commercial_wise_MarketplaceCredentials_list(){
       $data = CatalogMarketplaceCredentials::
        leftJoin('marketplaces', 'marketplaces.id', 'catalog_marketplace_credentials.marketplace_id')->
        select(
            'catalog_marketplace_credentials.id',
            'catalog_marketplace_credentials.commercial_id',
            'catalog_marketplace_credentials.link',
            'catalog_marketplace_credentials.username',
            'catalog_marketplace_credentials.password',
            'catalog_marketplace_credentials.created_at',
            'catalog_marketplace_credentials.updated_at',
            'catalog_marketplace_credentials.marketplace_id',
            'marketplaces.marketPlace_name', 
        )->
        get()->toArray();
        return $data;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CatalogWrcBatch extends Model
{
    use HasFactory;

    protected $table = 'catalog_wrc_batches';
    protected $fillable = [
        'wrc_id', 'batch_no', 'sku_count' , 'prequisites'
    ];


    public static function catalog_Wrc_Batch_list(){
        // SELECT lots_catalog.serviceType , lots_catalog.lot_number 
        // ,catalog_wrc_batches.batch_no , catalog_wrc_batches.sku_count
        // , catlog_wrc.id , catlog_wrc.wrc_number , catlog_wrc.modeOfDelivary , catlog_wrc.commercial_id,catlog_wrc.is_retainer

        $catalog_Wrc_Batch_list = CatalogWrcBatch::
        where('lots_catalog.requestType','=', 'Retainer')->
        leftJoin('catlog_wrc', 'catlog_wrc.id', 'catalog_wrc_batches.wrc_id')->
        leftJoin('lots_catalog', 'lots_catalog.id', 'catlog_wrc.lot_id')->
        leftJoin('users', 'lots_catalog.user_id', 'users.id')->
        leftJoin('brands', 'lots_catalog.brand_id', 'brands.id')->
        select(
            
            'catalog_wrc_batches.wrc_id',
            'catalog_wrc_batches.created_at as wrc_created_at',
            'catalog_wrc_batches.batch_no',
            'catalog_wrc_batches.sku_count',
            DB::raw('COUNT(catalog_wrc_batches.batch_no) as total_batch_no'),
            'catlog_wrc.wrc_number',
            'catlog_wrc.modeOfDelivary',
            'catlog_wrc.commercial_id',
            'catlog_wrc.is_retainer',
            'catlog_wrc.sku_qty as total_skus',
            'lots_catalog.serviceType',
            'lots_catalog.lot_number',
            'users.Company',
            'users.c_short',
            'brands.name as brand_name',
            'brands.short_name',
        )->groupBy(['catalog_wrc_batches.wrc_id', 'catalog_wrc_batches.batch_no'])->
        orderBy('catalog_wrc_batches.wrc_id' , 'ASC')->orderBy('catalog_wrc_batches.id' , 'ASC')->
        get()->toArray();
        
        return $catalog_Wrc_Batch_list;

    }
}

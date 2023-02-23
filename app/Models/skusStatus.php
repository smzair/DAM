<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class skusStatus extends Model {

    use HasFactory;

    protected $fillable = [
        'sku_id',
        'status',
    ];
    protected $table = 'sku_status';

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults();
    }

    public static function getSkuStatusList($filter = []) {

        $wheerArr = [];
        if (isset($filter['wrc_id'])) {
            $wheerArr[] = ['sku.wrc_id', '=', $filter['wrc_id']];
        }
        if (isset($filter['status'])) {
            $wheerArr[] = ['sku_status.status', '=', $filter['status']];
        }
        $result = DB::table('sku_status')
                ->join('sku', 'sku.id', '=', 'sku_status.sku_id')
                ->select('sku_status.status as log_status', 'sku.current_status', 'sku.status as sku_status', 'sku_status.sku_id', 'sku_status.id as sku_log_id', 'sku_status.created_at')
                ->where($wheerArr);
        if (isset($filter['count'])) {
            return $result->count();
        }
        if (isset($filter['single'])) {
            return $result->first();
        }
        return $result->get();
    }

}

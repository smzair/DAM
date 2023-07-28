<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class invoiceMOD extends Model
{
    use HasFactory;
    
       protected $table = 'invoice';
       
       public static function getInvoiceInfo($filter = []) {
        $wheerArr = [];
        if (isset($filter['user_id'])) {
            $wheerArr[] = ['users.id', '=', $filter['user_id']];
        }
        if (isset($filter['brand_id'])) {
            $wheerArr[] = ['brands.id', '=', $filter['brand_id']];
        }
        if (isset($filter['invoice'])) {
            $wheerArr[] = ['invoice.id', '=', $filter['invoice']];
        }
        $result = DB::table('invoice')
                ->join('users', 'users.id', '=', 'invoice.user_id')
                ->join('brands', 'brands.id', '=', 'invoice.brand_id')
                ->select( 'users.Company', 'users.client_id', 'brands.name','users.Address','users.Gst_number','users.email','users.phone','users.name as uname','users.payment_term','invoice.status','invoice.id','invoice.total_amount','invoice.invoice_number')
                ->where($wheerArr)
                ->orderBy('invoice.id', 'DESC');

        if (isset($filter['single'])) {
            return $result->first();
        }
        return $result->groupBy('invoice.invoice_number')->get();
    }
}

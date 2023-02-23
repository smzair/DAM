<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class feedback extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'brand_id',
        'name',
        'email',
        'type_of_service',
        'am_name',
        'q1',
        'q2',
        'q3',
        'q4',
        'q5_1',
        'q5_2',
        'q5_3',
        'q6_1',
        'q6_2',
        'q6_3',
        'q7',

    ];

    protected $table = 'feedback';

 public static function getlotInfo() {
    
        $result = DB::table('feedback')
                ->join('users', 'users.id', '=', 'feedback.user_id')
                ->join('brands', 'brands.id', '=', 'feedback.brand_id')
                ->select('feedback.id','feedback.name as C_name','feedback.email','users.Company','brands.name','feedback.am_name','feedback.q1','feedback.q2','feedback.q3','feedback.q4','feedback.q5_1','feedback.q5_2','feedback.q5_3','feedback.q6_1','feedback.q6_2','feedback.q6_3','feedback.q7','feedback.q8','feedback.created_at','feedback.updated_at')
                ->orderBy('feedback.id', 'DESC');
                return $result->get();
            }
}

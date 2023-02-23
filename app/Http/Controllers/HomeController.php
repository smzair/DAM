<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lots;
use App\Models\uploadraw;
use App\Models\Skus;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

   
$users = User::get()->count();
$lots = Lots::get()->count();
$raw = uploadraw::get()->count();
$skus = Skus::get()->count();

                $user = Auth::user();
                
                if ($user->roles->pluck( 'name' )->contains( 'Flipkart' )) {
                   return view('clients.home',compact('user'));
                }
                
                       return view('home',compact('users','lots','raw','skus'));

        
    }
    public function test1()
    {
        return view('test1');
    }
}

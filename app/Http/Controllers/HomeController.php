<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ClientsControllers\ClientDashboardController;
use App\Models\CreativeSubmission;

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
        $user_role = $user->roles->pluck('name');
        if($user->roles->pluck( 'name' )->contains( 'Client' ) || $user->roles->pluck( 'name' )->contains( 'Sub Client' )){
            return ClientDashboardController::index();
            // return view('clients.ClientDashboard');

        }
        
        return view('home',compact('users','lots','raw','skus'));
        
    }
    public function test1()
    {
        return view('test1');
    }
}

<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\Brands_user;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;


class User_Management_Controller_New extends Controller
{
  //Get all chilled clients based on the logged in client ID 
  public function Index(Request $request)
  {
    $user_data = Auth::user();
    if ($user_data->dam_enable != 1) {
      request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
      return redirect()->route('home_new');
    }
    $client_id = $user_data->id; //logged in user id 103
    $users = User::where('parent_client_id', $client_id)->get()->toArray();

    return view('clients.ClientUserManagement.users-list')->with('users', $users);
  }

  public function create(){
    $user_data = Auth::user();
    if ($user_data->dam_enable != 1) {
      request()->session()->flash('error', 'Dam Not Enable!! connect to admin');
      return redirect()->route('home_new');
    }
    $client_id = $user_data->id; //logged in user id 103
    $brands = Brands_user::leftJoin('brands', 'brands.id', '=', 'brands_user.brand_id')
    ->select('*')
    ->where('user_id', '=', $client_id)
    ->whereNotNull('brands.name')
    ->get()->toArray();

    // dd($brands);

    return view('clients.ClientUserManagement.create_user')->with('brands', $brands);
    // return view('clients.ClientUserManagement.UserManagement')->with('brands', $brands);
}
}

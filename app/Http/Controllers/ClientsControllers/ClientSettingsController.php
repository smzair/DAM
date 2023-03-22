<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientSettingsController extends Controller
{
    public function index(){
        $data = User::getClientData();
        // dd($data);
        return view('clients.Client-settings')->with('data',$data);
    }
}

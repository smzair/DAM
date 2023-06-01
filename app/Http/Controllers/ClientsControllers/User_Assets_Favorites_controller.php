<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class User_Assets_Favorites_controller extends Controller
{
    public function index(){
        return view('clients.ClientAssetsLinks.your-assets-Favorites');

    }
}

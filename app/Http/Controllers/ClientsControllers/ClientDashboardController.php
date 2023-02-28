<?php

namespace App\Http\Controllers\ClientsControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientDashboardController extends Controller
{
    //
    public function index(){
        return view('clients.ClientDashboard');
    }
}

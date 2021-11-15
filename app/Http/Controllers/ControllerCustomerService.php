<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerCustomerService extends Controller
{
    public function index_chat()
    {
        return view('Customer_service_list_chat');
    }
}

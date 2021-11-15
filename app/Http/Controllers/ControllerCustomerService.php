<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;

class ControllerCustomerService extends Controller
{
    public function index_chat()
    {
        return view('Customer_service_list_chat');
    }

    public function index_request_assist()
    {
        $tickets = Ticket::all();
        return view('Customer_service_list_request_assists', compact('tickets'));
    }

    public function create_request_assist()
    {
        return view('Customer_service_request_assists_add');
    }

    public function insert(Request $request)
    {
        $ticket = new Ticket();
        
        $ticket->insertdata((session()->get('userlogin'))->Id_member, $request->title, $request->description);
        
        return redirect()->route('list_request_assist');
    }

    public function update_request_assist($request_id)
    {
        $ticket = Ticket::find($request_id);
        return view('Customer_service_request_assists_update', compact('ticket'));
    }

    public function update($id, Request $request)
    {
        $ticket = new Ticket();
        
        $ticket->updatedata($id,(session()->get('userlogin'))->Id_member, $request->title, $request->description);
        
        return redirect()->route('list_request_assist');
    }

    public function closed( Request $request)
    {
        $ticket = new Ticket();
        logger($request->all());
        $ticket->closed($request->id, $request->conclusion);
        
        return redirect()->route('list_request_assist');
    }
}

<?php

namespace App\Http\Controllers;

use App\cust_order_header;
use App\followup;
use App\member;
use App\Ticket;
use App\voucher;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

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
        $ticket->closed($request->id, $request->conclusion);
        
        return redirect()->route('list_request_assist');
    }

    public function list_available_customer(Request $request)
    {
        $available_customers = [];
        if($request->exists('lama_tidak_transaksi')){
            $date = date('Y-m-d', strtotime( "-" .$request->get('lama_tidak_transaksi') . " day" , strtotime (date("Y-m-d H:i:s"))));
            $periode = [$date . " 00:00:00", $date . " 23:59:59"];
            
            $members = member::where('Role', 'CUST')->get();
            foreach ($members as $member) {
                $followup = followup::where("Id_member", $member->Id_member)->where("End_followup_date", ">", date("Y-m-d H:i:s"))->first();
                if(empty($followup)){
                    $jum_transaksi = cust_order_header::where("Id_member", $member->Id_member)->count();
                    if($jum_transaksi != $request->get('jum_transaksi')){
                        continue;
                    }

                    $transaksi = cust_order_header::where("Id_member", $member->Id_member)->orderBy('Id_order', 'desc')->first();
                    $tanggal_transaksi = new DateTime(date("Y-m-d", strtotime($transaksi->Date_time)));
                    $interval = (new DateTime(date("Y-m-d")))->diff($tanggal_transaksi);
                    if($interval->format("%d") != $request->get("lama_tidak_transaksi")){
                        continue;
                    }

                    $member->Phone = "62" . substr($member->Phone, -(strlen($member->Phone)-1));
                    array_push($available_customers, $member);
                }
            }
        }
        return view('Customer_service_followup_customers', compact('available_customers'));
    }

    public function followup(Request $request)
    {
        $followed_up_member = followup::where('Id_member', $request->Id_member)->orderBy('Id_followup', 'desc')->first();
        $tanggal_followup = new DateTime(date("Y-m-d", strtotime($followed_up_member->Followup_date)));
        $interval = (new DateTime(date("Y-m-d")))->diff($tanggal_followup);
        if($interval->format("%d") >= session('jeda_periode_followup')){
            $end_followup_date = date('Y-m-d', strtotime( "+" . session('jeda_periode_followup') . " day" , strtotime (date("Y-m-d H:i:s"))));
        }
        return redirect()->back();
    }

    public function pengaturan_followup()
    {
        return view("Pengaturan_followup");
    }

    public function simpan_pengaturan_followup(Request $request)
    {
        session(['jeda_periode_followup' => $request->jeda_periode_followup]);
        session(['limit_followup_cs' => $request->limit_followup_cs]);
        return redirect()->back();
    }
}

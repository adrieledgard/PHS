<?php

namespace App\Http\Controllers;

use App\chat;
use App\cust_order_detail;
use App\cust_order_header;
use App\followup;
use App\Mail\FollowUp as MailFollowUp;
use App\Mail\SendEmail;
use App\member;
use App\ticket;
use App\voucher;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ControllerCustomerService extends Controller
{
    public function index_chat()
    {
        return view('Customer_service_list_chat');
    }

    public function index_request_assist()
    {
        $tickets = ticket::join('member','member.Id_member','table_ticket.Cs_id')
        ->select('member.Username as namacs','table_ticket.*')
        ->get();
        return view('Customer_service_list_request_assists', compact('tickets'));
    }

    public function create_request_assist()
    {
        return view('Customer_service_request_assists_add');
    }

    public function insert(Request $request)
    {
        $ticket = new ticket();
        
        $ticket->insertdata((session()->get('userlogin'))->Id_member, $request->title, $request->description, $request->bukti_chat, $request->platform_komunikasi, $request->email, $request->phone);
        
        return redirect()->route('list_request_assist');
    }

    public function update_request_assist($request_id)
    {
        $ticket = ticket::find($request_id);
        return view('Customer_service_request_assists_update', compact('ticket'));
    }

    public function update($id, Request $request)
    {
        $ticket = new ticket();
        
        $ticket->updatedata($id,(session()->get('userlogin'))->Id_member, $request->title, $request->description, $request->bukti_chat, $request->platform_komunikasi, $request->email, $request->phone);
        
        return redirect()->route('list_request_assist');
    }

    public function closed( Request $request)
    {
        //cayang4
        $role = session()->get('userlogin')->Role;

        $tkt = ticket::find($request->id);

        if(($role == 'ADMIN') || ($tkt->Cs_id == session()->get('userlogin')->Id_member))
        {
            $ticket = new ticket();
            $ticket->closed($request->id, $request->conclusion);

            return redirect()->route('list_request_assist');
        }
        else
        {
            //error, tidak bisa close karena buka admin/bukan cs yg open tiket

            return redirect()->route('list_request_assist')->with('error','Error, only admin or ticket maker can close ticket');
        }

    }

    public function get_ticket_chat(Request $request)
    {
        $get_chat = chat::join('member', 'member.Id_member', 'chat.Id_member')->where('Id_ticket', $request->id_ticket)->get();
        $user_id = session()->get('userlogin')->Id_member;

        return [$get_chat, $user_id];
    }

    public function send_ticket_chat(Request $request)
    {
        if($request->hasFile("attachment_file"))
        {
            $file = $request->file("attachment_file");
            $attachment_chat = new chat();
            $attachment_chat->Id_ticket = $request->id_ticket;
            $attachment_chat->Id_member = session()->get('userlogin')->Id_member;
            $attachment_chat->Type = "file";
            $attachment_chat->Content = "";
            $attachment_chat->save();
            
            $name = $attachment_chat->id . "_" . $file->getClientOriginalName();
            $file->move(public_path() .'/ticket_attachment/', $name); 

            $update_attachment_chat = chat::find($attachment_chat->id);
            $update_attachment_chat->Content = $name;
            $update_attachment_chat->save();
        }
        else
        {
            $chat = new chat();
            $chat->Id_ticket = $request->id_ticket;
            $chat->Id_member = session()->get('userlogin')->Id_member;
            $chat->Type = "text";
            $chat->Content = $request->content_pesan;
            $chat->save();
        }
       

        $get_chat = chat::join('member', 'member.Id_member', 'chat.Id_member')->where('Id_ticket', $request->id_ticket)->get();
        $user_id = session()->get('userlogin')->Id_member;
        return [$get_chat, $user_id];
    }

    public function download_attachment($nama_file)
    {
        $file = public_path() . "/ticket_attachment/" . $nama_file;
        //Define header information
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        header('Content-Disposition: attachment; filename="'.public_path() . "/ticket_attachment/" . $nama_file.'"');
        header('Content-Length: ' . filesize($file));
        header('Pragma: public');

        flush();
        readfile($file);

        die();
    }

    public function kirim_email(Request $request)
    {
        Mail::to($request->email)->send(new SendEmail($request->subject, $request->content));
        return redirect()->back()->with('success', 'Email sukses dikirim kepada ' . $request->email);
    }

    public function list_available_customer(Request $request)
    {
        $available_customers = [];
        if($request->exists('lama_tidak_transaksi'))
        {
            //HARI INI - lama tidak transaksi
            $date = date('Y-m-d', strtotime( "-" .$request->get('lama_tidak_transaksi') . " day" , strtotime (date("Y-m-d H:i:s"))));
            $periode = [$date . " 00:00:00", $date . " 23:59:59"];
            
            $members = member::where('Role', 'CUST')->get();

            foreach ($members as $member) 
            {
                //end fol date = 2022-06-15 
                // date now = 2022-06-14
                // status = sukses
                $followup = followup::where("Id_member", $member->Id_member)
                ->where("End_followup_date", ">", date("Y-m-d H:i:s"))
                ->where('Is_successful_followup', '0')
                ->first();
                
                if(empty($followup))
                {
                    $jum_transaksi = cust_order_header::where("Id_member", $member->Id_member)->count();
                    if($request->get('operasi_jumlah_transaksi') == "=")
                    {
                        if($jum_transaksi != (int)$request->get('jum_transaksi'))
                        {
                            continue;
                        }
                    }
                    else if($request->get('operasi_jumlah_transaksi') == ">")
                    {
                        if(!($jum_transaksi > (int)$request->get('jum_transaksi')))
                        {
                            continue;
                        }
                    }
                    else if($request->get('operasi_jumlah_transaksi') == "<")
                    {
                        if(!($jum_transaksi < (int)$request->get('jum_transaksi')))
                        {
                            continue;
                        }
                    }
                    

                    if($jum_transaksi != 0){
                        
                        $transaksi = cust_order_header::where("Id_member", $member->Id_member)->orderBy('Id_order', 'desc')->first();
                        $tanggal_transaksi = new DateTime(date("Y-m-d", strtotime($transaksi->Date_time)));
                        
                        $interval = (new DateTime(date("Y-m-d")))->diff($tanggal_transaksi);
                        
                        if($request->get('operasi_lama_tidak_transaksi') == "=")
                        {
                            if(!($interval->format("%a") == (int)$request->get("lama_tidak_transaksi"))){
                                continue;
                            }
                        }
                        else if ($request->get('operasi_lama_tidak_transaksi') == ">")
                        {
                            if(!($interval->format("%a") > (int)$request->get("lama_tidak_transaksi"))){
                                continue;
                            }

                        }
                        else if($request->get('operasi_lama_tidak_transaksi') == "<")
                        {
                            if(!($interval->format("%a") < (int)$request->get("lama_tidak_transaksi"))){
                                continue;
                            }
                        }
                        
                        $member->lama_tidak_belanja = $interval->format("%a");
                        $member->rincian_transaksi = cust_order_header::where('cust_order_header.Id_member', $member->Id_member)->join('list_city', 'list_city.Id_city', 'cust_order_header.Id_city')->orderBy('Id_order', 'desc')->get();
                       
                        foreach ($member->rincian_transaksi as $trans)
                        {
                            $trans->detail = cust_order_detail::join('product', 'product.Id_product', 'cust_order_detail.Id_product')->join('variation_product', 'variation_product.Id_variation', 'cust_order_detail.Id_variation')->where('cust_order_detail.Id_order', $trans->Id_order)->select('product.Name', 'cust_order_detail.Normal_price','cust_order_detail.Discount_promo','cust_order_detail.Qty', 'cust_order_detail.Fix_price', 'variation_product.Variation_name as Variant_name', 'variation_product.Option_name as Variant_option_name')->get();
                        }
                    }else {
                        $member->lama_tidak_belanja = 0;
                        $member->rincian_transaksi = [];
                    }
                    
                    $member->total_transaksi = $jum_transaksi;
                    $member->Phone = "62" . substr($member->Phone, -(strlen($member->Phone)-1));
                    array_push($available_customers, $member);
                }
            }
        }
        return view('Customer_service_followup_customers', compact('available_customers'));
    }

    public function followup(Request $request)
    {
        $date_today = date("Y-m-d") . " 00:00:00";
        $count_followup_cs = followup::where("Id_customer_service", session()->get('userlogin')->Id_member)->where('Followup_date', $date_today)->count();
        $config_limit_followup = DB::table('config')->where('config_name', 'limit_followup_cs')->first();
       
        if(!empty($config_limit_followup))
        {
            if($count_followup_cs == $config_limit_followup->Value)
            {
                return redirect()->back()->withErrors(['message'=>'Anda sudah melebihi limit hari ini!']);
            }
        }

        $tanggal_followup = "";
        $followed_up_member = followup::where('Id_member', $request->Id_member)->orderBy('Id_followup', 'desc')->first();
        if(!empty($followed_up_member))
        {
            if($followed_up_member->Is_successful_followup == 1)
            {
                return redirect()->back();
            }

            $tanggal_followup = date("Y-m-d", strtotime($followed_up_member->End_followup_date));
        }
        if($tanggal_followup == "" || $tanggal_followup < date("Y-m-d"))
        {
            $tanggal_followup = $tanggal_followup == "" ? date("Y-m-d") : $tanggal_followup;
            $config_jeda_periode_followup = DB::table('config')->where('config_name', 'jeda_periode_followup')->first();
           
            if(empty($config_jeda_periode_followup))
            {
                $config_jeda_periode_followup = 30;
            }
            
            $member = member::find($request->Id_member);
            $end_followup_date = date('Y-m-d', strtotime($tanggal_followup . "+ " . $config_jeda_periode_followup->Value . " days" ));
            $followup = (new followup())->add_followup(session()->get('userlogin')->Id_member, $request->Id_member, $tanggal_followup, $end_followup_date);
            

            Mail::to(strtolower($member->Email))->send(new MailFollowUp($request->follow_up_description));
        }
        return redirect()->back();
    }

    public function pengaturan_followup()
    {
        $config_jeda_periode_followup = DB::table('config')->where('Config_name', 'jeda_periode_followup')->first();
        $config_limit_followup_cs = DB::table('config')->where('Config_name', 'limit_followup_cs')->first();
        
        
        if(is_null($config_jeda_periode_followup))
        {
            $config_jeda_periode_followup = "";
        }
        else 
        {
            $config_jeda_periode_followup = $config_jeda_periode_followup->Value;
        }


        if(is_null($config_limit_followup_cs))
        {
            $config_limit_followup_cs = "";
        }
        else 
        {
            $config_limit_followup_cs = $config_limit_followup_cs->Value;
        }
        return view("Pengaturan_followup", compact('config_jeda_periode_followup', 'config_limit_followup_cs'));
    }

    public function simpan_pengaturan_followup(Request $request)
    {
        $is_config_jeda_periode_exist = DB::table('config')
            ->where('Config_name', 'jeda_periode_followup')
            ->get();

        if(count($is_config_jeda_periode_exist) > 0)
        {
            DB::table('config')
            ->where('Config_name', 'jeda_periode_followup')
            ->update(['Value' => $request->jeda_periode_followup]);
        }
        else 
        {
            DB::table('config')->insert([
                'Config_name' => 'jeda_periode_followup',
                'Value' => $request->jeda_periode_followup
            ]);
        }


        $is_config_limit_followup_exist = DB::table('config')
            ->where('Config_name', 'limit_followup_cs')
            ->get();

        if(count($is_config_limit_followup_exist) > 0)
        {
            DB::table('config')
            ->where('Config_name', 'limit_followup_cs')
            ->update(['Value' => $request->limit_followup_cs]);
        }
        else 
        {
            DB::table('config')->insert([
                'Config_name' => 'limit_followup_cs',
                'Value' => $request->limit_followup_cs
            ]);
        }
       
        return redirect()->back();
    }

    public function my_followup()
    {
        $customers = followup::join('member', 'member.Id_member', 'followup_customers.Id_member')
                    ->where("followup_customers.Id_customer_service", session()->get('userlogin')->Id_member)
                    ->get();

        foreach ($customers as $customer)
         {
            $is_refollowup_available = "disabled"; // jika failed ada refollow up tapi ada pengecekan apakaah konsumen itu ada di follow up sama cs lain dk
            $followup = followup::where("Id_member", $customer->Id_member)
            ->orderBy('Id_followup', 'desc')
            ->first();


            if(date('Y-m-d', strtotime($followup->End_followup_date)) < date("Y-m-d") && $followup->Is_successful_followup == 0)
            { //jika memenuhi maka button refollow up muncul
                $is_refollowup_available = "";
            }
            $customer->is_refollowup_available = $is_refollowup_available;

            if($followup->Is_successful_followup == 1)
            {
                $customer->transaksi = cust_order_header::join('list_city', 'list_city.Id_city', 'cust_order_header.Id_city')
                ->where("Id_order", $followup->Id_order)
                ->first();


                $customer->transaksi->detail = cust_order_detail::join('product', 'product.Id_product', 'cust_order_detail.Id_product')
                ->join('variation_product', 'variation_product.Id_variation', 'cust_order_detail.Id_variation')
                ->where('cust_order_detail.Id_order', $followup->Id_order)
                ->select('product.Name', 'cust_order_detail.Normal_price','cust_order_detail.Discount_promo','cust_order_detail.Qty', 'cust_order_detail.Fix_price', 'variation_product.Variation_name as Variant_name', 'variation_product.Option_name as Variant_option_name')
                ->get();
            }
        }

        return view('Customer_service_my_followup', compact('customers'));
    }
}

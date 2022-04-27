<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = "table_ticket";
    protected $fillable = ['Cs_id', 'Title', 'Platform_komunikasi', 'Bukti_chat', 'Date_request', 'Status', 'Description', 'Email', 'Phone', 'Nomor_ticket'];
    public function insertdata($cs_id, $title, $description, $bukti_chat, $platform_komunikasi, $email, $phone)
    {
        Ticket::create([
            'Nomor_ticket' => mt_rand(1000000, 9999999),
            'Cs_id' => $cs_id,
            'Title' => strtoupper($title),
            'Bukti_chat' => strtoupper($bukti_chat),
            'Platform_komunikasi' => $platform_komunikasi,
            'Description' => $description,
            'Email' => $email,
            'Phone' => $phone,
            'Date_request' => date('Y-m-d'),
            'Status' => "OPEN",
        ]);

        return "sukses";
    }

    public function updatedata($id, $cs_id, $title, $description, $bukti_chat, $platform_komunikasi, $email, $phone)
    {
        $ticket = Ticket::find($id);
        $ticket->Cs_id = $cs_id;
        $ticket->Title = $title;
        $ticket->Bukti_chat = strtoupper($bukti_chat);
        $ticket->Platform_komunikasi = $platform_komunikasi;
        $ticket->Email = $email;
        $ticket->Phone = $phone;
        $ticket->Description = $description;
        $ticket->save();

        return "sukses";
    }

    public function closed($id)
    {
        $ticket = Ticket::find($id);
        $ticket->Status = "CLOSED";
        $ticket->save();

        return "sukses";
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = "table_ticket";
    protected $fillable = ['cs_id', 'title', 'platform_komunikasi', 'bukti_chat', 'date_request', 'status', 'description', 'email', 'phone'];
    public function insertdata($cs_id, $title, $description, $bukti_chat, $platform_komunikasi, $email, $phone)
    {
        Ticket::create([
            'cs_id' => $cs_id,
            'title' => strtoupper($title),
            'bukti_chat' => strtoupper($bukti_chat),
            'platform_komunikasi' => $platform_komunikasi,
            'description' => $description,
            'email' => $email,
            'phone' => $phone,
            'date_request' => date('Y-m-d'),
            'status' => "OPEN",
        ]);

        return "sukses";
    }

    public function updatedata($id, $cs_id, $title, $description, $bukti_chat, $platform_komunikasi, $email, $phone)
    {
        $ticket = Ticket::find($id);
        $ticket->cs_id = $cs_id;
        $ticket->title = $title;
        $ticket->bukti_chat = strtoupper($bukti_chat);
        $ticket->platform_komunikasi = $platform_komunikasi;
        $ticket->email = $email;
        $ticket->phone = $phone;
        $ticket->description = $description;
        $ticket->save();

        return "sukses";
    }

    public function closed($id)
    {
        $ticket = Ticket::find($id);
        $ticket->status = "CLOSED";
        $ticket->save();

        return "sukses";
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = "table_ticket";
    protected $fillable = ['cs_id', 'title', 'description', 'conclusion', 'date_request', 'status'];
    public function insertdata($cs_id, $title, $description)
    {
        Ticket::create([
            'cs_id' => $cs_id,
            'title' => strtoupper($title),
            'description' => strtoupper($description),
            'conclusion' => '',
            'date_request' => date('Y-m-d'),
            'status' => "OPEN",
        ]);

        return "sukses";
    }

    public function updatedata($id, $cs_id, $title, $description)
    {
        $ticket = Ticket::find($id);
        $ticket->cs_id = $cs_id;
        $ticket->title = $title;
        $ticket->description = $description;
        $ticket->save();

        return "sukses";
    }

    public function closed($id, $conclusion)
    {
        $ticket = Ticket::find($id);
        $ticket->conclusion = $conclusion;
        $ticket->status = "CLOSED";
        $ticket->save();

        return "sukses";
    }


}

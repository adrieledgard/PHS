<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class chat extends Model
{
    protected $table = "chat";
    protected $fillable = ['Id_ticket', 'Id_member', 'Type', 'Content'];
}

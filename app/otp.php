<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class otp extends Model
{
    protected $table = "kode_otp";

    protected $fillable = ["Kode", 'Email', 'Expired_time', 'Status'];
}

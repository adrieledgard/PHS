<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rate_review extends Model
{
    protected $table = "rating_review";
    protected $fillable = ["Id_order", 'Id_detail_order', 'Id_user', 'rate', 'review'];
}

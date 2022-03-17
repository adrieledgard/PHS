<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class rate_review extends Model
{
    use SoftDeletes;
    
    protected $table = "rating_review";
    protected $fillable = ["Id_order", 'Id_detail_order', 'Id_member', 'rate', 'review'];
}

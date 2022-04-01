<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cust_order_history extends Model
{
    protected $table = "cust_order_history";
    protected $fillable = ['Record', 'Order_status', 'Id_order'];
}

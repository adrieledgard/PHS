<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stock_card extends Model
{
    //

    public $table = 'stock_card';
    public $primaryKey = 'Id_stock_card';
    public $timestamps = false;
    public $fillable = ['Id_stock_card','Date_card','Id_product','Id_variation','Expire_date','Type_card','No_reference','First_stock','Debet','Credit','Last_stock','Transaction_price','Capital','Fifo_stock'];
    public $incrementing = true;

   
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class receive_expire extends Model
{
    //
    public $table = 'receive_expire';
    public $primaryKey = 'No_receive_expire';
    public $timestamps = false;
    public $fillable = ['No_receive_expire','No_receive_detail','Id_product','Id_variation','Qty','Expire_date'];
    public $incrementing = true;

    public function insertdata($No_receive_detail,$Id_product,$Id_variation,$Qty,$Expire_date)
    {
      
        receive_expire::create(
        [
            'No_receive_expire' => null,
            'No_receive_detail' => strtoupper($No_receive_detail),
            'Id_product' => strtoupper($Id_product),
            'Id_variation' => strtoupper($Id_variation),
            'Qty' => strtoupper($Qty),
            'Expire_date' => strtoupper($Expire_date)
        ]
        );
        return "sukses";
       

    }
}

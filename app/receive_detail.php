<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class receive_detail extends Model
{
    //

    public $table = 'receive_detail';
    public $primaryKey = 'No_receive_detail';
    public $timestamps = false;
    public $fillable = ['No_receive_detail','No_receive','Id_product','Id_variation','No_purchase_detail','Qty','Purchase_price'];
    public $incrementing = true;

    public function insertdata($No_receive,$Id_product,$Id_variation,$No_detail,$Qty,$Purchase_price)
    {
      
        receive_detail::create(
        [
            'No_receive_detail' => null,
            'No_receive' => strtoupper($No_receive),
            'Id_product' => strtoupper($Id_product),
            'Id_variation' => strtoupper($Id_variation),
            'No_purchase_detail' => strtoupper($No_detail),
            'Qty' => strtoupper($Qty),
            'Purchase_price' => strtoupper($Purchase_price)
        ]
        );
        return "sukses";
    }

    public function lastnoreceivedetail()
    {
        $temp = receive_detail::all();
        $c = 0;

        for ($i=0; $i < count($temp) ; $i++) { 
            if($temp[$i]['No_receive_detail']>$c)
            {
                $c = $temp[$i]['No_receive_detail'];
            }
        }

        return $c;

    }
}

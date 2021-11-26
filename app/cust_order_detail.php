<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cust_order_detail extends Model
{
    //

    public $table = 'cust_order_detail';
    public $primaryKey = 'Id_detail_order';
    public $timestamps = false;
    public $fillable = ['Id_detail_order','Id_order','Id_product','Id_variation','Qty',
                        'Normal_price','Id_promo','Discount_promo','Fix_price'];
    public $incrementing = true;


    
    public function insertdata($Id_order, $Id_product, $Id_variation,$Qty,
    $Normal_price,$Id_promo, $Discount_promo, $Fix_price)
    {
       
      
        cust_order_detail::create(
        [
            'Id_detail_order' => null,
            'Id_order' => ($Id_order),
            'Id_product' => ($Id_product),
            'Id_variation' => ($Id_variation),
            'Qty' => $Qty,
            'Normal_price' => $Normal_price,
            'Id_promo' => $Id_promo,
            'Discount_promo' => ($Discount_promo),
            'Fix_price' => $Fix_price,

        ]
        );
        return "sukses";
       

    }

}

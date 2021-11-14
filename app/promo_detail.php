<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class promo_detail extends Model
{
    public $table = 'promo_detail';
    public $primaryKey = 'Id_promo_detail';
    public $timestamps = false;
    public $fillable = ['Id_promo_detail','Id_promo','Minimum_qty','Discount','Status'];
    public $incrementing = true;


    public function add_detail_promo($Id_promo,$Minimum_qty,$Discount)
    {
       
        
        promo_detail::create(
        [
            'Id_promo_detail' => null,
            'Id_promo' => $Id_promo,
            'Minimum_qty' => $Minimum_qty,
            'Discount' => $Discount,
            'Status'=>1
        ]
        );
        return "sukses";
    }

    public function deletepromodetail($id_promo)
    {
        promo_detail::where('Id_promo','=',$id_promo)->update(array(
            'Status' => 0
        ));
    }
}

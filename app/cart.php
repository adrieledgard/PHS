<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    //
    public $table = 'cart';
    public $primaryKey = 'Id_cart';
    public $timestamps = false;
    public $fillable = ['Id_cart','Id_product','Id_variation','Qty','Id_member'];
    public $incrementing = true;

    public function add_cart($Id_product,$Id_variation,$Qty,$Id_member)
    {
        cart::create(
        [
            'Id_cart' => null,
            'Id_product' => strtoupper($Id_product),
            'Id_variation' => strtoupper($Id_variation),
            'Qty' => strtoupper($Qty),
            'Id_member' => strtoupper($Id_member)
        ]
        );
        return "sukses";
    }


    public function edit_cart($Id_cart,$Qty)
    {
        cart::where('Id_cart','=',$Id_cart)->update(array(
            'Qty'=>strtoupper($Qty),
        ));
        return "sukses";
    }


    public function delete_cart($Id_cart)
    {
        cart::where('Id_cart','=',$Id_cart)
            ->delete();


    }
}

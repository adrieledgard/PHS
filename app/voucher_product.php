<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class voucher_product extends Model
{
    //
    public $table = 'voucher_product';
    public $primaryKey = 'Id_voucher_product';
    public $timestamps = false;
    public $fillable = ['Id_voucher_product','Id_voucher','Id_product'];
    public $incrementing = true;

    public function add_voucher_product($Id_voucher, $Id_product)
    {
        voucher_product::create(
        [
            'Id_voucher_product' => null,
            'Id_voucher' => $Id_voucher,
            'Id_product' => $Id_product,
        ]
        );

    }

    public function delete_voucher_product($Id_voucher)
    {
        // voucher_product::where('Id_voucher','=',$Id_voucher)->update(array(
        //     'Status' => 0
        // ));

        voucher_product::where('Id_voucher','=',$Id_voucher)
        ->delete();
    }

    // public function edit_voucher($Id_voucher,$voucher_name, $voucher_type, $discount)
    // {
    //     voucher::where('Id_voucher','=',$Id_voucher)->update(array(
    //         'Voucher_name'=>strtoupper($voucher_name),
    //         'Voucher_type'=>$voucher_type,
    //         'Discount'=>$discount,
    //     ));


    // }

    // public function gettype($id)
    // {
    //     return type::where('Id_type', '=', $id)
    //     ->where('Status','=',1)
    //                     ->get();
    // }



 
}

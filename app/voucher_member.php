<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class voucher_member extends Model
{
    //

    public $table = 'voucher_member';
    public $primaryKey = 'Id_voucher_member';
    public $timestamps = false;
    public $fillable = ['Id_voucher_product','Id_member','Id_voucher'];
    public $incrementing = true;

    public function add_voucher_member($Id_member, $Id_voucher)
    {
        voucher_member::create(
        [
            'Id_voucher_member' => null,
            'Id_member' => $Id_member,
            'Id_voucher' => $Id_voucher,
        ]
        );

    }

    public function delete_voucher_member($Id_member,$Id_voucher)
    {
        // voucher_product::where('Id_voucher','=',$Id_voucher)->update(array(
        //     'Status' => 0
        // ));

        voucher_member::where('Id_voucher','=',$Id_voucher)
        ->where('Id_member','=',$Id_member)
        ->delete();
    }


    public function delete_voucher_member_2($Id_voucher_member)
    {
        // voucher_product::where('Id_voucher','=',$Id_voucher)->update(array(
        //     'Status' => 0
        // ));

        voucher_member::where('Id_voucher_member','=',$Id_voucher_member)
        ->delete();
    }
}

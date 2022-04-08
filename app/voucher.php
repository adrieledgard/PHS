<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class voucher extends Model
{
    //

    public $table = 'voucher';
    public $primaryKey = 'Id_voucher';
    public $timestamps = false;
    public $fillable = ['Id_voucher','Voucher_name','Voucher_type','Discount','Point','Redeem_due_date','Quota','Joinpromo','Status'];
    public $incrementing = true;

    public function add_voucher($voucher_name, $voucher_type, $discount,$point,$redeem_due_date,$joinpromo, $Quota)
    {
        voucher::create(
        [
            'Id_voucher' => null,
            'Voucher_name' => strtoupper($voucher_name),
            'Voucher_type' => $voucher_type,
            'Discount' => $discount,
            'Point' => $point,
            'Redeem_due_date' => $redeem_due_date,
            'Quota' => $Quota,
            'Joinpromo' => $joinpromo,
            'Status' =>1 
        ]
        );

    }


    public function edit_voucher($Id_voucher,$voucher_name, $voucher_type, $discount,$point,$redeem_due_date,$joinpromo)
    {
        voucher::where('Id_voucher','=',$Id_voucher)->update(array(
            'Voucher_name'=>strtoupper($voucher_name),
            'Voucher_type'=>$voucher_type,
            'Discount'=>$discount,
            'Point' => $point,
            'Redeem_due_date' => $redeem_due_date,
            'Joinpromo' => $joinpromo
        ));


    }

    // public function gettype($id)
    // {
    //     return type::where('Id_type', '=', $id)
    //     ->where('Status','=',1)
    //                     ->get();
    // }

    public function delete_voucher($Id_voucher)
    {
        voucher::where('Id_voucher','=',$Id_voucher)->update(array(
            'Status' => 0
        ));
    }

    public function changestatus($Id_voucher,$stat)
    {
        voucher::where('Id_voucher','=',$Id_voucher)->update(array(
            'Status' => $stat,
        ));
    }

    public function getlastid()
    {
        $temp = voucher::all();
        $c = 0;

        for ($i=0; $i < count($temp) ; $i++) { 
            if($temp[$i]['Id_voucher']>$c)
            {
                $c = $temp[$i]['Id_voucher'];
            }
        }

        return $c;
    }
}

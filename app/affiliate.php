<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class affiliate extends Model
{
    //

    public $table = 'affiliate';
    public $primaryKey = 'Id_affiliate';
    public $timestamps = false;
    public $fillable = ['Id_affiliate','Id_product','Id_variation','Poin','Status'];
    public $incrementing = true;

    public function add_affiliate($Id_product,$Id_variation, $Poin, $Status)
    {
        affiliate::create(
        [
            'Id_affiliate' => null,
            'Id_product' => $Id_product,
            'Id_variation' => $Id_variation,
            'Poin' => $Poin,
            'Status' =>$Status
        ]
        );

    }


    public function edit_affiliate($Id_variation, $Poin, $Status)
    {
        affiliate::where('Id_variation','=',$Id_variation)->update(array(
            'Status'=>$Status,
            'Poin'=>$Poin,
        ));


    }

    // public function gettype($id)
    // {
    //     return type::where('Id_type', '=', $id)
    //     ->where('Status','=',1)
    //                     ->get();
    // }

    // public function delete_affiliate($Id_affiliate)
    // {
    //     voucher::where('Id_affiliate','=',$Id_affiliate)->update(array(
    //         'Status' => 0
    //     ));
    // }

    // public function getlastid()
    // {
    //     $temp = voucher::all();
    //     $c = 0;

    //     for ($i=0; $i < count($temp) ; $i++) { 
    //         if($temp[$i]['Id_voucher']>$c)
    //         {
    //             $c = $temp[$i]['Id_voucher'];
    //         }
    //     }

    //     return $c;
    // }
}

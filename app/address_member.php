<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class address_member extends Model
{
    //

    public $table = 'address_member';
    public $primaryKey = 'Id_address';
    public $timestamps = false;
    public $fillable = ['Id_address','Id_member','Id_city','Id_province','Address','Status'];
    public $incrementing = true;

    public function add_address ($Id_member,$Id_city,$Id_province,$Address)
    {
        address_member::create(
        [
            'Id_address' => null,
            'Id_member' => $Id_member,
            'Id_city' => $Id_city,
            'Id_province' => $Id_province,
            'Address' => $Address,
            'Status'=>1
        ]
        );
        return "sukses";
    


    }


    public function edit_address($Id_address,$Id_city,$Id_province,$Address)
    {
      
        address_member::where('Id_address','=',$Id_address)->update(array(
            'Id_city' => $Id_city,
            'Id_province' => $Id_province,
            'Address' => $Address,
        ));
        return "sukses";
      

    }

    // public function getbank($id)
    // {
    //     return bank::where('Id_bank', '=', $id)
    //     ->where('Status','=',1)
    //                     ->get();
    // }

    public function delete_address($Id_address)
    {
        address_member::where('Id_address','=',$Id_address)->update(array(
            'Status' => 0
        ));
    }
}

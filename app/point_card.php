<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class point_card extends Model
{
    //
    public $table = 'point_card';
    public $primaryKey = 'Id_point_card';
    public $timestamps = false;
    public $fillable = ['Id_point_card','Date_card','Id_member','First_point','Debet','Credit','Last_point','Type','No_reference'];
    public $incrementing = true;

    public function add_point_card($Id_member,$Date_card,$First_point,$Debet,$Credit,$Last_point,$Type,$No_reff)
    {
        point_card::create(
        [
            'Id_point_card' => null,
            'Date_card' => $Date_card,
            'Id_member' => strtoupper($Id_member),
            'First_point' => strtoupper($First_point),
            'Debet' => strtoupper($Debet),
            'Credit' => strtoupper($Credit),
            'Last_point' => strtoupper($Last_point),
            'Type' => ($Type),
            'No_reference' => $No_reff
        ]
        );
        return "sukses";
    }
}

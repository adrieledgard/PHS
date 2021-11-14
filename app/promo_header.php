<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class promo_header extends Model
{
    //

    public $table = 'promo_header';
    public $primaryKey = 'Id_promo';
    public $timestamps = false;
    public $fillable = ['Id_promo','Id_product','Id_variation','Start_date','End_date','Model','Status'];
    public $incrementing = true;


    public function add_promo($Id_product,$Id_variation,$Start_date,$End_date,$Model,$Comingsoon)
    {
       
        if($Comingsoon==1)
        {
            promo_header::create(
                [
                    'Id_promo' => null,
                    'Id_product' => $Id_product,
                    'Id_variation' => $Id_variation,
                    'Start_date' => $Start_date,
                    'End_date' => $End_date,
                    'Model' => strtoupper($Model),
                    'Status'=>3
                ]
                );
                return "sukses";
        }
        else
        {
            promo_header::create(
                [
                    'Id_promo' => null,
                    'Id_product' => $Id_product,
                    'Id_variation' => $Id_variation,
                    'Start_date' => $Start_date,
                    'End_date' => $End_date,
                    'Model' => strtoupper($Model),
                    'Status'=>1
                ]
                );
                return "sukses";
        }
       
    }

    public function getlastid()
    {
        $temp = promo_header::all();
        $c = 0;

        for ($i=0; $i < count($temp) ; $i++) { 
            if($temp[$i]['Id_promo']>$c)
            {
                $c = $temp[$i]['Id_promo'];
            }
        }

        return $c;
    }

    public function deletepromoheader($id)
    {
        promo_header::where('Id_promo','=',$id)->update(array(
            'Status' => 0
        ));
    }

    public function changestatus($id,$stat)
    {
        promo_header::where('Id_promo','=',$id)->update(array(
            'Status' => $stat
        ));
    }

    
}




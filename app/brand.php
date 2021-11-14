<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class brand extends Model
{
    public $table = 'brand';
    public $primaryKey = 'Id_brand';
    public $timestamps = false;
    public $fillable = ['Id_brand','Brand_name','Status'];
    public $incrementing = true;

    public function add_brand ($name)
    {
       
        $du = brand::where('Brand_name','=', $name)
                ->where('Status','=',1)
                ->get();

        if(count($du)==0)
        {
            brand::create(
            [
                'Id_brand' => null,
                'Brand_name' => strtoupper($name),
                'Status'=>1
            ]
            );
            return "sukses";
        }
        else
        {
            return "failed";
        }


    }


    public function edit_brand ($id,$name)
    {
        $dn = brand::where('Brand_name','=', $name)
        ->where('Id_brand','<>',$id)
        ->where('Status','=',1)
        ->get();

        if(count($dn)==0)
        {
            brand::where('Id_brand','=',$id)->update(array(
                'Brand_name'=>strtoupper($name),
            ));
            return "sukses";
        }
        else
        {
            return "failed";
        }


    }

    public function getbrand($id)
    {
        return brand::where('Id_brand', '=', $id)
        ->where('Status','=',1)
                        ->get();
    }

    public function deletebrand($Id_brand)
    {
        brand::where('Id_brand','=',$Id_brand)->update(array(
            'Status' => 0
        ));
    }

}

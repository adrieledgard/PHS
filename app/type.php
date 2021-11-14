<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class type extends Model
{
    public $table = 'type';
    public $primaryKey = 'Id_type';
    public $timestamps = false;
    public $fillable = ['Id_type','Type_name','Status'];
    public $incrementing = true;

    public function add_type ($name)
    {
       
        $du = type::where('Type_name','=', $name)
        ->where('Status','=',1)
                ->get();

        if(count($du)==0)
        {
            type::create(
            [
                'Id_type' => null,
                'Type_name' => strtoupper($name),
                'Status' =>1
            ]
            );
            return "sukses";
        }
        else
        {
            return "failed";
        }


    }


    public function edit_type ($id,$name)
    {
        $dn = type::where('Type_name','=', $name)
        ->where('Id_type','<>',$id)
        ->where('Status','=',1)
        ->get();

        if(count($dn)==0)
        {
            type::where('Id_type','=',$id)->update(array(
                'Type_name'=>strtoupper($name),
            ));
            return "sukses";
        }
        else
        {
            return "failed";
        }


    }

    public function gettype($id)
    {
        return type::where('Id_type', '=', $id)
        ->where('Status','=',1)
                        ->get();
    }

    public function deletetype($Id_type)
    {
        type::where('Id_type','=',$Id_type)->update(array(
            'Status' => 0
        ));
    }
}

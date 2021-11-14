<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\sub_category;

class category extends Model
{
    public $table = 'category';
    public $primaryKey = 'Id_category';
    public $timestamps = false;
    public $fillable = ['Id_category','Category_code','Category_name','Status'];
    public $incrementing = true;



    public function add_category ($code, $name)
    {
       
        $du = category::where('Category_code','=', $code)
                ->where('Status','=',1)
                ->get();

        $du2 = category::where('Category_name','=',$name)
        ->where('Status','=',1)
        ->get();

        if(count($du)==0 &&count($du2)==0 ) 
        {
            category::create(
            [
                'Id_category' => null,
                'Category_code' => strtoupper($code),
                'Category_name' =>strtoupper($name),
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


    public function edit_category ($id,$code, $name)
    {
        $dc = category::where('Category_code','=', $code)
                ->where('Id_category','<>',$id)
                ->get();

        $dn = category::where('Category_name','=', $name)
        ->where('Id_category','<>',$id)
        ->get();

        if(count($dc)==0 && count($dn)==0)
        {
            category::where('Id_category','=',$id)->update(array(
                'Category_code' => strtoupper($code),
                'Category_name'=>strtoupper($name),
            ));
            return "sukses";
        }
        else
        {
            return "failed";
        }


    }

    public function deletecategory($id)
    {
        category::where('Id_category','=',$id)->update(array(
            'Status' => 0
        ));
    }

    public function getcategory($id)
    {
        return category::where('Id_category', '=', $id)
        ->where('Status','=',1)
                        ->get();
    }

    public function getsubcategory($kodecat)
    {
        return sub_category::where('Id_category', '=', $kodecat)
        ->where('Status','=',1)
                        ->get();
    }
}

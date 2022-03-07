<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sub_category extends Model
{
    public $table = 'sub_category';
    public $primaryKey = 'Id_sub_category';
    public $timestamps = false;
    public $fillable = ['Id_sub_category','Id_category','Sub_category_code','Sub_category_name','Status'];
    public $incrementing = true;

    public function add_sub_category ($id_cat, $sub_code,$sub_name)
    {
       
        $du = sub_category::where('Sub_category_code','=', $sub_code)
                ->where('Status','=',1)
                ->get();

        $du2 = sub_category::where('Sub_category_name','=',$sub_name)
        ->where('Status','=',1)
        ->get();

        if(count($du)==0 && count($du2)==0)
        {
           
            sub_category::create(
            [
                'Id_sub_category' => null,
                'Id_category' => strtoupper($id_cat),
                'Sub_category_code' => strtoupper($sub_code),
                'Sub_category_name' => strtoupper($sub_name),
                'Status' => 1
            ]
            );
            return "sukses";
        }
        else
        {
            return "failed";
        }


    }

    public function deletesubcategory($id)
    {
        sub_category::where('Id_category','=',$id)->update(array(
            'Status' => 0
        ));
    }

    public function deletesubcategory2($id)
    {
        sub_category::where('Id_sub_category','=',$id)->update(array(
            'Status' => 0
        ));
    }

    public function edit_sub_category ($id_sub,$id_cat,$code, $name)
    {
        $dc = sub_category::where('Sub_category_code','=', $code)
                ->where('Id_sub_category','<>',$id_sub)
                ->get();

        $dn = sub_category::where('Sub_category_name','=', $name)
        ->where('Id_sub_category','<>',$id_sub)
        ->get();

        if(count($dc)==0 && count($dn)==0)
        {
            sub_category::where('Id_sub_category','=',$id_sub)->update(array(
                'Id_category' => strtoupper($id_cat),
                'Sub_category_code' => strtoupper($code),
                'Sub_category_name'=>strtoupper($name),
            ));
            return "sukses";
        }
        else
        {
            return "failed";
        }


    }

    public function getsubcategory($kodesub)
    {
        return sub_category::where('sub_category.Id_sub_category', '=', $kodesub)
        ->where('sub_category.Status','=',1)
        ->join('category','sub_category.Id_category','category.Id_category')
        ->select('category.Id_category', 'sub_category.Sub_category_code', 'sub_category.Sub_category_name')
        ->get();	

    }
}

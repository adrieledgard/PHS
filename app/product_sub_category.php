<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_sub_category extends Model
{

    public $table = 'product_sub_category';
    public $primaryKey = 'Id_product_sub_category';
    public $timestamps = false;
    public $fillable = ['Id_product_sub_category','Id_product','Id_sub_category'];
    public $incrementing = true;


    
    public function insertdata ($Id_product, $Id_sub_category)
    {
       
      
        product_sub_category::create(
        [
            'Id_product_sub_category' => null,
            'Id_product' => strtoupper($Id_product),
            'Id_sub_category' => strtoupper($Id_sub_category)
            
        ]
        );
        return "sukses";
       

    }


    public function deletedata($Id_product)
    {
       
      
        product_sub_category::where('Id_product','=',$Id_product)
        ->delete();
        return "sukses";
       

    }
}

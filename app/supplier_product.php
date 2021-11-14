<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class supplier_product extends Model
{
    public $table = 'supplier_product';
    public $primaryKey = 'Id_supplier_product';
    public $timestamps = false;
    public $fillable = ['Id_supplier_product','Id_supplier','Id_product','Status'];
    public $incrementing = true;

    public function add_product ($Id_supplier, $Id_product)
    {

        supplier_product::create(
        [
            'Id_supplier_product' => null,
            'Id_supplier' => strtoupper($Id_supplier),
            'Id_product' => strtoupper($Id_product),
            'Status' => 1
        ]
        );
       
        
    }

    public function deletesupp($Id_supplier)
    {
        supplier_product::where('Id_supplier','=',$Id_supplier)
        ->delete();
    }


 
}

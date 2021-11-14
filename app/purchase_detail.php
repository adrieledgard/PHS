<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchase_detail extends Model
{
    //

    public $table = 'purchase_detail';
    public $primaryKey = 'No_detail';
    public $timestamps = false;
    public $fillable = ['No_detail','No_invoice','Id_product','Id_variation','Qty','Purchase_price'];
    public $incrementing = true;



    public function insertdata ($No_invoice,$Id_product, $Id_variation, $Qty, $Purchase_price)
    {
      
        purchase_detail::create(
        [
            'No_detail' => null,
            'No_invoice' => strtoupper($No_invoice),
            'Id_product' => strtoupper($Id_product),
            'Id_variation' => strtoupper($Id_variation),
            'Qty' => strtoupper($Qty),
            'Purchase_price' => strtoupper($Purchase_price)
            
            

        ]
        );
        return "sukses";
       

    }

    public function lastnodetail()
    {
        $temp = purchase_detail::all();
        $c = 0;

        for ($i=0; $i < count($temp) ; $i++) { 
            if($temp[$i]['No_detail']>$c)
            {
                $c = $temp[$i]['No_detail'];
            }
        }

        return $c;

    }
}

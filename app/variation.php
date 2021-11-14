<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class variation extends Model
{
    public $table = 'variation_product';
    public $primaryKey = 'Id_variation';
    public $timestamps = false;
    public $fillable = ['Id_variation','Id_product','Variation_name','Option_name','Purchase_price',
                        'Sell_price','Weight','Dimension','Stock','Stock_atc','Stock_pay','Status'];
    public $incrementing = true;


    
    public function insertdata ($Id_product, $Variation_name, $Option_name, $Purchase_price,$Sell_price,
    $Weight,$Dimension, $Stock, $Status)
    {
       
      
        variation::create(
        [
            'Id_variation' => null,
            'Id_product' => strtoupper($Id_product),
            'Variation_name' => strtoupper($Variation_name),
            'Option_name' => strtoupper($Option_name),
            'Purchase_price' => $Purchase_price,
            'Sell_price' => $Sell_price,
            'Weight' => $Weight,
            'Dimension' => strtoupper($Dimension),
            'Stock' => $Stock,
            'Stock_atc' => 0,
            'Stock_pay' => 0,
            'Status' => strtoupper($Status)

        ]
        );
        return "sukses";
       

    }


    public function edit_variation ($Id_variation,$Id_product, $Variation_name, $Option_name, $Purchase_price,$Sell_price,
    $Weight,$Dimension, $Stock, $Status)
    {


        variation::where('Id_variation','=',$Id_variation)->update(array(
            'Id_product'=>strtoupper($Id_product),
            'Variation_name'=>strtoupper($Variation_name),
            'Option_name'=>strtoupper($Option_name),
            'Purchase_price'=>strtoupper($Purchase_price),
            'Sell_price'=>strtoupper($Sell_price),
            'Weight'=>strtoupper($Weight),
            'Dimension'=>strtoupper($Dimension),
            'Stock'=>strtoupper($Stock),
            'Status'=>strtoupper($Status)
        ));
        return "sukses";




    }


    public function edit_variation_status ($Id_variation,$angka)
    {
        variation::where('Id_variation','=',$Id_variation)->update(array(
            'Status'=>strtoupper($angka)
        ));
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rate_review extends Model
{
    protected $table = "rating_review";
    protected $fillable = ["Id_order", 'Id_detail_order', 'Id_member', 'rate', 'review'];


    public function edit_rating_review($id_detail_order, $rate, $review)
    {
        rate_review::where('Id_detail_order','=',$id_detail_order)->update(array(
            'rate' => strtoupper($rate),
            'review' => strtoupper($review),
        ));
        return "sukses";
    }

    public function insert_rating_review($Id_detail_order,$Id_order,$Id_member,$rate,$review,$Purchase_price)
    {
      
        receive_detail::create(
        [
            'No_receive_detail' => null,
            'No_receive' => strtoupper($No_receive),
            'Id_product' => strtoupper($Id_product),
            'Id_variation' => strtoupper($Id_variation),
            'No_purchase_detail' => strtoupper($No_detail),
            'Qty' => strtoupper($Qty),
            'Purchase_price' => strtoupper($Purchase_price)
        ]
        );
        return "sukses";
    }
}

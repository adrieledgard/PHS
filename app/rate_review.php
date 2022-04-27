<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rate_review extends Model
{
    protected $table = "rating_review";
    protected $fillable = ['Id',"Id_order", 'Id_detail_order', 'Id_member', 'rate', 'review'];


    public function edit_rating_review($id_detail_order, $rate, $review)
    {
        rate_review::where('Id_detail_order','=',$id_detail_order)->update(array(
            'Rate' => strtoupper($rate),
            'Review' => strtoupper($review),
        ));
        return "sukses";
    }

    public function insert_rating_review($Id_detail_order,$Id_order,$Id_member,$rate,$review)
    {
      
        rate_review::create(
        [
            'Id' => null,
            'Id_order' => $Id_order,
            'Id_detail_order' => $Id_detail_order,
            'Id_member' => $Id_member,
            'Rate' => $rate,
            'Review' => $review,
            'Status' => 'Active',
        ]
        );
        return "sukses";
    }
   
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rate_review extends Model
{
    protected $table = "rating_review";
    protected $fillable = ["Id_order", 'Id_detail_order', 'Id_member', 'Rate', 'Review', 'Status'];
  
    public $timestamps = false;
    public $incrementing = true;


    public function edit_rating_review($id_detail_order, $rate, $review)
    {
        rate_review::where('Id_detail_order','=',$id_detail_order)->update(array(
            'Rate' => $rate,
            'Review' => $review,
        ));
        return "sukses";
    }

    public function insert_rating_review($Id_detail_order,$Id_order,$Id_member,$Rate,$Review)
    {
      
        rate_review::create(
        [
            'id' => null,
            'Id_order' => $Id_order,
            'Id_detail_order' => $Id_detail_order,
            'Id_member' => $Id_member,
            'Rate' => $Rate,
            'Review' => $Review,
            'Status' => 'Active'
        ]
        );
        return "sukses";
    }
   
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class wishlist extends Model
{
    //

    public $table = 'wishlist';
    public $primaryKey = 'Id_wishlist';
    public $timestamps = false;
    public $fillable = ['Id_wishlist','Id_product','Id_variation','Qty','Id_member'];
    public $incrementing = true;

    public function add_wishlist($Id_product,$Id_variation,$Qty,$Id_member)
    {
        wishlist::create(
        [
            'Id_wishlist' => null,
            'Id_product' => strtoupper($Id_product),
            'Id_variation' => strtoupper($Id_variation),
            'Qty' => strtoupper($Qty),
            'Id_member' => strtoupper($Id_member)
        ]
        );
        return "sukses";
    }


    public function edit_wishlist($Id_wishlist,$Qty)
    {
     
        wishlist::where('Id_wishlist','=',$Id_wishlist)->update(array(
            'Qty'=>strtoupper($Qty),
        ));
        return "sukses";
     
    }


    public function delete_wishlist($Id_wishlist)
    {
        wishlist::where('Id_wishlist','=',$Id_wishlist)
            ->delete();


    }
}

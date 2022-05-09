<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class embed_checkout extends Model
{
    //

    protected $table="submitted_embed_checkout";
    
    protected $fillable = ['User_token', 'Name', 'Phone' ,'Email', 'Id_product', 'Id_variation', 'Qty'];

    public function add_embed_checkout($user_token, $name, $phone, $email, $id_product, $id_variation, $qty)
    {
        embed_checkout::create(
        [
            'id' => null,
            'User_token' => $user_token,
            'Name' => $name,
            'Phone' => $phone,
            'Email' => $email,
            'Id_product' => $id_product,
            'Id_variation' => $id_variation,
            'Qty' => $qty,
        ]
        );
        return "sukses";

    }

    public function getlastid()
    {
        $temp = embed_checkout::all();
        $c = 0;

        for ($i=0; $i < count($temp) ; $i++) { 
            if($temp[$i]['id']>$c)
            {
                $c = $temp[$i]['id'];
            }
        }

        return $c;
    }

}

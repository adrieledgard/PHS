<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_image extends Model
{
    //

    public $table = 'product_image';
    public $primaryKey = 'Id_image';
    public $timestamps = false;
    public $fillable = ['Id_image','Id_product','Image_name','Image_order'];
    public $incrementing = true;


    public function add_image ($Id_product,$Image_name)
    {
        $urutan=0;

        $du = product_image::where('Id_product','=', $Id_product)
        ->get();

        if(count($du)==0)
        {
            $urutan=1;
        }
        else
        {
            $temp=0;
            foreach ($du as $data) {
                $u = $data->Image_order;
                if($u>$temp)
                {
                    $temp = $u;
                }
            }

            $urutan = $temp+1;
        }
       
        product_image::create(
            [
                'Id_image' => null,
                'Id_product' => strtoupper($Id_product),
                'Image_name' => strtoupper($Image_name),
                'Image_order' => strtoupper($urutan)
            ]
            );
            return "sukses";




    }



    public function switch_image ($id_product,$start_index,$drop_index)
    {
     
        product_image::where('Id_product','=',$id_product)
        ->where('Image_order','=',$start_index)
        ->update(array(
            'Image_order'=>strtoupper(0)
        ));

        product_image::where('Id_product','=',$id_product)
        ->where('Image_order','=',$drop_index)
        ->update(array(
            'Image_order'=>strtoupper($start_index)
        ));


        product_image::where('Id_product','=',$id_product)
        ->where('Image_order','=',0)
        ->update(array(
            'Image_order'=>strtoupper($drop_index)
        ));



        return "sukses";
     
    }

    public function deletedata($id,$id_product,$image_order)
    {
        product_image::where('Id_image','=',$id)
            ->delete();
    
        if($image_order==1)
        {
            $data = product_image::where('Id_product','=',$id_product)
            ->get();


            $ix= 9999;
            foreach ($data as $dt ) {
                if ($dt->Image_order < $ix) {
                   $ix = $dt->Image_order;
                }
            }

            product_image::where('Id_product','=',$id_product)
            ->where('Image_order','=', $ix)
            ->update(array(
                'Image_order'=>1,
            ));

        }

        
        

        return "sukses";
    }
}

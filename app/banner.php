<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class banner extends Model
{
    //

    public $table = 'banner';
    public $primaryKey = 'Id_banner';
    public $timestamps = false;
    public $fillable = ['Id_banner','Banner_image','Banner_header','Banner_content','Banner_cta','Id_product','Banner_position','Urutan'];
    public $incrementing = true;

    public function add_banner($Banner_image,$Banner_header,$Banner_content,$Banner_cta,$Id_product,$Banner_position, $Urutan)
    {
        banner::create(
        [
            'Banner_image' => $Banner_image,
            'Banner_header' => ($Banner_header),
            'Banner_content' => ($Banner_content),
            'Banner_cta' => ($Banner_cta),
            'Id_product' => strtoupper($Id_product),
            'Banner_position' => strtoupper($Banner_position),
            'Urutan' => $Urutan
        ]
        );

    }
    public function edit_banner($Banner_image,$Id_banner,$Banner_header,$Banner_content,$Banner_cta,$Id_product,$Banner_order)
    {
        $br=banner::where('Id_banner','=',$Id_banner)
        ->get();

        $orderlama = $br[0]['Urutan'];

        banner::where('Urutan','=',$Banner_order)
        ->where('Banner_position','=',1)
        ->update(array(
        'Urutan' => strtoupper($orderlama),
        ));


        if($Banner_image=="")
        {
            banner::where('Id_banner','=',$Id_banner)
            ->update(array(
            'Banner_header' => ($Banner_header),
            'Banner_content' => ($Banner_content),
            'Banner_cta' => ($Banner_cta),
            'Id_product' => ($Id_product),
            'Urutan' => ($Banner_order),
            ));
        }
        else
        {
            banner::where('Id_banner','=',$Id_banner)
            ->update(array(
            'Banner_image' => ($Banner_image),
            'Banner_header' => ($Banner_header),
            'Banner_content' => ($Banner_content),
            'Banner_cta' => ($Banner_cta),
            'Id_product' => ($Id_product),
            'Urutan' => ($Banner_order),
            ));
        }
      
    }

    public function edit_banner_2($Banner_image,$Id_banner,$Banner_header,$Banner_cta,$Id_product)
    {
        if($Banner_image=="")
        {
            banner::where('Id_banner','=',$Id_banner)
            ->update(array(
            'Banner_header' => ($Banner_header),
            'Banner_content' => "",
            'Banner_cta' => ($Banner_cta),
            'Id_product' => ($Id_product),
            'Urutan' => 1,
            ));
        }
        else
        {
            banner::where('Id_banner','=',$Id_banner)
            ->update(array(
            'Banner_image' => ($Banner_image),
            'Banner_header' => ($Banner_header),
            'Banner_content' => "",
            'Banner_cta' => ($Banner_cta),
            'Id_product' => ($Id_product),
            'Urutan' => 1,
            ));
        }
    }

    public function add_banner_2($Banner_image,$Banner_header,$Banner_cta,$Id_product)
    {
        banner::create(
        [
            'Banner_image' => $Banner_image,
            'Banner_header' => ($Banner_header),
            'Banner_content' => "",
            'Banner_cta' => ($Banner_cta),
            'Id_product' => strtoupper($Id_product),
            'Banner_position' => 2,
            'Urutan' => 1
        ]
        );
    
    }

    public function delete_banner($Id_banner)
    {
        banner::where('Id_banner','=',$Id_banner)
        ->delete();
        $br= banner::where('Banner_position','=',1)
        ->orderby('Urutan')
        ->get();

        $ctr=0;
        foreach ($br as $data) {
            $ctr++;

            banner::where('Id_banner','=',$data->Id_banner)
            ->update(array(
            'Urutan' => $ctr,
            ));
        }
    }

    
}

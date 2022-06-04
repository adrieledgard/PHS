<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    public $table = 'product';
    public $primaryKey = 'Id_product';
    public $timestamps = false;
    public $fillable = ['Id_product','Name','Id_type','Packaging','Id_brand',
                        'Composition','Bpom','Efficacy','Description','Storage'
                        ,'Dose','Disclaimer','Variation','Status'];
    public $incrementing = true;


    public function insertdata ($name, $id_type, $packaging, $id_brand,$composition,
    $bpom,$efficacy, $desc,$storage,$dose,$disclaimer,$variation,$status)
    {
       
      
        product::create(
        [
            'Id_product' => null,
            'Name' => strtoupper($name),
            'Id_type' => strtoupper($id_type),
            'Packaging' => strtoupper($packaging),
            'Id_brand' => strtoupper($id_brand),
            'Composition' => strtoupper($composition),
            'Bpom' => strtoupper($bpom),
            'Efficacy' => strtoupper($efficacy),
            'Description' => strtoupper($desc),
            'Storage' => strtoupper($storage),
            'Dose' => strtoupper($dose),
            'Disclaimer' => strtoupper($disclaimer),
            'Variation' => strtoupper($variation),
            'Status' => strtoupper($status)

        ]
        );
        return "sukses";
       

    }

    public function getlastid()
    {
        $dn = product::all();
        $ix=0;

        foreach ($dn as $data) {
           $ix = $data->Id_product;
        }


        // // $ix=0;
        // // for ($i=0; $i < count($dn); $i++) { 
        // //     $ix = $dn->Id_product;
        // // }

        // $ix=7;
        return $ix;
    }


    public function edit_product ($idp,$name, $id_type, $packaging, $id_brand,$composition,
    $bpom,$efficacy, $desc,$storage,$dose,$disclaimer,$variation,$status)
    {

        product::where('Id_product','=',$idp)->update(array(
            'Name'=>strtoupper($name),
            'Id_type'=>strtoupper($id_type),
            'Packaging'=>strtoupper($packaging),
            'Id_brand'=>strtoupper($id_brand),
            'Composition'=>strtoupper($composition),
            'Bpom'=>strtoupper($bpom),
            'Efficacy'=>strtoupper($efficacy),
            'Description'=>strtoupper($desc),
            'Storage'=>strtoupper($storage),
            'Dose'=>strtoupper($dose),
            'Disclaimer'=>strtoupper($disclaimer),
            'Variation'=>strtoupper($variation),
            'Status'=>strtoupper($status),
        ));
        return "sukses";

    }


    
    public function getvariation($Id_product)
    {
        // $Id_product = $request->Id_product;

        return variation::where('Id_product', '=', $Id_product)
        ->where('Status','=',1)
        ->get();	

    }

    public function getproduct_search()
    {
        $search_name     = session()->get('search_name'); 
        $start_price   =  session()->get('start_price');
        $end_price   = session()->get('end_price');
        $kumpulan_id_brand    = session()->get('kumpulan_id_brand');
        $kumpulan_id_sub_cat    = session()->get('kumpulan_id_sub_cat');
        $sortby    = session()->get('sortby');


		// session()->put('sortby','Default');

        $query = product::query();
        $query  = $query->select('product.Id_product', 'product.Name', 'type.Type_name', 'brand.Brand_name', 'variation_product.Sell_price', 'product.Rating');
        $query  = $query->join("type", "product.Id_type", "=", "type.Id_type");
        $query  = $query->join("brand", "product.Id_brand", "=", "brand.Id_brand");
        $query  = $query->join("product_sub_category", "product.Id_product", "=", "product_sub_category.Id_product");
        $query  = $query->join("variation_product", "product.Id_product", "=", "variation_product.Id_product");

        if($search_name != "")
        { 
            $query  = $query->where('product.Name', 'like', '%'.$search_name.'%'); 
        }
         if($start_price != "") { $query  = $query->where('variation_product.Sell_price', '>=', $start_price); }
         if($end_price != "") { $query  = $query->where('variation_product.Sell_price', '<=', $end_price); }
        
        if($kumpulan_id_brand != "") {
            $query  = $query->where(function($query) use ($kumpulan_id_brand) {
                $t  = explode(',', $kumpulan_id_brand); 
                for($i = 0; $i < count($t); $i++) {
                    $query  = $query->orwhere('brand.Id_brand', '=', $t[$i]); 
                }
           });
        }

        if($kumpulan_id_sub_cat != "") {
            $query  = $query->where(function($query) use ($kumpulan_id_sub_cat) {
                $t  = explode(',', $kumpulan_id_sub_cat); 
                for($i = 0; $i < count($t); $i++) {
                    $query  = $query->orwhere('product_sub_category.Id_sub_category', '=', $t[$i]); 
                }
           });
        }
        $query  = $query->where('product.Status', '=', 1); 
        $query  = $query->where('variation_product.Status', '=', 1); 

        if($sortby != "" && $sortby != "CHEAP" && $sortby != "EXP") {
            $query  = $query->orderBy('product.Name', $sortby);
        }
        else if ($sortby == "CHEAP")
        {
            $query  = $query->orderBy('variation_product.Sell_price', "ASC");
        }
        else if ($sortby == "EXP")
        {
            $query  = $query->orderBy('variation_product.Sell_price', "DESC");
        }
       
        $query  = $query->distinct()->get();





        // dismiss data kembar 
        $arr = []; 
        $patokan = ""; 
        foreach($query as $row) {
            $flag = 0; 
            foreach($arr as $baris) {
                if($row->Name == $baris->Name) 
                { $flag+=1; }
            }

            if($flag == 0) {
                $patokan = $row->Name; 
                array_push($arr, $row); 
            }
        }

         return $arr;
        // return $query;
    }


   

}

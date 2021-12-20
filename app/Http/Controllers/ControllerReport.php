<?php

namespace App\Http\Controllers;
use App\product;
use App\variation;
use App\stock_card;

use Illuminate\Http\Request;

class ControllerReport extends Controller
{
    //

    
    public function stock_card(){

        //  $param['purchase_header'] = purchase_header::where('purchase_header.Id_supplier','>',0)
        //  ->join('supplier','purchase_header.Id_supplier','supplier.Id_supplier')
        //  ->select('purchase_header.No_invoice','purchase_header.Purchase_date','supplier.Supplier_name','purchase_header.Grand_total',\DB::raw('(CASE WHEN purchase_header.Status = 1 THEN "OPEN" WHEN purchase_header.Status = 2 THEN "Partially Processed" WHEN purchase_header.Status = 3 THEN "Partially Processed (Close)" WHEN purchase_header.Status = 4 THEN "Completed (Close)" WHEN purchase_header.Status = 0 THEN "Void" END) AS STATUS_ORDER'))
        //  // ->select('purchase_header.No_invoice',\DB::raw('DATE_FORMAT(purchase_header.Purchase_date,"%d/%m/%Y") as Purchase_date'),'supplier.Supplier_name','purchase_header.Grand_total',\DB::raw('(CASE WHEN purchase_header.Status = 1 THEN "OPEN" WHEN purchase_header.Status = 2 THEN "Partially Processed" WHEN purchase_header.Status = 3 THEN "Partially Processed (Close)" WHEN purchase_header.Status = 4 THEN "Completed (Close)" WHEN purchase_header.Status = 0 THEN "Void" END) AS STATUS_ORDER'))
        //  ->orderby('purchase_header.Purchase_date','Desc')
        //  ->get();
 
 
        //  $param['purchase_detail'] = purchase_detail::all();
 
        $db = product::all(); 
		$arr= [];  // array 
		foreach($db as $row) {
            $arr[0] = "";
			if($row->Status==1)
			{
				$arr[$row->Id_product] = $row->Name; 
			}
		
		}
		
		$param['arr_product']  = $arr; 

         return view('Report_stock_card',$param);
    }

    public function get_variation_product(Request $request)
    {
        $va = new Product();
		echo $va->getvariation($request->Id_product);

    }


    public function show_table_stock_card(Request $request)
	{

        $temp="";
        $Id_variation = $request->Id_variation;

        $stockcard = stock_card::where('stock_card.Id_variation','=',$Id_variation)
        ->join('Product','stock_card.Id_product','Product.Id_product')
         ->join('variation_product','stock_card.Id_variation','variation_product.Id_variation')
        // ->orderBy('stock_card.Id_stock_card')
        ->orderBy('stock_card.Id_stock_card')
         ->select('stock_card.Date_card','Product.Name','variation_product.Option_name','stock_card.Expire_date','stock_card.Type_card','stock_card.First_stock','stock_card.Debet','stock_card.Credit','stock_card.Last_stock','stock_card.Transaction_price','stock_card.Capital','stock_card.Fifo_stock')
        ->get();

        //   $stockcard = stock_card::where('Id_variation','=',$Id_variation)
        //   ->get();

        {{  }}
		for ($i=0; $i < count($stockcard) ; $i++) { 
			$temp =$temp. "<tr>";
                $temp =$temp. "<td>";
                    $temp =$temp. date("d-m-Y", strtotime($stockcard[$i]['Date_card']));
                $temp =$temp. "</td>";
                $temp =$temp. "<td>";
                    $temp =$temp. $stockcard[$i]['Type_card'];
                $temp =$temp. "</td>";
                $temp =$temp. "<td>";
                    $temp =$temp. $stockcard[$i]['Name'];
                $temp =$temp. "</td>";
                $temp =$temp. "<td>";
                     $temp =$temp. $stockcard[$i]['Option_name'];
                $temp =$temp. "</td>";
                $temp =$temp. "<td>";
                    $temp =$temp. date("d-m-Y", strtotime($stockcard[$i]['Expire_date']));
                $temp =$temp. "</td>";
                $temp =$temp. "<td>";
                    $temp =$temp. $stockcard[$i]['First_stock'];
                $temp =$temp. "</td>";
                $temp =$temp. "<td>";
                    $temp =$temp. $stockcard[$i]['Debet'];
                $temp =$temp. "</td>";
                $temp =$temp. "<td>";
                    $temp =$temp. $stockcard[$i]['Credit'];
                $temp =$temp. "</td>";
                $temp =$temp. "<td>";
                    $temp =$temp. $stockcard[$i]['Last_stock'];
                $temp =$temp. "</td>";
                $temp =$temp. "<td>";
                    $temp =$temp. $stockcard[$i]['Fifo_stock'];
                $temp =$temp. "</td>";
                $temp =$temp. "<td>";
                    $temp =$temp. $stockcard[$i]['Transaction_price'];
                $temp =$temp. "</td>";
                $temp =$temp. "<td>";
                    $temp =$temp. $stockcard[$i]['Capital'];
                $temp =$temp. "</td>";
            $temp =$temp. "</tr>";
		}

		return($temp);
	}
    
}

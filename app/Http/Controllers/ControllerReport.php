<?php

namespace App\Http\Controllers;

use App\cust_order_detail;
use App\cust_order_header;
use App\followup;
use App\member;
use App\product;
use App\variation;
use App\stock_card;

use Illuminate\Http\Request;

class ControllerReport extends Controller
{
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

        $period = explode(" - ", $request->date_period);

        $period[0] = date("Y-m-d", strtotime($period[0]));
        $period[1] = date("Y-m-d", strtotime($period[1]));
        
        $stockcard = stock_card::where('stock_card.Id_variation','=',$Id_variation)
        ->join('Product','stock_card.Id_product','Product.Id_product')
         ->join('variation_product','stock_card.Id_variation','variation_product.Id_variation')
        // ->orderBy('stock_card.Id_stock_card')
        ->orderBy('stock_card.Id_stock_card')
         ->select('stock_card.Id_stock_card','stock_card.Date_card','Product.Name','variation_product.Option_name','stock_card.Expire_date','stock_card.Type_card','stock_card.First_stock','stock_card.Debet','stock_card.Credit','stock_card.Last_stock','stock_card.Transaction_price','stock_card.Capital','stock_card.Fifo_stock')
         ->whereBetween("stock_card.Date_card", $period)
         ->get();

        //   $stockcard = stock_card::where('Id_variation','=',$Id_variation)
        //   ->get();

        {{  }}
		for ($i=0; $i < count($stockcard) ; $i++) { 
			$temp =$temp. "<tr>";
                $temp =$temp. "<td>";
                    $temp =$temp. $stockcard[$i]['Id_stock_card'];
                $temp =$temp. "</td>";
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
    
    public function followup_report()
    {
        $customer_service = member::where("Role", "CUSTOMER SERVICE")->get();
        $arr= [];  // array 
		foreach($customer_service as $row) {
			$arr[$row->Id_member] = $row->Username; 
		}
        return view('Report_follow_up', compact('arr'));
    }

    public function print_followup_report(Request $request)
    {
        $request->merge(['date_period' => str_replace("%20", " ", $request->get('date_period'))]);
        $request->merge(['Id_customer_service' => $request->get('Id_customer_service')]);
        $data = $this->show_table_followup_cs($request);
        $data['customer_service'] = member::find($request->Id_customer_service);
        $data['period'] = $request->date_period;
        return view('Report_follow_up_print', compact('data'));
    }

    public function show_table_followup_cs(Request $request)
	{
        //TOTAL, FAILED, SUCCESS
        $summary = [0, 0, 0];
        $temp="";
        $Id_customer_service = $request->Id_customer_service;
        $period = explode(" - ", $request->date_period);
        
        $followup = followup::where("Id_customer_service", $Id_customer_service)
                    ->whereBetween("Followup_date", $period)
                    ->get();
        $summary[0] = count($followup);

		for ($i=0; $i < count($followup) ; $i++) { 
            $cs = member::where("Id_member", $followup[$i]->Id_customer_service)->first();
            $customer = member::where("Id_member", $followup[$i]->Id_member)->first();
            $transaksi = "";
            $status = "Wait transaction";
            if($followup[$i]['Is_successful_followup'] == 0){
                if(date("Y-m-d", strtotime($followup[$i]->End_followup_date)) < date("Y-m-d")){
                    $status = "Failed";
                    $summary[1] ++;
                }
            }else {
                $status = "Sucessful";
                $transaksi = cust_order_header::where("Id_order", $followup[$i]->Id_order)->join('list_city', 'list_city.Id_city', 'cust_order_header.Id_city')->first();
                $transaksi->detail = cust_order_detail::join('product', 'product.Id_product', 'cust_order_detail.Id_product')->join('variation_product', 'variation_product.Id_variation', 'cust_order_detail.Id_variation')->where("Id_order", $followup[$i]->Id_order)->select('product.Name', 'cust_order_detail.Normal_price','cust_order_detail.Discount_promo','cust_order_detail.Qty', 'cust_order_detail.Fix_price', 'variation_product.Variation_name as Variant_name', 'variation_product.Option_name as Variant_option_name')->get();
                $summary[2] ++;

            }
			$temp =$temp. "<tr>";
                $temp =$temp. "<td>";
                    $temp =$temp. $cs->Username;
                $temp =$temp. "</td>";
                $temp =$temp. "<td>";
                    $temp =$temp. $customer->Username;
                $temp =$temp. "</td>";
                $temp =$temp. "<td>";
                    $temp =$temp. date("Y-m-d", strtotime($followup[$i]['Followup_date'])) . " - " . date("Y-m-d", strtotime($followup[$i]['End_followup_date']));
                $temp =$temp. "</td>";
                $temp =$temp. "<td>";
                    $temp =$temp. $status;
                $temp =$temp. "</td>";
                $temp =$temp. "<td>";
                    if($followup[$i]['Is_successful_followup'] == 1){
                        $temp =$temp. "<button class='btn btn-primary btn-sm' data-order='$transaksi' data-toggle='modal' data-target='#rincian_order'>Transaksi</button>";
                    }
                $temp =$temp. "</td>";
            $temp =$temp. "</tr>";
		}

		return([$temp, $summary]);
	}

    public function populer_product($option)
	{
        $products = cust_order_header::join('cust_order_detail', 'cust_order_header.Id_order', 'cust_order_detail.Id_order')
            ->join('product', 'product.Id_product', 'cust_order_detail.Id_product')
            ->join('variation_product', 'variation_product.Id_variation', 'cust_order_detail.Id_variation')
            ->where('cust_order_header.Status', '>=', 2)
            ->groupBy('product.Id_product', 'product.Name', 'variation_product.Id_variation', 'variation_product.Option_name')
            ->orderBy('qty', 'desc')
            ->selectRaw("sum(cust_order_detail.Qty) as qty, product.Name, variation_product.Option_name")->get();

        if($option == 'print'){
            return view('Report_populer_product_print', compact('products'));
        }
        return view('Report_populer_product', compact('products'));
	}

    public function populer_affiliate_product(Request $request, $option)
	{
        $type_affiliate = "all";
        $products = cust_order_header::join('cust_order_detail', 'cust_order_header.Id_order', 'cust_order_detail.Id_order')
            ->join('product', 'product.Id_product', 'cust_order_detail.Id_product')
            ->join('variation_product', 'variation_product.Id_variation', 'cust_order_detail.Id_variation')
            ->where("cust_order_header.Affiliate" ,'<>', "")
            ->where('cust_order_header.Status', '>=', 2);

        if(isset($request->type_affiliate) && $request->type_affiliate != "all"){
            $type_affiliate = $request->type_affiliate;
            $products = $products->where("cust_order_header.Tracking_code", 'like', "%$request->type_affiliate%");   
        }else {
            $products = $products->where("cust_order_header.Tracking_code", "<>", '0');
        }

        $products = $products->groupBy('product.Id_product', 'product.Name', 'variation_product.Id_variation', 'variation_product.Option_name')
            ->orderBy('qty', 'desc')
            ->selectRaw("sum(cust_order_detail.Qty) as qty, product.Name, variation_product.Option_name")->get();

        if($option == 'print'){
            return view('Report_populer_affiliate_product_print', compact('products'));
        }
        return view('Report_populer_affiliate_product', compact('products', 'type_affiliate'));
	}
}

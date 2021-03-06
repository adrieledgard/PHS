<?php

namespace App\Http\Controllers;

use App\affiliate;
use App\cust_order_detail;
use App\cust_order_header;
use App\followup;
use App\member;
use App\product;
use App\purchase_detail;
use App\purchase_header;
use App\receive_detail;
use App\receive_header;
use App\variation;
use App\stock_card;
use App\voucher;
use App\voucher_member;
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

    public function print_stock_card(Request $request)
    {
        $data_stock_card = $this->show_table_stock_card($request);

        return view('Report_stock_card_print', compact('data_stock_card'));
    }

    public function get_variation_product(Request $request)
    {
        $va = new product();
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

		for ($i=0; $i < count($followup) ; $i++) 
        { 
            $cs = member::where("Id_member", $followup[$i]->Id_customer_service)
            ->first();

            $customer = member::where("Id_member", $followup[$i]->Id_member)
            ->first();
            $transaksi = "";
            $status = "Wait transaction";
            if($followup[$i]['Is_successful_followup'] == 0)
            {
                if(date("Y-m-d", strtotime($followup[$i]->End_followup_date)) < date("Y-m-d"))
                {
                    $status = "Failed";
                    $summary[1] ++;
                }
            }
            else
            {
                $status = "Sucessful";
                $transaksi = cust_order_header::where("Id_order", $followup[$i]->Id_order)
                ->join('list_city', 'list_city.Id_city', 'cust_order_header.Id_city')
                ->first();


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

    public function laba_rugi(Request $request)
    {
        $prepare_data = $this->prepareLabaRugiData($request);
        $total_keuntungan = $prepare_data[0];
        $cust_orders = $prepare_data[1];

        $filter_tahun = $this->generate_tahun();
        $filter_bulan = [0 => 'This month', 1 => 'Last month', 3 => '3 months ago', 6 => '6 months ago'];
        return view('Report_laba_rugi', compact('total_keuntungan', 'cust_orders', 'filter_tahun', 'filter_bulan'));
    }

    public function print_laba_rugi_report(Request $request)
    {
        $prepare_data = $this->prepareLabaRugiData($request);
        $total_keuntungan = $prepare_data[0];
        $cust_orders = $prepare_data[1];
        return view('Report_laba_rugi_print', compact('total_keuntungan', 'cust_orders'));
    }

    public function prepareLabaRugiData($request)
    {
        $total_keuntungan = 0;
        $cust_orders = cust_order_header::where('status', '>=', 2);

        if($request->has('filter'))
        {
            $period_format = $this->format_date($request);
            $cust_orders = $cust_orders->whereBetween('Date_time', $period_format);
        }
        $cust_orders = $cust_orders->get();

        //HAPUS CODING DIBAWAH INI
        $temp_orders = $cust_orders;
        //BATAS HAPUS
        foreach ($cust_orders as $index => $order) 
        {
            $order_profit = 0;
            $order_detail = cust_order_detail::join('product', 'product.Id_product', 'cust_order_detail.Id_product')->join('variation_product', 'variation_product.Id_variation', 'cust_order_detail.Id_variation')->where("Id_order", $order->Id_order)->get();
            foreach ($order_detail as $detail) 
            {
                $order_detail_stock_card = stock_card::where("No_reference", $detail->Id_detail_order)
                ->where("Type_card",'LIKE','Cust_order%')
                ->first();
                //HAPUS CODING DIBAWAH INI
                if(empty($order_detail_stock_card))
                {
                    continue;
                }
                //BATAS HAPUS
                $id_product_stock_card = explode("Cust_order - ", $order_detail_stock_card->Type_card);
                $item_stock_card = stock_card::find($id_product_stock_card[1]);
                $profit_product_sale = ($detail->Fix_price - $item_stock_card->Capital) * $detail->Qty;

                $detail->harga_modal = $item_stock_card->Capital;
                $detail->keuntungan_per_item = ($detail->Fix_price - $item_stock_card->Capital);
                $detail->keuntungan_item = $profit_product_sale;
                $order_profit += $profit_product_sale;
                
                
            }
            $order->detail = $order_detail;
            $order->order_profit = $order_profit;
            $total_keuntungan += $order_profit;

            //HAPUS CODING DIBAWAH INI
            if($order_profit == 0){
                unset($temp_orders[$index]);
            }
            //BATAS HAPUS
        }

        return [$total_keuntungan, $cust_orders];
    }

    public function generate_tahun()
    {
        $tahun = [];
        $date = date("Y", strtotime(date("Y-m-d")));
        for($i = 0; $i <= 10; $i++){
            $tahun[$date-$i] = $date-$i;
        }

        return $tahun;
    }

    public function format_date($request)
    {
        $period = [];
        if($request->filter == "bulan")
        {
            $period[0] = date("Y-m-01", strtotime("-$request->filter_bulan month")) . " 00:00:00";
            $period[1] = date("Y-m-t", strtotime("-$request->filter_bulan month")) . " 23:59:59";
        }
        else if($request->filter == "tahun")
        {
            $period[0] = date("$request->filter_tahun-m-01") . " 00:00:00";
            $period[1] = date("$request->filter_tahun-m-t") . " 23:59:59";
        }
        else 
        {
            $date_range = explode(" - ", $request->filter_date_range);
            $period[0] = $date_range[0] . " 00:00:00";
            $period[1] = $date_range[1] . " 23:59:59";
        }

        return $period;
    }

    public function penjualan(Request $request)
    {
        $prepare_data = $this->preparePenjualanData($request);
        $total_omzet = $prepare_data[0];
        $cust_orders = $prepare_data[1];
        $total_voucher = $prepare_data[2];

        $filter_tahun = $this->generate_tahun();
        $filter_bulan = [0 => 'This month', 1 => 'Last month', 3 => '3 months ago', 6 => '6 months ago'];
        return view('Report_penjualan', compact('total_omzet', 'cust_orders', 'filter_tahun', 'filter_bulan', 'total_voucher'));
    }

    public function print_penjualan_report(Request $request)
    {
        $prepare_data = $this->preparePenjualanData($request);
        $total_omzet = $prepare_data[0];
        $cust_orders = $prepare_data[1];
        $total_voucher = $prepare_data[2];

        return view('Report_penjualan_print', compact('total_omzet', 'cust_orders', 'total_voucher'));
    }

    public function preparePenjualanData($request)
    {
        $total_omzet = 0;
        $total_voucher = 0;
        $cust_orders = cust_order_header::where('status', '>=', 2);

        if($request->has('filter'))
        {
            $period_format = $this->format_date($request);
            $cust_orders = $cust_orders->whereBetween('Date_time', $period_format);
        }
        $cust_orders = $cust_orders->get();

        foreach ($cust_orders as $order) {
            
            $order_detail = cust_order_detail::join('product', 'product.Id_product', 'cust_order_detail.Id_product')->join('variation_product', 'variation_product.Id_variation', 'cust_order_detail.Id_variation')->where("Id_order", $order->Id_order)->get();
            
            $voucher = voucher::find($order->Id_voucher);
            if(!empty($voucher))
            {
                $total_voucher += $voucher->Discount;
                $order->voucher = $voucher;
            }
            $order->detail = $order_detail;
            $total_omzet += $order->Grand_total;
        }

        return [$total_omzet, $cust_orders, $total_voucher];
    }

    public function transaksi_affiliate(Request $request)
    {
        $prepare_data = $this->prepareTransaksiAffiliateData($request);
        $total_omzet = $prepare_data[0];
        $cust_orders = $prepare_data[1];

        $filter_tahun = $this->generate_tahun();
        $filter_bulan = [0 => 'This month', 1 => 'Last month', 3 => '3 months ago', 6 => '6 months ago'];
        return view('Report_transaksi_affiliate', compact('total_omzet', 'cust_orders', 'filter_tahun', 'filter_bulan'));
    }

    public function print_transaksi_affiliate_report(Request $request)
    {
        $prepare_data = $this->prepareTransaksiAffiliateData($request);
        $total_omzet = $prepare_data[0];
        $cust_orders = $prepare_data[1];

        return view('Report_transaksi_affiliate_print', compact('total_omzet', 'cust_orders'));
    }

    public function prepareTransaksiAffiliateData($request)
    {
        $total_omzet = 0;
        $cust_orders = cust_order_header::where('status', '>=', 2)->where('Affiliate', "<>", "")->where('Tracking_code', '<>', '');
        
        if($request->has('filter'))
        {
            $period_format = $this->format_date($request);
            $cust_orders = $cust_orders->whereBetween('Date_time', $period_format);
        }
        $cust_orders = $cust_orders->get();

        foreach ($cust_orders as $order) 
        {
            $order_detail = cust_order_detail::join('product', 'product.Id_product', 'cust_order_detail.Id_product')->join('variation_product', 'variation_product.Id_variation', 'cust_order_detail.Id_variation')->where("Id_order", $order->Id_order)->get();
            
            $order->affiliator = member::where('Random_code', $order->Affiliate)->first();
            $order->jenis_affiliate = (explode("-", $order->Tracking_code))[0];
            $order->detail = $order_detail;
            $total_omzet += $order->Grand_total;
        }

        return [$total_omzet, $cust_orders];
    }

    
    public function omzet_affiliator(Request $request)
    {
        $prepare_data = $this->prepareOmzetAffiliatorData($request);
        $total_omzet = $prepare_data[0];
        $affiliators = $prepare_data[1];

        $filter_tahun = $this->generate_tahun();
        $filter_bulan = [0 => 'This month', 1 => 'Last month', 3 => '3 months ago', 6 => '6 months ago'];
        return view('Report_omzet_affiliator', compact('total_omzet', 'affiliators', 'filter_tahun', 'filter_bulan'));
    }

    public function print_omzet_affiliator_report(Request $request)
    {
        $prepare_data = $this->prepareOmzetAffiliatorData($request);
        $total_omzet = $prepare_data[0];
        $affiliators = $prepare_data[1];

        return view('Report_omzet_affiliator_print', compact('total_omzet', 'affiliators'));
    }

    public function prepareOmzetAffiliatorData($request)
    {
        $total_omzet = 0;
        $affiliators = member::where("Role", 'CUST')->get();
        foreach ($affiliators as $affiliator) 
        {
            $total_omzet_affiliator = 0;
            $total_point = 0;
            $cust_orders = cust_order_header::where('status', '>=', 2)->where('Affiliate', $affiliator->Random_code)->where('Tracking_code', '<>', '');
            if($request->has('filter'))
            {
                $period_format = $this->format_date($request);
                $cust_orders = $cust_orders->whereBetween('Date_time', $period_format);
            }
            $cust_orders = $cust_orders->get();

            foreach ($cust_orders as $order) 
            {
                $order_detail = cust_order_detail::join('product', 'product.Id_product', 'cust_order_detail.Id_product')->join('variation_product', 'variation_product.Id_variation', 'cust_order_detail.Id_variation')->where("Id_order", $order->Id_order)->get();
                
                foreach ($order_detail as $detail) 
                {
                    $affiliate = affiliate::where("Id_product", $detail->Id_product)->where("Id_variation", $detail->Id_variation)->first();
                    if(!empty($affiliate))
                    {
                        $total_point += $affiliate->Poin;
                    }
                }
                $order->jenis_affiliate = (explode('-', $order->Tracking_code))[0];
                $order->detail = json_encode($order_detail);
                $total_omzet_affiliator += $order->Grand_total;
            }
            $total_omzet += $total_omzet_affiliator;
            $affiliator->orders = $cust_orders;
            $affiliator->total_omzet = $total_omzet_affiliator;
            $affiliator->total_point = $total_point;
        }
        
        return [$total_omzet, $affiliators];
    }
    
    public function penukaran_point_member(Request $request)
    {
        $members = $this->preparePenukaranPointMemberData($request);

        return view('Report_penukaran_point_member', compact('members'));
    }

    public function print_penukaran_point_member_report(Request $request)
    {
        $members = $this->preparePenukaranPointMemberData($request);

        return view('Report_penukaran_point_member_print', compact('members'));
    }

    public function preparePenukaranPointMemberData($request)
    {
        $members = member::all();

        foreach ($members as $member) 
        {
            $total_point_ditukar = 0;
            $member->rincian_penukaran = voucher::join('point_card', 'point_card.No_reference', 'voucher.Id_voucher')->where('point_card.Id_member', $member->Id_member)->where('point_card.Type', 'Claim voucher')->orderBy("Date_card", 'desc')->get();

            foreach ($member->rincian_penukaran as $penukaran) 
            {
                $total_point_ditukar += $penukaran->Point;
            }
            $member->total_point_ditukar = $total_point_ditukar;
        }

        return $members;
    }

    
    public function pembelian(Request $request)
    {
        $prepare_data = $this->preparePembelianData($request);
        $total_pengeluaran = $prepare_data[0];
        $purchases = $prepare_data[1];
        // $total_voucher = $prepare_data[2];

        $filter_tahun = $this->generate_tahun();
        $filter_bulan = [0 => 'This month', 1 => 'Last month', 3 => '3 months ago', 6 => '6 months ago'];
        return view('Report_pembelian', compact('total_pengeluaran', 'purchases', 'filter_tahun', 'filter_bulan'));
    }

    public function print_pembelian_report(Request $request)
    {
        $prepare_data = $this->preparePembelianData($request);
        $total_pengeluaran = $prepare_data[0];
        $purchases = $prepare_data[1];
        // $total_voucher = $prepare_data[2];

        return view('Report_pembelian_print', compact('total_pengeluaran', 'purchases'));
    }

    public function preparePembelianData($request)
    {
        $total_pengeluaran = 0;
        $purchases = purchase_header::join('supplier', 'supplier.Id_supplier', 'purchase_header.Id_supplier')->where('purchase_header.Status', '>=', 1);
        if($request->has('filter'))
        {
            $period_format = $this->format_date($request);
            $purchases = $purchases->whereBetween('Purchase_date', $period_format);
        }
        $purchases = $purchases->select('purchase_header.status as purchasestat', 'purchase_header.*', 'supplier.*');
        $purchases = $purchases->get();

        foreach ($purchases as $purchase) {
            $purchase_detail = purchase_detail::join('product', 'product.Id_product', 'purchase_detail.Id_product')->join('variation_product', 'variation_product.Id_variation', 'purchase_detail.Id_variation')->where("No_invoice", $purchase->No_invoice)->get();
            
            $receive_purchase = receive_header::where('No_invoice', $purchase->No_invoice)
            ->where('Status','=',2)
            ->get();
            foreach ($receive_purchase as $receive) 
            {
                $receive->detail = receive_detail::join('product', 'product.Id_product', 'receive_detail.Id_product')->join('variation_product', 'variation_product.Id_variation', 'receive_detail.Id_variation')->where('No_receive', $receive->No_receive)->get();
            }

            $purchase->receive = $receive_purchase;
            $purchase->detail = $purchase_detail;
            $total_pengeluaran += $purchase->Grand_total;
        }

        return [$total_pengeluaran, $purchases];
    }
}

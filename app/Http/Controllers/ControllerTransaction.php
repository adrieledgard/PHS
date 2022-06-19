<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\supplier;
use App\product;
use App\product_image;
use App\variation;
use App\brand;
use App\bank;
use App\type;
use App\member;
use App\purchase_header;
use App\purchase_detail;
use App\purchase_expire;
use App\receive_header;
use App\receive_detail;
use App\receive_expire;
use App\supplier_product;
use App\purchase_payment;




use App\Http\Controllers\DateTime;
use App\Rules\ValidasiExpiredDate;
use App\Rules\ValidasiProductExist;
use App\Rules\ValidasiPurchaseInvoiceDate;

class ControllerTransaction extends Controller
{
    //

    
	public function Purchase(){


	   //STATUS
       //0 Void
       //1 Open (baru)
       //2 sdh datang sebagian barang tapi belum terpenuhi (posisi belum close)
       //3 sdh datang sebagian barang tapi belum terpenuhi (posisi close)
       //4 sdh datang dan sdh terpenuhi dan di close
		$param['purchase_header'] = purchase_header::where('purchase_header.Id_supplier','>',0)
		->join('supplier','purchase_header.Id_supplier','supplier.Id_supplier')
		->select('purchase_header.No_invoice','purchase_header.Purchase_date','supplier.Supplier_name','purchase_header.Grand_total',\DB::raw('(CASE WHEN purchase_header.Status = 1 THEN "OPEN" WHEN purchase_header.Status = 2 THEN "Partially Processed" WHEN purchase_header.Status = 3 THEN "Partially Processed (Close)" WHEN purchase_header.Status = 4 THEN "Completed (Close)" WHEN purchase_header.Status = 0 THEN "Void" END) AS STATUS_ORDER'))
		// ->select('purchase_header.No_invoice',\DB::raw('DATE_FORMAT(purchase_header.Purchase_date,"%d/%m/%Y") as Purchase_date'),'supplier.Supplier_name','purchase_header.Grand_total',\DB::raw('(CASE WHEN purchase_header.Status = 1 THEN "OPEN" WHEN purchase_header.Status = 2 THEN "Partially Processed" WHEN purchase_header.Status = 3 THEN "Partially Processed (Close)" WHEN purchase_header.Status = 4 THEN "Completed (Close)" WHEN purchase_header.Status = 0 THEN "Void" END) AS STATUS_ORDER'))
		->orderby('purchase_header.Purchase_date','Desc')
		->get();


		$param['purchase_detail'] = purchase_detail::all();

		return view('Purchase',$param);
	}
	public function Purchase_pre_add()
	{
		session()->forget('purchase_product_session');
		return redirect('Purchase_add');
	}

    public function Purchase_add(){
		$param['dtsupplier'] = supplier::where('Status','=',1)
		->get();


		$param['dtproduct'] = product::where('product.Status','=', '1')
		->join('brand','product.Id_brand','brand.Id_brand')
		->join('type','product.Id_type','type.Id_type')
		->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
		"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
			->get();


		$param['dtvariationname'] = variation::where('Status','=',1)
		->select("Option_name","Id_product")
		->get();

		$param['dtproductimage'] = product_image::all();
	

		return view('Purchase_add',$param);
	}


	public function show_supplier(Request $request){
	
		session()->forget('purchase_product_session');

		$supdetail = supplier::where('Id_supplier','=',$request->idsup)
		->select('Id_supplier','Supplier_name','Supplier_email', 'Supplier_phone1', 'Supplier_phone2','Supplier_address')
		->get();

		echo $supdetail;
	}


	public function showsession(Request $request){
	
		$temp= session()->get('purchase_product_session');

		print_r($temp);
	}

	public function showsessionreceive(Request $request){
		$temp= session()->get('receive_session');

		print_r($temp);
	}


	public function	changecboption(Request $request){ // SAAT ADA PERUBAHAN DALAM CB ATAUPUN TXT BOX
		$id = $request->nomer;
		$total=0;
		$product_session= session()->get('purchase_product_session');

		for ($i=0; $i < count($product_session) ; $i++) { 
			
			if($product_session[$i]['Id'] == $id)
			{
				$hargabeli = $request->hargabeli;
				if(gettype($hargabeli) == 'string'){
					$hargabeli = (int)str_replace(",",'', $hargabeli);
				}
				$product_session[$i]['Id_variation'] = $request->Id_variation;
				$product_session[$i]['Qty_beli'] = $request->qtybeli;
				$product_session[$i]['Purchase_price'] = $hargabeli;
				
				try {
					if($request->bentuk == "txt_qty") //KALAU TXT QTY BERUBAH MAKA ARRAY EXPIRE DI RESTART
					{
						$product_session[$i]['Qty_expire'] = [];
						$product_session[$i]['Date_expire'] =[];
					}
				} catch (\Throwable $th) {
					
				}
			
			}
			$total = $total + ($product_session[$i]['Qty_beli']*$product_session[$i]['Purchase_price']);
		}

		
		session()->forget('purchase_product_session');
		session()->put('purchase_product_session', $product_session);


		//HITUNG GRAND TOTAL
		print_r($total);


		

	}

	public function	delete_product_session(Request $request){

		$id = $request->nomer;

		$product_session= session()->get('purchase_product_session');

		for ($i=0; $i < count($product_session) ; $i++) { 
			if($product_session[$i]['Id'] == $id)
			{
				$product_session[$i]['Id'] = -1; //KASI MINES 1 agar gak di tampilkan
				$product_session[$i]['Id_variation'] = $request->Id_variation;
				$product_session[$i]['Qty_beli'] = $request->qtybeli;
				$product_session[$i]['Purchase_price'] = $request->hargabeli;
			}
		}

		
		session()->forget('purchase_product_session');
		session()->put('purchase_product_session', $product_session);

		$temp = $this->showtable();
		print_r($temp);

	}

	public function	get_data_product_session(Request $request){

		$temp="";
		$id = $request->nomer;
		$idpro= "";
		$idvariasi ="";
		$qtybeli="";
		$purchase_price="";
		$product_session= session()->get('purchase_product_session');

		for ($i=0; $i < count($product_session) ; $i++) { 
			if($product_session[$i]['Id'] == $id)
			{
				$idpro = $product_session[$i]['Id_product'];
				$idvariasi = $product_session[$i]['Id_variation'];
				$purchase_price = $product_session[$i]['Purchase_price'];

				$kurang=0;
				for ($k=0; $k < count($product_session[$i]['Qty_expire']) ; $k++) { 
					$kurang = $kurang + $product_session[$i]['Qty_expire'][$k];

					$temp =$temp. "<tr>";
						$temp =$temp. "<td>";
							$temp =$temp. $product_session[$i]['Qty_expire'][$k];
						$temp =$temp. "</td>";
						$temp =$temp. "<td>";
							$temp =$temp. $product_session[$i]['Date_expire'][$k];
						$temp =$temp. "</td>";
						$temp =$temp. "<td>";
							$temp =$temp. "<button type='button' class='btn btn-danger btn-sm' onclick='deleteqtyexpire(".$id.",".$k.")'> Delete </button>";
						$temp =$temp. "</td>";
					$temp =$temp. "</tr>";
				}

				$qtybeli = $product_session[$i]['Qty_beli']-$kurang;
				



			}
		}


		$namaproduk = product::where('Id_product','=',$idpro)
				->select('Name')
				->get();

		$namavariation = variation::where('Id_variation','=',$idvariasi)
				->select('Option_name')
				->get();

		$gabungan = $namaproduk[0]['Name']."#".$namavariation[0]['Option_name']."#".$qtybeli."#".$id."#".$temp;
		print_r($gabungan);

	}


	public function add_expire_qty_session(Request $request)
	{
		$product_session= session()->get('receive_session');
		$arr=[];
		$no_detail = $request->no_detail;
		$qty = $request->qty;
		$exp = $request->exp;

		for ($i=0; $i < count($product_session) ; $i++) { 
			if($product_session[$i]['No_detail'] == $no_detail)
			{
				array_push($product_session[$i]['Qty_expire'], $qty);
				array_push($product_session[$i]['Date_expire'], $exp);
			}
		}
		session()->forget('receive_session');
		session()->put('receive_session', $product_session);

		$titip = $this->show_table_expire($no_detail);
		print_r($titip);
	}

	public function delete_expire_qty_session(Request $request)
	{
		$no_detail = $request->no_detail;
		$kode_exp = $request->kode_exp;
		$sisa=0;

		$product_session= session()->get('receive_session');
		for ($i=0; $i < count($product_session) ; $i++) { 
			if($product_session[$i]['No_detail'] == $no_detail)
			{
				$arr_qty=[];
				$arr_date=[];
				$kurang=0;
				for ($k=0; $k < count($product_session[$i]['Qty_expire']) ; $k++) { 
					if($kode_exp!=$k)
					{
						array_push($arr_qty, $product_session[$i]['Qty_expire'][$k]);
						array_push($arr_date, $product_session[$i]['Date_expire'][$k]);
						$kurang = $kurang + $product_session[$i]['Qty_expire'][$k];
					}

				}
				$product_session[$i]['Qty_expire'] = $arr_qty;
				$product_session[$i]['Date_expire'] = $arr_date;

				$sisa = $product_session[$i]['Qty_receive']-$kurang;
				

			}

		}


		session()->forget('receive_session');
		session()->put('receive_session', $product_session);

		$titip = $this->show_table_expire($no_detail)."#".$sisa;
		print_r($titip);

	}

	public function show_table_expire($no_detail)
	{
		$no_detail = $no_detail;
		$temp="";
		$product_session= session()->get('receive_session');

		for ($i=0; $i < count($product_session) ; $i++) { 
			if($product_session[$i]['No_detail'] == $no_detail)
			{
				for ($k=0; $k < count($product_session[$i]['Qty_expire']) ; $k++) { 
					$temp =$temp. "<tr>";
						$temp =$temp. "<td>";
							$temp =$temp. $product_session[$i]['Qty_expire'][$k];
						$temp =$temp. "</td>";
						$temp =$temp. "<td>";
							$temp =$temp. $product_session[$i]['Date_expire'][$k];
						$temp =$temp. "</td>";
						$temp =$temp. "<td>";
							$temp =$temp. "<button type='button' class='btn btn-danger btn-sm' onclick='deleteqtyexpire(".$no_detail.",".$k.")'> Delete </button>";
						$temp =$temp. "</td>";
					$temp =$temp. "</tr>";
				}
			}
		}

		return($temp);
	}

	public function add_product_session(Request $request)
	{
		if ($request->idpro > 0) 
		{
			$kodeid=-1;

			try {
				$temp = count(session()->get('purchase_product_session'));
			} catch (\Throwable $th) {
				$kodeid=0;
			}

			if ($kodeid!=0)	
			{
				$kodeid = $temp;
			}

			$variation = variation::where('Id_product','=',$request->idpro)
			->where('Status','=','1')
			->get();


			session()->push("purchase_product_session", [
				"Id" => $kodeid,
				"Id_product" => $request->idpro,
				"Id_variation"=> $variation[0]['Id_variation'],
				"Qty_beli" => 1,
				"Purchase_price" => $variation[0]['Purchase_price'], 
				"Qty_expire" => [],
				"Date_expire" => []
			]);
		}
		$temp = $this->showtable();
		print_r($temp);

	}

	public function	show_table_session(Request $request)
	{
		$temp = $this->showtable();
		print_r($temp);

	}

	public function showtable()
	{
		$cart = session()->get('purchase_product_session');

		$temp="";
		$totalorder=0;

		for ($i=0; $i < count($cart); $i++) { 

			if($cart[$i]['Id']>=0) //JIKA ADA ID dibawah 0 Maka tidak di munculkan alias didelete
			{
				$pro = product::where('Id_product','=',$cart[$i]['Id_product'])
				->get();

				try {
					$img = product_image::where('Id_product','=',$cart[$i]['Id_product'])
				->where('Image_order','=',1)
				->select("Image_name")
				->get();


				$imgname = $img[0]->Image_name;

				} catch (\Throwable $th) {
					$imgname="default.jpg";
				}
				
				if(($imgname=="") || ($imgname==null))
				{
					$imgname="default.jpg";
				}


				$variation = variation::where('Id_product','=',$cart[$i]['Id_product'])
				->where('Status','=','1')
				->get();

				$arr_variation= [];  // array Variation
				$jum =0;
				foreach($variation as $data) 
				{
					$arr_variation[$jum]['Id_variation'] = $data->Id_variation; 
					$arr_variation[$jum]['Option_name'] = $data->Option_name; 
					$arr_variation[$jum]['Purchase_price'] = $data->Purchase_price; 
					$jum++;
				}
				
		

				
		

				$brand = brand::where('Id_brand','=',$pro[0]->Id_brand)
				->get();

				$type = type::where('Id_type','=',$pro[0]->Id_type)
				->get();



				// {{ Form::button('<i class="fa fa-mouse-pointer" aria-hidden="true"></i> Choose',['class'=>'btn btn-warning btn-sm','onClick'=>"choose_supplier('$data->Id_product')"]) }}
				$temp =$temp. "<tr>";
				//PHOTO
				$temp =$temp. "<td> <img src='".url('Uploads/Product/'.$imgname)."' width='150px' height='150px' class='center'>  </td>";
				//NAME
				$temp =$temp. 
					"<td>"
					.$pro[0]->Name."<br>-".
					"<p style='font-size:80%'> Brand : "
					.
					$brand[0]->Brand_name
					.
					"<br> Type : "
					.
					$type[0]->Type_name
					.
					"<br><br><button type='button' class='btn btn-danger btn-sm' onclick='deleteproduct(".$i.")'> Delete </button>"
					.
					"</p>"
					.
					"</td>";

				$jenisvariasi="";
				$temp =$temp."<td width='14%'>";
				
				if($pro[0]->Variation=="NONE")
				{
					$jenisvariasi="NO VARIATION";
					$temp =$temp."<br>".$jenisvariasi;
					
				}
				else
				{
					$jenisvariasi=$pro[0]->Variation;
					$temp =$temp.$jenisvariasi;
				}
				

				if($pro[0]->Variation!="NONE")
				{
					$temp =$temp."<br> <select id='cboption".$i."' onclick='changecboption($i)' class='form-control'>";
				
					// $temp = $temp . "<option value='"." "."#"."0"."#"."0"."'>". "". "</option>";
					
					foreach ($arr_variation as $data) {
					$select = "";
					if(($data['Id_variation'] == $cart[$i]['Id_variation']) && ($i == $cart[$i]['Id']))
					{
						$select="selected";
					}
					$temp = $temp . "<option value='".$data['Option_name']."#".$data['Purchase_price']."#".$data['Id_variation']."' ".$select.">". $data['Option_name']. "</option>";
					}

					$temp =$temp."</select>"
					.
					"</td>";
				}
				else
				{
					$temp =$temp."<br> <select id='cboption".$i."' hidden onclick='changecboption($i)' class='form-control'>";
				
					// $temp = $temp . "<option value='"." "."#"."0"."#"."0"."'>". "". "</option>";
					
					foreach ($arr_variation as $data) {
					$select = "";
					if(($data['Id_variation'] == $cart[$i]['Id_variation']) && ($i == $cart[$i]['Id']))
					{
						$select="selected";
					}
					$temp = $temp . "<option value='".$data['Option_name']."#".$data['Purchase_price']."#".$data['Id_variation']."' ".$select.">". $data['Option_name']. "</option>";
					}

					$temp =$temp."</select>"
					.
					"</td>";
					
				}
					

				
				//PURCHASE PRICE
				$temp =$temp ."<td width='17%'><br>
				<input type='text' min='0' id='txt_purchase_price".$i."' class='form-control' onkeyup='changetxtpurchase($i)' onfocusin='format($i,`in`)' onfocusout='format($i,`out`)' value='".number_format($cart[$i]['Purchase_price'])."'>
				</td>";
				//				<input type='text' id='txt_purchase_price".$i."' data-a-sign='' data-a-dec=',' data-a-sep='.' class='form-control purchase_price' onkeyup='changetxtpurchase($i)' onchange='changetxtpurchase($i)' value='".$cart[$i]['Purchase_price']."'>
//

				// $pat = '';

				// $temp =$temp .'<td><input type="text" name="currency-field" id="currency-field" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" value="" data-type="currency" placeholder="$1,000,000.00">
				// </td>';
				



				//QTY
				$temp =$temp. "<td width='18%'><br>
				<input type='number' min='1' id='txt_qty".$i."' onkeyup='changetxtqty($i)' onchange='changetxtqty($i)' class='form-control' value='".$cart[$i]['Qty_beli']."'>
				<br>
				<div class='row'>
					<div class='col-md-9'>
						
					</div>

					<div class='col-md-3'>";
			// <button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-urutan='".$i."' data-target='#modal-expired'> Expired Date </button>
				$c=0;
				
				for ($k=0; $k < count($cart[$i]['Qty_expire']) ; $k++)
				{
					$c = $c + $cart[$i]['Qty_expire'][$k];
				}

				if($c==$cart[$i]['Qty_beli'])
				{
					$temp=$temp."<p id='checkexpire".$i."'> <i class='fas fa-check-circle'></i> </p>";
				}
				else
				{
					$temp=$temp."<p id='checkexpire".$i."'>  </p>";
				}

				$temp=$temp."</div> </div></td>";
			



				//SUBTOTAL
				$tot= $cart[$i]['Purchase_price'] * $cart[$i]['Qty_beli'];
				$totalorder = $totalorder + $tot;
				$temp =$temp. "<td width='17%'>";
				$temp =$temp. "<br><label id='txt_subtotal".$i."'> Rp. ".number_format($cart[$i]['Purchase_price'] * $cart[$i]['Qty_beli'])." </label>";
				
				$temp =$temp. "</td>";
				
					
					
				
				$temp =$temp. "</tr>";
			}
			

		}


		$temp =$temp. "<tr>";
			$temp =$temp. "<td>";
			$temp =$temp. "</td>";
			$temp =$temp. "<td>";
			$temp =$temp. "</td>";
			$temp =$temp. "<td>";
			$temp =$temp. "</td>";
			$temp =$temp. "<td>";
			$temp =$temp. "</td>";
			$temp =$temp. "<td>";
				$temp =$temp. "<p style='float:right'><b>TOTAL </b></p>";
			$temp =$temp. "</td>";
			$temp =$temp. "<td>";
				$temp =$temp. "<p style=''' id='txt_total'><b> Rp. " .number_format($totalorder) ."</b></p>" ;
				$temp =$temp. "<input type='text' name='txt_grandtotal' id='txt_grandtotal' value='".$totalorder."' hidden>";
			$temp =$temp. "</td>";


		$temp =$temp. "</tr>";
		return($temp);
	}

//adriel
	public function Insert_purchase(Request $request)
	{
		if($request->insert_purchase){


			if($request->validate(
				[
					'supplier_name' => ['required', new ValidasiProductExist()],
					'txt_invoice_date' => ['required', new ValidasiPurchaseInvoiceDate()],
				
				],
				[
					'supplier_name.required' => 'Please select supplier',
					'txt_invoice_date.required' => 'Invoice date cannot be empty'
					

				]))
				{
					$invdate= $request->txt_invoice_date;
					//INV-P-260121-0001
					$invdatemodif = $invdate[0].$invdate[1].$invdate[3].$invdate[4].$invdate[8].$invdate[9];

					$tglfix = $invdate[6].$invdate[7].$invdate[8].$invdate[9]."/".$invdate[3].$invdate[4]."/".$invdate[0].$invdate[1];
					$nourut="";

					$pur = purchase_header::where('Purchase_date','=',$tglfix)
							->get();

						
					if(count($pur)<10)
					{
						$nourut = "000".(count($pur)+1);
					}
					else if(count($pur)<100)
					{
						$nourut = "00".(count($pur)+1);
					}
					else if(count($pur)<1000)
					{
						$nourut ="0".(count($pur)+1);
					}
					else
					{
						$nourut = count($pur)+1;
					}

					$noinv = "INV-P-".$invdatemodif."-".$nourut;

					// txt_grandtotal

					//echo "<script language='javascript'> alert('".($request->txt_grandtotal)."') </script>";

					//Insert Header
					$head = new purchase_header();
					$hasil = $head->insertdata($noinv,$tglfix, $request->id_supplier, $request->txt_grandtotal);


					//Insert Detail
					$cart =  session()->get('purchase_product_session');
			
					for ($i=0; $i < count($cart); $i++) { 
						
						if($cart[$i]['Id']>=0) //JIKA ADA ID dibawah 0 Maka tidak di munculkan alias didelete
						{
							$detail = new purchase_detail();
							$hasil = $detail->insertdata($noinv,$cart[$i]['Id_product'],$cart[$i]['Id_variation'], $cart[$i]['Qty_beli'], $cart[$i]['Purchase_price']);
							// $lastnodetail = $detail->lastnodetail();
							
							// //Insert Expaire
							// for ($k=0; $k < count($cart[$i]['Qty_expire']) ; $k++) { 
							// 	$exp = new purchase_expire();
							// 	$hasil = $exp->insertdata($lastnodetail,$noinv,$cart[$i]['Id_product'] ,$cart[$i]['Id_variation'], $cart[$i]['Qty_expire'][$k], $cart[$i]['Date_expire'][$k]);

							// }
						}
				
					}
				
					$param['purchase_header'] = purchase_header::where('purchase_header.Id_supplier','>',0)
					->join('supplier','purchase_header.Id_supplier','supplier.Id_supplier')
					->select('purchase_header.No_invoice','purchase_header.Purchase_date','supplier.Supplier_name','purchase_header.Grand_total',\DB::raw('(CASE WHEN purchase_header.Status = 1 THEN "OPEN" WHEN purchase_header.Status = 2 THEN "Partially Processed" WHEN purchase_header.Status = 3 THEN "Partially Processed (Close)" WHEN purchase_header.Status = 4 THEN "Completed (Close)" WHEN purchase_header.Status = 0 THEN "Void" END) AS STATUS_ORDER'))
					// ->select('purchase_header.No_invoice',\DB::raw('DATE_FORMAT(purchase_header.Purchase_date,"%d/%m/%Y") as Purchase_date'),'supplier.Supplier_name','purchase_header.Grand_total',\DB::raw('(CASE WHEN purchase_header.Status = 1 THEN "OPEN" WHEN purchase_header.Status = 2 THEN "Partially Processed" WHEN purchase_header.Status = 3 THEN "Partially Processed (Close)" WHEN purchase_header.Status = 4 THEN "Completed (Close)" WHEN purchase_header.Status = 0 THEN "Void" END) AS STATUS_ORDER'))
					->orderby('purchase_header.Purchase_date','Desc')
					->get();
			
			
					$param['purchase_detail'] = purchase_detail::all();
			
					return view('Purchase',$param);
				}
		}

	}

	function void_purchase(Request $request)
	{
		$noinv = $request->noinv;

		$purchase_header = purchase_header::where('No_invoice','=',$noinv)
		->select('Status')
		->get();

		if($purchase_header[0]['Status'] != 1)
		{
			echo "no";
		}
		else
		{
			$edit = new purchase_header();
			$hasil = $edit->editstatus($noinv,0);
			echo $hasil;
		}
	}

	function force_close_purchase(Request $request)
	{
		$noinv = $request->noinv;

		$purchase_header = purchase_header::where('No_invoice','=',$noinv)
		->select('Status')
		->get();

		if($purchase_header[0]['Status'] != 2)
		{
			echo "no";
		}
		else
		{
			$edit = new purchase_header();
			$hasil = $edit->editstatus($noinv,3);
			echo $hasil;
		}
	}


	function get_purchase_detail(Request $request)
	{
		$noinv = $request->noinv;

		$purchase_header = purchase_header::where('purchase_header.No_invoice','=',$noinv)
		->join('supplier','purchase_header.Id_supplier','supplier.Id_supplier')
		->select('purchase_header.No_invoice','purchase_header.Purchase_date','purchase_header.Grand_total','supplier.Supplier_name')
		->get();

		$tgl = date("d-m-Y", strtotime($purchase_header[0]['Purchase_date']));
		$supp = $purchase_header[0]['Supplier_name'];

		$purchase_detail = purchase_detail::where('purchase_detail.No_invoice','=',$noinv)
		->join('product','purchase_detail.Id_product','product.Id_product')
		->join('variation_product','purchase_detail.Id_variation','variation_product.Id_variation')
		->select('purchase_detail.No_detail','purchase_detail.No_invoice','product.Name','variation_product.Option_name','purchase_detail.Qty','purchase_detail.Purchase_price')
		->get();



		$temp="";
		$total=0;
		for ($i=0; $i < count($purchase_detail); $i++) 
		{ 

			$no_detail = $purchase_detail[$i]['No_detail'];

			$receive_detail = receive_detail::where('No_purchase_detail','=',$no_detail)
			->get();

			$qtyreceive=0;
			
			for ($k=0; $k < count($receive_detail); $k++) 
			{ 

				$norec = $receive_detail[$k]['No_receive'];
				$receive_header = receive_header::where('No_receive','=',$norec)
				->where('Status','=',2)
				->get();

				if(count($receive_header) == 0)
				{

				}
				else
				{
					$qtyreceive=$qtyreceive + $receive_detail[$k]['Qty'];
				}

				
			}

			$temp=$temp."<tr>";
				
				$temp=$temp."<td>";
					$temp=$temp.$purchase_detail[$i]['Name'];
				$temp=$temp."</td>";
				$temp=$temp."<td>";
					$temp=$temp.$purchase_detail[$i]['Option_name'];
				$temp=$temp."</td>";
				$temp=$temp."<td>";
					$temp=$temp.number_format($purchase_detail[$i]['Qty']);
				$temp=$temp."</td>";
				$temp=$temp."<td>";
					$temp=$temp."Rp. ".number_format($purchase_detail[$i]['Purchase_price']);
				$temp=$temp."</td>";
				$temp=$temp."<td>";
					$total=$total+ ($purchase_detail[$i]['Qty']*$purchase_detail[$i]['Purchase_price']);
					$temp=$temp."Rp. ".number_format($purchase_detail[$i]['Qty']*$purchase_detail[$i]['Purchase_price']);
				$temp=$temp."</td>";
				$temp=$temp."<td>";
					$temp=$temp.number_format($qtyreceive);
					if($qtyreceive==$purchase_detail[$i]['Qty'])
					{
						$temp=$temp." <i class='fas fa-check-circle'></i>";
					}
				$temp=$temp."</td>";
				
			$temp=$temp."</tr>";
		}

		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td> TOTAL :</td>";
		$temp=$temp."<td>"."Rp. ".number_format($total)."</td>";
		$temp=$temp."<td></td>";

		$gabungan = $temp."#".$noinv."#".$tgl."#".$supp;
		print_r($gabungan);
	}


	public function Add_product_modal(Request $request)
	{
		 $Id_supplier = $request->idsup;


		$prosupp = supplier_product::where('Id_supplier','=',$Id_supplier)
		 ->where('Status','=',1)
		->get();


		$temp="";
		for ($i=0; $i < count($prosupp); $i++) 
		{ 
			
			$Id_product = $prosupp[$i]['Id_product'];

			$product = product::where('product.Status','=', '1')
			->join('brand','product.Id_brand','brand.Id_brand')
			->join('type','product.Id_type','type.Id_type')
			->where('Id_product','=',$Id_product)
			->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
			"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
				->get();


			$variation= variation::where('Status','=',1)
			->where('Id_product','=',$Id_product)
			->select("Option_name","Id_product")
			->get();

			$imgname = "default.jpg";

			$dtproductimage = product_image::all();

			foreach ($dtproductimage as $img) {
				
				// $idp = $data->Id_product;
				$idi = $img->Id_product;
				$urutan = $img->Image_order;
				
				if (($Id_product == $idi) && ($urutan==1))
				{
					$imgname = $img->Image_name;
				}
			}

			$temp=$temp."<tr>";
			$temp=$temp."<td width='150px'>";
				$temp=$temp."<img src='".url('Uploads/Product/'.$imgname)."' width='150px' height='150px' class='center'>";
			$temp=$temp."</td>";

			$temp=$temp."<td>";
				$temp=$temp.$product[0]->Name;
			$temp=$temp."</td>";

			$temp=$temp."<td>";
				$temp=$temp.$product[0]->Brand_name;
			$temp=$temp."</td>";

			$temp=$temp."<td>";
				$temp=$temp.$product[0]->Type_name;
			$temp=$temp."</td>";

			$temp=$temp."<td>";
				$vari="";
				$vari2="";
				if($product[0]->Variation == "NONE")
				{
					$vari2="NONE";
				}
				else
				{
				foreach ($variation as $datavar) {
					if($datavar->Id_product == $product[0]->Id_product)
					{
						$vari.=$datavar->Option_name." , ";
					}
				}
				$vari2=substr($vari,0,-2);
				}


				$temp=$temp."(".$vari2.")";

			$temp=$temp."</td>";
			// {{invtosession('".$invno."')}}
			$temp=$temp."<td>";
				$temp=$temp."<button class='btn btn-warning btn-sm' onclick={{select_product('".$product[0]->Id_product."')}}> <i class='fa fa-mouse-pointer' aria-hidden='true'></i> Select </button>";
			$temp=$temp."</td>";
			$temp=$temp."</tr>";
		}

		if($temp=="")
		{
			$product = product::where('product.Status','=', '1')
			->join('brand','product.Id_brand','brand.Id_brand')
			->join('type','product.Id_type','type.Id_type')
			->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
			"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
				->get();


			$variation= variation::where('Status','=',1)
			->select("Option_name","Id_product")
			->get();

			for ($i=0; $i < count($product); $i++) { 
			
				$Id_product = $product[$i]['Id_product'];
	
			
				$imgname = "default.jpg";
	
				$dtproductimage = product_image::all();
	
				foreach ($dtproductimage as $img) {
					
					// $idp = $data->Id_product;
					$idi = $img->Id_product;
					$urutan = $img->Image_order;
					
					if (($Id_product == $idi) && ($urutan==1))
					{
						$imgname = $img->Image_name;
					}
				}
	
				$temp=$temp."<tr>";
				$temp=$temp."<td width='150px'>";
					$temp=$temp."<img src='".url('Uploads/Product/'.$imgname)."' width='150px' height='150px' class='center'>";
				$temp=$temp."</td>";
	
				$temp=$temp."<td>";
					$temp=$temp.$product[$i]->Name;
				$temp=$temp."</td>";
	
				$temp=$temp."<td>";
					$temp=$temp.$product[$i]->Brand_name;
				$temp=$temp."</td>";
	
				$temp=$temp."<td>";
					$temp=$temp.$product[$i]->Type_name;
				$temp=$temp."</td>";
	
				$temp=$temp."<td>";
					$vari="";
					$vari2="";
					if($product[$i]->Variation == "NONE")
					{
						$vari2="NONE";
					}
					else
					{
					foreach ($variation as $datavar) {
						if($datavar->Id_product == $product[$i]->Id_product)
						{
							$vari.=$datavar->Option_name." , ";
						}
					}
					$vari2=substr($vari,0,-2);
					}
	
	
					$temp=$temp."(".$vari2.")";
	
				$temp=$temp."</td>";
				// {{invtosession('".$invno."')}}
				$temp=$temp."<td>";
					$temp=$temp."<button class='btn btn-warning btn-sm' onclick={{select_product('".$product[$i]->Id_product."')}}> <i class='fa fa-mouse-pointer' aria-hidden='true'></i> Select </button>";
				$temp=$temp."</td>";
				$temp=$temp."</tr>";
			}
		}

		print_r($temp);
	}

	

	




























	public function Receive_order(){

		if(session()->get('userlogin')->Role=="ADMIN")
		{
			$param['receive_header'] = receive_header::where('receive_header.Id_member','>',0)
			->join('member','receive_header.Id_member','member.Id_member')
			// ->select('receive_header.No_receive','receive_header.No_invoice',\DB::raw('DATE_FORMAT(receive_header.Receive_date,"%d/%m/%Y") as Receive_date'),'member.Username',\DB::raw('(CASE WHEN receive_header.Status = 1 THEN "Success" ELSE "Void" END) AS STATUS_ORDER'))
			->select('receive_header.No_receive','receive_header.No_invoice','receive_header.Receive_date','member.Username',\DB::raw('(CASE WHEN receive_header.Status = 1 THEN "Pending" when receive_header.Status = 2 THEN "Success" WHEN receive_header.Status = 3 THEN "Rejected" ELSE "Void" END) AS STATUS_ORDER'))
			->where('receive_header.Status','<>',1)
			->orderby('receive_header.Receive_date','desc')
			->get();
		}
		else if(session()->get('userlogin')->Role=="SHIPPER")
		{
			$param['receive_header'] = receive_header::where('receive_header.Id_member','>',0)
			->join('member','receive_header.Id_member','member.Id_member')
			// ->select('receive_header.No_receive','receive_header.No_invoice',\DB::raw('DATE_FORMAT(receive_header.Receive_date,"%d/%m/%Y") as Receive_date'),'member.Username',\DB::raw('(CASE WHEN receive_header.Status = 1 THEN "Success" ELSE "Void" END) AS STATUS_ORDER'))
			->select('receive_header.No_receive','receive_header.No_invoice','receive_header.Receive_date','member.Username',\DB::raw('(CASE WHEN receive_header.Status = 1 THEN "Pending" when receive_header.Status = 2 THEN "Success" WHEN receive_header.Status = 3 THEN "Rejected" ELSE "Void" END) AS STATUS_ORDER'))
			->where('receive_header.Id_member','=',session()->get('userlogin')->Id_member)
			->orderby('receive_header.Receive_date','desc')
			->get();
		}

		


		$param['receive_detail'] = receive_detail::all();

		return view('Receive_order',$param);
	}



	public function Receive_request(){

		$param['receive_header'] = receive_header::where('receive_header.Id_member','>',0)
		->join('member','receive_header.Id_member','member.Id_member')
		// ->select('receive_header.No_receive','receive_header.No_invoice',\DB::raw('DATE_FORMAT(receive_header.Receive_date,"%d/%m/%Y") as Receive_date'),'member.Username',\DB::raw('(CASE WHEN receive_header.Status = 1 THEN "Success" ELSE "Void" END) AS STATUS_ORDER'))
		->select('receive_header.No_receive','receive_header.No_invoice','receive_header.Receive_date','member.Username',\DB::raw('(CASE WHEN receive_header.Status = 1 THEN "Pending" when receive_header.Status = 2 THEN "Success" WHEN receive_header.Status = 3 THEN "Rejected" ELSE "Void" END) AS STATUS_ORDER'))
		->where('receive_header.Status','=',1)
		->orderby('receive_header.Receive_date','desc')
		->get();

		$param['receive_detail'] = receive_detail::all();

		return view('Receive_request',$param);
	}

	public function Receive_order_pre()
	{
		session()->forget('receive_session');
		return redirect('Receive_order_add');
	}

	public function Receive_order_add()
	{

		$param['dtsupplier'] = supplier::where('status','=',1)
		->get();


		$param['dtproduct'] = product::where('product.Status','=', '1')
		->join('brand','product.Id_brand','brand.Id_brand')
		->join('type','product.Id_type','type.Id_type')
		->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
		"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
			->get();


		$param['dtvariationname'] = variation::where('Status','=',1)
		->select("Option_name","Id_product")
		->get();

		$param['dtproductimage'] = product_image::all();
	
	
		return view('Receive_order_add',$param);

	}
	public function get_session_receive(Request $request)
	{
		$no_detail=$request->no_detail;

		$receive_session = session()->get('receive_session');

		$remainingqty=0;
	
		for ($i=0; $i < count($receive_session) ; $i++) { 
			if($receive_session[$i]['No_detail'] == $no_detail)
			{
				$temp="";
				$ctr=0;
				for ($k=0; $k < count($receive_session[$i]['Qty_expire'])  ; $k++) { 
					$ctr= $ctr + $receive_session[$i]['Qty_expire'][$k];

					$temp =$temp. "<tr>";
						$temp =$temp. "<td>";
							$temp =$temp. $receive_session[$i]['Qty_expire'][$k];
						$temp =$temp. "</td>";
						$temp =$temp. "<td>";
							$temp =$temp. $receive_session[$i]['Date_expire'][$k];
						$temp =$temp. "</td>";
						$temp =$temp. "<td>";
							$temp =$temp. "<button type='button' class='btn btn-danger btn-sm' onclick='deleteqtyexpire(".$no_detail.",".$k.")'> Delete </button>";
						$temp =$temp. "</td>";
					$temp =$temp. "</tr>";
				}
				$remainingqty = $receive_session[$i]['Qty_receive'] - $ctr;
			}
		}

		echo $remainingqty."#".$temp;


	}


	public function show_supplier_receive_order(Request $request)
	{
		$supdetail = supplier::where('Id_supplier','=',$request->idsup)
		->select('Id_supplier','Supplier_name','Supplier_email', 'Supplier_phone1', 'Supplier_phone2','Supplier_address')
		->get();



		// $du = member::where(function($query) use($username_email)
        // {
        //     $query->where('username','=', $username_email);
        //     $query->orwhere('email','=', $username_email);
        // })
        // ->where('password', '=', $password)
        // ->where('status','=',1)
        // ->get();






		$purheader = purchase_header::where(function($query){
			$query->where('Status','=',1);
            $query->orwhere('Status','=', 2);
		})
		->where('Id_supplier','=',$request->idsup)
		->select('No_invoice','Purchase_date','Grand_total',\DB::raw('(CASE WHEN Status = 1 THEN "OPEN" WHEN Status = 2 THEN "Partially Processed" WHEN Status = 3 THEN "Partially Processed (Close)" WHEN Status = 4 THEN "Completed (Close)" WHEN Status = 0 THEN "Void" END) AS Status'))
		->get();

		$temp="";
		//$tes="";

		for ($i=0; $i <count($purheader); $i++) { 
			$stat="";
			$temp=$temp."<tr>";


			if($purheader[$i]['Status'] =="OPEN")
			{
			    $stat= "<td><button type='button' class='btn btn-info btn-sm' disabled>".$purheader[$i]['Status']."</button></td>";
			}
			else if($purheader[$i]['Status'] =="Partially Processed")
			{
				$stat= "<td><button type='button' class='btn btn-warning btn-sm' disabled>".$purheader[$i]['Status']."</button></td>";
			}
			else if($purheader[$i]['Status'] =="Partially Processed (Close)")
			{
				$stat= "<td><button type='button' class='btn btn-success btn-sm' disabled>".$purheader[$i]['Status']."</button></td>";
			}
			else if($purheader[$i]['Status'] =="Completed (Close)")
			{
				$stat= "<td><button type='button' class='btn btn-success btn-sm' disabled>".$purheader[$i]['Status']."</button></td>";
			}
			else {
			  
				$stat= "<td><button type='button' class='btn btn-danger btn-sm' disabled>".$purheader[$i]['Status']."</button></td>";
			}


			$temp=$temp.$stat;

			$temp=$temp."<td>";
				$temp=$temp.$purheader[$i]['No_invoice'];

			$temp=$temp."</td>";

			$temp=$temp."<td>";
				$temp=$temp.$purheader[$i]['Purchase_date'];

			$temp=$temp."</td>";

			// $temp=$temp."<td>";
			// 	$temp=$temp."Rp. ".number_format($purheader[$i]['Grand_total']);

			// $temp=$temp."</td>";

			$temp=$temp."</td>";

			$invno =$purheader[$i]['No_invoice'];
			// $invno =8;
			$temp=$temp."<td>";
				$temp=$temp.
				"<button type='button' onclick={{invtosession('".$invno."')}} class='btn btn-warning btn-sm'> Select </button>";

			$temp=$temp."</td>";



			$temp=$temp."</tr>";

			//$tes= $purheader[$i]['No_invoice'];
		}

		

		$gabungan = $supdetail."#".$temp;
		echo $gabungan;
	}

	public function session_receive_select(Request $request)
	{
		session()->forget('noinvselect');
		$noinv = $request->noinv;
		session()->put('noinvselect', $noinv);
		

	}
	public function Receive_order_add_select()
	{
		$param['noinv'] = session()->get('noinvselect');

		// $purheader = purchase_header::where(function($query){
		// 	$query->where('Status','=',1);
        //     $query->orwhere('Status','=', 2);
		// })



		$param['purchase_header'] = purchase_header::where(function($query){
			$query->where('purchase_header.Status','=',1);
			$query->orwhere('purchase_header.Status','=',2);
		})
		->where('purchase_header.No_invoice','=',$param['noinv'])
		->join('supplier','purchase_header.Id_supplier','supplier.Id_supplier')
		->select('purchase_header.No_invoice','purchase_header.Purchase_date','purchase_header.Grand_total','supplier.Supplier_name')
		->get();

		$param['purchase_detail'] = purchase_detail::where('purchase_detail.No_invoice','=',$param['noinv'])
		->get();

		// $param['receive_select'] = purchase_receive::where('No_invoice','=',$param['noinv'])
		// ->orderBy('Remaining_qty', 'DESC') //desc dari besar ke kecil
		// ->get();

		$param['receive_header'] = receive_header::where(function($query){
			$query->where('Status','=',1);
			$query->orwhere('Status','=',2);
		})
		->where('No_invoice','=',$param['noinv'])
		->get();

		$param['receive_detail'] = receive_detail::all();

		$param['dtproduct'] = product::where('product.Status','=', 1)
		->join('brand','product.Id_brand','brand.Id_brand')
		->join('type','product.Id_type','type.Id_type')
		->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
		"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
			->get();


		$param['dtvariation'] = variation::where('Status','=',1)
		->select("Option_name","Id_product","Id_variation")
		->get();

		$param['product_image'] = product_image::all();


		// $param['shipper'] = member::where('')

		$pur = $param['purchase_detail'];

		// for ($i=0; $i < count($pur); $i++) { 
		// 	session()->push("receive_session", [
		// 		"Id" => 0,
		// 		"No_detail" => $pur[$i]['No_detail'],
		// 		// "Id_product"=> $data->Id_product,
		// 		// "Id_variation"=> $data->Id_variation,
		// 		// "Qty" => $data->Qty,
		// 		// "Qty_expire" => [],
		// 		// "Date_expire" => []
		// 	]);
		// }
		session()->forget("receive_session");
		foreach ($param['purchase_detail'] as $data) {
			session()->push("receive_session", [
				"Id" => 0,
				"No_detail" => $data->No_detail,
				"Id_product"=> $data->Id_product,
				"Id_variation"=> $data->Id_variation,
				"Purchase_price" => $data->Purchase_price,
				"Qty_receive" => 0,
				"Qty_expire" => [],
				"Date_expire" => []
			]);
		}


// 		$subcat = product_sub_category::where('product_sub_category.Id_product','=', $id)
// 		->join('sub_category','product_sub_category.Id_sub_category','sub_category.Id_sub_category')
// 		->join('category','sub_category.Id_category','category.Id_category')
// 		->select("category.Category_name","sub_category.Sub_category_name","product_sub_category.Id_sub_category")
// ->get();

		return view('Receive_order_add_select',$param);
	}


	public function	change_receive_qty(Request $request){ // SAAT ADA PERUBAHAN DALAM  TXT BOX
		$no_detail = $request->no_detail;
		$total=0;
		$product_session= session()->get('receive_session');

		for ($i=0; $i < count($product_session) ; $i++) { 
			
			if($product_session[$i]['No_detail'] == $no_detail)
			{
				$product_session[$i]['Qty_receive'] = $request->qty_receive;
				$product_session[$i]['Qty_expire'] = [];
				$product_session[$i]['Date_expire'] =[];
				$product_session[$i]['Id'] =0;
			
			}
			
		}
		session()->forget('receive_session');
		session()->put('receive_session', $product_session);


	}

	public function get_receive_detail(Request $request)
	{
		$norcv = $request->norcv;


		$receive_detail = receive_detail::where('receive_detail.No_receive','=',$norcv)
		->join('product','receive_detail.Id_product','product.Id_product')
		->join('variation_product','receive_detail.Id_variation','variation_product.Id_variation')
		->select('receive_detail.No_receive_detail','receive_detail.No_receive','product.Name','variation_product.Option_name','receive_detail.Qty')
		->get();

		$receive_header = receive_header::where('No_receive','=',$norcv)
		->join('member','receive_header.Id_member','member.Id_member')
		->select('receive_header.No_receive','receive_header.No_invoice','receive_header.Receive_date','member.Username','member.Role','receive_header.No_reff_supplier','receive_header.Payment')
		->get();

		$operator = $receive_header[0]['Username'];
		$nopo = $receive_header[0]['No_invoice'];
		$tgl = date("d-m-Y", strtotime($receive_header[0]['Receive_date']));
		$noreffsupp = $receive_header[0]['No_reff_supplier'];

		$Status_payment="";
		if($receive_header[0]['Payment']==1)
		{
			$Status_payment="<button type='button' class='btn btn-success btn-sm' disabled>PAID</button>";
		}
		else
		{
			$Status_payment="<button type='button' class='btn btn-danger btn-sm' disabled>UNPAID</button>";
		}

		$purchase_header = purchase_header::where('purchase_header.No_invoice','=',$nopo)
		->join('supplier','purchase_header.Id_supplier','supplier.Id_supplier')
		->select('purchase_header.No_invoice','purchase_header.Purchase_date','supplier.Supplier_name','supplier.Credit_due_date','purchase_header.Grand_total',\DB::raw('(CASE WHEN purchase_header.Status = 1 THEN "OPEN" WHEN purchase_header.Status = 2 THEN "Partially Processed" WHEN purchase_header.Status = 3 THEN "Partially Processed (Close)" WHEN purchase_header.Status = 4 THEN "Completed (Close)" WHEN purchase_header.Status = 0 THEN "Void" END) AS STATUS_ORDER'))
		// ->select('purchase_header.No_invoice',\DB::raw('DATE_FORMAT(purchase_header.Purchase_date,"%d/%m/%Y") as Purchase_date'),'supplier.Supplier_name','purchase_header.Grand_total',\DB::raw('(CASE WHEN purchase_header.Status = 1 THEN "OPEN" WHEN purchase_header.Status = 2 THEN "Partially Processed" WHEN purchase_header.Status = 3 THEN "Partially Processed (Close)" WHEN purchase_header.Status = 4 THEN "Completed (Close)" WHEN purchase_header.Status = 0 THEN "Void" END) AS STATUS_ORDER'))
		->orderby('purchase_header.Purchase_date','Desc')
		->get();

		$supp = $purchase_header[0]['Supplier_name'];
		$plushari =  $purchase_header[0]['Credit_due_date'];
		
		$duedate = date('Y-m-d', strtotime('+'.$plushari.' days', strtotime($tgl))); 
		





		$temp="";
		$total=0;
		for ($i=0; $i < count($receive_detail); $i++) { 

			$temp=$temp."<tr>";
				
				$temp=$temp."<td>";
					$temp=$temp.$receive_detail[$i]['Name'];
				$temp=$temp."</td>";
				$temp=$temp."<td>";
					$temp=$temp.$receive_detail[$i]['Option_name'];
				$temp=$temp."</td>";
				$temp=$temp."<td>";
					$temp=$temp.number_format($receive_detail[$i]['Qty']);
				$temp=$temp."</td>";
			$temp=$temp."</tr>";
		}


		$gabungan = $temp."#".$norcv."#".$nopo."#".$supp."#".$operator."#".$tgl."#".$noreffsupp."#".$Status_payment."#".$duedate;
		print_r($gabungan);
	}





	public function get_receive_detail_payment(Request $request)
	{

		//adriel3
		$norcv = $request->norcv;


		$receive_detail = receive_detail::where('receive_detail.No_receive','=',$norcv)
		->join('product','receive_detail.Id_product','product.Id_product')
		->join('variation_product','receive_detail.Id_variation','variation_product.Id_variation')
		->select('receive_detail.No_receive_detail','receive_detail.No_receive','product.Name','variation_product.Option_name','receive_detail.Qty','receive_detail.Purchase_price')
		->get();

		$receive_header = receive_header::where('No_receive','=',$norcv)
		->join('member','receive_header.Id_member','member.Id_member')
		->select('receive_header.No_receive','receive_header.No_invoice','receive_header.Receive_date','member.Username','member.Role','receive_header.No_reff_supplier','receive_header.Payment')
		->get();

		$operator = $receive_header[0]['Username'];
		$nopo = $receive_header[0]['No_invoice'];
		$tgl =  date("d-m-Y", strtotime($receive_header[0]['Receive_date']));
		$noreffsupp = $receive_header[0]['No_reff_supplier'];
		$no_payment="";
		$receipt_image="";
		$payment_by="";
		$payment_method="";
		$namabank="";
		$norekening="";
		$namapemilikrekening="";


		$Status_payment="";
		if($receive_header[0]['Payment']==1)
		{
			$Status_payment="<button type='button' class='btn btn-success btn-sm' disabled>PAID</button>";

			$purchase_payment = purchase_payment::where('purchase_payment.No_receive','=',$norcv)
			 ->join('member','purchase_payment.Id_member','member.Id_member')
			//  ->join('bank','purchase_payment.Id_bank','bank.Id_bank')
			 ->select('purchase_payment.Id_purchase_payment','purchase_payment.Payment_method','purchase_payment.Id_bank','purchase_payment.Payment_image','member.Username')
			->get();

			 $no_payment = $purchase_payment[0]['Id_purchase_payment'];
			 $receipt_image=$purchase_payment[0]['Payment_image'];
			 $payment_by = $purchase_payment[0]['Username'];
			 $payment_method = $purchase_payment[0]['Payment_method'];

			if($payment_method=="BANK_TRANSFER")
			{
				$purchase_payment = purchase_payment::where('purchase_payment.No_receive','=',$norcv)
			     ->join('bank','purchase_payment.Id_bank','bank.Id_bank')
				->select('bank.Bank_name','bank.Account_number','bank.Account_name')
			   ->get();

				$namabank=$purchase_payment[0]['Bank_name'];
				$norekening=$purchase_payment[0]['Account_number'];
				$namapemilikrekening=$purchase_payment[0]['Account_name'];
				
			}
			else
			{

			}


		}
		else
		{
			$Status_payment="<button type='button' class='btn btn-danger btn-sm' disabled>UNPAID</button>";
		}

		$purchase_header = purchase_header::where('purchase_header.No_invoice','=',$nopo)
		->join('supplier','purchase_header.Id_supplier','supplier.Id_supplier')
		->select('purchase_header.No_invoice','purchase_header.Purchase_date','supplier.Supplier_name','supplier.Credit_due_date','purchase_header.Grand_total',\DB::raw('(CASE WHEN purchase_header.Status = 1 THEN "OPEN" WHEN purchase_header.Status = 2 THEN "Partially Processed" WHEN purchase_header.Status = 3 THEN "Partially Processed (Close)" WHEN purchase_header.Status = 4 THEN "Completed (Close)" WHEN purchase_header.Status = 0 THEN "Void" END) AS STATUS_ORDER'))
		// ->select('purchase_header.No_invoice',\DB::raw('DATE_FORMAT(purchase_header.Purchase_date,"%d/%m/%Y") as Purchase_date'),'supplier.Supplier_name','purchase_header.Grand_total',\DB::raw('(CASE WHEN purchase_header.Status = 1 THEN "OPEN" WHEN purchase_header.Status = 2 THEN "Partially Processed" WHEN purchase_header.Status = 3 THEN "Partially Processed (Close)" WHEN purchase_header.Status = 4 THEN "Completed (Close)" WHEN purchase_header.Status = 0 THEN "Void" END) AS STATUS_ORDER'))
		->orderby('purchase_header.Purchase_date','Desc')
		->get();

		$supp = $purchase_header[0]['Supplier_name'];
		$plushari =  $purchase_header[0]['Credit_due_date'];
		
		$duedate = date('d-m-Y', strtotime('+'.$plushari.' days', strtotime($tgl))); 
		





		$temp="";
		$total=0;
		for ($i=0; $i < count($receive_detail); $i++) { 

			$temp=$temp."<tr>";
				
				$temp=$temp."<td>";
					$temp=$temp.$receive_detail[$i]['Name'];
				$temp=$temp."</td>";
				$temp=$temp."<td>";
					$temp=$temp.$receive_detail[$i]['Option_name'];
				$temp=$temp."</td>";
				$temp=$temp."<td>";
					$temp=$temp.number_format($receive_detail[$i]['Qty']);
				$temp=$temp."</td>";
				$temp=$temp."<td>";
					$temp=$temp."Rp. ".number_format($receive_detail[$i]['Purchase_price']);
				$temp=$temp."</td>";
				$temp=$temp."<td>";
					$temp=$temp."Rp. ".number_format($receive_detail[$i]['Qty']*$receive_detail[$i]['Purchase_price']);
				$temp=$temp."</td>";
			$temp=$temp."</tr>";

			$total = $total + ($receive_detail[$i]['Qty']*$receive_detail[$i]['Purchase_price']);
		}

		$temp=$temp."<tr>";
		$temp=$temp."<td>";
		$temp=$temp."</td>";
		$temp=$temp."<td>";
		$temp=$temp."</td>";
		$temp=$temp."<td>";
		$temp=$temp."</td>";
		$temp=$temp."<td>";
			$temp=$temp."<b>TOTAL :</b>";
		$temp=$temp."</td>";
		$temp=$temp."<td>";
			$temp=$temp."<b>Rp. ".number_format($total)."</b>";
		$temp=$temp."</td>";


		$temp=$temp."</tr>";






		$gabungan = $temp."#".$norcv."#".$nopo."#".$supp."#".$operator."#".$tgl."#".$noreffsupp."#".$Status_payment."#".$duedate."#".$no_payment."#".$receipt_image."#".$payment_by."#".$payment_method."#".$namabank."#".$norekening."#".$namapemilikrekening;
		print_r($gabungan);
	}



	public function set_id_reveice_session(Request $request)
	{
		$no_detail = $request->no_detail;
		$idx = $request->idx;

		$product_session= session()->get('receive_session');

		for ($i=0; $i < count($product_session) ; $i++) { 
			
			if($product_session[$i]['No_detail'] == $no_detail)
			{
				$product_session[$i]['Id'] = $idx;
			
			}
			
		}
		session()->forget('receive_session');
		session()->put('receive_session', $product_session);

	}

	public function show_table_ro(Request $request)
	{
		$no_invoice = session()->get('noinvselect');
		$ro_header = receive_header::where('No_invoice','=',$no_invoice)
		->join('member','receive_header.Id_member','member.Id_member')
		->where('receive_header.Status','=',2)
		->select('receive_header.No_receive','receive_header.No_invoice','receive_header.Receive_date','member.Username','member.Role')
		->get();

		$temp="";
		for ($i=0; $i < count($ro_header); $i++) { 
			$temp=$temp."<tr>";
				$temp=$temp."<td>";
					$temp=$temp.$ro_header[$i]['No_receive'];
				$temp=$temp."</td>";
				$temp=$temp."<td>";
					$temp=$temp.$ro_header[$i]['No_invoice'];
				$temp=$temp."</td>";
				$temp=$temp."<td>";
					$temp=$temp.$ro_header[$i]['Receive_date'];
				$temp=$temp."</td>";
				$temp=$temp."<td>";
					$temp=$temp.$ro_header[$i]['Username'].'-'.$ro_header[$i]['Role'];
				$temp=$temp."</td>";
				$temp=$temp."<td>";
					$temp=$temp."<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-noreceive='".$ro_header[$i]['No_receive']."' data-target='#modal-detailreceive'> View Detail </button>";
				$temp=$temp."</td>";
			$temp=$temp."</tr>";
		}

		print_r($temp);
	}

	public function input_receive_order(Request $request) // JIKA DI INPUT DARI DASHBOARD SHIPPER
	{
		$product_session= session()->get('receive_session');
		$noinv = $request->noinv;
		$noreff = $request->noreff;
		$tgl= date('d/m/Y');
		$member = session()->get('userlogin');

		$tglfix = $tgl[6].$tgl[7].$tgl[8].$tgl[9]."/".$tgl[3].$tgl[4]."/".$tgl[0].$tgl[1];

		$statuspurchase=0;
		$jumlahfull=0;

		//Cek ada dk yang terselect
		$tes="no";
		for ($i=0; $i < count($product_session) ; $i++) { 
			
			if($product_session[$i]['Id'] == 1)
			{
				$tes="yes";
			}
		}

		if($tes=="no")
		{
			 //echo $tes;
		}
		else
		{
			//INV-RO-260121-0001
			$invrodate = $tgl[0].$tgl[1].$tgl[3].$tgl[4].$tgl[8].$tgl[9];
			$nourut="";

			$pur = receive_header::where('Receive_date','=',$tglfix)
					->get();

				
			if(count($pur)<10)
			{
				$nourut = "000".(count($pur)+1);
			}
			else if(count($pur)<100)
			{
				$nourut = "00".(count($pur)+1);
			}
			else if(count($pur)<1000)
			{
				$nourut ="0".(count($pur)+1);
			}
			else
			{
				$nourut = count($pur)+1;
			}

			$noinvro = "INV-RO-".$invrodate."-".$nourut;

			$head = new receive_header();
			$hasil = $head->insertdata($noinvro,$noinv, $tglfix, $member['Id_member'],$noreff);

			
			for ($i=0; $i < count($product_session) ; $i++) { 
				
				if($product_session[$i]['Id'] == 1)
				{
					$det = new receive_detail();
					$hasil2 = $det->insertdata($noinvro ,$product_session[$i]['Id_product'], $product_session[$i]['Id_variation'], $product_session[$i]['No_detail'],$product_session[$i]['Qty_receive'],$product_session[$i]['Purchase_price']);
				
					$det = new receive_detail();
					$lastnoreceivedetail = $det->lastnoreceivedetail();
					


			

					for ($k=0; $k < count($product_session[$i]['Qty_expire']) ; $k++) { 

						$tglexp = $product_session[$i]['Date_expire'][$k];
						$tglfixexp = $tglexp[6].$tglexp[7].$tglexp[8].$tglexp[9]."/".$tglexp[3].$tglexp[4]."/".$tglexp[0].$tglexp[1];


						$exp = new receive_expire();
						$hasil3 = $exp->insertdata($lastnoreceivedetail,$product_session[$i]['Id_product'],$product_session[$i]['Id_variation'],$product_session[$i]['Qty_expire'][$k],$tglfixexp);
					}
				
				
				}
				
			}

			//status
			//0 void
			//1 pending
			//2 approve
			//3 reject


		}
		echo $tes;
		
		
	}



	public function input_receive_order_shipper(Request $request) //JIKA DI INPUT LEWAT DASHBOARD ADMIN
	{
		

		$product_session= session()->get('receive_session');
		$noinv = $request->noinv;
		$noreff = $request->noreff;
		$tgl= date('d/m/Y');
		$member = $request->Id_member;

		$tglfix = $tgl[6].$tgl[7].$tgl[8].$tgl[9]."/".$tgl[3].$tgl[4]."/".$tgl[0].$tgl[1];

		$statuspurchase=2;
		$jumlahfull=0;

		//Cek ada dk yang terselect
		$tes="no";
		for ($i=0; $i < count($product_session) ; $i++) { 
			
			if($product_session[$i]['Id'] == 1)
			{
				$tes="yes";
			}
		}

		if($tes=="no")
		{
			 //echo $tes;
		}
		else
		{
			//INV-RO-260121-0001
			$invrodate = $tgl[0].$tgl[1].$tgl[3].$tgl[4].$tgl[8].$tgl[9];
			$nourut="";

			$pur = receive_header::where('Receive_date','=',$tglfix)
					->get();

				
			if(count($pur)<10)
			{
				$nourut = "000".(count($pur)+1);
			}
			else if(count($pur)<100)
			{
				$nourut = "00".(count($pur)+1);
			}
			else if(count($pur)<1000)
			{
				$nourut ="0".(count($pur)+1);
			}
			else
			{
				$nourut = count($pur)+1;
			}

			$noinvro = "INV-RO-".$invrodate."-".$nourut;

			$head = new receive_header();
			$hasil = $head->insertdata2($noinvro,$noinv, $tglfix, $member,$noreff);

			
			for ($i=0; $i < count($product_session) ; $i++) { 
				
				if($product_session[$i]['Id'] == 1)
				{
					$det = new receive_detail();
					$hasil2 = $det->insertdata($noinvro ,$product_session[$i]['Id_product'], $product_session[$i]['Id_variation'], $product_session[$i]['No_detail'],$product_session[$i]['Qty_receive'],$product_session[$i]['Purchase_price']);
				
					$det = new receive_detail();
					$lastnoreceivedetail = $det->lastnoreceivedetail();
					


			

					for ($k=0; $k < count($product_session[$i]['Qty_expire']) ; $k++) { 

						$tglexp = $product_session[$i]['Date_expire'][$k];
						$tglfixexp = $tglexp[6].$tglexp[7].$tglexp[8].$tglexp[9]."/".$tglexp[3].$tglexp[4]."/".$tglexp[0].$tglexp[1];


						$exp = new receive_expire();
						$hasil3 = $exp->insertdata($lastnoreceivedetail,$product_session[$i]['Id_product'],$product_session[$i]['Id_variation'],$product_session[$i]['Qty_expire'][$k],$tglfixexp);
					}
				
				
				}
				
			}

			//status
			//0 void
			//1 pending
			//2 approve
			//3 reject


			$receiveheader = receive_header::where('No_invoice','=',$noinv)
				->where('Status','=',2) //status approve
				->get();

				$qtyreceive=0;
				for ($i=0; $i < count($receiveheader) ; $i++) { 
					
					$no_receive = $receiveheader[$i]['No_receive'];

					$receivedetail = receive_detail::where('No_receive','=',$no_receive)
					->get();

					for ($k=0; $k < count($receivedetail) ; $k++) { 
						$qtyreceive = $qtyreceive + $receivedetail[$k]['Qty'];
					}
				}


				// $statuspurchase=2;
				$qtypurchase=0;
				$purchasedetail = purchase_detail::where('No_invoice','=',$noinv)
				->get();

				for ($i=0; $i < count($purchasedetail) ; $i++) { 
					$qtypurchase = $qtypurchase + $purchasedetail[$i]['Qty'];
				}


			if($qtypurchase == $qtyreceive)
			{
				$statuspurchase=4;
			}

				
				$headerpur = new purchase_header();
				$headerpur->editstatus($noinv, $statuspurchase);

			
		}
		echo $tes;
		
		
	}



	public function show_detail_receive(Request $request)
	{
		$no_receive = $request->no_receive;
		// $detail = receive_detail::where('receive_detail.No_receive','=',$no_receive)
		// ->join('product','receive_detail.Id_product','product.Id_product')
		// ->join('variation','receive_detail.Id_variation','variation.Id_variation')
		// ->select('receive_detail.No_receive','product.Name','variation.Option_name','receive_detail.Qty')
		// ->get();

		$detail = receive_detail::where('receive_detail.No_receive','=',$no_receive)
		->get();

		$pro = product::all();
		$vari = variation::all();


		
		$temp="ss";
		for ($i=0; $i < count($detail); $i++) { 
			$temp=$temp."<tr>";
				$temp=$temp."<td>";
					$temp=$temp.$detail[$i]['No_receive'];
				$temp=$temp."</td>";

				for ($k=0; $k < count($pro) ; $k++) { 
					# code...
					if($pro[$k]['Id_product']== $detail[$i]['Id_product'])
					{
						$temp=$temp."<td>";
							$temp=$temp.$pro[$k]['Name'];
						$temp=$temp."</td>";
						break;
					}
				}

				for ($j=0; $j < count($vari) ; $j++) { 
					# code...
					if($vari[$j]['Id_variation']== $detail[$i]['Id_variation'])
					{
						$temp=$temp."<td>";
							$temp=$temp.$vari[$j]['Option_name'];
						$temp=$temp."</td>";
						break;
					}
				}

				
				$temp=$temp."<td>";
					$temp=$temp.$detail[$i]['Qty'];
				$temp=$temp."</td>";
			$temp=$temp."</tr>";
		}

		print_r($temp);
	}
    
	public function get_shipper_data(Request $request)
	{
		$hasil = member::where('Id_member','=',$request->Id_member)
		->where('Status','=',1)
		->get();

		print_r($hasil[0]->Username."#".$hasil[0]->Password);
	}

	public function set_status_receive(Request $request)
	{
		$No_receive = $request->No_receive;
		$Status = $request->Status;

		$head = new receive_header();
		$head->editstatus($No_receive, $Status);

		if($Status==2)
		{
			$statuspurchase=2;

			$receiveheader = receive_header::where('No_receive','=',$No_receive)
			->where('Status','=',2) //status approve //AMBIL NO INVOICE
			->get();
		

			$noinv = $receiveheader[0]['No_invoice'];

			$receiveheader = receive_header::where('No_invoice','=',$noinv)
			->where('Status','=',2) //status approve
			->get();
		
			$qtyreceive=0;
			for ($i=0; $i < count($receiveheader) ; $i++) { 
				
				$no_receive_for = $receiveheader[$i]['No_receive'];
		
				$receivedetail = receive_detail::where('No_receive','=',$no_receive_for)
				->get();
		
				for ($k=0; $k < count($receivedetail) ; $k++) { 
					$qtyreceive = $qtyreceive + $receivedetail[$k]['Qty'];
				}
			}
		
		
		
			$qtypurchase=0;
			$purchasedetail = purchase_detail::where('No_invoice','=',$noinv)
			->get();
		
			for ($i=0; $i < count($purchasedetail) ; $i++) { 
				$qtypurchase = $qtypurchase + $purchasedetail[$i]['Qty'];
			}
		
		
			if($qtypurchase == $qtyreceive)
			{
				$statuspurchase=4;
			}
			
			
			echo $qtypurchase."#".$qtyreceive;
			// echo $statuspurchase;

			 $headerpur = new purchase_header();
			$headerpur->editstatus($noinv, $statuspurchase);
		
		
		}


	}


	public function void_receive_detail(Request $request)
	{
		$No_receive = $request->No_receive;
		$No_invoice = "";

		$receivehead = receive_header::where('No_receive','=',$No_receive)
				->get();

		$oke="";
		foreach ($receivehead as $data) {
			$No_invoice = $data->No_invoice;
			if($data->Status=="2")
			{
				$oke="yes";

				$todayDate = date("Y/m/d");

				$todayDate2 = strtotime($todayDate); 
				$todayDate3 = getDate($todayDate2); 
		
		
				$newDate = $data->Receive_date;
		
				$newDate2 = strtotime($newDate); 
				$newDate3 = getDate($newDate2); 

				if($todayDate3==$newDate3)
				{
				
				}
				else
				{
					$oke="faildate";
				}


				$receivedetail = receive_detail::where('No_receive','=',$No_receive)
				->get();


				foreach ($receivedetail as $data2) {
					$Id_variation = $data2->Id_variation;
					$variation = variation::where('Id_variation','=',$Id_variation)
					->where('Status','=',1)
					->get();


					if($variation[0]['Stock']>=$data2->Qty)
					{

					}
					else
					{
						$oke="failstock";
						break;
					}

				}




			}
			else
			{
				$oke="failstatus";
			}

	
		}

		if($oke=="yes")
		{
			$headerreceive = new receive_header();
			$headerreceive->editstatus($No_receive,0);

		
			$receiveheader = receive_header::where('No_invoice','=',$No_invoice)
				->where('Status','=',2) //status approve
				->get();

			$qtyreceive=0;
			for ($i=0; $i < count($receiveheader) ; $i++) { 
				
				$norec = $receiveheader[$i]['No_receive'];

				$receivedetail = receive_detail::where('No_receive','=',$norec)
				->get();

				for ($k=0; $k < count($receivedetail) ; $k++) { 
					$qtyreceive = $qtyreceive + $receivedetail[$k]['Qty'];
				}
			}


			 $statuspurchase=2;
			$qtypurchase=0;
			$purchasedetail = purchase_detail::where('No_invoice','=',$No_invoice)
			->get();

			for ($i=0; $i < count($purchasedetail) ; $i++) { 
				$qtypurchase = $qtypurchase + $purchasedetail[$i]['Qty'];
			}


			if($qtypurchase == $qtyreceive)
			{
				$statuspurchase=4;
			}
			else if($qtyreceive == 0) //open 
			{
				$statuspurchase=1;
			}

			
			$headerpur = new purchase_header();
			$headerpur->editstatus($No_invoice, $statuspurchase);

			
			
		}

		print_r($oke);

	}






















	public function Purchase_payment(Request $request)
	{
		$param['payment'] = receive_header::where('receive_header.Id_member','>',0)
		->join('member','receive_header.Id_member','member.Id_member')
		->select('receive_header.No_receive','receive_header.No_invoice','receive_header.Receive_date','member.Username',\DB::raw('(CASE WHEN receive_header.Payment = 1 THEN "Paid" ELSE "Unpaid" END) AS Payment'))
		->where('receive_header.Status','=',2)
		->orderby('receive_header.Receive_date','desc')
		->get();

		$param['detail'] = receive_detail::all();

		$payment=$param['payment'];

		$supp=[];
		$duedate=[];


		$tes="";
		for ($i=0; $i < count($payment) ; $i++) { 
			
			$noinv = $payment[$i]['No_invoice'];
			$receive_date = $payment[$i]['Receive_date'];

			
			$pur = purchase_header::where('purchase_header.No_invoice','=',$noinv)
			->join('supplier','purchase_header.Id_supplier','supplier.Id_supplier')
			->select('supplier.Supplier_name','supplier.Credit_due_date')
			->get();

			$supplier_name = $pur[0]['Supplier_name'];
			$plushari = $pur[0]['Credit_due_date'];

			
			$tgl1 = $receive_date;// pendefinisian tanggal awal
			$tgl2 = date('Y-m-d', strtotime('+'.$plushari.' days', strtotime($tgl1))); //operasi penjumlahan tanggal sebanyak 6 hari
			
			// $param['tes']=$tgl2;




			array_push($supp, $supplier_name);
			array_push($duedate, $tgl2);
		}

		$param['supp'] = $supp;
		$param['duedate'] = $duedate;

		
		return view('Purchase_payment',$param);
	}

	public function Purchase_payment_pay($No_receive)
	{

		$norcv = $No_receive;


		$param['receive_detail'] = receive_detail::where('receive_detail.No_receive','=',$norcv)
		->join('product','receive_detail.Id_product','product.Id_product')
		->join('variation_product','receive_detail.Id_variation','variation_product.Id_variation')
		->select('receive_detail.No_receive_detail','receive_detail.No_receive','product.Name','variation_product.Option_name','receive_detail.Qty','receive_detail.Purchase_price')
		->get();

		$param['receive_header'] = receive_header::where('No_receive','=',$norcv)
		->join('member','receive_header.Id_member','member.Id_member')
		->select('receive_header.No_receive','receive_header.No_invoice','receive_header.Receive_date','member.Username','member.Role','receive_header.No_reff_supplier','receive_header.Payment')
		->get();

		 $nopo = $param['receive_header'][0]['No_invoice'];
		 $tgl = $param['receive_header'][0]['Receive_date'];
		

		$purchase_header = purchase_header::where('purchase_header.No_invoice','=',$nopo)
		->join('supplier','purchase_header.Id_supplier','supplier.Id_supplier')
		->select('purchase_header.No_invoice','purchase_header.Purchase_date','supplier.Supplier_name','supplier.Credit_due_date','purchase_header.Grand_total',\DB::raw('(CASE WHEN purchase_header.Status = 1 THEN "OPEN" WHEN purchase_header.Status = 2 THEN "Partially Processed" WHEN purchase_header.Status = 3 THEN "Partially Processed (Close)" WHEN purchase_header.Status = 4 THEN "Completed (Close)" WHEN purchase_header.Status = 0 THEN "Void" END) AS STATUS_ORDER'))
		// ->select('purchase_header.No_invoice',\DB::raw('DATE_FORMAT(purchase_header.Purchase_date,"%d/%m/%Y") as Purchase_date'),'supplier.Supplier_name','purchase_header.Grand_total',\DB::raw('(CASE WHEN purchase_header.Status = 1 THEN "OPEN" WHEN purchase_header.Status = 2 THEN "Partially Processed" WHEN purchase_header.Status = 3 THEN "Partially Processed (Close)" WHEN purchase_header.Status = 4 THEN "Completed (Close)" WHEN purchase_header.Status = 0 THEN "Void" END) AS STATUS_ORDER'))
		->orderby('purchase_header.Purchase_date','Desc')
		->get();

		$plushari =  $purchase_header[0]['Credit_due_date'];
		$param['supp'] = $purchase_header[0]['Supplier_name'];
		$param['duedate'] = date('Y-m-d', strtotime('+'.$plushari.' days', strtotime($tgl))); 
		

		$db = bank::all(); 
		$arr= [];  // array 
		foreach($db as $row) {
			if($row->Status==1)
			{
				$arr[$row->Id_bank] = $row->Bank_name."-".$row->Account_number."-".$row->Account_name; 

				
			}
		
		}
		
		$param['bank'] = $arr;

		session()->put('payment_method', 'cash');
		return view('Purchase_payment_pay',$param);


		
	}

	public function payment_method_select(Request $request)
	{
		session()->put('payment_method', $request->method);

		echo session()->get('payment_method');
	}

	// public function input_purchase_payment(Request $request)
	// {
	// 	//INV-PPAY-120121-0001
	// 	// $foto = $request->file('foto')


	// 	$filefoto = $request->file('foto');
	// 	$extfile = $filefoto->getClientOriginalExtension();

	// 	$despath = 'Uploads/Purchase_payment_receipt';
	// 	$randoman = rand(1,100000);
	// 	$namafile = $randoman.'.'.$extfile;
	// 	$filefoto->move($despath,$namafile);

	// 	// $br = new product_image();
	// 	// $hasil = $br->add_image ($kodeproduk,$namafile);
	// }

	public function Insert_purchase_payment(Request $request)
	{
		if($request->input_purchase_payment){

			//INV-PPAY-120121-0001

			//adriel2

			$namafile="";
			$tgl= date('d/m/Y');
			$tglkode = $tgl[0].$tgl[1].$tgl[3].$tgl[4].$tgl[8].$tgl[9];
			// $tglfix = $invdate[6].$invdate[7].$invdate[8].$invdate[9]."/".$invdate[3].$invdate[4]."/".$invdate[0].$invdate[1];
		    $tglfix = $tgl[6].$tgl[7].$tgl[8].$tgl[9]."/".$tgl[3].$tgl[4]."/".$tgl[0].$tgl[1];

			$pur = purchase_payment::where('Payment_date','=',$tglfix)
							->get();


			if(count($pur)<10)
			{
				$nourut = "000".(count($pur)+1);
			}
			else if(count($pur)<100)
			{
				$nourut = "00".(count($pur)+1);
			}
			else if(count($pur)<1000)
			{
				$nourut ="0".(count($pur)+1);
			}
			else
			{
				$nourut = count($pur)+1;
			}

			$no_payment = "INV-PPAY-".$tglkode."-".$nourut;
			

			if($request->hasFile('foto'))
			{
				$tes = $request->No_receive;
				$filefoto = $request->file('foto');
				$extfile = $filefoto->getClientOriginalExtension();
	
				$despath = 'Uploads/Purchase_payment_receipt';
				$randoman = rand(1,100000);
				$namafile = $no_payment.'-'.$randoman.'.'.$extfile;
				$filefoto->move($despath,$namafile);
	
			}
			else
			{
				$namafile = "";
			}


			if(session()->get('payment_method') == "cash")
			{
				//Insert Payment
				$head = new purchase_payment();
				$hasil = $head->insertdata($no_payment,$tglfix, $request->No_receive, $request->No_invoice , session()->get('userlogin')->Id_member, session()->get('payment_method'), 0, $namafile);

			}
			else
			{
				//Insert Payment
				$head = new purchase_payment();
				$hasil = $head->insertdata($no_payment,$tglfix, $request->No_receive, $request->No_invoice , session()->get('userlogin')->Id_member, session()->get('payment_method'), $request->cb_bank, $namafile);

			}
			
			$rec = new receive_header();
			$hasil = $rec->editpayment($request->No_receive,1);





//---------------------------------------------------------------------------------------

			$param['payment'] = receive_header::where('receive_header.Id_member','>',0)
		->join('member','receive_header.Id_member','member.Id_member')
		->select('receive_header.No_receive','receive_header.No_invoice','receive_header.Receive_date','member.Username',\DB::raw('(CASE WHEN receive_header.Payment = 1 THEN "Paid" ELSE "Unpaid" END) AS Payment'))
		->where('receive_header.Status','=',2)
		->orderby('receive_header.Receive_date','desc')
		->get();

		$param['detail'] = receive_detail::all();

		$payment=$param['payment'];

		$supp=[];
		$duedate=[];


		$tes="";
		for ($i=0; $i < count($payment) ; $i++) { 
			
			$noinv = $payment[$i]['No_invoice'];
			$receive_date = $payment[$i]['Receive_date'];

			
			$pur = purchase_header::where('purchase_header.No_invoice','=',$noinv)
			->join('supplier','purchase_header.Id_supplier','supplier.Id_supplier')
			->select('supplier.Supplier_name','supplier.Credit_due_date')
			->get();

			$supplier_name = $pur[0]['Supplier_name'];
			$plushari = $pur[0]['Credit_due_date'];

			
			$tgl1 = $receive_date;// pendefinisian tanggal awal
			$tgl2 = date('Y-m-d', strtotime('+'.$plushari.' days', strtotime($tgl1))); //operasi penjumlahan tanggal sebanyak 6 hari
			
			// $param['tes']=$tgl2;




			array_push($supp, $supplier_name);
			array_push($duedate, $tgl2);
		}

		$param['supp'] = $supp;
		$param['duedate'] = $duedate;

		
		return view('Purchase_payment',$param);

		}

	}
	

	// public function session_kodegambar_payment(Request $request)
	// {
	// 	$kodegambar = $request->kodegambar;

	// 	session()->put('kodegambarpayment',$kodegambar);
	// }




	
	
	
}

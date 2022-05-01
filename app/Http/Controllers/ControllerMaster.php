<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\member;
use App\category;
use App\sub_category;
use App\brand;
use App\bank;
use App\banner;
use App\type;
use App\product;
use App\product_sub_category;
use App\variation;
use App\product_image;
use App\supplier;
use App\supplier_product;
use App\promo_header;
use App\promo_detail;
use App\voucher;
use App\voucher_product;
use App\voucher_member;
use App\affiliate;
use App\ebook;
use App\email_ebook;
use App\Mail\SendEbook;
use App\rate_review;
use App\Rules\ValidasiEmailMember;
use App\Rules\ValidasiPasswordEditTeamMember;
use App\Rules\ValidasiUsernameMember;
use App\Rules\ValidasiPhoneMember;
use App\Rules\ValidasiProductName;
use App\Rules\ValidasiSubCategorySession;
use App\Rules\ValidasiOptionSession;
use App\Rules\ValidasiSupplierName;
use App\Rules\ValidasiInsertPhotoMasterProduct;
use App\Rules\ValidasiCbProduct;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ControllerMaster extends Controller
{
    //
	public function dtproduct()
	{
		$param['dtproduct'] = product::where('product.Id_product','>',-1)
		->join('brand','product.Id_brand','brand.Id_brand')
		->join('type','product.Id_type','type.Id_type')
		->select("product.Id_product","product.Name","brand.Brand_name", "type.Type_name","product.Variation", \DB::raw('(CASE WHEN product.status = 1 THEN "Active" ELSE "Non-Active" END) AS status_user'))
			->get();

		$param['dtproductimage'] = product_image::where('Id_image','>',-1)
		->get();

		$param['dtvariationname'] = variation::where('Status','=',1)
		->select("Option_name","Id_product")
		->get();

		foreach ($param['dtproduct'] as $product) {
			$product->rating = rate_review::join('member', 'rating_review.Id_member', 'member.Id_member')
								->join('cust_order_detail', 'cust_order_detail.Id_detail_order', 'rating_review.Id_detail_order')
								->where('Id_product', $product->Id_product)
								->select('Id_product', 'member.Username', 'rating_review.Rate', 'rating_review.Review', 'rating_review.id', 'rating_review.Status')
								->get();
		}
		return($param);

	}

	public function mastervoucheradd()
	{
		session()->forget('session_product_supplier');


		$param['dtproduct'] = product::where('product.Status','=', '1')
		->join('brand','product.Id_brand','brand.Id_brand')
		->join('type','product.Id_type','type.Id_type')
		->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
		"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
			->get();


		$param['dtvariationname'] = variation::where('Status','=',1)
		->select("Option_name","Id_product")
		->get();

		$param['dtproductimage'] = Product_image::all();

		session()->put('tipe_voucher',1);
		// session()->put('tipe_voucher_product',"all");


		$param['msg'] = "";
		$param['msgerror'] = "";
	}


    public function master_product(){

		//(CASE WHEN product.status= '1' THEN 'Active' ELSE 'No Active') As Status
	
		return view('Master_product', $this->dtproduct());

	}
	public function Master_product_detail($id)
	{
		session()->forget('datavariasi');
		session()->forget('datasubcategory');


		session()->forget('product_model');
		session()->put('product_model','simple');


		$dp =  product::where('Id_product','=', $id)
		->get();

		$param['Ix_status'] = $dp[0]->Status;

		$cal=1;
		$dt = type::all(); 
		$arr= [];  // array 
		foreach($dt as $row) {
			if($row->Status==1)
			{
				$arr[$row->Id_type] = $row->Type_name; 
	
				if($dp[0]->Id_type == $row->Id_type)
				{
				   $param['Ix_type']  = $cal; 
				}
				$cal=$cal+1;
			}
		 
		}
		
		$param['arr_type']  = $arr; 


		$cal=1;
		$db = brand::all(); 
		$arr= [];  // array 
		foreach($db as $row) {
			if($row->Status==1)
			{
				$arr[$row->Id_brand] = $row->Brand_name; 

				if($dp[0]->Id_brand == $row->Id_brand)
				{
				   $param['Ix_brand']  = $cal; 
				}
				$cal=$cal+1;
			}
		
		}
		
		$param['arr_brand']  = $arr; 

		$db = category::all(); 
		$arr= [];  // array 
		foreach($db as $row) {
			if($row->Status==1)
			{
				$arr[$row->Id_category] = $row->Category_name; 
			}
		
		}
		
		$param['arr_category']  = $arr; 


		$param['dtproduct'] = product::where('product.Id_product','=', $id)
						->join('brand','product.Id_brand','brand.Id_brand')
						->join('type','product.Id_type','type.Id_type')
						->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
						"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
							->get();

		
		//Variation
		$param['dtvar'] = variation::where('Id_product','=', $id)
		->where('Status','=',1)
		->select("Id_variation","Id_product", "Variation_name","Option_name","Purchase_price","Sell_price",
		"Weight","Dimension","Stock","Stock_atc","Stock_pay","Status")
			->get();

		$variasi = $param['dtvar'];

		foreach ($variasi as $data) {
			# code...
			if($data->Variation_name == "NONE")
			{
				$param['product_model'] = "";
				session()->put('product_model', "simple");
				
			}
			else
			{
				$param['product_model'] = $data->Variation_name;
				session()->put('product_model', "variation");
				
				session()->push("datavariasi", [
					"option_name" => $data->Option_name,
					"stock" => $data->Stock,
					"purchase_price" => $data->Purchase_price,
					"sell_price" => $data->Sell_price,
					"weight" => $data->Weight,
					"dimension" => $data->Dimension
				]);
				
			}
			$param['dtvariasi'] = $param['dtvar'];
			
		}
		




		//SUbcat
		$subcat = product_sub_category::where('product_sub_category.Id_product','=', $id)
				->join('sub_category','product_sub_category.Id_sub_category','sub_category.Id_sub_category')
				->join('category','sub_category.Id_category','category.Id_category')
				->select("category.Category_name","sub_category.Sub_category_name","product_sub_category.Id_sub_category")
		->get();

		foreach ($subcat as $data) {
			
			session()->push("datasubcategory", [
				"category" => $data->Category_name,
				"subcategory" => $data->Sub_category_name,
				"idsubcategory" => $data->Id_sub_category
			]);
	
		}

	
		// session()->push("datasubcategory", [
		// 	"category" => "Jamu",
		// 	"subcategory" => "haha",
		// 	"idsubcategory" => 1
		// ]);





		return view('Master_product_detail', $param);
	}

	public function View_detail_product(Request $request)
	{
		


	}

	public function master_product_add(){ //halaman

	
		session()->forget('datavariasi');
		session()->forget('datasubcategory');


		session()->forget('product_model');
		session()->put('product_model','simple');

		
		


		$dt = type::all(); 
		$arr= [];  // array 
		foreach($dt as $row) {
			if($row->Status==1)
			{
				$arr[$row->Id_type] = $row->Type_name; 
			}
		
		}
		
		$param['arr_type']  = $arr; 


		$db = brand::all(); 
		$arr= [];  // array 
		foreach($db as $row) {
			if($row->Status==1)
			{
				$arr[$row->Id_brand] = $row->Brand_name; 
			}
		
		}
		
		$param['arr_brand']  = $arr; 

		$db = category::all(); 
		$arr= [];  // array 
		foreach($db as $row) {
			if($row->Status==1)
			{
				$arr[$row->Id_category] = $row->Category_name;
			}
	 
		}
		
		$param['arr_category']  = $arr; 


		return view('Master_product_add',$param);

	}

	public function product_model(Request $request)
	{
		session()->put("product_model",$request->model);
		print_r(session()->get('product_model'));
	}
	

	public function add_sub_table(Request $request)
	{

		session()->push("datasubcategory", [
			"category" => $request->cat,
			"subcategory" => $request->sub,
			"idsubcategory" => $request->idsub
		]);

		print_r(session()->get('datasubcategory'));


	}

	public function add_subcat_session(Request $request)
	{

	    $cart = session()->get('datasubcategory');

		$arr =array("a");

		$temp="";

		for ($i=0; $i < count($cart); $i++) { 

			$temp.= $cart[$i]['idsubcategory'] . ',';
			// array_push($arr,$cart[$i]['idsubcategory']);
		}

		echo $temp;
	}


	public function show_cart_sub(Request $request)
	{

	    $cart = session()->get('datasubcategory');

		$temp="";

		for ($i=0; $i < count($cart); $i++) { 

			
			$temp =$temp. "<tr>";
			$temp =$temp. "<td>".$cart[$i]['category']."</td>";
			$temp =$temp. "<td>".$cart[$i]['subcategory']."</td>";
			$temp =$temp. "<td> <button type='button' class='btn btn-warning btn-sm' onclick='delete_sub(".$i.")'> Delete </button></td>";
			$temp =$temp. "</tr>";

		}
		echo $temp;
	}


	public function delete_sub(Request $request)
	{

		$ix = $request->ix;


		$cart = session()->get('datasubcategory');

		$potong = [];

		for ($i=0; $i <count($cart) ; $i++) { 
			if($i == $ix)
			{

			}
			else
			{
				array_push($potong, $cart[$i]);
				
			}

		}

		session()->forget('datasubcategory');

		session()->put("datasubcategory",$potong);

	}


	public function add_option_session(Request $request)
	{
		$cart = session()->get('datavariasi');

		$temp="";

		for ($i=0; $i < count($cart); $i++) { 

			$temp.= $cart[$i]['option_name'] . ',';
		}

		echo $temp;
	}

	public function add_option_product(Request $request)
	{

		session()->push("datavariasi", [
			"option_name" => $request->option_name,
			"stock" => $request->stock,
			"purchase_price" => $request->purchase_price,
			"sell_price" => $request->sell_price,
			"weight" => $request->weight,
			"dimension" => $request->dimension
		]);

		print_r(session()->get('datavariasi'));

	}

	public function show_cart_option(Request $request)
	{

		// session()->forget('datavariasi');

	    $cart = session()->get('datavariasi');

		$temp="";

		for ($i=0; $i < count($cart); $i++) { 

			
			$temp =$temp. "<tr>";
			$temp =$temp. "<td>".$cart[$i]['option_name']."</td>";
			$temp =$temp. "<td>".$cart[$i]['purchase_price']."</td>";
			$temp =$temp. "<td>".$cart[$i]['sell_price']."</td>";
			$temp =$temp. "<td>".$cart[$i]['weight']."</td>";
			$temp =$temp. "<td>".$cart[$i]['dimension']."</td>";
			$temp =$temp. "<td>".$cart[$i]['stock']."</td>";
			$temp =$temp. "<td> 

			<a>
			 
			<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-option='".$cart[$i]['option_name']."' data-target='#variation_modal_edit'> Edit </button>
			</a>
		
			
			</td>";
			$temp =$temp. "<td> 
			
			<a><button type='button' class='btn btn-warning btn-sm' onclick='delete_option(".$i.")'> Delete </button></a>
			
			</td>";
			$temp =$temp. "</tr>";

		}
		echo $temp;
	}

	

	public function delete_option(Request $request)
	{

		$ix = $request->ix;


		$cart = session()->get('datavariasi');

		$potong = [];

		for ($i=0; $i <count($cart) ; $i++) { 
			if($i == $ix)
			{

			}
			else
			{
				array_push($potong, $cart[$i]);
				
			}

		}

		session()->forget('datavariasi');

		session()->put("datavariasi",$potong);


	}


	public function get_variation(Request $request)
	{
		$op = $request->option_name;

		$vari = session()->get('datavariasi');
		$ix=0;
		

		for ($i=0; $i < count($vari); $i++) { 
			if($vari[$i]['option_name'] == $op)
			{
				$ix=$i;
			}
		}
		
		print_r($vari[$ix]['option_name'].','.$vari[$ix]['purchase_price'].','.$vari[$ix]['sell_price'].','.$vari[$ix]['weight'].','.$vari[$ix]['dimension'].','.$vari[$ix]['stock']);

	}



	public function edit_variation(Request $request)
	{
		$option_name = $request->option_name;
		$purchase_price = $request->purchase_price;
		$sell_price = $request->sell_price;
		$weight = $request->weight;
		$dimension = $request->dimension;
		$stock = $request->stock;

		$vari = session()->get('datavariasi');
		for ($i=0; $i < count($vari); $i++) { 
			if($vari[$i]['option_name'] == $option_name)
			{
				$ix=$i;
			}
		}

		$vari[$ix]['purchase_price'] = $purchase_price;
		$vari[$ix]['sell_price'] = $sell_price;
		$vari[$ix]['weight'] = $weight;
		$vari[$ix]['dimension'] = $dimension;
		$vari[$ix]['stock'] = $stock;

		session()->forget('datavariasi');

		session()->put('datavariasi',$vari);


	}

	public function Master_product_images($id){

		$param['id'] = $id;

		$param['product'] = Product::where('Id_product','=',$id)
		->get();

		$param['product_image'] = product_image::where('Id_product','=',$id)
		->orderBy('Image_order')
		->get();



		return view('Master_product_images',$param);
	}


	public function switch_image_order(Request $request)
	{
		$Id_product = $request->id_product;
		$Start_index = $request->startindex;
		$Drop_index = $request->dropindex;

		$switchimage = new product_image();
		echo $switchimage->switch_image ($Id_product,$Start_index,$Drop_index);
		
	
	}

	public function deleteproductimage(Request $request)
	{
		$id = $request->id;
		$id_product = $request->id_product;
		$image_order = $request->image_order;
		$deleteproductimage = new product_image();
		$deleteproductimage->deletedata($id,$id_product,$image_order);
		echo $deleteproductimage;

	}

	public function Insertphoto(Request $request){

		if($request->validate(
		[
			'foto' => ['required',new ValidasiInsertPhotoMasterProduct($request->id)],
		
		],
		[
			'foto.required' => 'Please choose image file',
		]))
		{
			if($request->hasFile('foto'))
			{
				$kodeproduk = $request->id;
				$filefoto = $request->file('foto');
				$extfile = $filefoto->getClientOriginalExtension();
	
				$despath = 'Uploads/Product';
				$randoman = rand(1,100000);
				$namafile = $kodeproduk.'-'.$randoman.'.'.$extfile;
				$filefoto->move($despath,$namafile);
	
				$br = new product_image();
				$hasil = $br->add_image ($kodeproduk,$namafile);
	
				if($hasil=="sukses")
				{
					$param['id'] = $kodeproduk;
	
					$param['product'] = Product::where('Id_product','=',$kodeproduk)
					->get();
	
					$param['product_image'] = product_image::where('Id_product','=',$kodeproduk)
					->orderBy('Image_order')
					->get();
	
					return view('Master_product_images',$param);
				}
	
			}
			else
			{
				$namafile = "default.png";
			}
		}




	

	}
	

	public function add_product_detail(Request $request){

		if($request->add_product_detail){


			if($request->validate(
				[
					'txt_product_name' => ['required','max:100',new ValidasiProductName("add","")],
					'cb_type' => ['required'],
					'txt_packaging' => ['max:20'],
					'cb_brand' => ['required'],
					'txt_composition' => ['max:500'],
					'txt_efficacy' => ['max:500'],
					'txt_description' => ['max:1000'],
					'txt_bpom' => ['max:20'],
					'txt_storage_way' => ['max:50'],
					'txt_dose' => ['max:100'],
					'txt_disclaimer' => ['max:50'],
					'cb_status' =>['required',new ValidasiSubCategorySession(), new ValidasiOptionSession()],
				],
				[

					'cb_status.required' => 'Status cannot be empty',
					'txt_product_name.required' => 'Product name cannot be empty',
					'txt_product_name.max' => 'Product name max length 100',
					'cb_type.required' => 'Type cannot be empty',
					'txt_packaging.max' => 'Packaging name max length 20',
					'cb_brand.required' => 'Brand name cannot be empty',
					'txt_composition.max' =>'Composition max length 500',
					'txt_efficacy.max' => 'Efficacy max length 500',
					'txt_description.max' => 'Description max length 1.000',
					'txt_bpom.max' => 'BPOM max length 20',
					'txt_storage_way.max' => 'Storage way max length 50',
					'txt_dose.max' => 'Dose max length 100',
					'txt_disclaimer.max' => 'Disclaimer max length 50',
				

				]))
				{
					$status = $request->cb_status;
					$name = $request->txt_product_name;
					$id_type = $request->cb_type;
					$packaging = $request->txt_packaging;
					$id_brand = $request->cb_brand;
					$composition = $request->txt_composition;
					$bpom = $request->txt_bpom;
					$efficacy = $request->txt_efficacy;
					$desc = $request->txt_description;
					$storage = $request->txt_storage_way;
					$dose = $request->txt_dose;
					$disclaimer = $request->txt_dose;
					 
					//Insert Variation
					//SIMPLE NO Variation

					$temp = session()->get('product_model');

					if($temp == "simple")
					{
						$variation_name = $request->txt_variation_name;
						$option_name = $request->option_name;
						$weight = $request->txt_weight;
						$p = $request->txt_length;
						$l = $request->txt_width;
						$t = $request->txt_height;
						$di = $p."X".$l."X".$t;
						$dimension = $di;
						$purchase = $request->txt_purchase_price;
						$sell = $request->txt_sell_price;
						$stok = $request->txt_stock;


						
						$pro = new Product();
						$hasil = $pro->insertdata($name, $id_type, $packaging, $id_brand,$composition,
						$bpom,$efficacy, $desc,$storage,$dose,$disclaimer,'None',$status);


						$pro2 = new Product();
						$idp =  $pro2->getlastid();
						

						$vari = new variation();

						$hasil2 = $vari->insertdata($idp, 'NONE', 'NONE', $purchase,$sell,
						$weight,$dimension, $stok,1) ;

					}
					else //ada variation
					{
						$variation_name = $request->txt_variation_name;

						if (($variation_name=="") ||  ($variation_name=="NONE"))
						{
							//REDIRECT KE ADD PRODUCT

							session()->forget('datavariasi');
							session()->forget('datasubcategory');


							session()->forget('product_model');
							session()->put('product_model','simple');



							$dt = type::all(); 
							$arr= [];  // array 
							foreach($dt as $row) {
								if($row->Status==1)
								{
									$arr[$row->Id_type] = $row->Type_name; 
								}
						
							}
							
							$param['arr_type']  = $arr; 


							$db = brand::all(); 
							$arr= [];  // array 
							foreach($db as $row) {
								if($row->Status==1)
								{
									$arr[$row->Id_brand] = $row->Brand_name; 
								}
							
							}
							
							$param['arr_brand']  = $arr; 

							$db = category::all(); 
							$arr= [];  // array 
							foreach($db as $row) {
								if($row->Status==1)
								{
									$arr[$row->Id_category] = $row->Category_name; 
								}
							
							}
							
							$param['arr_category']  = $arr; 
							
							return view('Master_product_add',$param)->withErrors("Variation name cannot be empty");
						}
						else
						{
							$pro = new Product();
							$hasil = $pro->insertdata($name, $id_type, $packaging, $id_brand,$composition,
							$bpom,$efficacy, $desc,$storage,$dose,$disclaimer,$variation_name,$status);

							$pro2 = new Product();
							$idp =  $pro2->getlastid();



							$datavariasi = session()->get('datavariasi');



							for ($i=0; $i < count($datavariasi) ; $i++) { 
								
								$vari = new variation();
								$hasil2 = $vari->insertdata($idp, $variation_name, $datavariasi[$i]['option_name'], $datavariasi[$i]['purchase_price'],
								$datavariasi[$i]['sell_price'],$datavariasi[$i]['weight'],$datavariasi[$i]['dimension'],$datavariasi[$i]['stock'],1);
							}
						}

						
					}
					

					//Insert table product_sub_categpry

					$datasubcategory = session()->get('datasubcategory');

					$pro = new Product();
					$idp =  $pro->getlastid();

					for ($i=0; $i<count($datasubcategory); $i++) { 
						$sub = new product_sub_category();
						$idsub = $datasubcategory[$i]['idsubcategory'];

						$hasil = $sub->insertdata($idp,$idsub);
					}
					
						

					return view('Master_product', $this->dtproduct());
				}
		}
	}



	public function edit_product_detail(Request $request){

		
		if($request->edit_product_detail){

			if($request->validate(
				[
					'txt_product_name' => ['required','max:100',new ValidasiProductName("edit",$request->txt_id_product)],
					'cb_type' => ['required'],
					'txt_packaging' => ['max:20'],
					'cb_brand' => ['required'],
					'txt_composition' => ['max:500'],
					'txt_efficacy' => ['max:500'],
					'txt_description' => ['max:1000'],
					'txt_bpom' => ['max:20'],
					'txt_storage_way' => ['max:50'],
					'txt_dose' => ['max:100'],
					'txt_disclaimer' => ['max:50'],
					'cb_status' =>['required',new ValidasiSubCategorySession(), new ValidasiOptionSession()],
				],
				[

					'cb_status.required' => 'Status cannot be empty',
					'txt_product_name.required' => 'Product name cannot be empty',
					'txt_product_name.max' => 'Product name max length 100',
					'cb_type.required' => 'Type cannot be empty',
					'txt_packaging.max' => 'Packaging name max length 20',
					'cb_brand.required' => 'Brand name cannot be empty',
					'txt_composition.max' =>'Composition max length 500',
					'txt_efficacy.max' => 'Efficacy max length 500',
					'txt_description.max' => 'Description max length 1.000',
					'txt_bpom.max' => 'BPOM max length 20',
					'txt_storage_way.max' => 'Storage way max length 50',
					'txt_dose.max' => 'Dose max length 100',
					'txt_disclaimer.max' => 'Disclaimer max length 50',
				

				]))
				{
					//AMBIL DATA 
					$Id_product= $request->txt_id_product;
					$Status = $request->cb_status;
					$Name = $request->txt_product_name;
					$Id_type = $request->cb_type;
					$Packaging = $request->txt_packaging;
					$Id_brand = $request->cb_brand;
					$Composition = $request->txt_composition;
					$Bpom = $request->txt_bpom;
					$Efficacy = $request->txt_efficacy;
					$Desc = $request->txt_description;
					$Storage = $request->txt_storage_way;
					$Dose = $request->txt_dose;
					$Disclaimer = $request->txt_dose;
					 

					//UBAH VARIATION
					//-----------------------------------------------------------------------
					//AMBIL PRODUCT MODEL SESSION
					$temp = session()->get('product_model');



					//AMBIL VARIASI SESUAI DENGAN ID PRODUK
					$vari =  variation::where('Status','=',1)
					->where('Id_product','=',$Id_product)
					->get();


					//UBAH SEMUA STATUS VARIASI DENGAN ID PRODUK TERTENU JADI 2
					foreach ($vari as $data) {
						$v = new variation();
						$hasil = $v->edit_variation_status($data->Id_variation,2); //UBAH SEMUA KE STATUS 2
					}

					//AMBIL DATA VARIASI DI SESSION
					$datavariasi = session()->get('datavariasi');
					
				
					//AMBIL VARIASI SESUAI DENGAN STATUS 2
					$variasitemp =  variation::where('Status','=',2)
					->where('Id_product','=',$Id_product)
					->get();


					$Variation_name = $request->txt_variation_name;
					$Option_name = $request->option_name;
					$Weight = $request->txt_weight;
					$p = $request->txt_length;
					$l = $request->txt_width;
					$t = $request->txt_height;
					$di = $p."X".$l."X".$t;
					$Dimension = $di;
					$Purchase = $request->txt_purchase_price;
					$Sell = $request->txt_sell_price;
					$Stok = $request->txt_stock;

					if(($temp=="simple") && (count($variasitemp)==1) && ($variasitemp[0]->Variation_name=="NONE"))//Session simple - DB Simple
					{
						//UPDATE
						$v = new variation();
						$hasil = $v->edit_variation($variasitemp[0]->Id_variation ,$Id_product, 'NONE', 'NONE' , $Purchase,$Sell,
						$Weight,$Dimension, $Stok, 1);

						$Variation_name = "NONE";
					}
					else if($temp=="simple") //Session simple - DB variation
					{
						//INSERT NONE /SIMPLE

						$v = new variation();
						$hasil = $v->insertdata ($Id_product, 'NONE', 'NONE', $Purchase,$Sell,
						$Weight,$Dimension, $Stok, 1);


						$Variation_name = "NONE";
					}
					else // Variation- variation atau session variation- db simple
					{
						

						for ($i=0; $i < count($datavariasi) ; $i++) { 
							$Option_name = $datavariasi[$i]['option_name'];
							
							$ada=false;
	
	
							foreach ($variasitemp as $datadb) {
								if($datadb->Option_name == $Option_name)
								{
									//UPDATE
									$ada=true;
									$v = new variation();
									$hasil = $v->edit_variation($datadb->Id_variation ,$Id_product, $Variation_name, $datavariasi[$i]['option_name'], $datavariasi[$i]['purchase_price'],$datavariasi[$i]['sell_price'],
									$datavariasi[$i]['weight'],$datavariasi[$i]['dimension'], $datavariasi[$i]['stock'], 1);
								}
							}
							if($ada==false)
							{
								//INSERT VARIATION BARU
								$v = new variation();
								$hasil = $v->insertdata ($Id_product, $Variation_name, $datavariasi[$i]['option_name'], $datavariasi[$i]['purchase_price'], $datavariasi[$i]['sell_price'],
								$datavariasi[$i]['weight'],$datavariasi[$i]['dimension'], $datavariasi[$i]['stock'], 1);

							
							}
						}

						
	
					}

					
					//UBAH SEMUA YG STATUS 2 jadi 0
					$variasi2 =  variation::where('Status','=',2)
					->where('Id_product','=',$Id_product)
					->get();
					foreach ($variasi2 as $data) {
						$v = new variation();
						$hasil = $v->edit_variation_status($data->Id_variation,0); //UBAH SEMUA KE STATUS 2
					}

					//-----------------------------------------------------------------------
					//-----------------------------------------------------------------------
					// UBAH CATEGORY

					//DELETE CATEGORY LAMA
					$deletecat = new product_sub_category();
					$deletecat->deletedata($Id_product);



					//INPUT CATEGORY BARU
					$datasubcategory = session()->get('datasubcategory');

					for ($i=0; $i<count($datasubcategory); $i++) { 
						$sub = new product_sub_category();
						$idsub = $datasubcategory[$i]['idsubcategory'];
						// echo "<script>alert("+$idsub+") </script>";
						$hasil = $sub->insertdata($Id_product,$idsub);
					}


					$pro = new Product();
					$hasil = $pro->edit_product($Id_product,$Name, $Id_type, $Packaging, $Id_brand,$Composition,
					$Bpom,$Efficacy, $Desc,$Storage,$Dose,$Disclaimer,$Variation_name,$Status);

					

					return view('Master_product', $this->dtproduct());
				}
		}
		
	}




	// public function upload_product_images(Request $request)
	// {
		
	// 	$param['dttype'] = type::all();

	// 	return view('Master_type',$param);
		
		
	// 	// $image_name = $request->image->getClientOriginalName();
	// 	// $request->image->move(public_path('product_images').$image_name);
	// 	// return response()->json(['uploaded'=>'/product_images/'.$image_name]);

	// }

	public function master_category(){
		$param['dtcategory'] = category::where('Status','=',1)
		->get();
		$param['msg'] ="";
		

		return view('Master_category',$param);
	}


	public function master_sub_category(){


		//Untuk milih kategori (cb)
		$dt = category::all(); 
		$arr= [];  // array 
		foreach($dt as $row) {
			if($row->Status==1)
			{
				$arr[$row->Id_category] = $row->Category_name; 
			}
		
		}
		$param['arr']=[];
		$param['arr']  = $arr; 
		//-------------------------------------


		//untuk cetak tabel

		//Contoh join
		$param['dtsub_category'] = sub_category::where('sub_category.id_category','>',-1)
			 ->join('category','sub_category.Id_category','category.Id_category')
			 ->where('sub_category.Status','=',1)
			 ->select('sub_category.Id_sub_category','category.Category_name', 'sub_category.Sub_category_code', 'sub_category.Sub_category_name')
				->get();


		// $param['dtsub_category'] = sub_category::all();


		return view('Master_sub_category', $param);

	}


	public function delete_category(Request $request)
	{
		$Id_category = $request->Id_category;

		$cat = new category();
		$hasil = $cat->deletecategory($Id_category);

		$cat = new sub_category();
		$hasil = $cat->deletesubcategory($Id_category);

		echo "sukses";

	}


	public function delete_sub_category(Request $request)
	{
		$Id_sub = $request->Id_sub;

		$cat = new sub_category();
		$hasil = $cat->deletesubcategory2($Id_sub);

		echo "sukses";
	}

	public function master_team_member(){
		$param['dtteam_member'] = member::where('role','=','ADMIN')
		->orwhere('role','=','CUSTOMER SERVICE')
		->orwhere('role','=','SHIPPER')
		->get();

		return view('Master_team_member',$param);
	}


	public function master_brand(){
		$param['dtbrand'] = brand::where('Status','=',1)
		->get();

		return view('Master_brand',$param);
	}

	public function delete_brand(Request $request)
	{
		$Id_brand = $request->Id_brand;

		$pro = product::where('Status','=',1)
		->where('Id_brand','=',$Id_brand)
		->get();

		if(count($pro)<=0)
		{
			$brand = new brand();
			$hasil = $brand->deletebrand($Id_brand);
	
			echo "sukses";
		}
		else
		{
			echo "producterror";
		}

	
	}

	public function isi_modal_product()
	{
		$temp="";

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

		echo $temp;
	}


	public function isi_modal_product_2()
	{
		$temp="";

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
				$temp=$temp."<button class='btn btn-warning btn-sm' onclick={{select_product_2('".$product[$i]->Id_product."')}}> <i class='fa fa-mouse-pointer' aria-hidden='true'></i> Select </button>";
			$temp=$temp."</td>";
			$temp=$temp."</tr>";
		}

		echo $temp;
	}

	public function master_banner(){
		$param['dtbanner'] = banner::where('Id_banner','>',0)
		->where('banner_position','=',1)
		->join('product','banner.Id_product','product.Id_product')
		->orderby('banner.Urutan')
		->get();

		$param['dtbanner2'] = banner::where('Id_banner','>',0)
		->where('banner_position','=',2)
		->join('product','banner.Id_product','product.Id_product')
		->get();

		$param['msg'] = "";

		return view('Master_banner',$param);
	}

	public function Add_main_banner(Request $request){

		if($request->Add_main_banner){


			if($request->validate(
				[
					'txt_header_banner_1' => ['required','max:50'],
					'txt_content_banner_1' => ['required','max:50'],
					'txt_ctatext_banner_1' => ['required','max:20'],
					'foto' => ['required'],
					'txt_fix_product_id' => ['required']
				],
				[

					'txt_header_banner_1.required' => 'Header banner cannot be empty',
					'txt_header_banner_1.max' => 'Header banner Max 50 Char',

					'txt_content_banner_1.required' => 'Content banner cannot be empty',
					'txt_content_banner_1.max' => 'Content banner Max 50 Char',

					'txt_ctatext_banner_1.required' => 'CTA banner cannot be empty',
					'txt_ctatext_banner_1.max' => 'CTA banner Max 20 Char',

					'txt_fix_product_id.required' => 'Product cannot be empty',

					'foto.required' => 'Photo cannot be empty'
					
					
				

				]))
				{
					//jenn
					
					if($request->hasFile('foto'))
					{
					
						$filefoto = $request->file('foto');
						$extfile = $filefoto->getClientOriginalExtension();
			
						$despath = 'Uploads/Banner';
						$randoman = rand(1,100000);
						$namafile = 'Banner-'.$randoman.'.'.$extfile;
						$filefoto->move($despath,$namafile);
					}
					else
					{
						$namafile = "";
					}

					 $txt_header_banner_1 = $request->txt_header_banner_1;
					 $txt_content_banner_1 = $request->txt_content_banner_1;
					 $txt_ctatext_banner_1 = $request->txt_ctatext_banner_1;
					 $txt_fix_product_id = $request->txt_fix_product_id;

					 $ctrbanner=0;
					$br = banner::where('Banner_position','=',1)
					->get();

					$ctrbanner = count($br);
					$ctrbanner++;

					if($ctrbanner>=6)
					{
						$param['msg'] = "lebih5";

						$param['dtbanner'] = banner::where('Id_banner','>',0)
						->where('banner_position','=',1)
						->join('product','banner.Id_product','product.Id_product')
						->orderby('banner.Urutan')
						->get();
				
						$param['dtbanner2'] = banner::where('Id_banner','>',0)
						->where('banner_position','=',2)
						->join('product','banner.Id_product','product.Id_product')
						->get();
				

						return view('master_banner',$param);
					}
					else
					{
						$banner = new banner();
						$hasil = $banner->add_banner($namafile,$txt_header_banner_1,$txt_content_banner_1,$txt_ctatext_banner_1,$txt_fix_product_id,1,$ctrbanner);
					   
						$param['msg'] = "";

						$param['dtbanner'] = banner::where('Id_banner','>',0)
						->where('banner_position','=',1)
						->join('product','banner.Id_product','product.Id_product')
						->orderby('banner.Urutan')
						->get();

						$param['dtbanner2'] = banner::where('Id_banner','>',0)
						->where('banner_position','=',2)
						->join('product','banner.Id_product','product.Id_product')
						->get();


						return view('master_banner',$param);
					
					}
					

						
					
				}
		}
	}

	public function Edit_main_banner(Request $request){

		if($request->Edit_main_banner){


			if($request->validate(
				[
					'txt_header_banner_1_edit' => ['required','max:50'],
					'txt_content_banner_1_edit' => ['required','max:50'],
					'txt_ctatext_banner_1_edit' => ['required','max:20'],
					'txt_fix_product_id_1_edit' => ['required']
				],
				[

					'txt_header_banner_1_edit.required' => 'Header banner cannot be empty',
					'txt_header_banner_1_edit.max' => 'Header banner Max 50 Char',

					'txt_content_banner_1_edit.required' => 'Content banner cannot be empty',
					'txt_content_banner_1_edit.max' => 'Content banner Max 50 Char',

					'txt_ctatext_banner_1_edit.required' => 'CTA banner cannot be empty',
					'txt_ctatext_banner_1_edit.max' => 'CTA banner Max 20 Char',

					'txt_fix_product_id_1_edit.required' => 'Product cannot be empty',

					
				]))
				{
					//jenn
					
					if($request->hasFile('foto_1_edit'))
					{
					
						$filefoto = $request->file('foto_1_edit');
						$extfile = $filefoto->getClientOriginalExtension();
			
						$despath = 'Uploads/Banner';
						$randoman = rand(1,100000);
						$namafile = 'Banner-'.$randoman.'.'.$extfile;
						$filefoto->move($despath,$namafile);
					}
					else
					{
						$namafile = "";
					}

					$txt_id_banner_1_edit = $request->txt_id_banner_1_edit;
					 $txt_header_banner_1_edit = $request->txt_header_banner_1_edit;
					 $txt_content_banner_1_edit = $request->txt_content_banner_1_edit;
					 $txt_ctatext_banner_1_edit = $request->txt_ctatext_banner_1_edit;
					 $txt_fix_product_id_1_edit = $request->txt_fix_product_id_1_edit;
					 $txt_banner_order_1_edit = $request->txt_banner_order_1_edit;


					 $ctrbanner=0;
					$br = banner::where('Banner_position','=',1)
					->get();

					$ctrbanner = count($br);
					
					if($ctrbanner<$txt_banner_order_1_edit)
					{
						$param['msg'] = "ordererror";

						$param['dtbanner'] = banner::where('Id_banner','>',0)
						->where('banner_position','=',1)
						->join('product','banner.Id_product','product.Id_product')
						->orderby('banner.Urutan')
						->get();
				
						$param['dtbanner2'] = banner::where('Id_banner','>',0)
						->where('banner_position','=',2)
						->join('product','banner.Id_product','product.Id_product')
						->get();
				

						return view('master_banner',$param);
					}
					else
					{
						$banner = new banner();
						$hasil = $banner->edit_banner($namafile,$txt_id_banner_1_edit,$txt_header_banner_1_edit,$txt_content_banner_1_edit,$txt_ctatext_banner_1_edit,$txt_fix_product_id_1_edit,$txt_banner_order_1_edit);
					   
						$param['msg'] = "";
	
						$param['dtbanner'] = banner::where('Id_banner','>',0)
						->where('banner_position','=',1)
						->join('product','banner.Id_product','product.Id_product')
						->orderby('banner.Urutan')
						->get();
	
						$param['dtbanner2'] = banner::where('Id_banner','>',0)
						->where('banner_position','=',2)
						->join('product','banner.Id_product','product.Id_product')
						->get();
	
	
						return view('master_banner',$param);
					}


				
				

					
				}
		}
	}


	public function Add_main_banner_2(Request $request){

		if($request->Add_main_banner_2){


			if($request->validate(
				[
					'txt_header_banner_2' => ['required','max:50'],
					'txt_ctatext_banner_2' => ['required','max:20'],
					'foto_2' => ['required'],
					'txt_fix_product_id_2' => ['required']
				],
				[

					'txt_header_banner_2.required' => 'Header banner cannot be empty',
					'txt_header_banner_2.max' => 'Header banner Max 50 Char',

					'txt_ctatext_banner_2.required' => 'CTA banner cannot be empty',
					'txt_ctatext_banner_2.max' => 'CTA banner Max 20 Char',

					'txt_fix_product_id_2.required' => 'Product cannot be empty',

					'foto_2.required' => 'Photo cannot be empty'
					
					
				

				]))
				{
					//jenn
					
					if($request->hasFile('foto_2'))
					{
					
						$filefoto = $request->file('foto_2');
						$extfile = $filefoto->getClientOriginalExtension();
			
						$despath = 'Uploads/Banner';
						$randoman = rand(1,100000);
						$namafile = 'Banner_2-'.$randoman.'.'.$extfile;
						$filefoto->move($despath,$namafile);
					}
					else
					{
						$namafile = "";
					}

					 $txt_header_banner_2 = $request->txt_header_banner_2;
					 $txt_content_banner_2 = $request->txt_content_banner_2;
					 $txt_ctatext_banner_2 = $request->txt_ctatext_banner_2;
					 $txt_fix_product_id_2 = $request->txt_fix_product_id_2;

					 $ctrbanner=0;
					$br = banner::where('Banner_position','=',2)
					->get();

					$ctrbanner = count($br);
					$ctrbanner++;

					if($ctrbanner>=2)
					{
						$param['msg'] = "lebih1";

						$param['dtbanner'] = banner::where('Id_banner','>',0)
						->where('banner_position','=',1)
						->join('product','banner.Id_product','product.Id_product')
						->orderby('banner.Urutan')
						->get();
				
						$param['dtbanner2'] = banner::where('Id_banner','>',0)
						->where('banner_position','=',2)
						->join('product','banner.Id_product','product.Id_product')
						->get();
				

						return view('master_banner',$param);
					}
					else
					{
						$banner = new banner();
						$hasil = $banner->add_banner_2($namafile,$txt_header_banner_2,$txt_ctatext_banner_2,$txt_fix_product_id_2);
					   
						$param['msg'] = "";

						$param['dtbanner'] = banner::where('Id_banner','>',0)
						->where('banner_position','=',1)
						->join('product','banner.Id_product','product.Id_product')
						->orderby('banner.Urutan')
						->get();

						$param['dtbanner2'] = banner::where('Id_banner','>',0)
						->where('banner_position','=',2)
						->join('product','banner.Id_product','product.Id_product')
						->get();


						return view('master_banner',$param);
					
					}
					

						
					
				}
		}
	}

	public function Edit_main_banner_2(Request $request){

		if($request->Edit_main_banner_2){


			if($request->validate(
				[
					'txt_header_banner_2_edit' => ['required','max:50'],
					'txt_ctatext_banner_2_edit' => ['required','max:20'],
					'txt_fix_product_id_2_edit' => ['required']
				],
				[

					'txt_header_banner_2_edit.required' => 'Header banner cannot be empty',
					'txt_header_banner_2_edit.max' => 'Header banner Max 50 Char',

					'txt_ctatext_banner_2_edit.required' => 'CTA banner cannot be empty',
					'txt_ctatext_banner_2_edit.max' => 'CTA banner Max 20 Char',

					'txt_fix_product_id_2_edit.required' => 'Product cannot be empty',

					
				]))
				{
					//jenn
					
					if($request->hasFile('foto_2_edit'))
					{
					
						$filefoto = $request->file('foto_2_edit');
						$extfile = $filefoto->getClientOriginalExtension();
			
						$despath = 'Uploads/Banner';
						$randoman = rand(1,100000);
						$namafile = 'Banner_2-'.$randoman.'.'.$extfile;
						$filefoto->move($despath,$namafile);
					}
					else
					{
						$namafile = "";
					}

					$txt_id_banner_2_edit = $request->txt_id_banner_2_edit;
					 $txt_header_banner_2_edit = $request->txt_header_banner_2_edit;
					 $txt_ctatext_banner_2_edit = $request->txt_ctatext_banner_2_edit;
					 $txt_fix_product_id_2_edit = $request->txt_fix_product_id_2_edit;



					 $banner = new banner();
					$hasil = $banner->edit_banner_2($namafile,$txt_id_banner_2_edit,$txt_header_banner_2_edit,$txt_ctatext_banner_2_edit,$txt_fix_product_id_2_edit);
				   
					$param['msg'] = "";

					$param['dtbanner'] = banner::where('Id_banner','>',0)
					->where('banner_position','=',1)
					->join('product','banner.Id_product','product.Id_product')
					->orderby('banner.Urutan')
					->get();

					$param['dtbanner2'] = banner::where('Id_banner','>',0)
					->where('banner_position','=',2)
					->join('product','banner.Id_product','product.Id_product')
					->get();


					return view('master_banner',$param);


					//  $ctrbanner=0;
					// $br = banner::where('Banner_position','=',2)
					// ->get();

					// $ctrbanner = count($br);
					
					// if($ctrbanner<1)
					// {
					// 	$param['msg'] = "ordererror";

					// 	$param['dtbanner'] = banner::where('Id_banner','>',0)
					// 	->where('banner_position','=',1)
					// 	->join('product','banner.Id_product','product.Id_product')
					// 	->orderby('banner.Urutan')
					// 	->get();
				
					// 	$param['dtbanner2'] = banner::where('Id_banner','>',0)
					// 	->where('banner_position','=',2)
					// 	->join('product','banner.Id_product','product.Id_product')
					// 	->get();
				

					// 	return view('master_banner',$param);
					// }
					// else
					// {
						
					// }


					
				

					
				}
		}
	}


	public function get_data_banner(Request $request)
	{
		$Id_banner = $request->Id_banner;

		$banner = banner::where('banner.Id_banner','=',$Id_banner)
		->join('product','banner.Id_product','product.Id_product')
		->get();

		echo $banner;
	}

	public function delete_banner(Request $request)
	{
		$Id_banner = $request->Id_banner;

		$banner = new banner();
		$hasil = $banner->delete_banner($Id_banner);
	}


	public function get_product_detail(Request $request)
	{
		$Id_product = $request->Id_product;

		$product = product::where('product.Status','=', '1')
		->join('brand','product.Id_brand','brand.Id_brand')
		->join('type','product.Id_type','type.Id_type')
		->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
		"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
		->where('product.Id_product','=',$Id_product)	
		->get();

		$temp="";
		foreach ($product as $data) {
			$temp = $data->Id_product."||".$data->Name;
		}

		echo $temp;

	}

	public function master_bank(){
		$param['dtbank'] = bank::where('Status','=',1)
		->get();

		return view('Master_bank',$param);
	}

	public function validasipromo()
	{
		$promo = promo_header::where('Status','<>',0)
		->get();

		// print_r('aaaaccca');
		// echo "aadsd";
		foreach ($promo as $data) {
			if($data->End_date < date('Y-m-d'))
			{
				//expire lewat tanggal
				$p = new promo_header();
				$hasil = $p->changestatus($data->Id_promo,2); //exp 2
			}
			else if((date('Y-m-d') >= $data->Start_date) && (date('Y-m-d')<= $data->End_date) && ($data->Status==3))
			{

				//Ubah jadi active yg dalam range waktu
				$p = new promo_header();
				$hasil = $p->changestatus($data->Id_promo,1);
			}
		}
	}

//adriel
	public function master_promo(){

		$this->validasipromo();

		session()->forget('discount_session');
		session()->forget('minqty_session');


		$param['dtheaderpromo'] = promo_header::join('product','promo_header.Id_product','product.Id_product')
		->join('variation_product','promo_header.Id_variation','variation_product.Id_variation')
		->select('promo_header.Id_promo','product.Name','variation_product.Option_name', 'promo_header.Start_date', 'promo_header.End_date', 'promo_header.Status')
		->where('promo_header.Status','<>',0)
			->get();


		$param['dtdetailpromo'] = promo_detail::all();

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


		return view('Master_promo',$param);
	}



	public function add_promo_session(Request $request)
	{
		$discount_session = [];
		$minqty_session = [];
		$tes=false;
		try {

			$discount_session= session()->get('discount_session');
			$minqty_session = session()->get('minqty_session');

		} catch (\Throwable $th) {
			$discount_session = [];
			$minqty_session = [];
		}



		try {
			if(count($discount_session)==0)
			{
				
			}
		} catch (\Throwable $th) {
			
			//pertama
			$discount_session = [];
			$minqty_session = [];
			$tes=true;
		}
		
		
		$discount = $request->discount;
		$minqty = $request->minqty;

		if(in_array($minqty, $minqty_session))
		{
			print_r('qtysama');
		}
		else
		{
			array_push($discount_session, $discount);
			array_push($minqty_session, $minqty);
		
			try {
				session()->forget('discount_session');
				session()->forget('minqty_session');
			} catch (\Throwable $th) {
				
			}
			
			session()->put('discount_session', $discount_session);
			session()->put('minqty_session', $minqty_session);
	
	
			$titip = $this->show_table_promo();
			print_r($titip);
		}


		
	}

	public function show_table_promo()
	{
		$temp="";
		$discount_session= session()->get('discount_session');
		$minqty_session= session()->get('minqty_session');

		for ($i=0; $i < count($discount_session) ; $i++) { 
			
			$temp =$temp. "<tr>";
				$temp =$temp. "<td>";
					$temp =$temp.$minqty_session[$i];
				$temp =$temp. "</td>";
				$temp =$temp. "<td>";
					$temp =$temp.$discount_session[$i];
				$temp =$temp. "</td>";
				$temp =$temp. "<td>";
					$temp =$temp. "<button type='button' class='btn btn-danger btn-sm' onclick='deletepromo($i)'> Delete </button>";
				$temp =$temp. "</td>";
			$temp =$temp. "</tr>";
				
		}
		

		return($temp);
	}

	public function reset_promo_session(Request $request)
	{
		session()->forget('discount_session');
		session()->forget('minqty_session');
	}

	public function delete_promo_session(Request $request)
	{
		$x = $request->x;

		$discount_session= session()->get('discount_session');
		$minqty_session = session()->get('minqty_session');

		$discount_session_baru=[];
		$minqty_session_baru=[];

		for ($i=0; $i < count($discount_session) ; $i++) { 
			if($i == $x)
			{

			}
			else
			{
				array_push($discount_session_baru,$discount_session[$i]);
				array_push($minqty_session_baru, $minqty_session[$i]);
			}
		}


		session()->forget('discount_session');
		session()->forget('minqty_session');

		
		session()->put('discount_session', $discount_session_baru);
		session()->put('minqty_session', $minqty_session_baru);

		$titip = $this->show_table_promo();
		print_r($titip);
	}


	public function add_promo(Request $request)
	{
		$Id_product = $request->Id_product;
		$Id_variation = $request->Id_variation;
		$Start_date = str_replace("/", "-", $request->Start_date);
		 $End_date = str_replace("/", "-", $request->End_date);
		$Model = $request->Model;
   
	//  print_r($Id_product.$Id_variation.$Start_date.$End_date.$Model);
		try 
		{
			// print_r("sini");
			if(count(session()->get('discount_session'))<=0)
			{
				print_r('fail');
			}
			else
			{
				// echo "sini"; 
				// $promo_header = promo_header::select('promo_header.Id_product','promo_header.Id_variation', 'promo_header.Start_date', 'promo_header.End_date', 'promo_header.Status')
				// 	->get();

				$promo_header = promo_header::where('Id_variation', '=', $Id_variation)
				->get();
		
				// echo count($promo_header); 
				// echo $Start_date; 
				$nabrak= 0;
				for ($i=0; $i < count($promo_header); $i++) { 
					// echo "\nkode variasi = ".$promo_header[$i]['Id_variation'];
					if($promo_header[$i]['Id_variation'] == $Id_variation && $promo_header[$i]['Status'] == 1)
					{
						// echo "\n"; 
						// echo "id-variation\n"; 
						// echo $promo_header[$i]['Id_variation']."---".$Id_variation;
						// echo "\n"; 
						$hari = 0;
						do {
							$nextdate = date('Y-m-d',strtotime($Start_date.' +'.$hari.' day'));
							
							// echo "\n"; 
							// echo $promo_header[$i]['Start_date'];
							// echo $promo_header[$i]['End_date'];
							// echo "\n"; 
							if((strtotime($nextdate) >= strtotime($promo_header[$i]['Start_date'])) && (strtotime($nextdate) <= strtotime($promo_header[$i]['End_date'])))
							{
								$nabrak = 1;
							}
							// echo $nextdate."//".$End_date;
							$hari++;
						} 
						while ($nextdate != $End_date);
					}
				}
				// echo "step sini"; 
		
				if($nabrak==0)
				{
					$Comingsoon = $request->Comingsoon;
					$promo = new promo_header();
					$hasil = $promo->add_promo($Id_product,$Id_variation,$Start_date,$End_date,$Model,$Comingsoon);
					$discount = session()->get('discount_session');
					$minqty = session()->get('minqty_session');
				
					$lastid = $promo->getlastid();
				
					for ($i=0; $i < count($discount); $i++) { 
					$detail = new promo_detail();
					$hasil2 = $detail->add_detail_promo($lastid,$minqty[$i],$discount[$i]);
				
					}
					print_r('sukses');
				}
				else
				{
					print_r('failperiod');
				}
	
			}
		} 
		catch (\Throwable $th) {
			print_r('fail2');
		}
	}

	public function get_data_promo(Request $request)
	{
		$Id_promo = $request->id;

		$temp="";

		$promo_header = promo_header::where('promo_header.Id_promo', '=', $Id_promo)
		->join('product','promo_header.Id_product','product.Id_product')
		->join('variation_product','promo_header.Id_variation','variation_product.Id_variation')
		->select('promo_header.Id_promo','promo_header.Id_product','promo_header.Id_variation',
		'promo_header.Start_date','promo_header.End_date','promo_header.Model','promo_header.Status','product.Name',
		'variation_product.Option_name')
		 ->where('promo_header.Status','<>',0)
		->get();


		foreach ($promo_header as $data) {
			$temp = $temp . $data->Id_product . "#" . $data->Id_variation . "#" . date("d-m-Y", strtotime($data->Start_date))  . "#" . date("d-m-Y", strtotime($data->End_date)). "#" .$data->Model;
		}
		
		$promo_detail = promo_detail::where('Id_promo','=',$Id_promo)
		->get();


		$discount_session = [];
		$minqty_session = [];
		foreach ($promo_detail as $data) {
			array_push($discount_session, $data->Discount);
			array_push($minqty_session, $data->Minimum_qty);
		}


	
		try {
			session()->forget('discount_session');
			session()->forget('minqty_session');
		} catch (\Throwable $th) {
			
		}
		
		session()->put('discount_session', $discount_session);
		session()->put('minqty_session', $minqty_session);


		$titip = $this->show_table_promo();
		// print_r($titip);


		echo $temp."#". $titip;



	}


	public function delete_promo(Request $request)
	{

		$Id_promo = $request->Id_promo;
		$header = new promo_header();
		$deleteheader = $header->deletepromoheader($Id_promo);


		
		$detail = new promo_detail();
		$deletedetail = $detail->deletepromodetail($Id_promo);


	}

	public function master_voucher(Request $request)
	{
		$param['dtvoucher'] = voucher::where('Status','<>',0)
		->select('Id_voucher','Voucher_name',\DB::raw('(CASE WHEN Voucher_type = 1 THEN "Disc All Product" WHEN Voucher_type = 2 THEN "Disc Selected Product" ELSE "Disc Shipping Cost" END) AS Voucher_type'),'Discount','Point','Redeem_due_date','Joinpromo','Status')
		->get();
		// \DB::raw('(CASE WHEN product.status = 1 THEN "Active" ELSE "Non-Active" END) AS status_user')
		return view('Master_voucher',$param);
	}


	public function master_voucher_add(Request $request)
	{
		// session()->forget('session_product_voucher');
		session()->forget('session_product_supplier');


		$param['dtproduct'] = product::where('product.Status','=', '1')
		->join('brand','product.Id_brand','brand.Id_brand')
		->join('type','product.Id_type','type.Id_type')
		->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
		"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
			->get();


		$param['dtvariationname'] = variation::where('Status','=',1)
		->select("Option_name","Id_product")
		->get();

		$param['dtproductimage'] = Product_image::all();

		session()->put('tipe_voucher',1);
		// session()->put('tipe_voucher_product',"all");


		$param['msg'] = "";
		$param['msgerror'] = "";
		return view('Master_voucher_add',$param);
	}


	public function session_tipe_voucher(Request $request)
	{
		//adrieledgard
		$tipe = $request->tipe;

		session()->forget('tipe_voucher');
		session()->put('tipe_voucher',$tipe);

		echo session()->get('tipe_voucher');

	}


	public function add_voucher(Request $request){
		
		if($request->add_voucher){


			if($request->validate(
				[
					'txt_voucher_name' => ['required','max:30'],
					'txt_discount' => ['required', 'min:1','max:11'],
					'txt_date' => ['required'],
					'txt_quota' => ['required','min:1'],
				],
				[
					'txt_voucher_name.required' => 'Voucher name cannot be empty',
					'txt_voucher_name.max' => 'Voucher name max length 30',
					'txt_discount.required' => 'Discount cannot be empty',
					'txt_discount.min' => 'Please insert discount',
					'txt_discount.max' => 'Error discount. >max length',
					'txt_date.required' => 'Redeem due date cannot empty',
					'txt_quota.required' => 'Quota cannot empty',
					'txt_quota.min' => 'Quota must > 1',

				]))
				{
					$voucher_name = $request->txt_voucher_name;
					$discount = $request->txt_discount;
					$point=$request->txt_point;
					$joinpromo=$request->select_promo;
					$quota = $request->txt_quota;

					$redeem_due_date = $request->txt_date;
					//04/01/2020
					$tempredeem = $redeem_due_date[6].$redeem_due_date[7].$redeem_due_date[8].$redeem_due_date[9]."-".$redeem_due_date[3].$redeem_due_date[4]."-".$redeem_due_date[0].$redeem_due_date[1];
					$redeem_due_date = $tempredeem;

					$tipe = session()->get('tipe_voucher');
					$ctr=0;
					if($tipe==2)
					{
						
						try {

							$tampung = session()->get('session_product_supplier');

							
							foreach ($tampung as $data) {
								$ctr++;
							}

						} catch (\Throwable $th) {
							$ctr=0;
						}
						
						if($ctr==0)
						{
							//Untuk return Master_voucher_add
							$this->mastervoucheradd();

							$param['msg'] = "productfail";

							return view('Master_voucher_add',$param);
						}
						else
						{
							$voucher = new voucher();
							$hasil = $voucher->add_voucher($voucher_name, $tipe, $discount,$point,$redeem_due_date,$joinpromo, $quota);

							$lastid = $voucher->getlastid();

							foreach ($tampung as $data) {
								$voupro = new voucher_product();
								$hasil = $voupro->add_voucher_product($lastid, $data);
							}
							$param['dtvoucher'] = voucher::where('Status','<>',0)
							->select('Id_voucher','Voucher_name',\DB::raw('(CASE WHEN Voucher_type = 1 THEN "Disc All Product" WHEN Voucher_type = 2 THEN "Disc Selected Product" ELSE "Disc Shipping Cost" END) AS Voucher_type'),'Discount','Point','Redeem_due_date','Joinpromo','Status','Status')
							// ->select('Id_voucher','Voucher_name',\DB::raw('(CASE WHEN Voucher_type = 1 THEN "Disc All Product" WHEN Voucher_type = 2 THEN "Disc Selected Product" ELSE "Disc Shipping Cost" END) AS Voucher_type'),'Discount')
							->get();
							return view('Master_voucher',$param);
							
						}
					}
					else
					{
						$voucher = new voucher();
						$hasil = $voucher->add_voucher($voucher_name, $tipe, $discount,$point,$redeem_due_date,$joinpromo, $quota);
						
						$param['dtvoucher'] = voucher::where('Status','<>',0)
						->select('Id_voucher','Voucher_name',\DB::raw('(CASE WHEN Voucher_type = 1 THEN "Disc All Product" WHEN Voucher_type = 2 THEN "Disc Selected Product" ELSE "Disc Shipping Cost" END) AS Voucher_type'),'Discount','Point','Redeem_due_date','Joinpromo','Status','Status')
						// ->select('Id_voucher','Voucher_name',\DB::raw('(CASE WHEN Voucher_type = 1 THEN "Disc All Product" WHEN Voucher_type = 2 THEN "Disc Selected Product" ELSE "Disc Shipping Cost" END) AS Voucher_type'),'Discount')
						->get();
						return view('Master_voucher',$param);
					}


				}
		}
		
	}






	public function edit_voucher(Request $request){
		
		if($request->edit_voucher){


			if($request->validate(
				[
					'txt_voucher_name' => ['required','max:30'],
					'txt_discount' => ['required', 'min:1','max:11'],
					'txt_date' => ['required']

				],
				[
					'txt_voucher_name.required' => 'Voucher name cannot be empty',
					'txt_voucher_name.max' => 'Voucher name max length 30',
					'txt_discount.required' => 'Discount cannot be empty',
					'txt_discount.min' => 'Please insert discount',
					'txt_discount.max' => 'Error discount. >max length',
					'txt_date.required' => 'Redeem due date cannot empty'

				]))
				{

					$Id_voucher = $request->txt_id_voucher;


					$voucher_name = $request->txt_voucher_name;
					$discount = $request->txt_discount;
					$point=$request->txt_point;
					$joinpromo=$request->select_promo;

					$redeem_due_date = $request->txt_date;
					//04/01/2020
					$tempredeem = $redeem_due_date[6].$redeem_due_date[7].$redeem_due_date[8].$redeem_due_date[9]."-".$redeem_due_date[3].$redeem_due_date[4]."-".$redeem_due_date[0].$redeem_due_date[1];
					$redeem_due_date = $tempredeem;

					$tipe = session()->get('tipe_voucher');
					$ctr=0;
					if($tipe==2)
					{
						//voucher produk dengan Id_voucher hapus semua terlebih dahulu
						$voupro = new voucher_product();
						$hasil = $voupro->delete_voucher_product($Id_voucher);



						try {

							$tampung = session()->get('session_product_supplier');

							
							foreach ($tampung as $data) {
								$ctr++;
							}

						} catch (\Throwable $th) {
							$ctr=0;
						}
						
						if($ctr==0)
						{
							//Untuk return Master_voucher_add
							$this->mastervoucheradd();

							$param['msg'] = "productfail";

							return view('Master_voucher_add',$param);
						}
						else
						{
							$voucher = new voucher();
							// $hasil = $voucher->add_voucher($voucher_name, $tipe, $discount);
							$hasil = $voucher->edit_voucher($Id_voucher,$voucher_name, $tipe, $discount,$point,$redeem_due_date,$joinpromo);
							// $lastid = $voucher->getlastid();

							foreach ($tampung as $data) {
								$voupro = new voucher_product();
								$hasil = $voupro->add_voucher_product($Id_voucher, $data);
							}
							$param['dtvoucher'] = voucher::where('Status','<>',0)
							->select('Id_voucher','Voucher_name',\DB::raw('(CASE WHEN Voucher_type = 1 THEN "Disc All Product" WHEN Voucher_type = 2 THEN "Disc Selected Product" ELSE "Disc Shipping Cost" END) AS Voucher_type'),'Discount','Point','Redeem_due_date','Joinpromo','Status','Status')
							// ->select('Id_voucher','Voucher_name',\DB::raw('(CASE WHEN Voucher_type = 1 THEN "Disc All Product" WHEN Voucher_type = 2 THEN "Disc Selected Product" ELSE "Disc Shipping Cost" END) AS Voucher_type'),'Discount')
							->get();
							return view('Master_voucher',$param);
							
						}
					}
					else
					{

						//voucher produk dengan Id_voucher hapus semua
						$voupro = new voucher_product();
						$hasil = $voupro->delete_voucher_product($Id_voucher);



						$voucher = new voucher();
						// $hasil = $voucher->add_voucher($voucher_name, $tipe, $discount);
						$hasil = $voucher->edit_voucher($Id_voucher,$voucher_name, $tipe, $discount,$point,$redeem_due_date,$joinpromo);
						
						$param['dtvoucher'] = voucher::where('Status','<>',0)
						->select('Id_voucher','Voucher_name',\DB::raw('(CASE WHEN Voucher_type = 1 THEN "Disc All Product" WHEN Voucher_type = 2 THEN "Disc Selected Product" ELSE "Disc Shipping Cost" END) AS Voucher_type'),'Discount','Point','Redeem_due_date','Joinpromo','Status','Status')
						// ->select('Id_voucher','Voucher_name',\DB::raw('(CASE WHEN Voucher_type = 1 THEN "Disc All Product" WHEN Voucher_type = 2 THEN "Disc Selected Product" ELSE "Disc Shipping Cost" END) AS Voucher_type'),'Discount')
						->get();
						return view('Master_voucher',$param);
					}


				}
		}
		
	}

	public function delete_voucher(Request $request)
	{
		$Id_voucher = $request->Id_voucher;

		$vc = new Voucher();
		$hasil = $vc->changestatus($Id_voucher,0);

		echo "sukses";
	}

	public function Master_voucher_detail($id)
	{
		session()->forget('session_product_supplier');

		$Id_voucher = $id;

		$param['dtvoucher'] = voucher::where('Status','<>',0)
		->where('Id_voucher','=',$Id_voucher)
		->get();

		$param['dtvoucherproduct'] = voucher_product::where('Id_voucher','=',$Id_voucher)
		->get();
		
		$voucherproduct = $param['dtvoucherproduct'];

		//session
		session()->forget('tipe_voucher');
		session()->put('tipe_voucher',$param['dtvoucher'][0]['Voucher_type']);


		//untuk masukan session jika type 2
		if($param['dtvoucher'][0]['Voucher_type']==2)
		{
			$arr_id_product=[];
			for ($i=0; $i < count($voucherproduct); $i++) { 
				array_push($arr_id_product,$voucherproduct[$i]['Id_product']);
			}
			session()->put('session_product_supplier',$arr_id_product);
		}
		


		//menghitung kuota voucher yg sdh di pake
		$param['quotaterpakai'] = voucher_member::where('Id_voucher','=',$Id_voucher)->count();
		
		
		return view('Master_voucher_detail',$param);
	}
















	public function get_variation_product(Request $request)
    {
        $va = new Product();
		echo $va->getvariation($request->Id_product);

    }


	public function delete_bank(Request $request)
	{
		$Id_bank= $request->Id_bank;

		$bank = new bank();
		$hasil = $bank->deletebank($Id_bank);

		echo "sukses";
	}


	public function master_type(){
		$param['dttype'] = type::where('Status','=',1)
		->get();

		return view('Master_type',$param);
	}
	

	public function delete_type(Request $request)
	{

		
		$Id_type = $request->Id_type;

		$pro = product::where('Status','=',1)
		->where('Id_type','=',$Id_type)
		->get();

		if(count($pro)<=0)
		{
			$type = new type();
			$hasil = $type->deletetype($Id_type);
	
			echo "sukses";
		}
		else
		{
			echo "producterror";
		}

		

		
	}
	

	public function add_category(Request $request){
		
		if($request->add_category){


			if($request->validate(
				[
					'txt_category_code' => ['required','max:4'],
					'txt_category_name' => ['required', 'max:50']

				],
				[
					'txt_category_code.required' => 'Category code cannot be empty',
					'txt_category_code.max' => 'Category code max length 4',
					'txt_category_name.required' => 'Category name cannot be empty',
					'txt_category_name.max' => 'Category name max length 50',

				]))
				{
					$category_code = $request->txt_category_code;
					$category_name = $request->txt_category_name;

					$cat = new category();
					$hasil = $cat->add_category($category_code,$category_name);

					if($hasil == "failed")
					{
						$param['dtcategory'] = category::where('Status','=',1)
						->get();

						
						$param['msg'] = "fail";
						return view('Master_category',$param);
					}
					else
					{
						$param['dtcategory'] = category::where('Status','=',1)
						->get();

						$param['msg'] = "sukses";
						// echo "<script type='text/javascript'>toastr['success']('Success', 'Success')</script>";
						// echo "<script>toastr['success']('Success', 'Success')</script>";
						return view('Master_category',$param);
					}
				}
		}
		
	}


	public function edit_category(Request $request){
		
		if($request->edit_category){


			if($request->validate(
				[
					'txt_category_code' => ['required','max:4'],
					'txt_category_name' => ['required', 'max:50']

				],
				[
					'txt_category_code.required' => 'Category code cannot be empty',
					'txt_category_code.max' => 'Category code max length 4',
					'txt_category_name.required' => 'Category name cannot be empty',
					'txt_category_name.max' => 'Category name max length 50',

				]))
				{

					$id_category = $request->id_category;
					$category_code = $request->txt_category_code;
					$category_name = $request->txt_category_name;

					$cat = new category();
					$hasil = $cat->edit_category($id_category ,$category_code,$category_name);

					if($hasil == "failed")
					{
						$param['msg_err'] = "Update Failed, Category code/category name maybe already exist !";
						
						$param['dtcategory'] = category::where('Status','=',1)
						->get();

						return view('Master_category',$param);
					}
					else
					{
						$param['dtcategory'] = category::where('Status','=',1)
						->get();

						$param['msg'] = "Data saved";
						return view('Master_category',$param);
					}
				}
		}
		
	}

 
	public function add_sub_category(Request $request){
		
		if($request->add_sub_category){


			if($request->validate(
				[
					'cb_category' => ['required'],
					'txt_sub_category_code' => ['required','max:4'],
					'txt_sub_category_name' => ['required', 'max:50']

				],
				[
					'cb_category.required' => 'category cannot be empty',
					'txt_sub_category_code.required' => 'Sub category code cannot be empty',
					'txt_sub_category_code.max' => 'Sub category code  max length 4',
					'txt_sub_category_name.required' => 'Sub category name cannot be empty',
					'txt_sub_category_name.max' => 'Sub category name max length 50',

				]))
				{
					$id_category =  $request->cb_category;
					$sub_category_code = $request->txt_sub_category_code;
					$sub_category_name = $request->txt_sub_category_name;


					$cat = new sub_category();
					$hasil = $cat->add_sub_category($id_category,$sub_category_code,$sub_category_name);

					if($hasil == "failed")
					{
						$param['msg_err'] = "Insert Failed !";
						// 	$param['dtcategory'] = category::where('Status','<>','0');

						// return view('Master_sub_category',$param);
						$dt = category::all(); 
						$arr= [];  // array 
						foreach($dt as $row) {
							if($row->Status==1)
							{
								$arr[$row->Id_category] = $row->Category_name; 
							}
					
						}
						
						$param['arr']  = $arr; 


						//untuk cetak tabel
						$param['dtsub_category'] = sub_category::where('sub_category.id_category','>',-1)
						->join('category','sub_category.Id_category','category.Id_category')
						->where('sub_category.Status','=',1)
						->select('sub_category.Id_sub_category','category.Category_name', 'sub_category.Sub_category_code', 'sub_category.Sub_category_name')
							->get();

						return view('Master_sub_category', $param);
					}
					else
					{
						
						$param['msg'] = "Insert Success !";

						$dt = category::all(); 
						$arr= [];  // array 
						foreach($dt as $row) {
							if($row->Status==1)
							{
								$arr[$row->Id_category] = $row->Category_name; 
							}
						
						}
						
						$param['arr']  = $arr; 

						//untuk cetak tabel
						$param['dtsub_category'] = sub_category::where('sub_category.id_category','>',-1)
						->join('category','sub_category.Id_category','category.Id_category')
						->where('sub_category.Status','=',1)
						->select('sub_category.Id_sub_category','category.Category_name', 'sub_category.Sub_category_code', 'sub_category.Sub_category_name')
						   ->get();
		   

						return view('Master_sub_category', $param);
				
				
				
					}
				}
			
		}
		
	}


	public function edit_sub_category(Request $request){
		
		if($request->edit_sub_category){


			if($request->validate(
				[
					'cb_category' => ['required'],
					'txt_sub_category_code' => ['required','max:4'],
					'txt_sub_category_name' => ['required', 'max:50']

				],
				[
					'cb_category.required' => 'category cannot be empty',
					'txt_sub_category_code.required' => 'Sub category code cannot be empty',
					'txt_sub_category_code.max' => 'Sub category code  max length 4',
					'txt_sub_category_name.required' => 'Sub category name cannot be empty',
					'txt_sub_category_name.max' => 'Sub category name max length 50',

				]))
				{

					$id_sub_category = $request->id_sub_category;
					$id_category = $request->cb_category;
					$sub_category_code = $request->txt_sub_category_code;
					$sub_category_name = $request->txt_sub_category_name;

					$cat = new sub_category();
					$hasil = $cat->edit_sub_category($id_sub_category,$id_category ,$sub_category_code,$sub_category_name);

					if($hasil == "failed")
					{
						$dt = category::all(); 
						$arr= [];  // array 
						foreach($dt as $row) {
							if($row->Status==1)
							{
								$arr[$row->Id_category] = $row->Category_name; 
							}
						
						}
						
						$param['arr']  = $arr; 

						//untuk cetak tabel
						$param['dtsub_category'] = sub_category::where('sub_category.id_category','>',-1)
						->join('category','sub_category.Id_category','category.Id_category')
						->where('sub_category.Status','=',1)
						->select('sub_category.Id_sub_category','category.Category_name', 'sub_category.Sub_category_code', 'sub_category.Sub_category_name')
							->get();



						$param['msg_err'] = "Update Failed,Sub Category code/ Sub category name maybe already exist !";
						
						return view('Master_sub_category',$param);
					}
					else
					{
						
						$dt = category::all(); 
						$arr= [];  // array 
						foreach($dt as $row) {
							if ($row->Status==1)
							{
								$arr[$row->Id_category] = $row->Category_name; 
							}
						}
						
						$param['arr']  = $arr; 

						$param['dtsub_category'] = sub_category::where('sub_category.id_category','>',-1)
						->join('category','sub_category.Id_category','category.Id_category')
						->where('sub_category.Status','=',1)
						->select('sub_category.Id_sub_category','category.Category_name', 'sub_category.Sub_category_code', 'sub_category.Sub_category_name')
							->get();

						$param['msg'] = "Data saved";
						return view('Master_sub_category', $param);
						
					}
				}
		}
		
	}


	public function add_brand(Request $request){
		
		if($request->add_brand){


			if($request->validate(
				[
					'txt_brand_name' => ['required', 'max:20']

				],
				[
					'txt_brand_name.required' => 'Brand name cannot be empty',
					'txt_brand_name.max' => 'Brand name max length 20',

				]))
				{
					$brand_name = $request->txt_brand_name;

					$br = new brand();
					$hasil = $br->add_brand($brand_name);

					if($hasil == "failed")
					{
						$param['dtbrand'] = brand::where('Status','=',1)
						->get();
						$param['msg_err'] = "Insert Failed, brand name maybe already exist ! !";
						return view('Master_brand',$param);
					}
					else
					{
						$param['dtbrand'] = brand::where('Status','=',1)
						->get();
						$param['msg'] = "Data saved";
						return view('Master_brand',$param);
					}
				}
			}
		
	}


	public function edit_brand(Request $request){
		
		if($request->edit_brand){


			if($request->validate(
				[
					'txt_brand_name' => ['required', 'max:20']

				],
				[
					'txt_brand_name.required' => 'Brand name cannot be empty',
					'txt_brand_name.max' => 'Brand name max length 20',

				]))
				{

					$id_brand = $request->id_brand;
					$brand_name = $request->txt_brand_name;

					$br = new brand();
					$hasil = $br->edit_brand($id_brand ,$brand_name);

					if($hasil == "failed")
					{
						$param['msg_err'] = "Update Failed, Brand name maybe already exist !";
						$param['dtbrand'] = brand::where('Status','=',1)
						->get();
						return view('Master_brand',$param);
					}
					else
					{
						$param['dtbrand'] = brand::where('Status','=',1)
						->get();
						$param['msg'] = "Data saved";
						return view('Master_brand',$param);
					}
				}
		}
		
	}


	public function add_bank(Request $request){
		
		if($request->add_bank){


			if($request->validate(
				[
					'txt_bank_name' => ['required', 'max:20'],
					'txt_account_number' => ['required', 'max:20'],
					'txt_account_name' => ['required', 'max:40'],
					'txt_bank_branch' => ['required', 'max:40'],

				],
				[
					'txt_bank_name.required' => 'Bank name cannot be empty',
					'txt_bank_name.max' => 'Bank name max length 20',
					'txt_account_number.required' => 'Account number cannot be empty',
					'txt_account_number.max' => 'Account number max length 20',
					'txt_account_name.required' => 'Account name cannot be empty',
					'txt_account_name.max' => 'Account name max length 40',
					'txt_bank_branch.required' => 'Bank branch cannot be empty',
					'txt_bank_branch.max' => 'Bank branch max length 40',

				]))
				{
					$bank_name = $request->txt_bank_name;
					$account_number = $request->txt_account_number;
					$account_name = $request->txt_account_name;
					$bank_branch = $request->txt_bank_branch;

					$br = new bank();
					$hasil = $br->add_bank($bank_name,$account_number,$account_name,$bank_branch);

					if($hasil == "failed")
					{
						$param['dtbank'] = bank::where('Status','=',1)
						->get();
						$param['msg_err'] = "Insert Failed, account number maybe already exist ! !";
						return view('Master_bank',$param);
					}
					else
					{
						$param['dtbank'] = bank::where('Status','=',1)
						->get();
						$param['msg'] = "Data saved";
						return view('Master_bank',$param);
					}
				}
		}
		
	}


	public function edit_bank(Request $request){
		
		if($request->edit_bank){


			if($request->validate(
				[
					'txt_bank_name' => ['required', 'max:20'],
					'txt_account_number' => ['required', 'max:20'],
					'txt_account_name' => ['required', 'max:40'],
					'txt_bank_branch' => ['required', 'max:40'],

				],
				[
					'txt_bank_name.required' => 'Bank name cannot be empty',
					'txt_bank_name.max' => 'Bank name max length 20',
					'txt_account_number.required' => 'Account number cannot be empty',
					'txt_account_number.max' => 'Account number max length 20',
					'txt_account_name.required' => 'Account name cannot be empty',
					'txt_account_name.max' => 'Account name max length 40',
					'txt_bank_branch.required' => 'Bank branch cannot be empty',
					'txt_bank_branch.max' => 'Bank branch max length 40',
				]))
				{

					$id_bank = $request->id_bank;
					$bank_name = $request->txt_bank_name;
					$account_number = $request->txt_account_number;
					$account_name = $request->txt_account_name;
					$bank_branch = $request->txt_bank_branch;

					$br = new bank();
					$hasil = $br->edit_bank($id_bank,$bank_name,$account_number,$account_name,$bank_branch);

					if($hasil == "failed")
					{
						$param['msg_err'] = "Update Failed, Account number maybe already exist !";
						$param['dtbank'] = bank::where('Status','=',1)
						->get();
						return view('Master_bank',$param);
					}
					else
					{
						$param['dtbank'] = bank::where('Status','=',1)
						->get();
						$param['msg'] = "Data saved";
						return view('Master_bank',$param);
					}
				}
		}
		
	}



	public function add_type(Request $request){
		
		if($request->add_type){


			if($request->validate(
				[
					'txt_type_name' => ['required', 'max:20']

				],
				[
					'txt_type_name.required' => 'Type name cannot be empty',
					'txt_type_name.max' => 'Type name max length 20',

				]))
				{
					$type_name = $request->txt_type_name;

					$br = new type();
					$hasil = $br->add_type($type_name);

					if($hasil == "failed")
					{
						$param['dttype'] = type::where('Status','=',1)
						->get();
						$param['msg_err'] = "Insert Failed, type name maybe already exist ! !";
						return view('Master_type',$param);
					}
					else
					{
						$param['dttype'] = type::where('Status','=',1)
						->get();
						$param['msg'] = "Data saved";
						return view('Master_type',$param);
					}
				}
		}
		
	}


	public function edit_type(Request $request){
		
		if($request->edit_type){


			if($request->validate(
				[
					'txt_type_name' => ['required', 'max:20']

				],
				[
					'txt_type.required' => 'Type name cannot be empty',
					'txt_type.max' => 'Type name max length 20',

				]))
				{

					$id_type = $request->id_type;
					$type_name = $request->txt_type_name;

					$br = new type();
					$hasil = $br->edit_type($id_type ,$type_name);

					if($hasil == "failed")
					{
						$param['msg_err'] = "Update Failed, Type name maybe already exist !";
						$param['dttype'] = type::where('Status','=',1)
						->get();
						return view('Master_type',$param);
					}
					else
					{
						$param['dttype'] = type::where('Status','=',1)
						->get();
						$param['msg'] = "Data saved";
						return view('Master_type',$param);
					}
				}
		}
		
	}

	public function add_team_member(Request $request){
		
		if($request->add_team_member){


			if($request->validate(
				[
					'txt_username' => ['required','max:20','alpha_dash', new ValidasiUsernameMember("add","")],
					'txt_email' => ['required','email','max:500', new ValidasiEmailMember('add','')],
					'txt_phone' => ['required','numeric', new ValidasiPhoneMember("add","")],
					'txt_password' => ['required','min:8', 'max:20'],
					'txt_konpassword' => ['same:txt_password'],
					'cb_role' => ['required'],
					'cb_status' =>['required']

				],
				[
					'txt_username.required' => 'Username cannot be empty !!',
					'txt_username.max' => 'Username max 20 character !!',
					'txt_username.alpha_dash' => 'Username may only contain letters, numbers, dashes and underscores !!',
					'txt_email.required' => 'Email cannot be empty !!',
					'txt_email.email' => 'Email format wrong !!',
					'txt_phone.required' => 'Phone number cannot be empty !!',
					'txt_phone.numeric' => 'Phone number must numeric !!',
					'txt_phone.max' => 'Phone max 16 character !!',
					'txt_password.required' => 'Password cannot be empty !!',
					'txt_password.min' => 'Password min 8 character !!',
					'txt_password.max' => 'Password max 20 character !!',
					'txt_konpassword.same' => 'Password & Passwword confirmation not match !!',
					'cb_role.required' => 'Role cannot be empty !!',
					'cb_status.required' => 'Status cannot be empty' 

				]))
				{
					$status = $request->cb_status;
					$username = $request->txt_username;
					$email = $request->txt_email;
					$phone = $request->txt_phone;
					$password = $request->txt_password;
					$role = $request->cb_role;

					$member = new member();
					$hasil = $member->insertdata_teammember($username,$email,$phone,$password,$role,$status);

					if($hasil == "sukses")
					{
						//return redirect('Master_team_member')->with('success', 'Data Saved');
						$param['dtteam_member'] = member::where('role','=','ADMIN')
						->orwhere('role','=','CUSTOMER SERVICE')
						->orwhere('role','=','SHIPPER')
						->get();
						 $param['msg'] = "Data saved";
						 return view('Master_team_member',$param);
					}
					else
					{
						// $param['msg'] = "Data ada kembar !";
						// return view('register',$param);
					}
				}
			

			
		}
		else if($request->login)
		{
			return view('login');
		}
		
	}


	public function edit_team_member(Request $request){
		
		if($request->edit_team_member){


			if($request->validate(
				[
					'txt_username' => ['required','max:20','alpha_dash', new ValidasiUsernameMember("edit",$request->Id_member)],
					'txt_email' => ['required','email','max:500', new ValidasiEmailMember('edit',$request->Id_member)],
					'txt_phone' => ['required','numeric', new ValidasiPhoneMember("edit",$request->Id_member)],
					'txt_password' => [new ValidasiPasswordEditTeamMember(), 'max:20'],
					'txt_konpassword' => ['same:txt_password'],
					'cb_role' => ['required'],
					'cb_status' => ['required'],

				],
				[
					'txt_username.required' => 'Username cannot be empty !!',
					'txt_username.max' => 'Username max 20 character !!',
					'txt_username.alpha_dash' => 'Username may only contain letters, numbers, dashes and underscores !!',
					'txt_email.required' => 'Email cannot be empty !!',
					'txt_email.email' => 'Email format wrong !!',
					'txt_phone.required' => 'Phone number cannot be empty !!',
					'txt_phone.numeric' => 'Phone number must numeric !!',
					'txt_phone.max' => 'Phone max 16 character !!',
					'txt_password.min' => 'Password min 8 character !!',
					'txt_password.max' => 'Password max 20 character !!',
					'txt_konpassword.same' => 'Password & Passwword confirmation not match !!',
					'cb_role.required' => 'Role cannot be empty !!',
					'cb_status.required' => 'Status cannot be empty !!'

				]))
				{

					$id = $request->Id_member;
					$username = $request->txt_username;
					$email = $request->txt_email;
					$phone = $request->txt_phone;
					$password = $request->txt_password;
					$role = $request->cb_role;
					$status = $request->cb_status;



					$member = new member();
					$hasil = $member->edit_team_member($id,$username,$email ,$phone,$password,$role,$status);

					if($hasil == "failed")
					{
						$param['dtteam_member'] = member::where('role','=','ADMIN')
						->orwhere('role','=','CUSTOMER SERVICE')
						->orwhere('role','=','SHIPPER')
						->get();
						 $param['msg'] = "err";
						 return view('Master_team_member',$param);
					}
					else
					{
						$param['dtteam_member'] = member::where('role','=','ADMIN')
						->orwhere('role','=','CUSTOMER SERVICE')
						->orwhere('role','=','SHIPPER')
						->get();
						 $param['msg'] = "Data saved";
						 return view('Master_team_member',$param);
					}
				}
		}
		
	}

	public function master_supplier(){

		
		$param['dtsupplier'] = supplier::where('Id_supplier','>',-1)
						->select('Id_supplier','Supplier_name','Supplier_email', 'Supplier_phone1', 'Supplier_phone2','Supplier_address','Credit_due_date','Status')
						->get();

						return view('Master_supplier',$param);
		

	}


	public function master_supplier_add(Request $request){

		 session()->forget('session_product_supplier');

		$param['dtproduct'] = product::where('product.Status','=', '1')
		->join('brand','product.Id_brand','brand.Id_brand')
		->join('type','product.Id_type','type.Id_type')
		->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
		"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
			->get();


		$param['dtvariationname'] = variation::where('Status','=',1)
		->select("Option_name","Id_product")
		->get();

		$param['dtproductimage'] = Product_image::all();

		session()->put('tipe_supplier_product',"all");



		return view('Master_supplier_add',$param);

	}

	public function Master_supplier_detail($id)
	{
		$param['supplier'] = supplier::where('Id_supplier','=',$id)
		->get();

		$param['supplier_product'] = supplier_product::where('Id_supplier','=',$id)
		->where('Status','=',1)
		->get();

		$supp_pro = $param['supplier_product'];

		$param['jum_supplier_product'] = count($param['supplier_product']);

		$arr_id_product=[];
		if($param['jum_supplier_product'] ==0)
		{

		}
		else
		{
			for ($i=0; $i < count($supp_pro) ; $i++) { 
				array_push($arr_id_product,$supp_pro[$i]->Id_product);
			}
		}

		session()->put('session_product_supplier',$arr_id_product);




		return view('Master_supplier_detail',$param);
	}

	public function start_session_product_supplier(Request $request)
	{
		$data_session_produk =[];
		
		try {
			$data_session_produk = session()->get('session_product_supplier');
		} catch (\Throwable $th) {
			$data_session_produk =[];
		}

		$arr_id_product=$data_session_produk;

		$temp="";
		for ($i=0; $i < count($arr_id_product); $i++) { 


			$pro = product::where('Id_product','=',$arr_id_product[$i])
			->get();

			try {
				//code...
					$img = product_image::where('Id_product','=',$arr_id_product[$i])
				->where('Image_order','=',1)
				->select("Image_name")
				->get();
				$imgname = $img[0]->Image_name;

			} catch (\Throwable $th) {
				//throw $th;
				$imgname="default.jpg";
			}

			if($imgname=="")
			{
				$imgname="default.jpg";
			}
			

			$variation = variation::where('Id_product','=',$arr_id_product[$i])
			->where('Status','=','1')
			->get();

			
			$brand = brand::where('Id_brand','=',$pro[0]->Id_brand)
			->where('Status','=',1)
			->get();

			$type = type::where('Id_type','=',$pro[0]->Id_type)
			->where('Status','=',1)
			->get();



			
			$temp =$temp."<tr>";
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
				"</p>"
				.
				"</td>";

				$temp= $temp."<td><button type='button' class='btn btn-danger btn-sm' onclick='deleteproduct(".$pro[0]->Id_product.")'> Delete </button></td>";
				$temp =$temp. "</tr>";



		}
		print_r($temp);

	}


	public function enter_product_supplier(Request $request)
	{
		$data_session_produk =[];
		
		try {
			$data_session_produk = session()->get('session_product_supplier');
		} catch (\Throwable $th) {
			$data_session_produk =[];
		}

		$product = product::where('product.Status','=', '1')
		->join('brand','product.Id_brand','brand.Id_brand')
		->join('type','product.Id_type','type.Id_type')
		->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
		"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
			->get();


		$variation= variation::where('Status','=',1)
		->select("Option_name","Id_product")
		->get();

		$dtproductimage = Product_image::all();

		$temp="";
		for ($i=0; $i < count($product); $i++) { 
			
			$ada=false;
			$idp = $product[$i]->Id_product;
			try {
				for ($k=0; $k < count($data_session_produk); $k++) { 
					if($data_session_produk[$k]==$product[$i]->Id_product)
					{
						$ada=true;
					}
				}
			} catch (\Throwable $th) {
				$ada=false;
			}
		

			if($ada==false)
			{
				$imgname = "default.jpg";
				foreach ($dtproductimage as $img)
				{
					$idi = $img->Id_product;
					$urutan = $img->Image_order;
					
					if (($idp == $idi) && ($urutan==1))
					{
					  $imgname = $img->Image_name;
					}
				}

				$temp=$temp."<tr>";

					$temp=$temp."<td>";

					$temp=$temp."<center><input type='checkbox' class='cb_child' value='$idp' style='transform: scale(1.5)'></center>";

					$temp=$temp."</td>";


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


				$temp=$temp."</tr>";
			}




		}

		print_r($temp);

	}



	public function session_tipe_supplier_product(Request $request){


		$tipe = $request->tipe;
		session()->forget('tipe_supplier_product');
		session()->put('tipe_supplier_product',$tipe);


	}



	public function enter_session_product_supplier(Request $request){

		$kumpulan_id_produk = $request->kumpulan_id_produk;

		$arr_id_product = explode("," ,$kumpulan_id_produk);

		// session()->forget('session_product_supplier');
		
		try {
			$sebelumnya = session()->get('session_product_supplier');

		for ($i=0; $i < count($sebelumnya); $i++) { 
			
			array_push($arr_id_product,$sebelumnya[$i]);
		}
		} catch (\Throwable $th) {
			//throw $th;
		}
		

		session()->put('session_product_supplier',$arr_id_product);


		$temp="";

		for ($i=0; $i < count($arr_id_product); $i++) { 


				$pro = product::where('Id_product','=',$arr_id_product[$i])
				->get();

				try {
					//code...
						$img = product_image::where('Id_product','=',$arr_id_product[$i])
					->where('Image_order','=',1)
					->select("Image_name")
					->get();
					$imgname = $img[0]->Image_name;

				} catch (\Throwable $th) {
					//throw $th;
					$imgname="default.jpg";
				}

				if($imgname=="")
				{
					$imgname="default.jpg";
				}
				

				$variation = variation::where('Id_product','=',$arr_id_product[$i])
				->where('Status','=','1')
				->get();

				
				$brand = brand::where('Id_brand','=',$pro[0]->Id_brand)
				->where('Status','=',1)
				->get();

				$type = type::where('Id_type','=',$pro[0]->Id_type)
				->where('Status','=',1)
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
					"</p>"
					.
					"</td>";

					$temp= $temp."<td><button type='button' class='btn btn-danger btn-sm' onclick='deleteproduct(".$pro[0]->Id_product.")'> Delete </button></td>";
					$temp =$temp. "</tr>";



		}
		echo $temp;


	}


	public function delete_session_product_supplier(Request $request){

		$Id_product = $request->Id_product;

	

		$session = session()->get('session_product_supplier');
			$new_session=[];


			for ($i=0; $i < count($session) ; $i++) { 
				# code...

				if($session[$i]==$Id_product)
				{

				}
				else
				{
					array_push($new_session,$session[$i]);
				}
			}
		

		session()->put('session_product_supplier',$new_session);

		$arr_id_product = $new_session;



		$temp="";

		for ($i=0; $i < count($arr_id_product); $i++) { 


				$pro = product::where('Id_product','=',$arr_id_product[$i])
				->get();

				try {
					//code...
						$img = product_image::where('Id_product','=',$arr_id_product[$i])
					->where('Image_order','=',1)
					->select("Image_name")
					->get();
					$imgname = $img[0]->Image_name;

				} catch (\Throwable $th) {
					//throw $th;
					$imgname="default.jpg";
				}

				if($imgname=="")
				{
					$imgname="default.jpg";
				}
				

				$variation = variation::where('Id_product','=',$arr_id_product[$i])
				->where('Status','=','1')
				->get();

				
				$brand = brand::where('Id_brand','=',$pro[0]->Id_brand)
				->where('Status','=',1)
				->get();

				$type = type::where('Id_type','=',$pro[0]->Id_type)
				->where('Status','=',1)
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
					"</p>"
					.
					"</td>";

					$temp= $temp."<td><button type='button' class='btn btn-danger btn-sm' onclick='deleteproduct(".$pro[0]->Id_product.")'> Delete </button></td>";
					$temp =$temp. "</tr>";



		}
		echo $temp;
	}

	public function add_supplier(Request $request){

		if($request->add_supplier){


			if($request->validate(
				[
					'txt_supplier_name' => ['required','max:50', new ValidasiSupplierName("add","")],
					'txt_supplier_email' => ['email','max:50'],
					'txt_supplier_phone1' => ['required','numeric','min:2'],
					'txt_supplier_phone2' => ['numeric'],
					'txt_supplier_address' => ['max:100'],
					'txt_credit_due_date' => ['numeric'],
					// 'cb_status' => ['required']

				],
				[
					'txt_supplier_name.required' => 'Supplier name cannot be empty !!',
					'txt_supplier_name.max' => 'Username max 50 character !!',
					'txt_supplier_email.max' => 'Supplier email max 50 character !!',
					'txt_supplier_phone1.required' => 'Supplier Phone 1 cannot be empty !!',
					'txt_supplier_phone1.min' => 'Supplier Phone 1 cannot be empty !!',
					// 'cb_status.required' => 'Status cannot be empty'
					

				]))
				{
					$name = $request->txt_supplier_name;
					$email = $request->txt_supplier_email;
					$phone1 = $request->txt_supplier_phone1;
					$phone2 = $request->txt_supplier_phone2;
					$address = $request->txt_supplier_address;
					$credit = $request->txt_credit_due_date;
					$status = $request->cb_status;

					$supp = new supplier();
					$hasil = $supp->add_supplier($name,$email,$phone1,$phone2,$address,$credit,$status);

					if($hasil == "sukses")
					{

						$supp = new supplier();
						$lastid = $supp->getlastid();

						//Update table product
						$tipe = session()->get('tipe_supplier_product');

						if($tipe=="all")
						{

						}
						else
						{
							$datasession = session()->get('session_product_supplier');

							for ($i=0; $i < count($datasession); $i++) { 
								
								$prosupp = new supplier_product();
								$hasil = $prosupp->add_product($lastid, $datasession[$i]);
							}
										
						}


						//return redirect('Master_team_member')->with('success', 'Data Saved');
						$param['dtsupplier'] = supplier::where('Id_supplier','>',-1)
						->select('Status','Id_supplier','Supplier_name','Supplier_email', 'Supplier_phone1', 'Supplier_phone2','Supplier_address','Credit_due_date')
						->get();

						return view('Master_supplier',$param);
					}
					else
					{
						// $param['msg'] = "Data ada kembar !";
						// return view('register',$param);
					}
				}
			

			
		}
		else if($request->login)
		{
			return view('login');
		}
	}

	public function edit_supplier(Request $request){
		
		if($request->edit_supplier){

			$id = $request->txt_id_supplier;
			if($request->validate(
				[
					'txt_supplier_name' => ['required','max:50', new ValidasiSupplierName("edit", $id)],
					'txt_supplier_email' => ['email','max:50'],
					'txt_supplier_phone1' => ['required','numeric','min:2'],
					'txt_supplier_phone2' => ['numeric'],
					'txt_supplier_address' => ['max:100'],
					'txt_credit_due_date' => ['numeric'],
				],
				[
					'txt_supplier_name.required' => 'Supplier name cannot be empty !!',
					'txt_supplier_name.max' => 'Username max 50 character !!',
					'txt_supplier_email.max' => 'Supplier email max 50 character !!',
					'txt_supplier_phone1.required' => 'Supplier Phone 1 cannot be empty !!',
					'txt_supplier_phone1.min' => 'Supplier Phone 1 cannot be empty !!',

				]))
				{

					$status = $request->cb_status;
					$name = $request->txt_supplier_name;
					$email = $request->txt_supplier_email;
					$phone1 = $request->txt_supplier_phone1;
					$phone2 = $request->txt_supplier_phone2;
					$address = $request->txt_supplier_address;
					$credit = $request->txt_credit_due_date;

					$supp = new supplier();
					$hasil = $supp->edit_supplier($id,$name,$email,$phone1,$phone2,$address,$credit,$status);

					if($hasil == "sukses")
					{
						//return redirect('Master_team_member')->with('success', 'Data Saved');
						$param['dtsupplier'] = supplier::where('Id_supplier','>',-1)
						->select('Status','Id_supplier','Supplier_name','Supplier_email', 'Supplier_phone1', 'Supplier_phone2','Supplier_address','Credit_due_date')
						->get();




						//Update table product
						$tipe = session()->get('tipe_supplier_product');

						if($tipe=="all")
						{
							//Hapus semua table supplier produk yg sesuai id supplier
							$prosupp = new supplier_product();
							$prosupp->deletesupp($id);
						}
						else
						{
							$prosupp = new supplier_product();
							$prosupp->deletesupp($id);


							$datasession = session()->get('session_product_supplier');

							for ($i=0; $i < count($datasession); $i++) { 
								
								$prosupp = new supplier_product();
								$hasil = $prosupp->add_product($id, $datasession[$i]);
							}
										
						}


						return view('Master_supplier',$param);





					}
					else
					{
						// $param['msg'] = "Data ada kembar !";
						// return view('register',$param);
					}
				}
		}
		
	}

	public function master_affiliate(Request $request)
	{

		
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

		$param['msg']="";
		$param['msgerror']="";


		$param['dtaffiliate'] = affiliate::join('product','affiliate.Id_product','product.Id_product')
		->select('affiliate.Id_product','product.Name','affiliate.Poin','affiliate.Status')
		->get();



		$param['dtproduct'] = product::where('product.Status','=', '1')
		->join('brand','product.Id_brand','brand.Id_brand')
		->join('type','product.Id_type','type.Id_type')
		->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
		"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
			->get();


		$param['dtvariation']= variation::where('Status','=',1)
		// ->select("Option_name","Id_product")
		->get();


		$param['dtproductimage'] = Product_image::all();

		

		return view('master_affiliate',$param);
	}


	
	public function getaffiliatedata(Request $request)
	{
		$temp="";
		$temp2="";


		$Id_product = $request->Id_product;

		$aff = affiliate::where('Id_product','=',$Id_product)
		->get();

		$vari = variation::where('Id_product','=',$Id_product)
		->where('Status','=',1)
		->get();

		if(count($aff)==0)
		{
			$temp="0";
		}
		else if($aff[0]['Status'] == 1)
		{
			$temp="1";
		}
		else if($aff[0]['Status'] == 0)
		{
			$temp="0";
		}


		foreach ($vari as $data) {

			$poin=0;
			foreach ($aff as $data_aff) {
				if($data_aff->Id_variation == $data->Id_variation)
				{
					$poin= $data_aff->Poin;
				}
			}

			$temp2=$temp2."<div class='row'>";
				$temp2=$temp2."<div class='col-md-6'>";
					$temp2=$temp2."<label >".$data->Option_name."</label>";
				$temp2=$temp2."</div>";
				$temp2=$temp2."<div class='col-md-6'>";
					$temp2=$temp2."<input class='form-control' type='number' name='var_".$data->Id_variation."' id='var-".$data->Id_variation."' value=".$poin." >";
				$temp2=$temp2."</div>";
			$temp2=$temp2."</div>";
			$temp2=$temp2."<br>";
			
			
		}

		echo $temp."#".$temp2;

	}

	public function add_affiliate(Request $request)
	{
		if($request->add_affiliate){


			if($request->validate(
				[
					'cb_product' => ['required','min:1',new ValidasiCbProduct()],
					'txt_poin' => ['required', 'min:1','max:11']

				],
				[
					'cb_product.required' => 'Product cannot be empty',
					'cb_product.min' => 'Product cannot be empty',
					'txt_poin.required' => 'Poin cannot be empty',
					'txt_poin.min' => 'Please insert poin',
					'txt_poin.max' => 'Error Poin. >max length',

				]))
				{	
					
					$cb_product = $request->cb_product;
					$txt_poin = $request->txt_poin;

					$aff = new affiliate();
					$hasil = $aff->add_affiliate($cb_product, $txt_poin);


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


					$param['msg']="";
					$param['msgerror']="";
					$param['dtaffiliate'] = affiliate::where('Status','=',1)
					->get();
					return view('master_affiliate',$param);
				}
		}
	}


	public function edit_affiliate(Request $request)
	{
		if($request->edit_affiliate){


			if($request->validate(
				[
					'cb_status' => ['required'],

				],
				[
					'cb_status.required' => 'status cannot be empty',

				]))
				{	


	
					$Status = $request->cb_status;
					$Id_product = $request->Id_product;

					$aff = affiliate::where('Id_product','=',$Id_product)
						->get();

					$vari = variation::where('Id_product','=',$Id_product)
					->where('Status','=',1)
					->get();

					if(count($aff)==0)
					{

						foreach ($vari as $datavar) {
							# code...
							$namevariasi = "var_".$datavar->Id_variation;
							$Id_variation = $datavar->Id_variation;
							$poinvariasi = $request->$namevariasi;
							$newaff = new affiliate();
							$hasil = $newaff->add_affiliate($Id_product,$Id_variation, $poinvariasi, $Status);
						}

						
					}
					else{

						foreach ($vari as $datavar) {
							# code...
							$namevariasi = "var_".$datavar->Id_variation;
							$Id_variation = $datavar->Id_variation;
							$poinvariasi = $request->$namevariasi;
							$newaff = new affiliate();
							$hasil = $newaff->edit_affiliate($Id_variation, $poinvariasi, $Status);
						}

					}

					
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

					$param['msg']="";
					$param['msgerror']="";


					$param['dtaffiliate'] = affiliate::join('product','affiliate.Id_product','product.Id_product')
					->select('affiliate.Id_product','product.Name','affiliate.Poin','affiliate.Status')
					->get();



					$param['dtproduct'] = product::where('product.Status','=', '1')
					->join('brand','product.Id_brand','brand.Id_brand')
					->join('type','product.Id_type','type.Id_type')
					->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
					"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
						->get();


					$param['dtvariation']= variation::where('Status','=',1)
					->select("Option_name","Id_product")
					->get();


					$param['dtproductimage'] = Product_image::all();

					

					return view('master_affiliate',$param);
				}
		}
	}

	public function master_ebook()
	{
		$ebooks = ebook::where('status', '1')->get();
		foreach ($ebooks as $book) {
			$book->sub_category = sub_category::find($book->Id_sub_category);
		}
		return view('master_ebook', compact('ebooks'));
	}

	public function show_ebook($ebook_id, $user_token)
	{
		$ebook = ebook::find($ebook_id);
		if($ebook->Id_template == "1"){
			$view = "Ebook_template1";
		}else if($ebook->Id_template == "2"){
			$view = "Ebook_template2";
		}else {
			$view = "Ebook_template3";
		}
		return view($view, compact('ebook', 'user_token'));
	}

	public function submit_email_ebook(Request $request, $ebook_id, $user_token)
	{
		$existed_user_ebook = email_ebook::where('Email', $request->email)
		->where('User_token', $user_token)
		->where('Ebook_id', $ebook_id)
		->get();


		
		if(count($existed_user_ebook) == 0)
		{
			$email_ebook = new email_ebook();
			$email_ebook->add_email_ebook($request->ebook_id, $request->name, $request->phone, $request->email, $request->user_token);
			if(!Cookie::has("username_login") && !Cookie::has("Affiliate"))   
			{
				Cookie::queue(Cookie::make("Affiliate", $user_token, 1500000));
				Cookie::queue(Cookie::make("Tracking_code", "EBOOK-".$ebook_id, 1500000));
				
				$member_aff = member::where('Random_code', $user_token)->first();

				$ebook = DB::table('ebook_member_downloaded')
				->where('Id_ebook', $ebook_id)
				->where('Id_member', $member_aff->Id_member)
				->first();
				
				if(!empty($member_aff))
				{
					$total_download = 0;
					if(!empty($ebook))
					{
						$total_download = $ebook->Total_didownload + 1;	
						DB::update("update ebook_member_downloaded set Total_didownload = $total_download where Id_ebook = $ebook_id and Id_member = $member_aff->Id_member");
					}
					else 
					{
						$total_download = 1;
						DB::insert('insert into ebook_member_downloaded (Total_didownload, Id_member, Id_ebook) values (?, ?, ?)', [$total_download, $member_aff->Id_member, $ebook_id]);
					}
				}
				
				
			}
		}

		
		Mail::to($request->email)->send(new SendEbook($ebook_id));

		return redirect()->back()->with('success', 'Email submitted');
	}

	public function create_ebook()
	{
		// $sub_category = sub_category::pluck('Sub_category_name', 'Id_sub_category');
		// return view('Ebook_add', compact('sub_category'));


		$db = sub_category::all(); 
		$arr= [];  // array 
		foreach($db as $row) {
			if($row->Status==1)
			{
				$arr[$row->Id_sub_category] = $row->Sub_category_name; 
			}
		
		}
		
		$param['sub_category']  = $arr; 




		// $param['sub_category'] = sub_category::select('Sub_category_name','Id_sub_category')
		// ->where('Status','=',1)
		// ->get();


		return view('Ebook_add', $param);


	}

	public function edit_ebook($id)
	{

		// $ebook = ebook::find($id);
		// $sub_category = sub_category::pluck('Sub_category_name', 'Id_sub_category');
		// // ->where('Status','=',1);
		// return view('Ebook_edit', compact('ebook', 'sub_category'));



		$param['ebook'] = ebook::find($id);

		$db = sub_category::all(); 
		$arr= [];  // array 
		foreach($db as $row) {
			if($row->Status==1)
			{
				$arr[$row->Id_sub_category] = $row->Sub_category_name; 
			}
		
		}
		
		$param['sub_category']  = $arr; 

		return view('Ebook_edit', $param);

	}
	
	public function delete_ebook($id)
	{
		$ebook = new ebook();
		$ebook->delete_ebook($id);
		return redirect()->route('master_ebook');
	}

	public function ebook_store(Request $request)
	{
		if($request->validate(
		[
			'image' => ['required', 'mimes:jpeg,png,jpg'],
			'pdf' => ['required', 'mimes:pdf'],
		
		],
		[
			'image.required' => 'Please choose image file',
		]))
		{
			$title = str_replace(' ', '-', $request->title);
			//FOTO
			$filefoto = $request->file('image');
			$extfile = $filefoto->getClientOriginalExtension();

			$despath = 'Uploads/Ebook';
			$namafilefoto = $title. '-'. date('Y-m-d-H-i-s') .'-image' .'.'.$extfile;
			$filefoto->move($despath,$namafilefoto);

			//PDF
			$filepdf = $request->file('pdf');
			$extfile = $filepdf->getClientOriginalExtension();

			$despath = 'Uploads/Ebook';
			$namafilepdf = $title.'-'. date('Y-m-d-H-i-s') .'-pdf' . '.'.$extfile;
			$filepdf->move($despath,$namafilepdf);

			$ebook = new ebook();
			$ebook->add_ebook($request->id_template, $request->sub_catgory,$request->title, $request->content, $namafilefoto, $namafilepdf, $request->call_to_action);

			return redirect()->route('master_ebook');
		}
	}

	public function ebook_update(Request $request, $id)
	{
		$current_ebook = ebook::find($id);
		$title = str_replace(' ', '-', $request->title);
		//FOTO
		if($request->hasFile('image')){
			unlink(public_path() ."/Uploads/Ebook/". $current_ebook->Image);

			$filefoto = $request->file('image');
			$extfile = $filefoto->getClientOriginalExtension();

			$despath = 'Uploads/Ebook';
			$namafilefoto = $title. '-'. date('Y-m-d-H-i-s') .'-image' .'.'.$extfile;
			$filefoto->move($despath,$namafilefoto);
		} else {
			$namafilefoto = $current_ebook->Image;
		}

		//PDF
		if($request->hasFile('pdf')){
			unlink(public_path() ."/Uploads/Ebook/". $current_ebook->Pdf_file);

			$filepdf = $request->file('pdf');
			$extfile = $filepdf->getClientOriginalExtension();

			$despath = 'Uploads/Ebook';
			$namafilepdf = $title.'-'. date('Y-m-d-H-i-s') .'-pdf' . '.'.$extfile;
			$filepdf->move($despath,$namafilepdf);
		}else {
			$namafilepdf = $current_ebook->Pdf_file;
		}


		$ebook = new ebook();
		$ebook->edit_ebook($id, $request->id_template, $request->sub_catgory,$request->title, $request->content, $namafilefoto, $namafilepdf, $request->call_to_action);

		return redirect()->route('master_ebook');
	}

	public function ajaxsubcategory(Request $request) //Untuk dropdown subcategori event dari onchange kategori
	{
		$modelcategory = new category();
		echo $modelcategory->getsubcategory($request->kodecategory);

	}

	public function getcategory(Request $request)
	{
		$modelcategory = new category();
		echo $modelcategory->getcategory($request->id);
	}

	public function getsubcategory(Request $request)
	{
		$modelsubcategory = new sub_category();
		echo $modelsubcategory->getsubcategory($request->id);
	}

	public function getteammember(Request $request)
	{
		$modelteam = new member();
		echo $modelteam->getteammember($request->id);

		// session()->put('IxEditMember',$modelteam->Status);
	}

	public function getbrand(Request $request)
	{
		$modelbrand = new brand();
		echo $modelbrand->getbrand($request->id);
	}

	public function getbank(Request $request)
	{
		$modelbank = new bank();
		echo $modelbank->getbank($request->id);
	}

	public function gettype(Request $request)
	{
		$modeltype = new type();
		echo $modeltype->gettype($request->id);
	}


	public function getsupplier(Request $request)
	{
		$modelsupplier = new supplier();
		echo $modelsupplier->getsupplier($request->id);
	}
}

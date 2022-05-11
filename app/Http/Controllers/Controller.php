<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
// use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Services\Midtrans\CreateSnapTokenService;

use App\stock_card;
use App\member;
use App\category;
use App\sub_category;
use App\brand;
use App\banner;
use App\type;
use App\product;
use App\product_sub_category;
use App\variation;
use App\product_image;
use App\supplier;
use App\affiliate;
use App\promo_header;
use App\promo_detail;
use App\wishlist;
use App\cart;
use App\voucher;
use App\voucher_member;
use App\voucher_product;
use App\point_card;
use App\address_member;
use App\list_city;
use App\cust_order_header;
use App\cust_order_detail;
use App\cust_order_history;
use App\ebook;
use App\email_ebook;
use App\embed_checkout;
use App\followup;
use App\Mail\BroadcastMail;
use App\Mail\RequestOTP;
use App\Mail\SendEmail;
use App\otp;
use App\rate_review;
use DateTime;
use App\Rules\ValidasiEmailMember;
use App\Rules\ValidasiPasswordEditTeamMember;
use App\Rules\ValidasiUsernameMember;
use App\Rules\ValidasiPhoneMember;
use App\Rules\ValidasiProductName;
use App\Rules\ValidasiSubCategorySession;
use App\Rules\ValidasiOptionSession;
use App\Rules\ValidasiSupplierName;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use LDAP\Result;
use resources\lang\en\validation;
use SubmittedEmailEbook;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function dthome()
	{
		session()->forget('id_cat');
		session()->forget('Id_address');
		//  session()->put('id_cat','');


		$this->validasipromo();
		$this->validasivoucher();
		// validasipromo();

		$param['dtproduct'] = product::where('product.Id_product','>', -1)
		->join('brand','product.Id_brand','brand.Id_brand')
		->join('type','product.Id_type','type.Id_type')
		// ->join('product_image','product.Id_product','product_image.Id_product')
		// ->where('product_image.Image_order','=',1)
		->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
		"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status", "product.Rating")
			->get();

		$param['dtpopulerproduct'] = $this->getPopulerProduct();

		$param['dtcust_order_header'] = cust_order_header::where('Status','>',1)
		->get();

		$param['dtcust_order_detail'] = cust_order_header::all();
		
		// $param['dtproduct_popular'] = product::where('product.Id_product','>', -1)
		// ->join('brand','product.Id_brand','brand.Id_brand')
		// ->join('type','product.Id_type','type.Id_type')
		// ->join('cust_order_detail','cust_order_detail.Id_product','product.Id_product')
		// // ->where('product.Status','=',1)
		// ->where('cust_order_detail.Qty','>',0)
		// ->distinct()
		// ->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
		// "product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status", "product.Rating")
		// 	->get();
		

		$param['dtproductimage'] = product_image::all();

		$param['dtvariasi'] = variation::all();

		$param['dtpromoheader'] = promo_header::where('Status','=',1)
		->get();

		$param['dtpromodetail'] = promo_detail::where('Status','=',1)
		->get();

		$param['banner'] = banner::where('banner_position','=',1)
		->get();

		$param['banner_2'] = banner::where('banner_position','=',2)
		->get();

		$param['member_name'] ="";
		try {
			//code...
			$param['member_name'] = session()->get('userlogin')->Username;
		
		
		} catch (\Throwable $th) {
			//throw $th;
			$param['member_name'] ="";
		}
		
		$param['category'] = category::where('category.Status','=',1)
		->join('sub_category','category.Id_category','sub_category.Id_category')
		->select('category.Id_category','category.Category_code','category.Category_name')
		->distinct('category.Id_category')
		->get();

		$param['subcategory'] = sub_category::where('Status','=',1)
		->get();

		return $param;
	}


	public function hasil_Search($angkapage)
	{
		$dtproductimage = product_image::all();
		$dtvariasi = variation::all();

		$dtpromoheader = promo_header::where('Status','=',1)
		->get();

		$dtpromodetail = promo_detail::where('Status','=',1)
		->get();

		//---------------------------------------------------------
		session()->forget('page');
		session()->put('page',$angkapage);
		//---------------------------------------------------------

		$temp="";
		$pro = new product();
		$hasil = $pro->getproduct_search();

		$hitungjumlah=0;

		//1 1-12
		//2 13-24

		if($angkapage <= ceil(count($hasil)/12) )
		{
			$pageakhir = $angkapage * 12;
			$pageawal = $pageakhir-11;
		}
		else
		{
			$pageakhir = ceil(count($hasil)/12) * 12;
			$pageawal = $pageakhir-11;
		}
		foreach ($hasil as $product) {
			# code...
			$hitungjumlah++;
			if($hitungjumlah>=$pageawal && $hitungjumlah<=$pageakhir)
			{
				$gambardata = "";

				foreach ($dtproductimage as $gambar ) {
					if(($gambar->Id_product == $product->Id_product )&& ($gambar->Image_order == 1))
					{
						$gambardata = $gambar->Image_name;
					}
				}
	
				if($gambardata=="")
				{
					$gambardata="default.jpg";
				}
	
				//--------------------------------------
	
				$Id_product=$product->Id_product;
				$fixharga="";
				$murah=999999999999;
				$mahal=0;
				$ctr=0;
				foreach ($dtvariasi as $datavariasi) {
					if($Id_product == $datavariasi->Id_product && $datavariasi->Status == 1)
					{
						$ctr++;
						if($datavariasi->Sell_price < $murah)
						{
							$murah= $datavariasi->Sell_price;
						}
	
	
						if($datavariasi->Sell_price > $mahal)
						{
							$mahal= $datavariasi->Sell_price;
						}
					}
				}
	
				if($ctr==1)
				{
					$fixharga = 'Rp. '. number_format($mahal);
				}
				else {
					$fixharga = 'Rp. '.number_format($murah).' - '.number_format($mahal);
				}
				//------------------------------------------------------------
	
				$sale=0;
				$upto= "";
				$maxrupiah=0;
				$mahal=0;
				$tes=0;
				foreach ($dtpromoheader as $promoheader ) {
					if($promoheader->Id_product == $product->Id_product)
					{
						$sale=1;
						$model= $promoheader->Model;
						$Id_variation = $promoheader->Id_variation;
						$sellprice=0;
	
						foreach ($dtvariasi as $vari) {
							if($vari->Id_variation==$Id_variation)
							{
								$sellprice=$vari->Sell_price;
							}
						}
	
						foreach ($dtpromodetail as $promodetail) {
							if($promoheader->Id_promo == $promodetail->Id_promo )
							{
								if($model=='%')
								{
									if(($sellprice * ($promodetail->Discount / 100)) > $mahal)
									{
										$mahal= $sellprice * ($promodetail->Discount / 100);
										$upto=$promodetail->Discount." %";
										$tes = $mahal;
									}
								}
								else if($model=='RP') {
									if(($promodetail->Discount) > $mahal)
									{
										$mahal= $promodetail->Discount;
										$upto= "Rp. ". number_format($promodetail->Discount);
									}
								}
								
							}
						}
						
					}
				}
	
				$temp=$temp."<div class='col-lg-6 col-md-6 col-xl-3'>";
					$temp=$temp."<div class='product-wrapper mb-30'>";
						$temp=$temp."<div class='product-img'>";
	
						if($sale==1)
						{
							$temp=$temp."<span class='badge bg-danger text-white position-absolute' style='top: 0.5rem; right: 0.5rem;align-content: center; font-size:70%; z-index:10'>";
								$temp=$temp."Sale";
							$temp=$temp."</span>";
						}
						
	
							$temp=$temp."<div class='product-img'>";
								$temp=$temp."<a href='".url('Cust_show_product/'.$product->Id_product)."'>";
									$temp=$temp. "<img src='".url('Uploads/Product/'.$gambardata)."' alt=''>";
								$temp=$temp."</a>";
							$temp=$temp."</div>";
							$temp=$temp."<div class='product-content'>";
								$temp=$temp."<a href='".url('Cust_show_product/'.$product->Id_product)."'><b>".$product->Name."</b></a>";
	
								$temp=$temp."<div class='quick-view-rating'>";
									for($i = 1; $i <= 5; $i++){
										if($i <= ceil($product->Rating)){
											$temp=$temp."<i class='fas fa-star'></i>";
										}else {
											$temp=$temp."<i class='far fa-star'></i>";
										}
									}
								$temp=$temp."</div>";
	
								$temp=$temp."<span style='font-size:90%'>".$fixharga."</span>";
	
								if($sale==1)
								{
									$temp=$temp."<br><span style='color: red; font-size:80%'>";
										$temp=$temp."Discount up to ".$upto; 
									$temp=$temp."</span>";	
									
		
								}
								
							$temp=$temp."</div>";
						$temp=$temp."</div>";
					$temp=$temp."</div>";
				$temp=$temp."</div>";
			}

			
		}
		if($angkapage>ceil($hitungjumlah/12))
		{
			session()->forget('page');
			session()->put('page',ceil($hitungjumlah/12));
			$page = "Page ".ceil($hitungjumlah/12)." of ". ceil($hitungjumlah/12);
		}
		else
		{
			$page = "Page ".$angkapage." of ". ceil($hitungjumlah/12);
		}
		

		return $temp."||".$hitungjumlah."||".($page);

	}


	public function home(){
		return view('Cust_home',$this->dthome());
	}


	public function Dashboard_admin(){
		return view('Dashboard_admin');
	}

	public function register(){
		$param['msg']="";
		return view('register',$param);
	}
	
	public function login(){

		$param['msg']="";
		return view('login',$param);
	}

	public function forgot_password(){

		return view('forgot_password');
	}

	public function logout(){
		session()->forget('cart');
		session()->forget('userlogin');
		session()->forget('Id_address');
		$param['msg']="";
		return view('login',$param);
		
	}
	public function post_register(Request $request){
		
		if($request->register){

			$validator = Validator::make($request->all(),[
				'txt_username' => ['required','max:20','alpha_dash', new ValidasiUsernameMember("add","")],
				'txt_email' => ['required','email','max:500', new ValidasiEmailMember("add","")],
				'txt_phone' => ['required','numeric', new ValidasiPhoneMember("add","")],
				'txt_password_regist' => ['required','min:8', 'max:20'],
				'txt_konpassword' => ['required','same:txt_password_regist']
			],
			[
				'txt_username.required' => 'Username cant empty',
				'txt_username.max' => 'Username max 20 Char',
				'txt_username.alpha_dash' => 'Username may only contain letters, numbers, dashes and underscores',
				'txt_email.required' => 'Email cant empty',
				'txt_email.email' => 'Email format wrong',
				'txt_phone.required' => 'Phone cant empty',
				'txt_phone.numeric' => 'Phone must numeric',
				'txt_phone.max' => 'Phone max 16 char',
				'txt_password_regist.required' => 'Password cant empty',
				'txt_password_regist.min' => 'Password min 8 char',
				'txt_password_regist.min' => 'Password max 20 char',
				'txt_konpassword.same' => 'Password & Confirmation password not match'
			]);

			if ($validator->fails())
			{
				$param['msg']="";
				return view('register',$param)
				->withErrors($validator);
			}
			else
			{
				$username = $request->txt_username;
				$email = $request->txt_email;
				$phone = $request->txt_phone;
				$password = $request->txt_password_regist;

				$member = new member();
				$hasil = $member->insertdata($username,$email,$phone,$password);

				if($hasil == "sukses")
				{
					$param['msg'] = "Sukses Register !";


					$member = new member();
					$hasil = $member->ceklogin($username,$password);

					session()->put("userlogin",$hasil);


					$arr="";
					try {
						$arr = json_decode(session()->get('cart'));

						if(count($arr)<1)
						{
							$arr="";
						}

					} catch (\Throwable $th) {
						$arr="";
					}
					
					if($arr!="")
					{
						foreach ($arr as $data) {
							//adrieljenn
							$cart = new cart();
							$carthasil = $cart->add_cart($data->Id_product,$data->Id_variation,$data->Qty,$hasil->Id_member);
						}
					}
					Cookie::queue(Cookie::make("username_login", $hasil->Username, 1500000));
					return view('Cust_home',$this->dthome());	
				}
				else
				{
					$param['msg'] = "Data ada kembar !";
					return view('register',$param);
				}
			}

		}
		else if($request->login)
		{
			$param['msg']="";
		return view('login',$param);
		}
		
	}

	public function post_login(Request $request){
		
		if($request->login){


			$validator = Validator::make($request->all(),[
				'txt_username_email' => ['required','max:500'],
				'txt_password' => ['required','min:8', 'max:20']
			],
			[
				'txt_username_email.required' => 'Username / Email cant empty',
				'txt_username_email.max' => 'Username / Email max 500 char',
				'txt_password.required' => 'Password cant empty',
				'txt_password.min' => 'Password min 8 char',
				'txt_password.min' => 'Password max 20 char',
			]);

			if ($validator->fails())
			{
				return view('login')
				->withErrors($validator);
			}
			else
			{
				$username_email = $request->txt_username_email;
				$password = $request->txt_password;

				$member = new member();
				$hasil = $member->ceklogin($username_email,$password);

				if($hasil == "failed")
				{
					$param['msg'] = "Login Failed !";
					return view('login',$param);
				}
				else
				{
					session()->put("userlogin",$hasil);
					// $request->session()->forget('nama');
					if($hasil->Role=='ADMIN' ||$hasil->Role=='CUSTOMER SERVICE' ||$hasil->Role=='SHIPPER')
					{
						return view('Dashboard_admin');
					}
					else
					{
						Cookie::queue(Cookie::make("username_login", $hasil->Username, 1500000));
						return view('Cust_home',$this->dthome());	

						
					}
					
				}
			}
		}
		
	}
	public function test()
	{
		 echo (session()->get('userlogin'));
	}

	public function embedtes()
	{
		 
		return view('embedtes');
	}

	public function edit_profile()
	{

		$Id_member =session()->get('userlogin')->Id_member;
		$param['dtaddress'] = address_member::where('address_member.Id_member','=',$Id_member)
		->where('address_member.Status','=',1)
		->join('list_city','address_member.Id_city','list_city.Id_city')
		// ->join('list_city','address_member.Id_province','list_city.Id_province')
		->get();

		$db = list_city::all(); 
		$arr= [];  // array 
		$arr2= [];  // array 
		foreach($db as $row) {
            $arr[0] = "";
			$arr2[0] = "";
			$arr[$row->Id_province] = $row->Province_name; 
			$arr2[$row->Id_city] = $row->City_name; 
		
		}
		
		$param['arr_province']  = $arr; 
		$param['arr_city']  = $arr2; 

		return view('Cust_edit_profile',$param);
	}

	public function update_profile(Request $request)
	{
			if($request->validate(
				[
					'txt_username' => ['required','max:20','alpha_dash', new ValidasiUsernameMember("edit",$request->Id_member)],
					'txt_email' => ['required','email','max:500', new ValidasiEmailMember('edit',$request->Id_member)],
					'txt_phone' => ['required','numeric', new ValidasiPhoneMember("edit",$request->Id_member)],

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

				]))
				{

					$username = $request->txt_username;
					$email = $request->txt_email;
					$phone = $request->txt_phone;


					$member = new member();
					$hasil = $member->edit_team_member_cust(session()->get('userlogin')->Id_member ,$username,$email ,$phone);

					if($hasil == "failed")
					{
						return view('Cust_home',$this->dthome());
					}
					else
					{
						//----Update session----
						$member = new member();
						$hasil = $member->getteammember(session()->get('userlogin')->Id_member);

						session()->forget('userlogin');
						session()->put("userlogin",$hasil[0]);

						//-----------------------
						
						$Id_member =session()->get('userlogin')->Id_member;
						$param['dtaddress'] = address_member::where('address_member.Id_member','=',$Id_member)
						->where('address_member.Status','=',1)
						->join('list_city','address_member.Id_city','list_city.Id_city')
						// ->join('list_city','address_member.Id_province','list_city.Id_province')
						->get();

						$db = list_city::all(); 
						$arr= [];  // array 
						$arr2= [];  // array 
						foreach($db as $row) {
							$arr[0] = "";
							$arr2[0] = "";
							$arr[$row->Id_province] = $row->Province_name; 
							$arr2[$row->Id_city] = $row->City_name; 
						
						}
						
						$param['arr_province']  = $arr; 
						$param['arr_city']  = $arr2; 

						


						return view('Cust_edit_profile',$param);
					}
				}


		
	}

	public function logout_team_member(Request $request)
	{
		session()->forget('userlogin');
		session()->forget('cart');
		$param['msg']="";
		return view('login',$param);
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
				$hasil = $p->changestatus($data->Id_promo,2);
			}
			else if((date('Y-m-d') >= $data->Start_date) && (date('Y-m-d')<= $data->End_date) && ($data->Status==3))
			{

				//Ubah jadi active yg dalam range waktu
				$p = new promo_header();
				$hasil = $p->changestatus($data->Id_promo,1);
			}
		}
	}

	//STATUS VOUCHER
	// 1 active
	// 2 expire lewat tanggal
	public function validasivoucher()
	{
		$vc = voucher::where('Status','<>',0)
		->get();

		// print_r('aaaaccca');
		// echo "aadsd";
		foreach ($vc as $data) {
			if($data->Redeem_due_date < date('Y-m-d'))
			{
				//expire lewat tanggal
				$v = new voucher();
				$hasil = $v->changestatus($data->Id_voucher,2);
			}
		}
	}


	public function Cust_show_cat(Request $request)
	{
		$type = $request->type;
		$id = $request->id;
		$query="";
		$temp="";
		$ctrpro=0;
		$arr1= [];
		if($type=='cat')
		{
			session()->put('id_cat',$id);

			$query = category::where('category.Id_category','=', $id)
			// ->join('brand','product.Id_brand','brand.Id_brand')
			->join('sub_category','category.Id_category','sub_category.Id_category')
			->select('sub_category.Id_sub_category')
			->where('category.Status','=',1)
			->where('sub_category.Status','=',1)
			->get();

			$prosub = product_sub_category::all();

			foreach ($query as $data) {
				// $temp=$temp."-".$data->Id_sub_category;
				foreach ($prosub as $data2) {
					if($data->Id_sub_category == $data2->Id_sub_category)
					{
						// $temp=$temp."-".$data->Id_sub_category;
						
						array_push($arr1, $data2->Id_product);
					} 	
				}
				
			}

			for ($i=0; $i < count($arr1); $i++) { 
				
				$ctrpro++;

				if($ctrpro<=12)
				{
					$product = product::where('Id_product','=',$arr1[$i])
					->get();
	
					try {
						//code...
						$img = product_image::where('Id_product','=',$arr1[$i])
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
	
	
					$temp=$temp."<div class='custom-col-three-5 custom-col-style-5 mb-65'>";
						$temp=$temp. "<div class='product-wrapper' style='z-index:100' >";
							$temp=$temp."<div class='product-img'>";

							$dtpromoheader = promo_header::where('Status','=',1)
							->get();

							$dtpromodetail = promo_detail::where('Status','=',1)
							->get();

							$dtvariasi = variation::all();


							$sale=0;
							$upto= "";
							$maxrupiah=0;
							$mahal=0;
							$tes=0;
							foreach ($dtpromoheader as $promoheader ) {
								if($promoheader->Id_product == $product[0]['Id_product'])
								{
									$sale=1;
									$model= $promoheader->Model;
									$Id_variation = $promoheader->Id_variation;
									$sellprice=0;

									foreach ($dtvariasi as $vari) {
										if($vari->Id_variation==$Id_variation)
										{
											$sellprice=$vari->Sell_price;
										}
									}

									foreach ($dtpromodetail as $promodetail) {
										if($promoheader->Id_promo == $promodetail->Id_promo )
										{
											if($model=='%')
											{
												if(($sellprice * ($promodetail->Discount / 100)) > $mahal)
												{
													$mahal= $sellprice * ($promodetail->Discount / 100);
													$upto=$promodetail->Discount." %";
													$tes = $mahal;
												}
											}
											else if($model=='RP') {
												if(($promodetail->Discount) > $mahal)
												{
													$mahal= $promodetail->Discount;
													$upto= "Rp. ". number_format($promodetail->Discount);
												}
											}
											
										}
									}
									
								}
							}

							if($sale==1)
							{

								$temp=$temp."<span class='badge bg-danger text-white position-absolute' style='top: 0.5rem; right: 0.5rem;align-content: center; font-size:70%'>";
									$temp=$temp."Sale";
								$temp=$temp."</span>";
							}

								$temp=$temp. "<a href='".url('Cust_show_product/'.$arr1[$i])."'>";
									$temp=$temp. "<img src='".url('Uploads/Product/'.$imgname)."' alt=''>";
									$temp=$temp. "</a>";

								
                                
							$temp=$temp."</div>";

							$temp=$temp."<div class='funiture-product-content text-center'>";
							

								$temp=$temp."<h4><a href='".url('Cust_show_product/'.$arr1[$i])."'>".$product[0]['Name']."</a></h4>";
								
								//------------------------------------------------------
								$temp=$temp."<div class='quick-view-rating'>";
									$temp=$temp."<i class='fas fa-star'></i>";
									$temp=$temp."<i class='fas fa-star'></i>";
									$temp=$temp."<i class='fas fa-star'></i>";
									$temp=$temp."<i class='fas fa-star'></i>";
									$temp=$temp."<i class='fas fa-star'></i>";
								$temp=$temp."</div>";

								$temp=$temp."<div class='quick-view-number'>";
								$temp=$temp."<span>2 Ratting (S)</span>";
								$temp=$temp."</div>";
								//------------------------------------------------------

								$Id_product=$product[0]['Id_product'];
                                $fixharga="";
                                $murah=999999999999;
                                $mahal=0;
                                $ctr=0;
                                foreach ($dtvariasi as $datavariasi) {
                                    if($Id_product == $datavariasi->Id_product && $datavariasi->Status == 1)
                                    {
                                        $ctr++;
                                        if($datavariasi->Sell_price < $murah)
                                        {
                                            $murah= $datavariasi->Sell_price;
                                        }


                                        if($datavariasi->Sell_price > $mahal)
                                        {
                                            $mahal= $datavariasi->Sell_price;
                                        }
                                    }
                                }

                                if($ctr==1)
                                {
                                    $fixharga = 'Rp. '. number_format($mahal);
                                }
                                else {
                                    $fixharga = 'Rp. '.number_format($murah).' - '.number_format($mahal);
                                }





								$temp=$temp."<span>".$fixharga."</span>";
								
								
								if($sale==1)
								{
									$temp=$temp."<br><span style='color: red'>";
										$temp=$temp."Discount up to ".$upto;
										
										
									$temp=$temp."</span>";

								}


								$temp=$temp."</div>";
						$temp=$temp."</div>";
					$temp=$temp."</div>";
				}
			}
		}
		else
		{
			$prosub = product_sub_category::where('Id_sub_category','=', $id)
			->get();
			foreach ($prosub as $data) {
				$ctrpro++;

				if($ctrpro<=12)
				{
					$product = product::where('Id_product','=',$data->Id_product)
					->get();
	
					try {
						//code...
						$img = product_image::where('Id_product','=',$data->Id_product)
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
	
	
					$temp=$temp."<div class='custom-col-three-5 custom-col-style-5 mb-65'>";
						$temp=$temp. "<div class='product-wrapper' style='z-index:100'>";
							$temp=$temp."<div class='product-img'>";
									$temp=$temp. "<a href='".url('Cust_show_product/'.$product[0]['Id_product'])."'>";
									// $temp=$temp. "<a href='".url('Cust_show_product/'.$product->Id_product)."'>";
										$temp=$temp. "<img src='".url('Uploads/Product/'.$imgname)."' alt=''>";
									$temp=$temp. "</a>";
								$temp=$temp."<div class='product-action'>";
									$temp=$temp."<a class='animate-left' title='Wishlist' href='#'>";
										$temp=$temp."<i class='pe-7s-like'></i>";
										$temp=$temp."</a>";
									$temp=$temp."<a class='animate-top' title='Add To Cart' href='#'>";
										$temp=$temp."<i class='pe-7s-cart'></i>";
									$temp=$temp."</a>";
									$temp=$temp."<a class='animate-right' title='Quick View' data-bs-toggle='modal' data-bs-target='#exampleModal' href='#'>";
										$temp=$temp."<i class='pe-7s-look'></i>";
									$temp=$temp."</a>";
								$temp=$temp."</div>";
							$temp=$temp."</div>";
							$temp=$temp."<div class='funiture-product-content text-center'>";
								$temp=$temp."<h4><a href='".url('Cust_show_product/'.$product[0]['Id_product'])."'>".$product[0]['Name']."</a></h4>";
								$temp=$temp."<span>$90.00</span>";
								$temp=$temp."<div class='product-rating-5'>";
									$temp=$temp."<i class='pe-7s-star black'></i>";
									$temp=$temp."<i class='pe-7s-star black'></i>";
									$temp=$temp."<i class='pe-7s-star'></i>";
									$temp=$temp."<i class='pe-7s-star'></i>";
									$temp=$temp."<i class='pe-7s-star'></i>";
									$temp=$temp."</div>";
									$temp=$temp."</div>";
						$temp=$temp."</div>";
					$temp=$temp."</div>";
				}
			}


		}
		echo $temp;
	}

	public function view_more_halaman_home(Request $request)
	{
		//adr
		$id_cat = session()->get('id_cat');

		$query = sub_category::where('Status','=',1)
		->where('Id_category','=',$id_cat)
		->get();

		$kumpulan_id_sub_cat="";
		$ctr=0;
		foreach ($query as $data) {
			$ctr++;

			if($ctr==count($query))
			{
				$kumpulan_id_sub_cat= $kumpulan_id_sub_cat. $data->Id_sub_category;
			}
			else
			{
				$kumpulan_id_sub_cat= $kumpulan_id_sub_cat. $data->Id_sub_category.",";
			}
		}


		session()->forget('search_name');
		session()->put('search_name','');

		session()->forget('start_price');
		session()->put('start_price','');

		session()->forget('end_price');
		session()->put('end_price','');

		session()->forget('kumpulan_id_brand');
		session()->put('kumpulan_id_brand','');

		session()->forget('kumpulan_id_sub_cat');
		session()->put('kumpulan_id_sub_cat',$kumpulan_id_sub_cat);

		session()->forget('sortby');
		session()->put('sortby','');

		session()->forget('page');
		session()->put('page',1);
	}
	public function Cust_show_product($id)
	{
// adriel

	$param['dtproductimage2'] = product_image::all();

	$param['dtvariasi2'] = variation::all();

	$param['dtpromoheader2'] = promo_header::where('Status','=',1)
	->get();

	$param['dtpromodetail2'] = promo_detail::where('Status','=',1)
	->get();

		$param['dtproduct'] = product::where('product.Id_product','=',$id)
		->join('type','product.Id_type','type.Id_type')
		->join('brand','product.Id_brand','brand.Id_brand')
		->get();

		$param['dtproductsubcat'] = product::where('product.Status','=',1)
		->get();

		$param['dtproductimage'] = product_image::where('Id_product','=',$id)
		->orderby('Image_order')
		->get();


		$param['dtvariation'] = variation::where('Id_product','=',$id)
		->where('Status','=',1)
		->get();

		$param['subcat'] = product_sub_category::where('product_sub_category.Id_product','=',$id)
		->join('sub_category','product_sub_category.Id_sub_category','sub_category.Id_sub_category')
		->select('sub_category.Sub_category_name','sub_category.Id_sub_category')
		->get();


		$param['subcat2'] = product_sub_category::all();


		$param['dtpromoheader'] = promo_header::where('Status','=',1)
		->where('Id_product','=',$id)
		->get();

		$param['dtpromodetail'] = promo_detail::where('Status','=',1)
		->get();

		$param['dtproductreview'] = rate_review::join('cust_order_detail', 'cust_order_detail.Id_detail_order', 'rating_review.Id_detail_order')
		->join('member', 'member.Id_member', 'rating_review.Id_member')
		->where('cust_order_detail.Id_product', $id)
		->where('rating_review.Status', 'Active')
		->select("member.*", 'rating_review.*')
		->get();

		return view('Cust_show_product',$param);
	}

	public function Cust_show_product_affiliate($id,$Random_code)
	{
// adriel

	$param['dtproductimage2'] = product_image::all();

	$param['dtvariasi2'] = variation::all();

	$param['dtpromoheader2'] = promo_header::where('Status','=',1)
	->get();

	$param['dtpromodetail2'] = promo_detail::where('Status','=',1)
	->get();

		$param['dtproduct'] = product::where('product.Id_product','=',$id)
		->join('type','product.Id_type','type.Id_type')
		->join('brand','product.Id_brand','brand.Id_brand')
		->get();

		$param['dtproductsubcat'] = product::where('product.Status','=',1)
		->get();

		$param['dtproductimage'] = product_image::where('Id_product','=',$id)
		->orderby('Image_order')
		->get();


		$param['dtvariation'] = variation::where('Id_product','=',$id)
		->where('Status','=',1)
		->get();

		$param['subcat'] = product_sub_category::where('product_sub_category.Id_product','=',$id)
		->join('sub_category','product_sub_category.Id_sub_category','sub_category.Id_sub_category')
		->select('sub_category.Sub_category_name','sub_category.Id_sub_category')
		->get();


		$param['subcat2'] = product_sub_category::all();


		$param['dtpromoheader'] = promo_header::where('Status','=',1)
		->where('Id_product','=',$id)
		->get();

		$param['dtpromodetail'] = promo_detail::where('Status','=',1)
		->get();

		$param['dtproductreview'] = rate_review::join('cust_order_detail', 'cust_order_detail.Id_detail_order', 'rating_review.Id_detail_order')
		->join('member', 'member.Id_member', 'rating_review.Id_member')
		->where('cust_order_detail.Id_product', $id)
		->where('rating_review.Status', 'Active')
		->select("member.*", 'rating_review.*')
		->get();

		if(!Cookie::has("username_login") && !Cookie::has("Affiliate"))   //cookie username_login untuk mengecek bahwa browser bersih, blmpernah ada yg login/regist
		{
			Cookie::queue(Cookie::make("Affiliate", $Random_code, 1500000));
			Cookie::queue(Cookie::make("Tracking_code", "LINK-".$id, 1500000));


			$member_aff = member::where('Random_code', $Random_code)->first();

			$affiliate = DB::table('affiliate_member')
			->where('Id_product', $id)
			->where('Id_member',$member_aff->Id_member)
			->first();
			
			
			if(!empty($member_aff))
			{
				$total_diklik = 0;
				if(!empty($affiliate))
				{
					$total_diklik = $affiliate->Total_diklik + 1;	
					DB::update("update affiliate_member set Total_diklik = $total_diklik where Id_product = $id and Id_member = $member_aff->Id_member");
				}
				else 
				{
					$total_diklik = 1;
					DB::insert('insert into affiliate_member (Total_diklik, Id_member, Id_product) values (?, ?, ?)', [$total_diklik, $member_aff->Id_member, $id]);
				}
			}


			
		}


		return view('Cust_show_product',$param);
	}


	public function getpricevariant(Request $request)
	{
		$Id_variation = $request->Id_variation;

		$vari = variation::where('Id_variation','=',$Id_variation)
		->where('Status','=',1)
		->get();

		$dtpromoheader = promo_header::where('Status','=',1)
		->where('Id_variation','=',$Id_variation)
		->get();

		$dtpromodetail = promo_detail::where('Status','=',1)
		->orderby('Minimum_qty')
		->get();

		$sale=0;
		$model ="";
		$discount=0;
		$temp="";

		

		foreach ($dtpromoheader as $promoheader) {
			if($promoheader->Id_variation == $vari[0]->Id_variation)
			{
				$sale=1;
				$model = $promoheader->Model;
				foreach ($dtpromodetail as $promodetail) {
					if($promoheader->Id_promo == $promodetail->Id_promo)
					{
						if($promodetail->Minimum_qty == 1)
						{
							$discount= $promodetail->Discount;
							$sale=1;
							break;
						}
						else {
							$sale=0;
						}
					}
				}

			}
		}
		if($sale==1)
		{
			$hargabaru=0;
			if($model=='%')
			{
				$hargabaru = $vari[0]->Sell_price - ($vari[0]->Sell_price * ($discount/100));
			
				$temp=$temp."<span style='color: slategrey;font-size:65%'><s>Rp.". number_format($vari[0]->Sell_price)."</s> <b style='font-size:100%;color:red'>(Discount ".number_format($discount)." %)</b></span>";
				$temp=$temp."<br>";
				$temp=$temp."<span style='font-size:120%'>Rp. ".number_format($hargabaru)." </span>";
		
			}
			else if($model=="RP")
			{
				$hargabaru = $vari[0]->Sell_price - $discount;
				$temp=$temp."<span style='color: slategrey;font-size:65%'><s>Rp.". number_format($vari[0]->Sell_price)."</s> <b style='font-size:100%;color:red'>(Discount Rp. ".number_format($discount).")</b></span>";
				$temp=$temp."<br>";
				$temp=$temp."<span style='font-size:120%'>Rp. ".number_format($hargabaru)." </span>";
			
			}

		
		}
		else {
			$temp=$temp."<spanstyle='font-size:120%'>Rp. ".number_format($vari[0]->Sell_price)."</span>";
			
			
		}

		echo $temp."#". ($vari[0]['Stock']-$vari[0]['Stock_atc']-$vari[0]['Stock_pay']);
		// print_r($temp);
	}


	public function getpromovariant(Request $request)
	{
		$temp="";
		$Id_variation = $request->Id_variation;

		$vari = variation::where('Id_variation','=',$Id_variation)
		->where('Status','=',1)
		->get();

		$dtpromoheader = promo_header::where('Status','=',1)
		->where('Id_variation','=',$Id_variation)
		->get();

		$dtpromodetail = promo_detail::where('Status','=',1)
		->orderby('Minimum_qty')
		->get();

		$ctr=0;
		foreach ($dtpromoheader as $promoheader) {
			$ctr=$ctr+1;
			$temp=$temp."<br>";
			$temp=$temp. "<b>".date("d-m-Y", strtotime($promoheader->Start_date)) ." - ".date("d-m-Y", strtotime($promoheader->Start_date)). "</b> <br>";

			foreach ($dtpromodetail as $promodetail) {
				if($promodetail->Id_promo == $promoheader->Id_promo)
				{
					if($promoheader->Model=="%")
					{
						$temp=$temp."Min qty ". number_format($promodetail->Minimum_qty)."-> [ ".number_format($promodetail->Discount) ."% ] <br>";
					}
					else
					{
						$temp=$temp."Min qty ". number_format($promodetail->Minimum_qty)."-> [ Rp. ".number_format($promodetail->Discount) ." ] <br>";
					}
					
				}
			}
		}

		if($ctr==0)
		{
			$temp=$temp."No Active Discount";
		}
		
		echo $temp;

	}

	public function getpricechangeqty(Request $request)
	{
		$Id_variation = $request->Id_variation;
		$Jumqty= $request->Jumqty;

		$vari = variation::where('Id_variation','=',$Id_variation)
		->where('Status','=',1)
		->get();

		$dtpromoheader = promo_header::where('Status','=',1)
		->where('Id_variation','=',$Id_variation)
		->get();

		$dtpromodetail = promo_detail::where('Status','=',1)
		->orderby('Minimum_qty')
		->get();

		$sale=0;
		$model ="";
		$discount=0;
		$temp="";

		foreach ($dtpromoheader as $promoheader) {
			if($promoheader->Id_variation == $vari[0]->Id_variation)
			{
				$sale=1;
				$model = $promoheader->Model;
				foreach ($dtpromodetail as $promodetail) {
					if($promoheader->Id_promo == $promodetail->Id_promo)
					{
						if($Jumqty >= $promodetail->Minimum_qty)
						{
							$discount= $promodetail->Discount;
							$sale=1;
						}
					}
				}

			}
		}

		if($sale==1)
		{
			$hargabaru=0;
			if($model=='%')
			{
				$hargabaru = $vari[0]->Sell_price - ($vari[0]->Sell_price * ($discount/100));

				$temp=$temp."<span style='color: slategrey;font-size:65%'><s>Rp.". number_format($vari[0]->Sell_price)."</s> <b style='font-size:100%;color:red'>(Discount ".number_format($discount)." %)</b></span>";
				$temp=$temp."<br>";
				$temp=$temp."<span style='font-size:120%'>Rp. ".number_format($hargabaru)." </span>";
			}
			else if($model=="RP")
			{	
				$hargabaru = $vari[0]->Sell_price - $discount;

				$temp=$temp."<span style='color: slategrey;font-size:65%'><s>Rp.". number_format($vari[0]->Sell_price)."</s> <b style='font-size:100%;color:red'>(Discount Rp. ".number_format($discount).")</b></span>";
				$temp=$temp."<br>";
				$temp=$temp."<span style='font-size:120%'>Rp. ".number_format($hargabaru)." </span>";
			}
		}
		else {
			$temp=$temp."<span style='font-size:120%'>Rp.".number_format($vari[0]->Sell_price)."</span>";
			
			
		}

		echo $temp;

	}

	public function Advance_search()
	{
		$param['category'] = category::where('Status','=',1)
		->get();

		$param['subcategory'] = sub_category::where('Status','=',1)
		->get();

		
		$param['brand'] = brand::where('Status','=',1)
		->get();

		return view('Cust_advance_search',$param);

	}

	public function search_multi(Request $request)
	{
		$name = $request->name;
		$start_price = $request->start_price;
		$end_price = $request->end_price;
		$kumpulan_id_brand = $request->kumpulan_id_brand;
		$kumpulan_id_sub_cat = $request->kumpulan_id_sub_cat;

		session()->forget('search_name');
		session()->put('search_name',$name);

		session()->forget('start_price');
		session()->put('start_price',$start_price);

		session()->forget('end_price');
		session()->put('end_price',$end_price);

		session()->forget('kumpulan_id_brand');
		session()->put('kumpulan_id_brand',$kumpulan_id_brand);

		session()->forget('kumpulan_id_sub_cat');
		session()->put('kumpulan_id_sub_cat',$kumpulan_id_sub_cat);

		session()->forget('sortby');
		session()->put('sortby','');

		session()->forget('page');
		session()->put('page',1);

		//---------------------------------------------------


		return $this->hasil_Search(1);

	}

	public function muncul_awal_search()
	{
		echo $this->hasil_Search(session()->get('page'));
	}

	public function page_next_previous(Request $request)
	{
		$tipe = $request->tipe;

		if($tipe=="next")
		{
			$temp = session()->get('page');
			$temp++;
			echo $this->hasil_Search($temp);
		}
		else
		{
			$temp = session()->get('page');
			$temp--;
			if($temp<1)
			{
				$temp=1;
			}
			echo $this->hasil_Search($temp);
		}
	}

	public function search_name(Request $request)
	{
		$name = $request->name;

		session()->forget('search_name');
		session()->put('search_name', $name);

		session()->forget('start_price');
		session()->put('start_price','');

		session()->forget('end_price');
		session()->put('end_price','');

		session()->forget('kumpulan_id_brand');
		session()->put('kumpulan_id_brand','');

		session()->forget('kumpulan_id_sub_cat');
		session()->put('kumpulan_id_sub_cat','');

		session()->forget('sortby');
		session()->put('sortby','');

		session()->forget('page');
		session()->put('page',1);
	}

	public function clear_search(Request $request)
	{
		session()->forget('search_name');
		session()->put('search_name','');

		session()->forget('start_price');
		session()->put('start_price','');

		session()->forget('end_price');
		session()->put('end_price','');

		session()->forget('kumpulan_id_brand');
		session()->put('kumpulan_id_brand','');

		session()->forget('kumpulan_id_sub_cat');
		session()->put('kumpulan_id_sub_cat','');

		session()->forget('sortby');
		session()->put('sortby','');

		session()->forget('page');
		session()->put('page',1);

	}

	public function ganti_Sort(Request $request)
	{
		$urutan = $request->urutan;

		if($urutan==2)
		{
			session()->forget('sortby');
			session()->put('sortby','ASC');
		}
		else if($urutan==3)
		{
			session()->forget('sortby');
			session()->put('sortby','DESC');
		}
		else if($urutan==4)
		{
			session()->forget('sortby');
			session()->put('sortby','EXP');
		}
		else if($urutan==5)
		{
			session()->forget('sortby');
			session()->put('sortby','CHEAP');
		}
		else
		{
			session()->forget('sortby');
			session()->put('sortby','');
		}

		return $this->hasil_Search(1);
	}

	public function open_wishlist(Request $request)
	{
		try {
			if(session()->get('userlogin')->Role=="CUST")
			{
				echo "yes";
				// return view('Cust_wishlist');
			}
			else
			{
				echo "no";
			}
		} catch (\Throwable $th) {
			echo "no";
		}
		
	}

	public function open_wishlist2(Request $request)
	{
		$Id_member =session()->get('userlogin')->Id_member;
		$param['wishlist'] = wishlist::where('Id_member','=',$Id_member)
		->get();

		$param['product'] = product::where('Status','=',1)
		->get();

		$param['productimage'] = product_image::where('Image_order','=',1)
		->get();

		$param['variation'] = variation::where('Status','=',1)
		->get();

		$param['dtpromoheader'] = promo_header::where('Status','=',1)
		->get();

		$param['dtpromodetail'] = promo_detail::where('Status','=',1)
		->get();

		return view('Cust_wishlist',$param);
	}
	public function update_wishlist(Request $request)
	{
		$Id_member="";
		try {
			if(session()->get('userlogin')->Role=="CUST")
			{
				$Id_member =session()->get('userlogin')->Id_member;

				$wish = wishlist::where('Id_member','=',$Id_member)
				->get();

				echo (Count($wish));
			}
			else
			{
				echo('0');
			}
			
		} catch (\Throwable $th) {
			echo('0');
		}
	}

	public function add_wishlist(Request $request)
	{
		$Id_variation= $request->Id_variation;
		$Qty= $request->Qty;

		$var = variation::where('Id_variation','=',$Id_variation)
		->get();

		$Id_product = $var[0]['Id_product'];

		try {
			//code...
			$Id_member =session()->get('userlogin')->Id_member;
		} catch (\Throwable $th) {
			//throw $th;
			$Id_member="";
		}
	
		$temp=0;
		$wi = wishlist::where('Id_member','=',$Id_member)
		->get();

		foreach ($wi as $data) {
			if ($data->Id_variation == $Id_variation)
			{
				$temp=1;
			}
		}

		if($Id_member=="")
		{
			echo "mustlogin";
		}
		else if($temp==0)
		{
			$wish = new wishlist();
			$hasil = $wish->add_wishlist ($Id_product,$Id_variation,$Qty,$Id_member);
	
		}
		else
		{
			echo "double";
		}
	}

	public function updateqtywishlist(Request $request)
	{
		$Id_wishlist = $request->Id_wishlist;
		$Qty = $request->Qty;

		$wish = new wishlist();
		$hasil = $wish->edit_wishlist($Id_wishlist,$Qty);

	}

	public function deletewishlist(Request $request)
	{
		$Id_wishlist = $request->Id_wishlist;

		$wish = new wishlist();
		$hasil = $wish->delete_wishlist($Id_wishlist);
	}


	public function updateqtycart(Request $request)
	{
		$Id_cart = $request->Id_cart;
		$Qty = $request->Qty;


		if(session()->get('userlogin'))
		{
			$cart = new cart();
			$hasil = $cart->edit_cart($Id_cart,$Qty);
		}
		else
		{
			$arr = json_decode(session()->get('cart'));

			foreach ($arr as $data) {
				if($Id_cart==$data->Id_cart)
				{
					$data->Qty = $Qty;
				}
			}
		}
		session()->put('cart',json_encode($arr));

	}

	public function cart(Request $request)
	{
		$Id_member="";
		try {
			//code...
			$Id_member =session()->get('userlogin')->Id_member;
		} catch (\Throwable $th) {
			//throw $th;
			$Id_member="";
		}
		

		if($Id_member!="")
		{

			$param['cart'] = cart::where('Id_member','=',$Id_member)
			->get();
	
		}
		else
		{
			if(session()->get('cart'))
			{
				$param['cart'] = json_decode(session()->get('cart'));
			}
			else
			{
				$param['cart'] =[];
			}
			
		}



		$param['product'] = product::where('Status','=',1)
		->get();

		$param['productimage'] = product_image::where('Image_order','=',1)
		->get();

		$param['variation'] = variation::where('Status','=',1)
		->get();

		$param['dtpromoheader'] = promo_header::where('Status','=',1)
		->get();

		$param['dtpromodetail'] = promo_detail::where('Status','=',1)
		->get();

		return view('Cust_cart',$param);
	}

	public function add_cart(Request $request)
	{
		$Id_variation= $request->Id_variation;
		$Qty= $request->Qty;

		$var = variation::where('Id_variation','=',$Id_variation)
		->get();

		$Id_product = $var[0]['Id_product'];

		try {
			//code...
			$Id_member =session()->get('userlogin')->Id_member;
		} catch (\Throwable $th) {
			//throw $th;
			$Id_member="";
		}
	


		$temp=0;
		$cr = cart::where('Id_member','=',$Id_member)
		->get();

		foreach ($cr as $data) {
			if ($data->Id_variation == $Id_variation)
			{
				$temp=1;
			}
		}

		if($Id_member=="")
		{
			$kembar=0;
			$ctr=0;
			$arr = json_decode(session()->get('cart')) ?? []; 
			for($i = 0; $i < count($arr); $i++) {
				$ctr++;
				if(($arr[$i]->Id_variation == $Id_variation) && ($arr[$i]->Id_cart>0))
				{
					$kembar=1;
				}
			}

			if(($var[0]->Stock*1 - $var[0]->Stock_atc*1 - $var[0]->Stock_pay*1)<$Qty*1)
			{
				echo "stok habis";
			}
			else if($kembar==0)
			{
				$baru       = array(
				'Id_cart' => ($ctr+1),
				'Id_product' => $Id_product, 
				'Id_variation' => $Id_variation, 
				'Qty' => $Qty, 
				);
				array_push($arr, $baru); 
				session()->put('cart', json_encode($arr));
		
		
			}
			else
			{
				echo "double";
			}


		}
		else 
		{
			if(($var[0]->Stock*1 - $var[0]->Stock_atc*1 - $var[0]->Stock_pay*1)<$Qty*1)
			{
				echo "stok habis";
			}
			else if($temp==0)
			{
				$cart = new cart();
				$hasil = $cart->add_cart($Id_product,$Id_variation,$Qty,$Id_member);
			}
			else
			{
				echo "double";
			}
		}

	}
	public function deletecart(Request $request)
	{
		$Id_cart = $request->Id_cart;

		if(session()->get('userlogin'))
		{
			$cart = new cart();
			$hasil = $cart->delete_cart($Id_cart);
		}
		else
		{
			$arr = json_decode(session()->get('cart'));
			foreach ($arr as $data) {
				if($Id_cart==$data->Id_cart)
				{
					$data->Id_cart =-1;
				}
			}
			session()->put('cart',json_encode($arr));

		}
		
	}
	public function update_cart(Request $request)
	{
		$Id_member="";
		try {
			if(session()->get('userlogin')->Role=="CUST")
			{
				$Id_member =session()->get('userlogin')->Id_member;

				$cart = cart::where('Id_member','=',$Id_member)
				->get();

				echo (Count($cart));
			}
			else
			{
				
				if(session()->get('cart'))
				{
					$hitung=0;

					foreach (json_decode(session()->get('cart')) as $data) {
						if($data->Id_cart<0)
						{

						}
						else
						{
							$hitung++;
						}
					}
					echo($hitung);
				}
				else
				{
					echo('0');
				}
				
			}
			
		} catch (\Throwable $th) {
			if(session()->get('cart'))
			{
				$hitung=0;

					foreach (json_decode(session()->get('cart')) as $data) {
						if($data->Id_cart<0)
						{

						}
						else
						{
							$hitung++;
						}
					}
					echo($hitung);
			}
			else
			{
				echo('0');
			}
			
		}
	}

	public function Ebook_marketing()
	{
		// $ebooks = ebook::leftJoin('ebook_member_downloaded', 'ebook.Id_ebook', 'ebook_member_downloaded.Id_ebook')->where('status', 1)->get();
		
		$param['ebooks'] = ebook::where('ebook.Status','=',1)
		->select('ebook.Id_ebook','ebook.Title','ebook.Image','ebook.Pdf_file','ebook.Status','ebook_member_downloaded.Total_didownload','ebook_member_downloaded.Id_member')
		->leftjoin('ebook_member_downloaded','ebook.Id_ebook','ebook_member_downloaded.Id_ebook')
		->get();
		
		$Random_code = session()->get('userlogin')->Random_code;

		$param['cust_order'] = cust_order_header::where('Affiliate','=',$Random_code)
		->where('Status','>=',2)
		->get();

		foreach ($param['ebooks'] as $book) {
			$book->sub_category = sub_category::find($book->Id_sub_category);
			$book->downloaded_detail = email_ebook::leftJoin('cust_order_header', 'cust_order_header.Id_prospect', 'submitted_email_ebook.id')
			->Select('cust_order_header.*','submitted_email_ebook.*')
			->where('submitted_email_ebook.Ebook_id', $book->Id_ebook)
			->where('submitted_email_ebook.User_token', $Random_code)
			->get();

		}


		return view('Cust_ebook', $param);
	}

	public function Affiliate_marketing(Request $request)
	{
		$param['affiliate'] = affiliate::where('affiliate.Status','=',1)
		->join('product','affiliate.Id_product','product.Id_product')
		->leftJoin('affiliate_member', 'affiliate_member.Id_product', 'affiliate.Id_product')
		// ->where('affiliate_member.Id_member','=',session()->get('userlogin')->Id_member)
		->select('affiliate.*', 'product.*', 'affiliate_member.Total_diklik', 'affiliate_member.Id_member')
		->get();

		$param['dtproduct'] = product::where('product.Status','=', '1')
		->join('brand','product.Id_brand','brand.Id_brand')
		->join('type','product.Id_type','type.Id_type')
		->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
		"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
			->get();

		
		$Random_code = session()->get('userlogin')->Random_code;

		$param['cust_order'] = cust_order_header::where('Affiliate','=',$Random_code)
		->where('Status','>=',2)
		->get();


		$param['dtvariation']= variation::where('Status','=',1)
		// ->select("Option_name","Id_product")
		->get();


		$param['dtproductimage'] = Product_image::all();

		return view('Cust_affiliate',$param);
	}

	public function show_detail_order(Request $request)
	{
		//adrieljenn
		$temp="";
		$kumpulan_id_order = $request->kumpulan_id_order;

		$arr_id_order = explode("," ,$kumpulan_id_order);
		
		foreach ($arr_id_order as $data) {
			
			if($data!="")
			{
				$custorder = cust_order_header::join('list_city', 'list_city.Id_city', 'cust_order_header.Id_city')->where('Id_order', $data)->first(); 

				$order_detail = cust_order_detail::join('product', 'product.Id_product', 'cust_order_detail.Id_product')->join('variation_product', 'variation_product.Id_variation', 'cust_order_detail.Id_variation')->where('cust_order_detail.Id_order', $data)->select('product.Name', 'cust_order_detail.Normal_price','cust_order_detail.Discount_promo','cust_order_detail.Qty', 'cust_order_detail.Fix_price', 'variation_product.Variation_name as Variant_name', 'variation_product.Option_name as Variant_option_name', 'cust_order_detail.Id_product', 'cust_order_detail.Id_variation')->get();
				
				if($custorder->Tracking_code != "0"){
					
					foreach ($order_detail as $detail) {
						$affiliate = affiliate::where("Id_product", $detail->Id_product)->where("Id_variation", $detail->Id_variation)->where("status", 1)->first();
						if(!empty($affiliate)){
							$detail->point = $affiliate->Poin;
							$custorder->total_point += $affiliate->Poin;
						}else {
							$detail->point = 0;
						}
					}
				}

				$temp = $temp. "<tr>";
					$temp = $temp. "<td>";
						$temp = $temp. $custorder->Id_order;
					$temp = $temp. "</td>";
					$temp = $temp. "<td>";
						$temp = $temp. $custorder->Date_time;
					$temp = $temp. "</td>";
					$temp = $temp. "<td>";
						$temp = $temp. $custorder->Name."<br>".$custorder->Phone ;
					$temp = $temp. "</td>";
					$temp = $temp. "<td>";
						$temp = $temp. $custorder->Address.", " .$custorder->City_name. ", ".$custorder->Province_name ;
					$temp = $temp. "</td>";
					// $temp = $temp. "<td>";
					// 	$temp = $temp. $custorder->Courier . "($custorder->Courier_packet)";
					// $temp = $temp. "</td>";
					$temp = $temp. "<td>";
						$temp = $temp. "Rp. ". number_format($custorder->Gross_total);
					$temp = $temp. "</td>";
					$temp = $temp. "<td>";
						$temp = $temp.$custorder->Courier . "($custorder->Courier_packet)". "<br> Rp. ". number_format($custorder->Shipping_cost);
					$temp = $temp. "</td>";
					$temp = $temp. "<td>";
						$temp = $temp. "Rp. ". number_format($custorder->Discount);
					$temp = $temp. "</td>";
					$temp = $temp. "<td>";
						$temp = $temp. "Rp. ". number_format($custorder->Grand_total);
					$temp = $temp. "</td>";
					$temp = $temp. "<td>";
						$temp = $temp. $custorder->total_point;
					$temp = $temp. "</td>";
					$temp = $temp. "<td>";
						$temp = $temp.  "<button class='btn btn-sm btn-info' data-toggle='modal' data-target='#rincian_order_detail' data-order-detail='". json_encode($order_detail) ."'>Rincian</button>";
					$temp = $temp. "</td>";
				
				$temp = $temp. "</tr>";

				
			}
			
		}

		return $temp;
	}


	public function Affiliate_embed_code(Request $request)
	{

		$param['affiliate'] = affiliate::where('affiliate.Status','=',1)
		->join('product','affiliate.Id_product','product.Id_product')
		->select('affiliate.*', 'product.*')
		->get();
		

		//cayang2
		foreach ($param['affiliate'] as $aff) {
			$embed_aff = DB::table("embed_member")
				->where("Id_product", $aff->Id_product)
				->where('Id_member', session()->get('userlogin')->Id_member)
				->first();

			$aff->embed_aff = $embed_aff;

			if(!empty($embed_aff)){
				$aff->embed_aff->submitted = embed_checkout::join('product', 'product.Id_product', 'submitted_embed_checkout.Id_product')->join('variation_product', 'submitted_embed_checkout.Id_variation', 'variation_product.Id_variation')
					->leftJoin('cust_order_header', 'cust_order_header.Id_prospect', 'submitted_embed_checkout.id')
					->where('submitted_embed_checkout.Id_product', $embed_aff->Id_product)->where("User_token", session()->get('userlogin')->Random_code)
					->select("submitted_embed_checkout.*", 'product.name as namaproduk', 'variation_product.Option_name as variasi', 'cust_order_header.Id_order as Id_order')
					->get();
			}
		}







		$param['dtproduct'] = product::where('product.Status','=', '1')
		->join('brand','product.Id_brand','brand.Id_brand')
		->join('type','product.Id_type','type.Id_type')
		->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
		"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
			->get();

		
		$Random_code = session()->get('userlogin')->Random_code;

		$param['cust_order'] = cust_order_header::where('Affiliate','=',$Random_code)
		->where('Status','>=',2)
		->get();


		$param['dtvariation']= variation::where('Status','=',1)
		// ->select("Option_name","Id_product")
		->get();


		$param['dtproductimage'] = Product_image::all();

		return view('Cust_embed_code',$param);
	}

	public function point(Request $request)
	{
		$this->validasivoucher();
		$Id = session()->get('userlogin')->Id_member;

		$param['dtmember'] = member::where('Id_member','=',$Id)
		->get();

		$param['dtmember_all'] = member::all();

		$param['dtvoucher'] = voucher::where('Status','=',1)
		->select('Id_voucher','Voucher_name',\DB::raw('(CASE WHEN Voucher_type = 1 THEN "Disc All Product" WHEN Voucher_type = 2 THEN "Disc Selected Product" ELSE "Disc Shipping Cost" END) AS Voucher_type'),'Discount','Point','Redeem_due_date','Joinpromo', 'Quota')
		->get();

		$param['dtvouchermember'] = voucher_member::all();

		$param['dtvoucher_all'] = voucher::all();

		$param['dtpoint_card'] = point_card::where('Id_member','=',$Id)
		->orderby('Id_point_card', 'desc')
		->get();

		$param['dtcustheader'] = cust_order_header::all();

		return view('Cust_point',$param);
	}

	public function claim_voucher(Request $request)
	{
		$Id_voucher = $request->Id_voucher;
		$vc = voucher::where('Id_voucher','=',$Id_voucher)
		->get();

		$vcpoint = $vc[0]->Point;

	
		// $pointmember = session()->get('userlogin')->Point;
		$Id_member = session()->get('userlogin')->Id_member;
		$fp= member::where('Id_member','=',$Id_member)
		->get();

		$pointmember = $fp[0]->Point;

		$lolosvalidasivoucher = 1;
		$vc = voucher::where('Status','<>',0)
		->get();

		// print_r('aaaaccca');
		// echo "aadsd";
		foreach ($vc as $data) {
			if($data->Redeem_due_date < date('Y-m-d') && $Id_voucher== $data->Id_voucher)
			{
				//expire lewat tanggal
				$lolosvalidasivoucher =0;
			}
		}


		$quotaterpakai = voucher_member::where('Id_voucher','=',$Id_voucher)->count();

		$vc2 = voucher::where('Id_voucher','=',$Id_voucher)
		->get();
		if($lolosvalidasivoucher==0)
		{
			echo "gagal validasi voucher";
		}
		else if($pointmember<$vcpoint)
		{
			echo "ga cukup";
		}
		else if ($quotaterpakai>=$vc2[0]->Quota)
		{
			echo "Quota voucher habis";
		}
		else
		{
			$vm = new voucher_member;
			$hasil = $vm->add_voucher_member($Id_member, $Id_voucher);

			$First_point = 0;
			$fp= member::where('Id_member','=',$Id_member)
			->get();

			$First_point = $fp[0]->Point;
			

			try {
				//code...
				$pc = point_card::where('Id_member','=',$Id_member)
				->orderBy('Id_point_card')
				->get();

				
				foreach ($pc as $datapc) {
					# code...
					$First_point = $datapc->Last_point;
				}
			} catch (\Throwable $th) {
				//throw $th;
			}
			

			$Last_point = $First_point-$vcpoint;

			$memberpoint = new member;
			$hasil = $memberpoint->edit_point($Id_member,$Last_point);



			$tgl= date('d/m/Y');
			$tglfix = $tgl[6].$tgl[7].$tgl[8].$tgl[9]."/".$tgl[3].$tgl[4]."/".$tgl[0].$tgl[1];
			
			$pointcard = new point_card;
			$hasil = $pointcard->add_point_card($Id_member,$tglfix,$First_point,0,$vcpoint,$Last_point,"Claim voucher",$Id_voucher);

			//--------------------------------------------

			//update history point modal

			$temp="";


			
			$temp=$temp."<table class='table_id_2' class='table table-striped display'>";
				$temp=$temp."<thead>";
					$temp=$temp."<tr>";
						$temp=$temp."<th>Date</th>";
						$temp=$temp."<th>Description</th>";
						$temp=$temp."<th>+ / -</th>";
					$temp=$temp."</tr>";
				$temp=$temp."</thead>";
				$temp=$temp."<tbody>";

					$pc = point_card::where('Id_member','=',$Id_member)
					->get();
					foreach ($pc as $data) {
						$temp=$temp."<tr>";

							$simpandulu= date('d-m-Y', strtotime($data->Date_card));
							$temp=$temp."<td>".$simpandulu."</td>";
							$txt="";
							if($data->Type == "Claim voucher")
							{
								$dtvoucher_all = voucher::all();
							foreach ($dtvoucher_all as $dtvc) {
								if($dtvc->Id_voucher == $data->No_reference)
								{
								$txt = "Claim voucher - ".$dtvc->Voucher_name;
								}
							}
							}
							$temp=$temp."<td>".$txt."</td>";

							$plusmines="";
							if($data->Debet==0)
							{
								$temp=$temp."<td style='color: red'>";
									$temp=$temp."<b>-".$data->Credit."</b>";
								$temp=$temp."</td>";
										
							}
							else {
							
								$temp=$temp."<td style='color: green'>";
									$temp=$temp."<b>+".$data->Debet."</b>";
								$temp=$temp."</td>";


							
							}

						$temp=$temp."</tr>";
					}
					$temp=$temp."</tbody>";
				$temp=$temp."</table>";
                      
                echo $Last_point."#".$temp;

		}

	}

	public function get_voucher_selected_product(Request $request)
	{
		$Id_voucher = $request->Id_voucher;

		$voucher = voucher::where('Id_voucher','=',$Id_voucher)
		->get();

		$vp = voucher_product::where('Id_voucher','=',$Id_voucher)
		->get();

	
		$product = product::join('brand','product.Id_brand','brand.Id_brand')
		->join('type','product.Id_type','type.Id_type')
		->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
		"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
			->get();


		$variation= variation::where('Status','=',1)
		->select("Option_name","Id_product")
		->get();

		$dtproductimage = Product_image::all();

		$temp="";


		$temp=$temp."<table class='table table-striped display table_id_3'>";
		$temp=$temp."<thead>";
			$temp=$temp."<tr>";
				$temp=$temp."<th>Product Image</th>";
				$temp=$temp."<th>Name</th>";
				$temp=$temp."<th>Brand</th>";
				$temp=$temp."<th>Type</th>";
				$temp=$temp."<th>Variation</th>";
			$temp=$temp."</tr>";
		$temp=$temp."</thead>";
		$temp=$temp."<tbody>";
		foreach ($vp as $datavp) {
		

			foreach ($product as $dataproduct) {
				
				if($datavp->Id_product == $dataproduct->Id_product)
				{
					$imgname = "default.jpg";
					foreach ($dtproductimage as $img)
					{
						$idi = $img->Id_product;
						$urutan = $img->Image_order;
						
						if (($datavp->Id_product == $idi) && ($urutan==1))
						{
						$imgname = $img->Image_name;
						}
					}

					

						$temp=$temp."<tr>";


							$temp=$temp."<td width='150px'>";
							
								$temp=$temp."<img src='".url('Uploads/Product/'.$imgname)."' width='150px' height='150px' class='center'>";

							$temp=$temp."</td>";


							$temp=$temp."<td>";

								$temp=$temp.$dataproduct->Name;

							$temp=$temp."</td>";

							$temp=$temp."<td>";

								$temp=$temp.$dataproduct->Brand_name;

							$temp=$temp."</td>";

							$temp=$temp."<td>";

								$temp=$temp.$dataproduct->Type_name;

							$temp=$temp."</td>";

							$temp=$temp."<td>";
								$vari="";
								$vari2="";
								if($dataproduct->Variation == "NONE")
								{
									$vari2="NONE";
								}
								else
								{
								foreach ($variation as $datavar) {
									if($datavar->Id_product == $dataproduct->Id_product )
									{
									$vari.=$datavar->Option_name." , ";
									}
								}
								$vari2=substr($vari,0,-2);
								}


								$temp=$temp."(".$vari2.")";

							// $temp=$temp."</td>";


						$temp=$temp."</tr>";
					
					
					
					
				 
					
				}
			}
			
		}

		
		$temp=$temp."</tbody>";
					
		$temp=$temp."</table>";


		echo($temp."#".$voucher[0]->Voucher_name);

	}

	public function My_voucher(Request $request)
	{
		$param['dtvoucher'] = voucher::select('Id_voucher','Voucher_name',\DB::raw('(CASE WHEN Voucher_type = 1 THEN "Disc All Product" WHEN Voucher_type = 2 THEN "Disc Selected Product" ELSE "Disc Shipping Cost" END) AS Voucher_type'),'Discount','Point','Redeem_due_date','Joinpromo')
		->get();


		$Id_member = session()->get('userlogin')->Id_member;
		$param['dtvouchermember'] = voucher_member::where('Id_member','=',$Id_member)
		->get();

		return view('Cust_my_voucher',$param);
	}

	public function get_city(Request $request)
	{
		$Id_province = $request->Id_province;

		$city = list_city::where('Id_province','=',$Id_province)
		->get();

		return $city;
	}

	public function add_address(Request $request)
	{
		$Id_province = $request->Id_province;
		$Id_city =  $request->Id_city;
		$Address =  $request->Address;
		$Id_member = session()->get('userlogin')->Id_member;


		$dtaddress = address_member::where('Status','=',1)
		->where('Id_member','=',$Id_member)
		->get();

		$ctr=0;
		foreach ($dtaddress as $key ) {
			# code...

			$ctr++;
		}

		if($ctr<3)
		{
			$add = new address_member();
			$hasil= $add->add_address($Id_member,$Id_city,$Id_province,$Address);
			echo "sukses";
		}
		else
		{
			echo "lebih 3";
		}
	}


	public function edit_address(Request $request)
	{
		$Id_address = $request->Id_address;
		$Id_province = $request->Id_province;
		$Id_city =  $request->Id_city;
		$Address =  $request->Address;
		$Id_member = session()->get('userlogin')->Id_member;

		$add = new address_member();
		$hasil= $add->edit_address($Id_address,$Id_city,$Id_province,$Address);
		echo "sukses";
	}


	public function delete_address(Request $request)
	{
		$Id_address = $request->Id_address;

		$add = new address_member();
		$hasil= $add->delete_address($Id_address);
		echo "sukses";
	}
	

	public function getaddress(Request $request)
	{
		$Id_address= $request->Id_address;


		$add = address_member::where('Id_address','=',$Id_address)
		->get();

		$Id_province = $add[0]->Id_province;

		$add2 = list_city::where('Id_province','=',$Id_province)
		->get();

		return $add."#".$add2;
	}

	public function to_checkout(Request $request)
	{
		$Id_member="";
		try {
			//code...
			$Id_member =session()->get('userlogin')->Id_member;
		} catch (\Throwable $th) {
			//throw $th;
			$Id_member="";
		}

		if($Id_member!="") //login
		{
			$cart = cart::where('Id_member','=',$Id_member)
			->get();


		}
		else //guess
		{
			$cart = json_decode(session()->get('cart'));
		}

		
		$masalah="";
		foreach ($cart as $datacart) {
			
			$cek = $this->cek_stok($datacart->Id_variation,$datacart->Qty);

			if($cek=="sukses")
			{

			}
			else
			{
				$masalah = $cek;
			}

		}

		echo $masalah;

	}

	public function cek_stok($Id_variation,$qty)
	{
		$var = variation::where('Id_variation','=',$Id_variation)
		->get();

		if($qty <= ($var[0]->Stock - $var[0]->Stock_atc - $var[0]->Stock_pay))
		{
			return "sukses";
		}
		else
		{
			$pro = product::where('Id_product','=',$var[0]->Id_product)
			->get();

			return $pro[0]->Name." - ".$var[0]->Option_name." Available stock is ".($var[0]->Stock - $var[0]->Stock_atc - $var[0]->Stock_pay);
		}
	}

	public function Cust_checkout(Request $request)
	{
		$Id_member="";
		try {
			//code...
			$Id_member =session()->get('userlogin')->Id_member;
		} catch (\Throwable $th) {
			//throw $th;
			$Id_member="";
		}
		

		if($Id_member!="")
		{

			$param['cart'] = cart::where('Id_member','=',$Id_member)
			->get();

			$Id_member = session()->get('userlogin')->Id_member;

			$param['Id_member'] = $Id_member;
	
		}
		else
		{
			$param['Id_member'] ="";
			if(session()->get('cart'))
			{
				$param['cart'] = json_decode(session()->get('cart'));
			}
			else
			{
				$param['cart'] =[];
			}
			
		}
		$param['product'] = product::where('Status','=',1)
		->get();

		$param['productimage'] = product_image::where('Image_order','=',1)
		->get();

		$param['variation'] = variation::where('Status','=',1)
		->get();

		$param['dtpromoheader'] = promo_header::where('Status','=',1)
		->get();

		$param['dtpromodetail'] = promo_detail::where('Status','=',1)
		->get();

		$param['dtaddress'] = address_member::where('address_member.Status','=',1)
		->where('address_member.Id_member','=',$Id_member)
		->Join('list_city','address_member.Id_city','list_city.Id_city')
		->get();

		try {
			session()->put('Id_address',$param['dtaddress'][0]->Id_address);
		} catch (\Throwable $th) {
			//throw $th;
		}


		$param['dtvoucher'] = voucher::select('Id_voucher','Voucher_name',\DB::raw('(CASE WHEN Voucher_type = 1 THEN "Disc All Product" WHEN Voucher_type = 2 THEN "Disc Selected Product" ELSE "Disc Shipping Cost" END) AS Voucher_type'),'Discount','Point','Redeem_due_date','Joinpromo')
		->get();

		$param['dtvouchermember'] = voucher_member::where('Id_member','=',$Id_member)
		->get();
		

		$db = list_city::all(); 
		$arr= [];  // array 
		$arr2= [];  // array 
		foreach($db as $row) {
            $arr[0] = "";
			$arr2[0] = "";
			$arr[$row->Id_province] = $row->Province_name; 
			$arr2[$row->Id_city] = $row->City_name; 
		
		}
		
		$param['arr_province']  = $arr; 
		$param['arr_city']  = $arr2; 
		return view('Cust_checkout',$param);
	}

	public function Get_address(Request $request)
	{
		$Id_address = $request->Id_address;

		$add = address_member::where('address_member.Id_address','=',$Id_address)
		->join('list_city','address_member.Id_city','list_city.Id_city')
		->get();

		$Address="";
		$City_name="";
		$Province_name="";

		foreach ($add as $data) {
			$Address = $data->Address;
			$City_name = $data->City_name;
			$Province_name = $data->Province_name;
		}
		session()->put('Id_address',$Id_address);
		echo $Address."#".$City_name."#".$Province_name;
	}
	
	function getCost($apikey, $destination, $weight, $courier) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "origin=444&destination=$destination&weight=$weight&courier=$courier",
		  CURLOPT_HTTPHEADER => array(
			"content-type: application/x-www-form-urlencoded",
			"key: $apikey"
		  ),
		));
	
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl); 
		
		return $response; 
	}


	public function Get_cost_shipping(Request $request)
	{
		$str_courier = $request->courier;
		$weight = $request->weight * 1000;

		$Address_dest = session()->get('Id_address');

		$add= address_member::where('Id_address','=',$Address_dest)
		->get();


		if($request->Id_city == 0)
		{
			$Id_city = $add[0]['Id_city']; //member
		}
		else
		{
			$Id_city = $request->Id_city; //Guess
		}
	




		$temp="";
		$apikey = "5871496d6aeddd58790a98a8ea36ccd9"; 
		$res = $this->getCost($apikey, $Id_city, $weight,$str_courier);
		$arr = json_decode($res); 
		$jumresults = count($arr->rajaongkir->results); 

		for($i = 0; $i < $jumresults; $i++) 
		{
			$kurir = $arr->rajaongkir->results[$i]->costs; 
			$jumservice= count($kurir); 
			for($i = 0; $i < $jumservice; $i++) {

				$kurirservice = $kurir[$i]->service;
				$kurirservice_2 = str_replace(" ", "_", $kurirservice);

				$temp=$temp."<div class='form-check'>";
					$temp=$temp."<input class='form-check-input' type='radio' id='flexRadioDefault1' name='1' onclick={{pilih_paket_kurir('".$kurirservice_2."-".$kurir[$i]->cost[0]->value."')}}>";
						$temp=$temp."<label class='form-check-label' for='flexRadioDefault1'>";
							$temp=$temp.$kurir[$i]->service." - ".$kurir[$i]->cost[0]->value ;
						$temp=$temp."</label>";
				$temp=$temp."</div>";
					
			}
		}

		echo $temp;
	}

	public function Use_voucher(Request $request)
	{
		$Id_voucher = $request->Id_voucher;

		$dtvoucher = voucher::where('Id_voucher','=',$Id_voucher)
		->get();

		$dtvoucherproduct = voucher_product::where('Id_voucher','=',$Id_voucher)
		->get();

		$Id_member = session()->get('userlogin')->Id_member;

		$cart = cart::where('Id_member','=',$Id_member)
		->get();

		$dtpromoheader = promo_header::where('Status','=',1)
		->get();

		$dtpromodetail = promo_detail::where('Status','=',1)
		->get();

		$pakaivoucher=1;
		$voucherselectedproduct=0;
		$selectedproduct =0;
		foreach ($cart as $datacart) {

			foreach ($dtpromoheader as $datapromoheader) {
				if($datacart->Id_product == $datapromoheader->Id_product && $dtvoucher[0]->Joinpromo==0)
				{
					//product ada promo dan tidak boleh di gabung dengan promo
					$pakaivoucher=0;

				}
			}
		}


		foreach ($dtvoucherproduct as $datavoucherpro) {

			if($dtvoucher[0]->Voucher_type==2)
			{
				foreach ($cart as $datacart) {

					if($datavoucherpro->Id_product == $datacart->Id_product)
					{
						$voucherselectedproduct=1;
					}
				}

			}
			else
			{
				$voucherselectedproduct=1;
			}
			
		}

		if(count($dtvoucherproduct)<=0)
		{
			$voucherselectedproduct=1;
		}

		if ($voucherselectedproduct==0)
		{
			echo "no product selected";
		}
		else if($pakaivoucher==0)
		{
			echo "no join promo";
		}
		else
		{
			echo $dtvoucher[0]->Id_voucher."#".$dtvoucher[0]->Voucher_name."#".$dtvoucher[0]->Voucher_type."#".$dtvoucher[0]->Discount;
		}
	}

	public function Pay_cust(Request $request)
	{
		$member =0;
		try {
			$member = session()->get('userlogin')->Id_member;
		
		
		} catch (\Throwable $th) {
			$member =0;
		}

		$Courier = $request->Courier;
		if($Courier==0)
		{
			$Courier = "JNE";
		}
		else if($Courier==1)
		{
			$Courier = "POS";
		}
		else
		{
			$Courier = "TIKI";
		}

		$Courier_packet = $request->Courier_packet;


		$Id_voucher = $request->Id_voucher;
		$Weight = $request->Weight;
		$Gross_total = $request->Gross_total;
		$Shipping_cost = $request->Shipping_cost;
		$Discount = $request->Discount;
		$Grand_total = $request->Grand_total;
		$Affiliate="";
		$Shipper=0;
		$Status=1; //Status 1- belum bayar
		$Date_time = now();
		// echo $Date_time;

		if($member==0) //GUESS - No Login
		{
			$Address = $request->Address;
			$Id_city = $request->Id_city;
			$Id_province = $request->Id_province;
			$Phone = $request->Phone;
			$Email = $request->Email;
			$Name = $request->Name;
			$Id_member = 0;
			$Discount =0;
			$Id_voucher=0;

			$cust_header = new cust_order_header();
			$hasil = $cust_header->insertdata($Date_time, $Id_member, $Address, $Id_province,$Id_city,
			$Name,$Email, $Phone, $Courier, $Courier_packet, $Affiliate, $Id_voucher, $Weight, $Gross_total, $Shipping_cost,$Discount,$Grand_total,$Shipper,$Status);


			$arr = json_decode(session()->get('cart'));

			foreach ($arr as $datacart) {

				if($datacart->Id_cart!=-1) //-1 itu cart yg di delete di session
				{
					$cust_header_2 = new cust_order_header();
					$Id_order =  $cust_header_2->getlastinvoice();
	
	
					$dtpromoheader = promo_header::where('Status','=',1)
					->where('Id_variation','=',$datacart->Id_variation)
					->get();
			
					$dtpromodetail = promo_detail::where('Status','=',1)
					->get();
	
					$variation = variation::where('Id_variation','=',$datacart->Id_variation)
					->where('Status','=',1)
					->get();
	
	
					$Normal_price = $variation[0]->Sell_price;
					$Id_promo =0;
					$Discount_promo=0;
					$Fix_price = $Normal_price;
					if(count($dtpromoheader)>=1)
					{
						foreach ($dtpromoheader as $promhead) {
							
							foreach ($dtpromodetail as $promdetail) {
								if($promhead->Id_promo == $promdetail->Id_promo)
								{
									if($datacart->Qty>= $promdetail->Minimum_qty)
									{
										$Id_promo = $promhead->Id_promo;
	
										if($promhead->Model == "%")
										{
											$Discount_promo = $variation[0]->Sell_price * ($promdetail->Discount/100);
											
											$Fix_price = $variation[0]->Sell_price - ($variation[0]->Sell_price * ($promdetail->Discount/100));
										}
										else
										{
											$Discount_promo = $promdetail->Discount;
											$Fix_price = $variation[0]->Sell_price -$promdetail->Discount;
										}
	
									}
									
								}
							}
						}
					}
	
					$cust_detail = new cust_order_detail();
					$hasil = $cust_detail->insertdata($Id_order, $datacart->Id_product, $datacart->Id_variation,$datacart->Qty,
					$Normal_price,$Id_promo, $Discount_promo, $Fix_price);
	
				}
				
			}
			$cust_header = new cust_order_header();
			$last_id = $cust_header->getlastinvoice();
			$order = cust_order_header::find($last_id);
			$order_detail = cust_order_detail::where("Id_order", $last_id)
			->join('product','product.Id_product','cust_order_detail.Id_product')
			->join('variation_product','variation_product.Id_variation','cust_order_detail.Id_variation')
			->get();
			$midtrans = new CreateSnapTokenService($order, $order_detail);
			$snapToken = $midtrans->getSnapToken(); 
			
			$email_content = "Silahkan melakukan dengan mengklik link di bawah ini <br> <a href='https://localhost/PusatHerbalStore/public/guess_pay_email/$last_id' target='_blank'>Click link untuk melakukan pembayaran</a> <br><br><br> <b>Hiraukan email ini jika anda sudah melakukan pembayaran</b>";
			Mail::to($order->Email)->send(new SendEmail("Konfirmasi Pembayaran", $email_content));

			return $snapToken;   
		}
		else //Member
		{
			$Id_member =$member;

			$me = member::where('Id_member','=',$Id_member)
			->get();


			$Address_dest = session()->get('Id_address');

			$add = address_member::where('Id_address','=',$Address_dest)
			->get();

			$cust_header = new cust_order_header();
			$hasil = $cust_header->insertdata($Date_time, $Id_member, $add[0]->Address, $add[0]->Id_province,$add[0]->Id_city,
			$me[0]->Username,$me[0]->Email, $me[0]->Phone, $Courier, $Courier_packet, $Affiliate, $Id_voucher, $Weight, $Gross_total, $Shipping_cost,$Discount,$Grand_total,$Shipper,$Status);

			//Untuk menghapus isi table voucher_member
			if($Id_voucher=="" || $Id_voucher==0|| $Id_voucher==null)
			{

			}
			else
			{
				$vm = voucher_member::where('Id_member','=',$Id_member)
				->where('Id_voucher','=',$Id_voucher)
				->get();

				foreach ($vm as $datavm) {
					$deletevm = new voucher_member();
					$hasil = $deletevm->delete_voucher_member_2($datavm->Id_voucher_member);
					break;
				}
			}
			//-----------------------------------------------

			$arr = cart::where('Id_member','=',$Id_member)
			->get();

			foreach ($arr as $datacart) {

				if($datacart->Id_cart!=-1) //-1 itu cart yg di delete di session
				{
					$cust_header_2 = new cust_order_header();
					$Id_order =  $cust_header_2->getlastinvoice();
	
	
					$dtpromoheader = promo_header::where('Status','=',1)
					->where('Id_variation','=',$datacart->Id_variation)
					->get();
			
					$dtpromodetail = promo_detail::where('Status','=',1)
					->get();
	
					$variation = variation::where('Id_variation','=',$datacart->Id_variation)
					->where('Status','=',1)
					->get();
	
					$Normal_price = $variation[0]->Sell_price;
					$Id_promo =0;
					$Discount_promo=0;
					$Fix_price = $Normal_price;
					if(count($dtpromoheader)>=1)
					{
						foreach ($dtpromoheader as $promhead) {
							
							foreach ($dtpromodetail as $promdetail) {
								if($promhead->Id_promo == $promdetail->Id_promo)
								{
									if($datacart->Qty>= $promdetail->Minimum_qty)
									{
										$Id_promo = $promhead->Id_promo;
	
										if($promhead->Model == "%")
										{
											$Discount_promo = $variation[0]->Sell_price * ($promdetail->Discount/100);
											
											$Fix_price = $variation[0]->Sell_price - ($variation[0]->Sell_price * ($promdetail->Discount/100));
										}
										else
										{
											$Discount_promo = $promdetail->Discount;
											$Fix_price = $variation[0]->Sell_price -$promdetail->Discount;
										}
	
									}
									
								}
							}
						}
					}
	
					$cust_detail = new cust_order_detail();
					$hasil = $cust_detail->insertdata($Id_order, $datacart->Id_product, $datacart->Id_variation,$datacart->Qty,
					$Normal_price,$Id_promo, $Discount_promo, $Fix_price);
	
				}
				

			}
		}


		$cust_header = new cust_order_header();
		$last_id = $cust_header->getlastinvoice();
		 echo $last_id;
	}

	public function pay_email_guest(Request $request)
	{
		$order = cust_order_header::find($request->Id_order);
		$order_detail = cust_order_detail::where("Id_order", $request->Id_order)
		->join('product','product.Id_product','cust_order_detail.Id_product')
		->join('variation_product','variation_product.Id_variation','cust_order_detail.Id_variation')
		->get();
		$midtrans = new CreateSnapTokenService($order, $order_detail);
		$snapToken = $midtrans->getSnapToken(); 
		
	
		return $snapToken;   
	}

	public function Send_tracking_order(Request $request) //pesanan status nya payment receive
	{

		$data = cust_order_header::find($request->Id_order); 
		$data->Status = 2; 
		$data->save(); 

		$order_history = new cust_order_history();
		$order_history->Order_status = 2;
		$order_history->Record = "Pembayaran telah diterima";
		$order_history->Id_order = $request->Id_order;
		$order_history->save();

		// checker FU tidak ada karena guess

		// $this->checkerFollowup($data->Id_member, $data->Date_time, $row->Id_order);




		// (HANDLING POINT SYSTEM)
		// jika ada pembelian member(login) maka di cek dlu di database apakah ada referral, jika tidak ada maka cek cookie

		
		$header = cust_order_header::where('Id_order','=',$request->Id_order)
		->get();

		$cust_order_email = cust_order_header::where('Email', $header[0]->Email)
		->get();

		$cust_order_phone = cust_order_header::where('Phone', $header[0]->Phone)
		->get();

		$member_email = member::where('Email', $header[0]->Email)
		->get();

		$member_phone = member::where('Phone', $header[0]->Phone)
		->get();

		$Receive_point_random_code ="";

		if((Cookie::has('Affiliate')) && (!Cookie::has('username_login')) && count($cust_order_email) <= 1 && count($cust_order_phone) <=1 && count($member_email) == 0 && count($member_phone) == 0){
			$Receive_point_random_code = Cookie::get('Affiliate');
		}

		if($Receive_point_random_code!="")
		{
			
			$penambahanpoin=0;
			$receive_point_member = member::where('Random_code', $Receive_point_random_code)->first(); //member yang menerima
			$point = $receive_point_member->Point;
			
			
			//cayang3
			if(!Cookie::has('First_transaction')){
				$order = cust_order_header::where('cust_order_header.Id_order',$request->Id_order)
						->join('cust_order_detail', 'cust_order_header.Id_order', 'cust_order_detail.Id_order')
						->get();
						
				foreach ($order as $detail) {
					$affiliate = affiliate::where('Id_product', $detail->Id_product)
								->where('Id_variation', $detail->Id_variation)
								->where('Status', 1)
								->get();

					if(count($affiliate) > 0){
						foreach ($affiliate as $aff) {
							$point += $aff->Poin;
							$penambahanpoin += $aff->Poin;
						}
					}else {
						// $point += 100;
					}
				}
				
				$me = new member();
				$hasil = $me->edit_point($receive_point_member->Id_member, $point);
				// (new member)->edit_point($receive_point_member->Id_member, $point);


				$First_point = 0;
				$fp= member::where('Id_member','=',$receive_point_member->Id_member)
				->get();

				$First_point = $fp[0]->Point;
				

				try {
					//code...
					$pc = point_card::where('Id_member','=',$receive_point_member->Id_member)
					->orderBy('Id_point_card')
					->get();

					
					foreach ($pc as $datapc) {
						# code...
						$First_point = $datapc->Last_point;
					}
				} catch (\Throwable $th) {
					//throw $th;
				}
				

				$Last_point = $point;



				$tgl= date('d/m/Y');
				$tglfix = $tgl[6].$tgl[7].$tgl[8].$tgl[9]."/".$tgl[3].$tgl[4]."/".$tgl[0].$tgl[1];
				
				$pointcard = new point_card;
				$hasil = $pointcard->add_point_card($receive_point_member->Id_member,$tglfix,$First_point,$penambahanpoin,0,$Last_point,"Affiliate Success",$request->Id_order);


				Cookie::queue(Cookie::make("First_transaction", "1", 1500000));

				
				// Handling ubah Cust_order_header (Affiliate & tracking code)

				// $session_member = session()->get('userlogin');
				// $member = member::find($session_member->Id_member); 


				$Id_prospect=0;
				if(Cookie::has('Id_prospect'))
				{
					$Id_prospect=Cookie::get('Id_prospect');
				}

				$ss = new cust_order_header();
				$hasil = $ss->update_affiliate_trackingcode($request->Id_order,  Cookie::get('Affiliate') , Cookie::get('Tracking_code'), $Id_prospect);
				
				
			}
			
		}

		

		$order = cust_order_header::find($request->Id_order);
		$email_content = "Silahkan melacak pesanan anda dengan mengklik link di bawah ini <br> <a href='https://localhost/PusatHerbalStore/public/Tracking/$request->Id_order' target='_blank'>Click link untuk melacak pesanan</a>";
		Mail::to($order->Email)->send(new SendEmail("Pesanan $request->Id_order", $email_content));

		return true;
	}

	public function Tracking($id_order)
	{
		return view('Cust_guest_tracking_order', compact('id_order'));
	}

	public function guess_pay_email($id_order)
	{
		return view('Cust_guest_pay_email', compact('id_order'));
	}

	public function atc_from_wishlist(Request $request)
	{
		$Id_wishlist = $request->Id_wishlist;

		$wish = wishlist::where('Id_wishlist','=',$Id_wishlist)
		->get();

		$vari = variation::where('Id_variation','=',$wish[0]->Id_variation)
		->get();

		$Id_member = session()->get('userlogin')->Id_member;

		$cart = cart::where('Id_member','=',$Id_member)
		->get();

		$kembar=0;
		$Stock = $vari[0]->Stock*1 - $vari[0]->Stock_atc*1 - $vari[0]->Stock_pay*1;
		if($Stock < $wish[0]->Qty)
		{
			echo "stok tidak cukup";
		}
		else
		{
			foreach ($cart as $datacart) {
				if($datacart->Id_variation == $wish[0]->Id_variation)
				{
					$kembar=1;
				
				}
			}

			if($kembar==1)
			{
				echo "kembar";
			}
			else
			{
				$cart = new cart();
				$carthasil = $cart->add_cart($wish[0]->Id_product,$wish[0]->Id_variation,$wish[0]->Qty,$Id_member);
			

				$deletewish = new wishlist();
				$hasil = $deletewish->delete_wishlist($wish[0]->Id_wishlist);


				echo "sukses";
			}
			
		}
	}

	
	public function My_order() {

		// untuk membuat semua transaksi yg sudah dibayar di midtrans menjadi 
		// payment_status = 2. ambil dari cust_orer_header
			$ord = new cust_order_header(); 
			$orders = $ord->getaktifinvoice();
					foreach($orders as $row) {
						$res = $this->cekStatusTransaksi($row->Id_order);  
						// print_r("Pertama XXX".$res."yyy");
						if(!str_contains($res, "404")) 
						{
							$res = json_decode($res); 
							// print_r($res);
							if($res->status_message == "Success, transaction is found") {
								if($res->transaction_status == "settlement") {
									$data = cust_order_header::find($row->Id_order); 
									$data->Status = 2; 
									$data->save(); 

									$order_history = new cust_order_history();
									$order_history->Order_status = 2;
									$order_history->Record = "Pembayaran telah diterima";
									$order_history->Id_order = $row->Id_order;
									$order_history->save();


									$this->checkerFollowup($data->Id_member, $data->Date_time, $row->Id_order);
									// (HANDLING POINT SYSTEM)
									// jika ada pembelian member(login) maka di cek dlu di database apakah ada referral, jika tidak ada maka cek cookie

									$session_member = session()->get('userlogin');
									$Receive_point_random_code = "";

									if($session_member->Referral != "")
									{
										$Receive_point_random_code = $session_member->Referral;
									}
									else if(Cookie::has('Affiliate')){
										$Receive_point_random_code = Cookie::get('Affiliate');
									}

									if($Receive_point_random_code!="")
									{
										if($session_member->Random_code != $Receive_point_random_code){ //untuk menghindari cookie sama dgn random code user
											$point = 0;
											try {
												$member = member::find($session_member->Id_member); //member pemberi
												$penambahanpoin=0;
												$receive_point_member = member::where('Random_code', $Receive_point_random_code)->first(); //member yang menerima
												$point = $receive_point_member->Point;
											} catch (\Throwable $th) {
												//throw $th;
											}
											
											
											if($member->First_transaction == 0){
												$order = cust_order_header::where('cust_order_header.Id_order',$row->Id_order)
														->join('cust_order_detail', 'cust_order_header.Id_order', 'cust_order_detail.Id_order')
														->get();
														
												foreach ($order as $detail) {
													$affiliate = affiliate::where('Id_product', $detail->Id_product)
																->where('Id_variation', $detail->Id_variation)
																->where('Status', 1)
																->get();
								
													if(count($affiliate) > 0){
														foreach ($affiliate as $aff) {
															$point += $aff->Poin;
															$penambahanpoin += $aff->Poin;
														}
													}else {
														// $point += 100;
													}
												}
												
												$me = new member();
												$hasil = $me->edit_point($receive_point_member->Id_member, $point);
												// (new member)->edit_point($receive_point_member->Id_member, $point);
								
								
												$First_point = 0;
												$fp= member::where('Id_member','=',$receive_point_member->Id_member)
												->get();
								
												$First_point = $fp[0]->Point;
												
								
												try {
													//code...
													$pc = point_card::where('Id_member','=',$receive_point_member->Id_member)
													->orderBy('Id_point_card')
													->get();
								
													
													foreach ($pc as $datapc) {
														# code...
														$First_point = $datapc->Last_point;
													}
												} catch (\Throwable $th) {
													//throw $th;
												}
												
								
												$Last_point = $point;
								
								
								
												$tgl= date('d/m/Y');
												$tglfix = $tgl[6].$tgl[7].$tgl[8].$tgl[9]."/".$tgl[3].$tgl[4]."/".$tgl[0].$tgl[1];
												
												$pointcard = new point_card;
												$hasil = $pointcard->add_point_card($receive_point_member->Id_member,$tglfix,$First_point,$penambahanpoin,0,$Last_point,"Affiliate Success",$row->Id_order);
								
								
												member::where('Id_member', $member->Id_member)->update(array(
													'First_transaction' => 1
												));

												
												// Handling ubah Cust_order_header (Affiliate & tracking code)

												$session_member = session()->get('userlogin');
												$member = member::find($session_member->Id_member); 


												
												$ss = new cust_order_header();
												$hasil = $ss->update_affiliate_trackingcode($row->Id_order, $member->Referral, $member->Tracking_code, $member->Id_prospect);
												
												
											}
										}
									}


									
								}    
							}
						}
					
					}

		$Id_member = session()->get('userlogin')->Id_member;
		try {

			if(session()->get('Filter_my_order')==null || session()->get('Filter_my_order')=="")
			{
				$datatransaksi = cust_order_header::where('Id_member','=',$Id_member)
				 ->where('Status','=',1)
				->orderby('Id_order','desc')
				->get();
			}
			else if(session()->get('Filter_my_order')==6)
			{
				$datatransaksi = cust_order_header::where('Id_member','=',$Id_member)
				->orderby('Id_order','desc')
				->get();
			}
			else if(session()->get('Filter_my_order')==0)
			{
				$datatransaksi = cust_order_header::where('Id_member','=',$Id_member)
				->where('cust_order_header.Status','=',0)
				->orderby('Id_order','desc')
				->get();
			}
			else if(session()->get('Filter_my_order')==1)
			{
				$datatransaksi = cust_order_header::where('Id_member','=',$Id_member)
				->where('Status','=',1)
				->orderby('Id_order','desc')
				->get();
			}
			else if(session()->get('Filter_my_order')==2)
			{
				$datatransaksi = cust_order_header::where('Id_member','=',$Id_member)
				->where('Status','=',2)
				->orderby('Id_order','desc')
				->get();
			}
			else if(session()->get('Filter_my_order')==3)
			{
				$datatransaksi = cust_order_header::where('Id_member','=',$Id_member)
				->where('Status','=',3)
				->orderby('Id_order','desc')
				->get();
			}
			else if(session()->get('Filter_my_order')==4)
			{
				$datatransaksi = cust_order_header::where('Id_member','=',$Id_member)
				->where('Status','=',4)
				->orderby('Id_order','desc')
				->get();
			}
			else if(session()->get('Filter_my_order')==5)
			{
				$datatransaksi = cust_order_header::where('Id_member','=',$Id_member)
				->where('Status','=',5)
				->orderby('Id_order','desc')
				->get();
			}
			else 
			{
				$datatransaksi = cust_order_header::where('Id_member','=',$Id_member)
				//  ->where('Status','=',1)
				->orderby('Id_order','desc')
				->get();
			}

		} catch (\Throwable $th) {

			// print_r("err".session()->get('Filter_my_order'));
			$datatransaksi = cust_order_header::where('Id_member','=',$Id_member)
			->where('Status','=',1)
				->orderby('Id_order','desc')
				->get();
		}
		foreach($datatransaksi as $row) {

			$det = new cust_order_detail(); 
			$detail = $det->getdetail($row->Id_order); 

			$tglskrg = $row->Date_time; 
			$tgljatuhtempo = date('Y-m-d H:i:s', strtotime($tglskrg . '+48 hour'));
			
			$row->jatuhtempo = $tgljatuhtempo;

			if(count($detail) > 0) {
				if($row->Status == 1 ) {
				$midtrans = new CreateSnapTokenService($row, $det->getdetail($row->Id_order));
				$snapToken = $midtrans->getSnapToken(); 
				$row->snap_token = $snapToken;       
				}
				else {
				$row->snap_token = 0; 
				}
			}
			else { 
				$row->snap_token = 0; 
			}
		}

		$params['datatransaksi'] = $datatransaksi;
		return view('Cust_my_order', $params); 
	   }

	   function cekStatusTransaksi($number) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/$number/status",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "content-type: application/json",
            "Authorization: Basic ".base64_encode("SB-Mid-server-wBV8-wjmAO-gMST99rtlKaQy")
          ),
        ));
    
        $response   = curl_exec($curl);
        $err        = curl_error($curl);
    
        curl_close($curl);
    
        if ($err) {
			// print_r("atas");
          echo "cURL Error #:" . $err;
        } else {
			// print_r("bawah");
          return $response;
        } 
    }

	public function get_cust_detail_order(Request $request)
	{
		$Id_order = $request->id;
		
		$headerorder = cust_order_header::where('Id_order','=',$Id_order)
		->join('list_city','cust_order_header.Id_city','list_city.Id_city')
		// ->join('list_city','cust_order_header.Id_province','list_city.Id_province')
		->get();

		$detailorder = cust_order_detail::where('Id_order','=',$Id_order)
		->join('product','cust_order_detail.Id_product','product.Id_product')
		->join('variation_product','cust_order_detail.Id_variation','variation_product.Id_variation')
		->get();

		$order_history = cust_order_history::where('Id_order', $Id_order)->orderBy('id','desc')->get();
		$temp="";
		$temp2="";
		$total=0;

		$temp2 = $temp2 . "<b>Shipper pick orderby Exp date :</b><br><Br>";
		for ($i=0; $i < count($detailorder); $i++) { 

			$temp=$temp."<tr>";
				
			$temp=$temp."<td>";
				$temp=$temp.$detailorder[$i]['Name'];
			$temp=$temp."</td>";
			$temp=$temp."<td>";
				$temp=$temp.$detailorder[$i]['Option_name'];
			$temp=$temp."</td>";
			$temp=$temp."<td>";
				$temp=$temp.number_format($detailorder[$i]['Normal_price']);
			$temp=$temp."</td>";
			$temp=$temp."<td>";
				$temp=$temp."Rp. ".number_format($detailorder[$i]['Discount_promo']);
			$temp=$temp."</td>";
			$temp=$temp."<td>";
				$temp=$temp."Rp. ".number_format($detailorder[$i]['Fix_price']);
			$temp=$temp."</td>";
			$temp=$temp."<td>";
				$temp=$temp.number_format($detailorder[$i]['Qty']);
			$temp=$temp."</td>";
			$temp=$temp."<td>";
				$temp=$temp."Rp. ".number_format(($detailorder[$i]['Qty']*$detailorder[$i]['Fix_price']));
			$temp=$temp."</td>";


			$total=$total+ ($detailorder[$i]['Qty']*$detailorder[$i]['Fix_price']);
				
			$temp=$temp."</tr>";

			
			$stockcard = stock_card::where('No_reference','=',$detailorder[$i]['Id_detail_order'])
			->where('Type_card','like','%Cust_order%')
			->get();



			$temp2 = $temp2 . "<b>". $detailorder[$i]['Name'] ." - " . $detailorder[$i]['Option_name']. "</b> <br>";
			foreach ($stockcard as $datasc) {
				$temp2 = $temp2 . "@" . $datasc->Credit . "->" . date("d-m-Y", strtotime($datasc->Expire_date)) ."<br>";
			}
		}

		$temp=$temp."<tr>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td> TOTAL :</td>";
		$temp=$temp."<td>"."Rp. ".number_format($total)."</td>";
		$temp=$temp."<td></td>";
		$temp=$temp."</tr>";
		
		$temp=$temp."<tr>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td> Shipping Cost :</td>";
		$temp=$temp."<td>"."Rp. ".number_format($headerorder[0]['Shipping_cost'])."</td>";
		$temp=$temp."<td></td>";
		$temp=$temp."</tr>";

		$temp=$temp."<tr>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td> Discount Voucher :</td>";
		$temp=$temp."<td>"."Rp. -".number_format($headerorder[0]['Discount'])."</td>";
		$temp=$temp."<td></td>";
		$temp=$temp."</tr>";

		$temp=$temp."<tr>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td></td>";
		$temp=$temp."<td> Grand total :</td>";
		$temp=$temp."<td>"."Rp. ".number_format($total+$headerorder[0]['Shipping_cost']-$headerorder[0]['Discount'])."</td>";
		$temp=$temp."<td></td>";
		$temp=$temp."</tr>";

		if($request->has('request_from')){
			if($request->request_from == 'rating_review'){
				foreach ($detailorder as $detail) {
					$detail->is_review = false;
					$detail->is_deleted = false;
					$review = rate_review::where('Id_detail_order', $detail->Id_detail_order)->get();
					if(count($review) > 0){
						if($review[0]->Status == 'Active'){
							$detail->Status = $review[0]->Status;
							$detail->is_review = true;
							$detail->Rate = $review[0]->Rate;
							$detail->Review = $review[0]->Review;
						}else {
							$detail->Status = $review[0]->Status;
							$detail->is_review = true;
							$detail->Rate = $review[0]->Rate;
							$detail->Review = $review[0]->Review;
						}
					}
				}
				return $detailorder;
			}
			return $temp2;
		}

		print_r($temp."#".$headerorder[0]['Name']."#".$headerorder[0]['Phone']."#".$headerorder[0]['Email']."#".$headerorder[0]['Address'].",".$headerorder[0]['Type']." ".$headerorder[0]['City_name'].",".$headerorder[0]['Province_name']."#".$headerorder[0]['Courier']."-".$headerorder[0]['Courier_packet']."#".$headerorder[0]['Weight']."#".$headerorder[0]['Receipt_number']."#".$headerorder[0]['Id_order']."#".$headerorder[0]['Status']."#".$temp2."#".json_encode($order_history));
	}

	public function update_filter_session(Request $request)
	{
		session()->forget('Filter_my_order');
		session()->put('Filter_my_order',$request->Status);

		echo $request->Status;
	}

	public function Pick_order_shipper()
	{
		
		$datatransaksi = cust_order_header::where('Status','=',2)
		->orderby('Id_order','desc')
		->get();
	
		foreach($datatransaksi as $row) {
		 $tglskrg = $row->Date_time; 
		 $tgljatuhtempo = date('Y-m-d H:i:s', strtotime($tglskrg . '+2 hour'));
	  
		 $row->jatuhtempo = $tgljatuhtempo;
	  
		//  echo $tglskrg."<br>";
		//  echo $tgljatuhtempo."<br>";
		}
		$params['datatransaksi'] = $datatransaksi;
		return view('Pick_order_shipper', $params); 
	}
	
	public function filter_cust_order(Request $request)
	{
		$query = cust_order_header::query();

        if($request->Status != "")
        { 
			if($request->Status == 0) //payment receive
			{
				$query  = $query->where('Status', '=',2 ); 
			}
			else if($request->Status == 1) //processing
			{
				$query  = $query->where('Status', '=', 3); 
			}
			else if($request->Status == 2) //shipping
			{
				$query  = $query->where('Status', '=', 4); 
			}
        }
		else
		{
			$query  = $query->where(function($query)
			{
				$query->where('Status','=',2);
				$query->orwhere('Status','=', 3);
				$query->orwhere('Status','=', 4);
			});
		}


		if($request->Kurir != "")
		{
			if($request->Kurir == 0) //JNE
			{
				$query  = $query->where('Courier', '=','JNE' ); 
			}
			else if($request->Kurir == 1) //POS
			{
				$query  = $query->where('Courier', '=', 'POS'); 
			}
			else if($request->Kurir == 2) //TIKI
			{
				$query  = $query->where('Courier', '=', 'TIKI'); 
			}
		}

		if($request->Resi != "")
		{
			$query  = $query->where('Receipt_number', '=',$request->Resi); 
		
		}

		if($request->Nama != "")
		{
			$query  = $query->where('Name', 'like', '%'.$request->Nama.'%'); 
		
		}

		$query  = $query->get();

		$no=0;
		$temp="";
		foreach ($query as $data) {
			 $temp=$temp."<div class='card' id='card".$no."'>";
				$temp=$temp."<div class='card-body'>";
				$temp=$temp."<input type='checkbox' class='cb_child' value='".$data->Id_order."' style='transform: scale(1.5)'>";
			$temp=$temp."<br>";
			if($data->Status==2)
			{
				$temp=$temp."<button type='button' class='btn btn-light btn-sm' disabled>Payment Receive</button>";
			}
			else if($data->Status==3)
			{
				$temp=$temp."<button type='button' class='btn btn-primary btn-sm' disabled>Processing</button>";
				if($data->Printed == 1){
					$temp = $temp. " <span class='fa fa-print disabled' data-toggle='tooltip' title='Printed Label'></span>";
				}
			}
			else if($data->Status==4)
			{
				$temp=$temp."<button type='button' class='btn btn-secondary btn-sm' disabled>Shipping</button>";
				if($data->Printed == 1){
					$temp = $temp. " <span class='fa fa-print disabled' data-toggle='tooltip' title='Printed Label'></span>";
				}
			}

			$temp=$temp."<br><br>";
			$temp=$temp."<h5 class='card-title'>Nota : ". $data->Id_order." </h5>";
			$temp=$temp."<p class='card-text'>";
				$temp=$temp."<b><h5>". date("d-m-Y", strtotime($data->Date_time))."</h5></b>";
				$temp=$temp."<b><h5>Name : ".$data->Name." </h5></b>";
				$temp=$temp." <b><h5>Grand Total : Rp. ".number_format($data->Grand_total)." </h5></b>";
			$temp=$temp."</p>";
			$temp=$temp."<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-idorder='".$data->Id_order."' data-target='.viewdetail'> View detail </button>";
			$temp=$temp."<hr size='10px style='margin-top: 2%'>";
			$temp=$temp."</div>";
			$temp=$temp."</div>";
			$temp=$temp."<br> <br>";
		
			$no=$no+1;
		
		}

		echo $temp;
	}

	public function update_status(Request $request)
	{
		$Id_order= $request->Id_order;


		$dt = cust_order_header::where('Id_order','=',$Id_order)
		->get();
	

		if($dt[0]->Status==1) // hanya yg pending yg di ubah jadi 0 jika waktu habis
		{

			//Kembalikan voucher jika ada
			if($dt[0]['Id_voucher']=="" || $dt[0]['Id_voucher']==0 )
			{

			}
			else
			{
				$addvm = new voucher_member();
				$hasil = $addvm->add_voucher_member($dt[0]['Id_member'], $dt[0]['Id_voucher']);
			}


			$ch = new cust_order_header();
			$hasil = $ch->ganti_status($Id_order,0);
			
			return "sukses";
		}
	}

	public function Proccess_cust_order(Request $request)
	{
		$kumpulan_id_order = $request->kumpulan_id_order;

		$arr_id_order = explode("," ,$kumpulan_id_order);

		foreach ($arr_id_order as $data) {
			
			$ch = new cust_order_header();
			$hasil = $ch->ganti_status($data,3);


			$ch2 = new cust_order_header();
			$hasil2 = $ch2->ganti_shipper($data,session()->get('userlogin')->Id_member);


			$ch = new cust_order_header();
			$hasil = $ch->update_receipt_number($data,"");
		}


	}

	public function Print_shipping_label(Request $request)
	{
		$arr_order = [];
		$kumpulan_id_order = $request->input('kumpulan_id_order');
		$arr_id_order = explode("," ,$kumpulan_id_order);

		foreach ($arr_id_order as $id_order) {
			$new_request = new Request();
			$new_request->merge(['id' => $id_order, 'request_from' => 'function print_shipping_label']);
			$order = cust_order_header::find($id_order); 
			$order->detail = $this->get_cust_detail_order($new_request);
			$order->kota = list_city::find($order->Id_city);
			$arr_order[] = $order;
			$update_order = cust_order_header::find($id_order); 
			$update_order->Printed = 1;
			$update_order->save();
		}
	
		return view('Print_shipper_label', compact('arr_order'));

	}

	public function save_receipt_number(Request $request)
	{
		$Id_order = $request->Id_order;
		$Receipt_number = $request->Receipt_number;

		$ch = new cust_order_header();
		$hasil = $ch->ganti_status($Id_order,4);

		$ch = new cust_order_header();
		$hasil = $ch->update_receipt_number($Id_order,$Receipt_number);

		$ch = new cust_order_header();
		$hasil = $ch->update_resi_input_shipper($Id_order,session()->get('userlogin')->Id_member);

	}

	// public function pay_now(Request $request) //khusus yg login
	// {
	// 	//TEMPORARY STATUS CHANGER
	// 	// $order = cust_order_header::find($request->order_id);
	// 	// $order->Status = "2";
	// 	// $order->save();


	// 	// (HANDLING POINT SYSTEM)
	// 	//jika ada pembelian member(login) maka di cek dlu di database apakah ada referral, jika tidak ada maka cek cookie

	// 	$session_member = session()->get('userlogin');
	// 	$Receive_point_random_code = "";

	// 	if($session_member->Referral != "")
	// 	{
	// 		$Receive_point_random_code = $session_member->Referral;
	// 	}
	// 	else if(Cookie::has('Affiliate')){
	// 		$Receive_point_random_code = Cookie::get('Affiliate');
	// 	}

	// 	if($Receive_point_random_code!="")
	// 	{
	// 		if($session_member->Random_code != $Receive_point_random_code){ //untuk menghindari cookie sama dgn random code user
	// 			$member = member::find($session_member->Id_member); //member pemberi
	// 			$penambahanpoin=0;
	// 			$receive_point_member = member::where('Random_code', $Receive_point_random_code)->first(); //member yang menerima
	// 			$point = $receive_point_member->Point;
				
	// 			if($member->First_transaction == 0){
	// 				$order = cust_order_header::where('cust_order_header.Id_order',$request->order_id)
	// 						->join('cust_order_detail', 'cust_order_header.Id_order', 'cust_order_detail.Id_order')
	// 						->get();
							
	// 				foreach ($order as $detail) {
	// 					$affiliate = affiliate::where('Id_product', $detail->Id_product)
	// 								->where('Id_variation', $detail->Id_variation)
	// 								->where('Status', 1)
	// 								->get();
	
	// 					if(count($affiliate) > 0){
	// 						foreach ($affiliate as $aff) {
	// 							$point += $aff->Poin;
	// 							$penambahanpoin += $aff->Poin;
	// 						}
	// 					}else {
	// 						// $point += 100;
	// 					}
	// 				}
					
	// 				$me = new member();
	// 				$hasil = $me->edit_point($receive_point_member->Id_member, $point);
	// 				// (new member)->edit_point($receive_point_member->Id_member, $point);
	
	
	// 				$First_point = 0;
	// 				$fp= member::where('Id_member','=',$receive_point_member->Id_member)
	// 				->get();
	
	// 				$First_point = $fp[0]->Point;
					
	
	// 				try {
	// 					//code...
	// 					$pc = point_card::where('Id_member','=',$receive_point_member->Id_member)
	// 					->orderBy('Id_point_card')
	// 					->get();
	
						
	// 					foreach ($pc as $datapc) {
	// 						# code...
	// 						$First_point = $datapc->Last_point;
	// 					}
	// 				} catch (\Throwable $th) {
	// 					//throw $th;
	// 				}
					
	
	// 				$Last_point = $point;
	
	
	
	// 				$tgl= date('d/m/Y');
	// 				$tglfix = $tgl[6].$tgl[7].$tgl[8].$tgl[9]."/".$tgl[3].$tgl[4]."/".$tgl[0].$tgl[1];
					
	// 				$pointcard = new point_card;
	// 				$hasil = $pointcard->add_point_card($receive_point_member->Id_member,$tglfix,$First_point,$penambahanpoin,0,$Last_point,"Affiliate Success",$request->order_id);
	
	
	// 				member::where('Id_member', $member->Id_member)->update(array(
	// 					'First_transaction' => 1
	// 				));
					
	// 			}
	// 		}
	// 	}


	// 	// Handling ubah Cust_order_header (Affiliate & tracking code)

	// 	// $member = member::find($session_member->Id_member); 

	// 	$aa = new cust_order_header();
	// 	$hasil = $aa->update_affiliate_trackingcode(2003,'aa','bb');
		

	// 	return response()->json('success', 200);
	// }

	public function pay_now_guess(Request $request)
	{





		//TEMPORARY STATUS CHANGER
		// $order = cust_order_header::find($request->order_id);
		// $order->Status = "2";
		// $order->save();


		// if(Cookie::has('Affiliate')){
		// 	$cookie = Cookie::get('Affiliate');

		// 	$penambahanpoin=0;
		// 	$receive_point_member = member::where('Random_code', $cookie)->first(); //member yang menerima
		// 	$point = $receive_point_member->Point;
			
		// 	if(Cookie::has('First_transaction'))
		// 	{
		// 		$order = cust_order_header::where('cust_order_header.Id_order',$request->order_id)
		// 		->join('cust_order_detail', 'cust_order_header.Id_order', 'cust_order_detail.Id_order')
		// 		->get();
						
		// 		foreach ($order as $detail) {
		// 			$affiliate = affiliate::where('Id_product', $detail->Id_product)
		// 						->where('Id_variation', $detail->Id_variation)
		// 						->where('Status', 1)
		// 						->get();
	
		// 			if(count($affiliate) > 0){
		// 				foreach ($affiliate as $aff) {
		// 					$point += $aff->Poin;
		// 					$penambahanpoin += $aff->Poin;
		// 				}
		// 			}else {
		// 				// $point += 100;
		// 			}
		// 		}
				
		// 		$me = new member();
		// 		$hasil = $me->edit_point($receive_point_member->Id_member, $point);
		// 		// (new member)->edit_point($receive_point_member->Id_member, $point);
	
	
		// 		$First_point = 0;
		// 		$fp= member::where('Id_member','=',$receive_point_member->Id_member)
		// 		->get();
	
		// 		$First_point = $fp[0]->Point;
				
	
		// 		try {
		// 			//code...
		// 			$pc = point_card::where('Id_member','=',$receive_point_member->Id_member)
		// 			->orderBy('Id_point_card')
		// 			->get();
	
					
		// 			foreach ($pc as $datapc) {
		// 				# code...
		// 				$First_point = $datapc->Last_point;
		// 			}
		// 		} catch (\Throwable $th) {
		// 			//throw $th;
		// 		}
				
	
		// 		$Last_point = $point;
	
		// 		$tgl= date('d/m/Y');
		// 		$tglfix = $tgl[6].$tgl[7].$tgl[8].$tgl[9]."/".$tgl[3].$tgl[4]."/".$tgl[0].$tgl[1];
				
		// 		$pointcard = new point_card;
		// 		$hasil = $pointcard->add_point_card($receive_point_member->Id_member,$tglfix,$First_point,$penambahanpoin,0,$Last_point,"Affiliate Success",$request->order_id);
	
		// 		Cookie::queue(Cookie::make("First_transaction", "1", 1500000));


		// 	}
		// }
		
	}

	public function broadcastView()
	{
		$product = product::pluck('Name', 'Id_product');

		return view('Broadcast', compact('product'));
	}
	public function broadcastPembeliView()
	{
		$product = product::pluck('Name', 'Id_product');

		return view('Broadcast_pembeli', compact('product'));
	}

	public function broadcast(Request $request)
	{
		$jumlahterkirim = 0;
		$products = product::join('product_sub_category', 'product.Id_product', 'product_sub_category.Id_product')
					->join('sub_category', 'sub_category.Id_sub_category', 'product_sub_category.Id_sub_category')
					->where('product.Id_product', $request->product)
					->get();
		foreach ($products as $product) {
			$submitted_email_ebook = email_ebook::join('ebook', 'ebook.Id_ebook', 'submitted_email_ebook.Ebook_id')
					->where('ebook.Id_sub_category', $product->Id_sub_category)
					->get();

			foreach ($submitted_email_ebook as $user) {
				
				$jumlahterkirim += 1;
				$link_product = "https://localhost/PusatHerbalStore/public/Cust_show_product/$request->product/$user->User_token";
				Mail::to($user->Email)->send(new BroadcastMail($request->subject, $request->content, $link_product));
			}
		}
		
		return redirect()->route('broadcast_view')->with('success', "Success send to $jumlahterkirim users");
	}
	public function embed_code($id,$Random_code)
	{
		$param['dtproduct'] = product::where('product.Id_product','=', $id)
		->join('brand','product.Id_brand','brand.Id_brand')
		->join('type','product.Id_type','type.Id_type')
		->select("product.Id_product","product.Name", "type.Type_name","product.Packaging","brand.Brand_name","product.Composition",
		"product.Bpom","product.Efficacy","product.Description","product.Storage","product.Dose","product.Disclaimer","product.Variation","product.status")
			->get();
		$cal=1;
		$db = variation::where('Id_product','=', $id)
		->where('Status','=',1)
		->get(); 

		$arr= [];  // array 
		foreach($db as $row) {
			if($row->Status==1)
			{
				$arr[$row->Id_variation] = $row->Option_name; 
			}
		
		}
		
		$param['arr_variation']  = $arr; 
		$param['Random_code'] = $Random_code;

		return view('embed_code',$param);
	}

	public function embed_checkout(Request $request){
		$param['Name'] = $request->Name;
		$param['Phone'] = $request->Phone;
		$param['Email'] = $request->Email;

		$Id_variation = $request->cb_variation;
		$Qty = $request->Qty;
		$Random_code = $request->Random_code;

		$Variasi = variation::find($Id_variation);

		

		$Id_member="";
		try {
			//code...
			$Id_member =session()->get('userlogin')->Id_member;
		} catch (\Throwable $th) {
			//throw $th;
			$Id_member="";
		}
		

		if($Id_member!="") //Member
		{
			//tanam affiliate
			// $member_target = member::find($Id_member);

			// if($member_target->Referral == 0 || $member_target->Referral == '0')
			// {
			// 	if ($member_target->First_transaction == 0 || $member_target->First_transaction == '0')
			// 	{
			// 		$tempmember = new member();
			// 		$tambahreferral = $tempmember->edit_referral($Id_member,$Random_code,"EMBED-".$Variasi->Id_product);
				
			// 		$member_aff = member::where('Random_code', $Random_code)->first();
			// 		$embed = DB::table('embed_member')
			// 		->where('Id_product', $Variasi->Id_product)
			// 		->where('Id_member', $member_aff->Id_member)
			// 		->first();

					
			// 		if(!empty($member_aff)){
			// 			$total_diklik = 0;
			// 			if(!empty($embed))
			// 			{
			// 				$total_diklik = $embed->Total_diklik + 1;	
			// 				DB::update("update embed_member set Total_diklik = $Total_diklik where Id_product = $Variasi->Id_product and Id_member = $member_aff->Id_member");
			// 			}
			// 			else 
			// 			{
			// 				$total_diklik = 1;
			// 				DB::insert('insert into embed_member (Id_member, Id_product, Total_diklik) values (?, ?, ?)', [$member_aff->Id_member, $Variasi->Id_product, $total_diklik]);
			// 			}
			// 		}
				
			// 	}
				
			// }
			

			//tambah data cart

			$tempcart = cart::where('Id_member','=',$Id_member)
			->get();

			$ada=0;
			foreach ($tempcart as $datacart) {
				if($datacart->Id_variation == $Id_variation)
				{
					$cart = new cart();
					$hasil = $cart->edit_cart($datacart->Id_cart,$Qty);
					$ada=1;
				}
			}

			if($ada==0)
			{
				$cart = new cart();
				$carthasil = $cart->add_cart($Variasi->Id_product,$Id_variation,$Qty,$Id_member);
			}



			$param['cart'] = cart::where('Id_member','=',$Id_member)
			->get();

			$Id_member = session()->get('userlogin')->Id_member;
			$param['Id_member'] = $Id_member;
	
		}
		else // Guest
		{

			//tanam affiliate
			if(!Cookie::has("username_login") && !Cookie::has("Affiliate"))   //cookie username_login untuk mengecek bahwa browser bersih, blmpernah ada yg login/regist
			{
				Cookie::queue(Cookie::make("Affiliate", $Random_code, 1500000));
				Cookie::queue(Cookie::make("Tracking_code", "EMBED-".$Variasi->Id_product, 1500000));
			
				
				$member_aff = member::where('Random_code', $Random_code)->first();
				$embed = DB::table('embed_member')
				->where('Id_product', $Variasi->Id_product)
				->where('Id_member', $member_aff->Id_member)
				->first();

				$ec = new embed_checkout();
					$hasil = $ec->add_embed_checkout($Random_code, $param['Name'], $param['Phone'], $param['Email'], $Variasi->Id_product, $Id_variation, $Qty);
				
				$ec2 = new embed_checkout();
				Cookie::queue(Cookie::make("Id_prospect", $ec2->getlastid(), 1500000));
				
					if(!empty($member_aff)){
					$total_diklik = 0;
					if(!empty($embed))
					{
						$total_diklik = $embed->Total_diklik + 1;	
						DB::update("update embed_member set Total_diklik = $total_diklik where Id_product = $Variasi->Id_product and Id_member = $member_aff->Id_member");
					}
					else 
					{
						$total_diklik = 1;
						DB::insert('insert into embed_member (Id_member, Id_product, Total_diklik) values (?, ?, ?)', [$member_aff->Id_member, $Variasi->Id_product, $total_diklik]);
					}

					
			}

				//cayang


				
		
				// return "sukses";

			}


			$param['Id_member'] ="";
			if(session()->get('cart'))
			{
				$arr = json_decode(session()->get('cart'));
				$Id_cart=-1;
				foreach ($arr as $datacart) {
					if($datacart->Id_variation == $Id_variation && $datacart->Id_cart>0)
					{
						$Id_cart=$datacart->Id_cart;
					}
				}

				if($Id_cart==-1)
				{
					$baru = array(
					'Id_cart' => (count($arr)+1),
					'Id_product' => $Variasi->Id_product, 
					'Id_variation' => $Id_variation, 
					'Qty' => $Qty, 
					);

					array_push($arr, $baru); 
					session()->forget('cart');
					session()->put('cart', json_encode($arr));
					$param['cart'] = json_decode(session()->get('cart'));
	
				}
				else
				{
					$arr[($Id_cart*1)-1]->Qty = $Qty;
					session()->forget('cart');
					session()->put('cart', json_encode($arr));
					$param['cart'] = json_decode(session()->get('cart'));
				}
			}
			else
			{
				$arr = [];
				$baru = array(
					'Id_cart' => 1,
					'Id_product' => $Variasi->Id_product, 
					'Id_variation' => $Id_variation, 
					'Qty' => $Qty
					);
				array_push($arr, $baru); 
				session()->put('cart', json_encode($arr));
				$param['cart'] = json_decode(session()->get('cart'));
			}
			
		}


		
		$param['product'] = product::where('Status','=',1)
		->get();

		$param['productimage'] = product_image::where('Image_order','=',1)
		->get();

		$param['variation'] = variation::where('Status','=',1)
		->get();

		$param['dtpromoheader'] = promo_header::where('Status','=',1)
		->get();

		$param['dtpromodetail'] = promo_detail::where('Status','=',1)
		->get();

		$param['dtaddress'] = address_member::where('address_member.Status','=',1)
		->where('address_member.Id_member','=',$Id_member)
		->Join('list_city','address_member.Id_city','list_city.Id_city')
		->get();

		try {
			session()->put('Id_address',$param['dtaddress'][0]->Id_address);
		} catch (\Throwable $th) {
			//throw $th;
		}


		$param['dtvoucher'] = voucher::select('Id_voucher','Voucher_name',\DB::raw('(CASE WHEN Voucher_type = 1 THEN "Disc All Product" WHEN Voucher_type = 2 THEN "Disc Selected Product" ELSE "Disc Shipping Cost" END) AS Voucher_type'),'Discount','Point','Redeem_due_date','Joinpromo')
		->get();


	
		$param['dtvouchermember'] = voucher_member::where('Id_member','=',$Id_member)
		->get();
		

		$db = list_city::all(); 
		$arr= [];  // array 
		$arr2= [];  // array 
		foreach($db as $row) {
			$arr[0] = "";
			$arr2[0] = "";
			$arr[$row->Id_province] = $row->Province_name; 
			$arr2[$row->Id_city] = $row->City_name; 
		
		}
		
		$param['arr_province']  = $arr; 
		$param['arr_city']  = $arr2; 
		return view('Cust_checkout',$param);

	}

	public function order_confirmation(Request $request)
	{
		$order = cust_order_header::find($request->id);
		$order->Status = 5;
		$order->save();

		$order_history = new cust_order_history();
		$order_history->Order_status = 5;
		$order_history->Record = "Order sudah selesai";
		$order_history->Id_order = $request->id;
		$order_history->save();

		
		return 'sukses';
	}

	public function rate_review_order(Request $request)
	{
		$order_detail = cust_order_detail::find($request->id_detail_order);

		$exist_rate_review = rate_review::where("Id_detail_order", $request->id_detail_order)
		->first();
		
		if($exist_rate_review !== null)
		{
			$rate_review = new rate_review();
			$hasil = $rate_review->edit_rating_review($request->id_detail_order, $request->rate, $request->review);
		}
		else 
		{
			$rate_review = new rate_review();
			$hasil = $rate_review->insert_rating_review( $request->id_detail_order ,$order_detail->Id_order ,session()->get('userlogin')->Id_member,$request->rate,$request->review);
		}

		$this->update_rating_product($order_detail->Id_product);
		return 'sukses';
	}

	public function sort_review(Request $request)
	{
		$result = rate_review::join('cust_order_detail', 'cust_order_detail.Id_detail_order', 'rating_review.Id_detail_order')
		->join('member', 'member.Id_member', 'rating_review.Id_member')
		->where('cust_order_detail.Id_product', $request->Id_product)
		->where('rating_review.Status', 'Active')
		->select('member.*','rating_review.*')
		->orderBy('created_at', $request->format)
		->get();

		return $result;
	}

	public function update_rating_product($id_product)
	{
		$product_rating = rate_review::join('cust_order_detail', 'cust_order_detail.Id_detail_order', 'rating_review.Id_detail_order')
						->join('product', 'product.Id_product', 'cust_order_detail.Id_product')
						->where('cust_order_detail.Id_product', $id_product)
						->where('rating_review.Status', 'Active')
						->select(DB::raw("count(*) as jum_data"), DB::raw("sum(rate) as rate"))->first();
		$product = product::find($id_product);
		if($product_rating->jum_data > 0){
			$product->Rating = $product_rating->rate / $product_rating->jum_data;
			
		}else {
			$product->Rating = 0;
		}

		$product->save();
	}

	public function hapus_rating_product(Request $request)
	{
		rate_review::where('id', $request->Id_rating)->update(['Status' => 'Deleted']);

		$this->update_rating_product($request->Id_product);

		return "sukses";
	}

	public function complete_order_automation()
	{
		$ten_days_ago = date('Y-m-d H:i:s', strtotime( '-10 day' , strtotime (date("Y-m-d H:i:s"))));
		$old_orders = cust_order_header::where('Status', '4')->where('Date_time', '<=', $ten_days_ago)->get();
		foreach ($old_orders as $order) {
			$update_old_order = cust_order_header::find($order->Id_order);
			$update_old_order->Status = 5;
			$update_old_order->save();

			$order_history = new cust_order_history();
			$order_history->Order_status = 5;
			$order_history->Record = "Order sudah selesai";
			$order_history->Id_order = $order->Id_order;
			$order_history->save();
		}
	}

	public function checkerFollowup($Id_member, $transaction_date, $Id_order)
	{
		$followup = followup::where("Id_member", $Id_member)->orderBy('Id_followup', 'desc')->first();

		if(empty($followup))
		{
			return null;
		} 
		else
		{
			if(date("Y-m-d", strtotime($followup->End_followup_date)) > date("Y-m-d", strtotime($transaction_date))){
				(new followup())->followup_successful($followup->Id_followup, $Id_member, $Id_order);
			}
		}
	

	}

	public function Database_pembeli()
	{
		$member = member::where('Role', 'CUST')->get();
		foreach ($member as $customer) {
			$customer->total_order = cust_order_header::where("Id_member", $customer->Id_member)->count();
			$customer->last_order_date = cust_order_header::where("Id_member", $customer->Id_member)->orderBy('Date_time', 'desc')->select('Date_time as tanggal')->first();
			$customer->last_order_date = $customer->last_order_date == null ? "" : $customer->last_order_date->tanggal;
			//GET CUSTOMER TOTAL ITEM HAS BEEN ORDERED
			$items = [];
			$orders = cust_order_header::where('cust_order_header.Id_member', $customer->Id_member)->join('list_city', 'list_city.Id_city', 'cust_order_header.Id_city')->get();
			foreach ($orders as $order) {
				$detail_order = cust_order_detail::join('product', 'product.Id_product', 'cust_order_detail.Id_product')->join('variation_product', 'variation_product.Id_variation', 'cust_order_detail.Id_variation')->where('cust_order_detail.Id_order', $order->Id_order)->select('product.Name', 'cust_order_detail.Normal_price','cust_order_detail.Discount_promo','cust_order_detail.Qty', 'cust_order_detail.Fix_price', 'variation_product.Variation_name as Variant_name', 'variation_product.Option_name as Variant_option_name')->get()->toArray();
				$order->detail_order = $detail_order;
			}
			$customer->orders = $orders;
		}
		return view('Kelola_database_pembeli', compact('member'));
	}
	
	public function Broadcast_pembeli(Request $request)
	{
		$customer = "";
		if(!$request->has('produk') && $request->filter == 'produk'){
			return redirect()->back()->with('error', "Pilih satu atau lebih produk!")->withInput();
		}
		if($request->filter == 'produk'){
			$customer = cust_order_header::join('cust_order_detail', 'cust_order_header.Id_order', 'cust_order_detail.Id_order')->whereIn('cust_order_detail.Id_product', $request->produk)->groupBy('cust_order_header.Id_member')->groupBy('cust_order_header.Email')->select('Id_member', 'Email')->get();
		}else if($request->filter == 'total_transaksi'){
			$result = [];
			$member = member::where('Role', 'CUST')->get();
			foreach ($member as $cust) {
				$total_transaksi = cust_order_header::where('Id_member', $cust->Id_member)->count();
				if($total_transaksi == $request->total_transaksi){
					array_push($result,$cust);
				}
			}
			$customer = $result;
		}else if($request->filter == 'status_transaksi'){
			$customer = cust_order_header::where('Status', $request->status_transaksi)->get();
		}

		foreach ($customer as $cust) {
			Mail::to($cust->Email)->send(new BroadcastMail($request->subject, $request->content));
		}
		return redirect()->back()->with('success', "Success send to ". count($customer) ." customers");
	}

	public function Send_email_to_customer(Request $request)
	{
		logger($request->all());
		$customer = member::find($request->Id_member);
		Mail::to($customer->Email)->send(new SendEmail($request->Subject, $request->Content));

		return 'sukses';
	}

	public function simpan_catatan_customer(Request $request)
	{
		$member = member::find($request->Id_member);
		$member->Catatan = $request->Catatan;
		$member->save();

		return redirect()->back()->with('success', 'Sukses');
	}

	public function request_otp(Request $request)
	{
		$is_member = member::where('Email', $request->Email)->first();
		if(empty($is_member)){
			return "email_tidak_terdaftar";
		}

		$actived_kode_otp = otp::where('Email', $request->Email)->where('Status', 'Active')->first();
		if(!empty($actived_kode_otp)){
			otp::where('id', $actived_kode_otp->id)->update(['Status' => 'Expired']);
		}
		$kode_otp = random_int(000000, 999999);
		$expired_time = date('Y-m-d H:i:s', strtotime("+30 minutes"));
		otp::create([
			'Kode' => $kode_otp,
			'Email' => $request->Email,
			'Expired_time' => $expired_time,
			'Status' => 'Active'
		]);

		Mail::to(strtolower($request->Email))->send(new RequestOTP($kode_otp));

		return "sukses";
	}
	
	public function ganti_password(Request $request)
	{
		$validator = Validator::make($request->all(),[
			'new_password' => ['required','min:8', 'max:20'],
			'kon_new_password' => ['required','same:new_password'],
			'kode_otp' => ['required']
		],
		[
			'kode_otp.required' => 'Kode OTP cant empty',
			'new_password.required' => 'Password cant empty',
			'new_password.min' => 'Password min 8 char',
			'new_password.min' => 'Password max 20 char',
			'kon_new_password.same' => 'Password & Confirmation password not match'
		]);

		if($validator->fails()){
			return view('forgot_password')->withErrors($validator);
		}

		$otp = otp::where('Kode', $request->kode_otp)->where('Expired_time', '>=', date("Y-m-d H:i:s"))->where('Status', 'Active')->first();
		if(empty($otp)){
			return view('forgot_password')->withErrors(['kode_otp'=>'Kode expired/salah']);
		}

		$member = member::where("Email", $otp->Email)->first();
		member::where("Id_member", $member->Id_member)->update(['Password' => md5($request->new_password)]);

		otp::where('Kode', $request->kode_otp)->update(['Status' => "Used"]);

		return view('forgot_password')->with(['success' => "Password berhasil diganti"]);
	}

	public function getPopulerProduct()
	{
		$products = cust_order_header::join('cust_order_detail', 'cust_order_header.Id_order', 'cust_order_detail.Id_order')
            ->join('product', 'product.Id_product', 'cust_order_detail.Id_product')
            ->groupBy('product.Id_product', 'product.Name')
            ->orderBy('qty', 'desc')
            ->selectRaw("sum(cust_order_detail.Qty) as qty, product.Id_product, product.Name")->get();

			return $products;
	}
}

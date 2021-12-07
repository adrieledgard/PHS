<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// });

Route::get('test', ["uses"=>"Controller@test"]);
Route::get('embedtes', ["uses"=>"Controller@embedtes"]);

Route::get('/', ["uses"=>"Controller@home"]);

Route::get('coba', function () {
    return view('Dashboard_admin');
});

Route::get('Dashboard_admin', ["uses"=>"Controller@Dashboard_admin"]);



Route::get('rajaongkir', ["uses"=>"Controller@rajaongkir"]);


Route::get('register', ["uses"=>"Controller@register"]);
Route::post('registerProcess', ["uses"=>"Controller@post_register"]);

Route::get('login', ["uses"=>"Controller@login"]);
Route::get('forgot_password', ["uses"=>"Controller@forgot_password"]);
Route::get('logout_team_member', ["uses"=>"Controller@logout_team_member"]);
Route::post('loginProcess', ["uses"=>"Controller@post_login"]);
Route::get('validasipromo', ["uses"=>"Controller@validasipromo"]);
Route::get('edit_profile', ["uses"=>"Controller@edit_profile"]);
Route::post('update_profile', ["uses"=>"Controller@update_profile"]);


Route::get('Cust_show_cat', ["uses"=>"Controller@Cust_show_cat"]);
Route::get('Cust_show_product/{id}', ["uses"=>"Controller@Cust_show_product"]);
Route::get('Cust_show_product/{id}/{Random_code}', ["uses"=>"Controller@Cust_show_product_affiliate"]);




Route::get('getpricevariant', ["uses"=>"Controller@getpricevariant"]);
Route::get('getpricechangeqty', ["uses"=>"Controller@getpricechangeqty"]);
Route::get('getpromovariant', ["uses"=>"Controller@getpromovariant"]);


Route::get('Advance_search', ["uses"=>"Controller@Advance_search"]);
Route::get('search_multi', ["uses"=>"Controller@search_multi"]);
Route::get('clear_search', ["uses"=>"Controller@clear_search"]);
Route::get('muncul_awal_search', ["uses"=>"Controller@muncul_awal_search"]);
Route::get('page_next_previous', ["uses"=>"Controller@page_next_previous"]);
Route::get('search_name', ["uses"=>"Controller@search_name"]);
Route::get('view_more_halaman_home', ["uses"=>"Controller@view_more_halaman_home"]);
Route::get('ganti_Sort', ["uses"=>"Controller@ganti_Sort"]);






Route::get('Wishlist', ["uses"=>"Controller@Wishlist"]);
Route::get('open_wishlist', ["uses"=>"Controller@open_wishlist"]);
Route::get('open_wishlist2', ["uses"=>"Controller@open_wishlist2"]);
Route::get('update_wishlist', ["uses"=>"Controller@update_wishlist"]);
Route::get('add_wishlist', ["uses"=>"Controller@add_wishlist"]);

Route::get('updateqtywishlist', ["uses"=>"Controller@updateqtywishlist"]);
Route::get('deletewishlist', ["uses"=>"Controller@deletewishlist"]);



Route::get('Affiliate_marketing', ["uses"=>"Controller@Affiliate_marketing"]);
Route::get('Get_cost_shipping', ["uses"=>"Controller@Get_cost_shipping"]);





Route::get('cart', ["uses"=>"Controller@cart"]);
Route::get('add_cart', ["uses"=>"Controller@add_cart"]);

Route::get('update_cart', ["uses"=>"Controller@update_cart"]);
Route::get('updateqtycart', ["uses"=>"Controller@updateqtycart"]);
Route::get('deletecart', ["uses"=>"Controller@deletecart"]);


Route::get('point', ["uses"=>"Controller@point"]);
Route::get('claim_voucher', ["uses"=>"Controller@claim_voucher"]);
Route::get('get_voucher_selected_product', ["uses"=>"Controller@get_voucher_selected_product"]);

Route::get('My_voucher', ["uses"=>"Controller@My_voucher"]);


Route::get('get_city', ["uses"=>"Controller@get_city"]);
Route::get('add_address', ["uses"=>"Controller@add_address"]);
Route::get('edit_address', ["uses"=>"Controller@edit_address"]);
Route::get('delete_address', ["uses"=>"Controller@delete_address"]);
Route::get('getaddress', ["uses"=>"Controller@getaddress"]);



Route::get('to_checkout', ["uses"=>"Controller@to_checkout"]);
Route::get('Cust_checkout', ["uses"=>"Controller@Cust_checkout"]);
Route::get('Get_address', ["uses"=>"Controller@Get_address"]);
Route::get('Use_voucher', ["uses"=>"Controller@Use_voucher"]);



Route::get('Pay_cust', ["uses"=>"Controller@Pay_cust"]);
Route::get('atc_from_wishlist', ["uses"=>"Controller@atc_from_wishlist"]);




Route::get('master_product', ["uses"=>"ControllerMaster@master_product"])->middleware('CheckLogin','CheckRoleAdmin');
Route::get('master_product_add', ["uses"=>"ControllerMaster@master_product_add"])->middleware('CheckLogin','CheckRoleAdmin');
Route::post('add_product_detail', ["uses"=>"ControllerMaster@add_product_detail"]);
Route::post('edit_product_detail', ["uses"=>"ControllerMaster@edit_product_detail"]);
// Route::post('upload-images', ["uses"=>"Controller@upload_product_images"]);
Route::get('add_option_product', ["uses"=>"ControllerMaster@add_option_product"]);
Route::get('show_cart_option', ["uses"=>"ControllerMaster@show_cart_option"]);
Route::get('delete_option', ["uses"=>"ControllerMaster@delete_option"]);
Route::get('add_sub_table', ["uses"=>"ControllerMaster@add_sub_table"]);
Route::get('show_cart_sub', ["uses"=>"ControllerMaster@show_cart_sub"]);
Route::get('delete_sub', ["uses"=>"ControllerMaster@delete_sub"]);
Route::get('add_subcat_session', ["uses"=>"ControllerMaster@add_subcat_session"]);
Route::get('add_option_session', ["uses"=>"ControllerMaster@add_option_session"]);
Route::get('get_variation', ["uses"=>"ControllerMaster@get_variation"]);
Route::get('edit_variation', ["uses"=>"ControllerMaster@edit_variation"]);








Route::get('product_model', ["uses"=>"ControllerMaster@product_model"]);


Route::get('Master_product_detail/{id}', ["uses"=>"ControllerMaster@Master_product_detail"]);
Route::get('Master_product_images/{id}', ["uses"=>"ControllerMaster@Master_product_images"]);
Route::get('switch_image_order', ["uses"=>"ControllerMaster@switch_image_order"]);
Route::get('deleteproductimage', ["uses"=>"ControllerMaster@deleteproductimage"]);




Route::post('Insertphoto', ["uses"=>"ControllerMaster@Insertphoto"]);











Route::get('master_category', ["uses"=>"ControllerMaster@master_category"])->middleware('CheckLogin','CheckRoleAdmin');
Route::get('getsubcategoryname', ["uses"=>"ControllerMaster@ajaxsubcategory"]);
Route::get('getcategory', ["uses"=>"ControllerMaster@getcategory"]);
Route::get('getsubcategory', ["uses"=>"ControllerMaster@getsubcategory"]);
Route::post('add_category', ["uses"=>"ControllerMaster@add_category"]);
Route::post('edit_category', ["uses"=>"ControllerMaster@edit_category"]);
Route::post('edit_sub_category', ["uses"=>"ControllerMaster@edit_sub_category"]);
Route::get('delete_category', ["uses"=>"ControllerMaster@delete_category"]);
Route::get('delete_sub_category', ["uses"=>"ControllerMaster@delete_sub_category"]);




Route::get('master_sub_category', ["uses"=>"ControllerMaster@master_sub_category"])->middleware('CheckLogin','CheckRoleAdmin');
Route::post('add_sub_category', ["uses"=>"ControllerMaster@add_sub_category"]);


Route::get('master_team_member', ["uses"=>"ControllerMaster@master_team_member"])->middleware('CheckLogin','CheckRoleAdmin');
Route::post('add_team_member', ["uses"=>"ControllerMaster@add_team_member"]);
Route::post('edit_team_member', ["uses"=>"ControllerMaster@edit_team_member"]);
Route::get('getteammember', ["uses"=>"ControllerMaster@getteammember"]);


Route::get('master_brand', ["uses"=>"ControllerMaster@master_brand"])->middleware('CheckLogin','CheckRoleAdmin');
Route::post('add_brand', ["uses"=>"ControllerMaster@add_brand"]);
Route::post('edit_brand', ["uses"=>"ControllerMaster@edit_brand"]);
Route::get('getbrand', ["uses"=>"ControllerMaster@getbrand"]);
Route::get('delete_brand', ["uses"=>"ControllerMaster@delete_brand"]);


Route::get('master_bank', ["uses"=>"ControllerMaster@master_bank"])->middleware('CheckLogin','CheckRoleAdmin');
Route::post('add_bank', ["uses"=>"ControllerMaster@add_bank"]);
Route::post('edit_bank', ["uses"=>"ControllerMaster@edit_bank"]);
Route::get('getbank', ["uses"=>"ControllerMaster@getbank"]);
Route::get('delete_bank', ["uses"=>"ControllerMaster@delete_bank"]);



Route::get('master_banner', ["uses"=>"ControllerMaster@master_banner"])->middleware('CheckLogin','CheckRoleAdmin');
Route::get('isi_modal_product', ["uses"=>"ControllerMaster@isi_modal_product"]);
Route::get('isi_modal_product_2', ["uses"=>"ControllerMaster@isi_modal_product_2"]);
Route::get('get_product_detail', ["uses"=>"ControllerMaster@get_product_detail"]);
Route::post('Add_main_banner', ["uses"=>"ControllerMaster@Add_main_banner"]);
Route::post('Edit_main_banner', ["uses"=>"ControllerMaster@Edit_main_banner"]);
Route::post('Edit_main_banner_2', ["uses"=>"ControllerMaster@Edit_main_banner_2"]);

Route::get('delete_banner', ["uses"=>"ControllerMaster@delete_banner"]);
Route::post('Add_main_banner_2', ["uses"=>"ControllerMaster@Add_main_banner_2"]);
Route::get('get_data_banner', ["uses"=>"ControllerMaster@get_data_banner"]);



Route::get('master_type', ["uses"=>"ControllerMaster@master_type"])->middleware('CheckLogin','CheckRoleAdmin');
Route::post('add_type', ["uses"=>"ControllerMaster@add_type"]);
Route::post('edit_type', ["uses"=>"ControllerMaster@edit_type"]);
Route::get('gettype', ["uses"=>"ControllerMaster@gettype"]);
Route::get('delete_type', ["uses"=>"ControllerMaster@delete_type"]);



Route::get('master_supplier', ["uses"=>"ControllerMaster@master_supplier"])->middleware('CheckLogin','CheckRoleAdmin');
Route::get('getsupplier', ["uses"=>"ControllerMaster@getsupplier"]);
Route::post('add_supplier', ["uses"=>"ControllerMaster@add_supplier"]);
Route::post('edit_supplier', ["uses"=>"ControllerMaster@edit_supplier"]);
Route::get('master_supplier_add', ["uses"=>"ControllerMaster@master_supplier_add"]);
Route::get('enter_session_product_supplier', ["uses"=>"ControllerMaster@enter_session_product_supplier"]);
Route::get('session_tipe_supplier_product', ["uses"=>"ControllerMaster@session_tipe_supplier_product"]);
Route::get('enter_product_supplier', ["uses"=>"ControllerMaster@enter_product_supplier"]);
Route::get('delete_session_product_supplier', ["uses"=>"ControllerMaster@delete_session_product_supplier"]);
Route::get('Master_supplier_detail/{id}', ["uses"=>"ControllerMaster@Master_supplier_detail"]);
Route::get('start_session_product_supplier', ["uses"=>"ControllerMaster@start_session_product_supplier"]);




Route::get('master_promo', ["uses"=>"ControllerMaster@master_promo"])->middleware('CheckLogin','CheckRoleAdmin');
Route::get('add_promo_session', ["uses"=>"ControllerMaster@add_promo_session"]);
Route::get('reset_promo_session', ["uses"=>"ControllerMaster@reset_promo_session"]);
Route::get('delete_promo_session', ["uses"=>"ControllerMaster@delete_promo_session"]);
Route::get('add_promo', ["uses"=>"ControllerMaster@add_promo"]);
Route::get('get_data_promo', ["uses"=>"ControllerMaster@get_data_promo"]);
Route::get('delete_promo', ["uses"=>"ControllerMaster@delete_promo"]);




Route::get('master_voucher', ["uses"=>"ControllerMaster@master_voucher"])->middleware('CheckLogin','CheckRoleAdmin');
Route::get('master_voucher_add', ["uses"=>"ControllerMaster@master_voucher_add"]);
Route::get('session_tipe_voucher', ["uses"=>"ControllerMaster@session_tipe_voucher"]);
Route::post('add_voucher', ["uses"=>"ControllerMaster@add_voucher"]);
Route::post('edit_voucher', ["uses"=>"ControllerMaster@edit_voucher"]);
// Route::get('enter_session_product_voucher', ["uses"=>"ControllerMaster@enter_session_product_voucher"]);
Route::get('Master_voucher_detail/{id}', ["uses"=>"ControllerMaster@Master_voucher_detail"]);
Route::get('delete_voucher', ["uses"=>"ControllerMaster@delete_voucher"]);





Route::get('master_affiliate', ["uses"=>"ControllerMaster@master_affiliate"])->middleware('CheckLogin','CheckRoleAdmin');
// Route::post('add_affiliate', ["uses"=>"ControllerMaster@add_affiliate"]);
Route::get('getaffiliatedata', ["uses"=>"ControllerMaster@getaffiliatedata"]);
Route::post('edit_affiliate', ["uses"=>"ControllerMaster@edit_affiliate"]);


Route::get('master_ebook', ["uses"=>"ControllerMaster@master_ebook"])->name('master_ebook');
Route::get('master_ebook/{ebook_id}/show/{user_token}', ["uses"=>"ControllerMaster@show_ebook"]);
Route::post('master_ebook/{ebook_id}/email_submitted/{user_token}', ["uses"=>"ControllerMaster@submit_email_ebook"]);
Route::get('master_ebook/create', ["uses"=>"ControllerMaster@create_ebook"]);
Route::post('master_ebook/store', ["uses"=>"ControllerMaster@ebook_store"]);
Route::get('master_ebook/edit/{id}', ["uses"=>"ControllerMaster@edit_ebook"]);
Route::post('master_ebook/update/{id}', ["uses"=>"ControllerMaster@ebook_update"]);
Route::get('master_ebook/delete/{id}', ["uses"=>"ControllerMaster@delete_ebook"]);

Route::get('Ebook_marketing', ["uses"=>"Controller@Ebook_marketing"]);









Route::get('Purchase', ["uses"=>"ControllerTransaction@Purchase"]);
Route::get('Purchase_add', ["uses"=>"ControllerTransaction@Purchase_add"]);
Route::get('Purchase_pre_add', ["uses"=>"ControllerTransaction@Purchase_pre_add"]);
Route::get('show_supplier', ["uses"=>"ControllerTransaction@show_supplier"]);
Route::get('show_table_session', ["uses"=>"ControllerTransaction@show_table_session"]);
Route::get('add_product_session', ["uses"=>"ControllerTransaction@add_product_session"]);
Route::get('showsession', ["uses"=>"ControllerTransaction@showsession"]);
Route::get('changecboption', ["uses"=>"ControllerTransaction@changecboption"]);
Route::get('delete_product_session', ["uses"=>"ControllerTransaction@delete_product_session"]);
Route::get('get_data_product_session', ["uses"=>"ControllerTransaction@get_data_product_session"]);
Route::get('add_expire_qty_session', ["uses"=>"ControllerTransaction@add_expire_qty_session"]);
Route::get('show_table_expire', ["uses"=>"ControllerTransaction@show_table_expire"]);
Route::get('delete_expire_qty_session', ["uses"=>"ControllerTransaction@delete_expire_qty_session"]);
Route::post('Insert_purchase', ["uses"=>"ControllerTransaction@Insert_purchase"]);
Route::get('void_purchase', ["uses"=>"ControllerTransaction@void_purchase"]);
Route::get('get_purchase_detail', ["uses"=>"ControllerTransaction@get_purchase_detail"]);
Route::get('Add_product_modal', ["uses"=>"ControllerTransaction@Add_product_modal"]);
Route::get('force_close_purchase', ["uses"=>"ControllerTransaction@force_close_purchase"]);








Route::get('Receive_order', ["uses"=>"ControllerTransaction@Receive_order"]);
Route::get('Receive_order_pre', ["uses"=>"ControllerTransaction@Receive_order_pre"]);
Route::get('Receive_order_add', ["uses"=>"ControllerTransaction@Receive_order_add"]);
Route::get('show_supplier_receive_order', ["uses"=>"ControllerTransaction@show_supplier_receive_order"]);
Route::get('Receive_order_add_select', ["uses"=>"ControllerTransaction@Receive_order_add_select"]);
Route::get('session_receive_select', ["uses"=>"ControllerTransaction@session_receive_select"]);
Route::get('showsessionreceive', ["uses"=>"ControllerTransaction@showsessionreceive"]);
Route::get('get_session_receive', ["uses"=>"ControllerTransaction@get_session_receive"]);
Route::get('change_receive_qty', ["uses"=>"ControllerTransaction@change_receive_qty"]);
Route::get('set_id_reveice_session', ["uses"=>"ControllerTransaction@set_id_reveice_session"]);
Route::get('show_table_ro', ["uses"=>"ControllerTransaction@show_table_ro"]);
Route::get('input_receive_order', ["uses"=>"ControllerTransaction@input_receive_order"]);
Route::get('input_receive_order_shipper', ["uses"=>"ControllerTransaction@input_receive_order_shipper"]);
Route::get('show_detail_receive', ["uses"=>"ControllerTransaction@show_detail_receive"]);
Route::get('get_receive_detail', ["uses"=>"ControllerTransaction@get_receive_detail"]);
Route::get('Receive_request', ["uses"=>"ControllerTransaction@Receive_request"]);
Route::get('get_shipper_data', ["uses"=>"ControllerTransaction@get_shipper_data"]);
Route::get('set_status_receive', ["uses"=>"ControllerTransaction@set_status_receive"]);
Route::get('void_receive_detail', ["uses"=>"ControllerTransaction@void_receive_detail"]);

Route::get('chat_list', ['uses' => "ControllerCustomerService@index_chat"]);
Route::get('list_request_assist', ['uses' => "ControllerCustomerService@index_request_assist"])->name('list_request_assist');
Route::get('request_assist_add', ['uses' => "ControllerCustomerService@create_request_assist"]);
Route::post('add_request_assist', ['uses' => "ControllerCustomerService@insert"]);
Route::get('request_assist_update/{id}', ['uses' => "ControllerCustomerService@update_request_assist"]);
Route::post('update_request_assist/{id}', ['uses' => "ControllerCustomerService@update"]);
Route::post('closed_request_assist', ['uses' => "ControllerCustomerService@closed"]);





Route::get('Purchase_payment', ["uses"=>"ControllerTransaction@Purchase_payment"]);
Route::get('get_receive_detail_payment', ["uses"=>"ControllerTransaction@get_receive_detail_payment"]);

Route::get('Purchase_payment_pay/{id}', ["uses"=>"ControllerTransaction@Purchase_payment_pay"]);
Route::get('payment_method_select', ["uses"=>"ControllerTransaction@payment_method_select"]);
Route::post('Insert_purchase_payment', ["uses"=>"ControllerTransaction@Insert_purchase_payment"]);
// Route::get('session_kodegambar_payment', ["uses"=>"ControllerTransaction@session_kodegambar_payment"]);






Route::get('stock_card', ["uses"=>"ControllerReport@stock_card"]);
Route::get('get_variation_product', ["uses"=>"ControllerReport@get_variation_product"]);
Route::get('show_table_stock_card', ["uses"=>"ControllerReport@show_table_stock_card"]);


















Route::get('logout', ["uses"=>"Controller@logout"]);

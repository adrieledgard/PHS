@extends('layout_frontend.Master')


@push('custom-css')

    {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="{{ asset ('css/register-login/register-login.css') }}" rel="stylesheet" type="text/css">  --}}
    <link href="{{ asset ('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <script src ="{{ asset ('js/jquery.js') }}"></script>
    <script src ="{{ asset ('js/bootstrap.js') }}"></script>
    <script src ="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
@endpush




@section('Content')
<!-- shopping-cart-area start -->
<div class="cart-main-area pt-95 pb-100 wishlist">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <?php
                    $totalweight =0;
                    if($Id_member=="")
                    {
                        try {
                            $nama2 = $Name;
                            $phone2 = $Phone;
                            $email2 = $Email;
                        } catch (\Throwable $th) {
                            $nama2 = "";
                            $phone2 = "";
                            $email2 = "";
                        }
                        ?>
                            <input type="hidden" id="guess" value="yes">
                            <div class="jumbotron col-md-12 row">
                                <div class="col-md-6">
                                    {{-- <input type='text' id='txtsnaptoken{{ $no }}' value='{{ $cr->snap_token }}'> --}}
                                    {{ Form::label('Full name','') }}
                                    {{ Form::text('txt_name', $nama2, ['class'=>'form-control','Id'=>'txt_name']) }}
                                    <br>
                                    {{ Form::label('Email','') }}
                                    {{ Form::text('txt_email', $email2, ['class'=>'form-control','Id'=>'txt_email']) }}
                                    <br>
                                    {{ Form::label('Phone','') }}
                                    {{ Form::Number('txt_phone', $phone2, ['class'=>'form-control','Id'=>'txt_phone']) }}
                                    <br>
                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('Province :','') }}
                                    {{ Form::select('cb_province', $arr_province, 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_province', 'onchange' => 'load_city()' ]) }}
                                    <br>
                                    {{ Form::label('City :','') }}
                                    {{ Form::select('cb_city', [], 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_city','onchange' => 'choose_city()' ]) }}
                                    <br>
                                    {{ Form::label('Full address :','') }}
                                    {{ Form::textarea('txt_address', '', ['class'=>'form-control','id'=>'txt_address']) }}
                                </div>
                               
                            </div>
                    

                        <?php
                    }
                    else {
                        ?>
                            <div class="jumbotron col-md-5">
                                <div class="button-box" style="text-align:left">
                                    <button type="submit" name="update_profile" class="default-btn"  data-toggle="modal" data-target="#Choose_address">Choose Address</button>
                                </div>
                                <div class="row">
                                <div class="col-md-12">
                                    @php
                                        $ctr=0;
                                        
                                        
                                    @endphp
                                    @foreach ($dtaddress as $data)
                                        
                                            <?php
                                                if($ctr==0)
                                                {
                                                    ?>
                                                        <br>
                                                        <label class="form-check-label" style="font-size: 200%">Ship to :</label>
                                                        <br>
                                                        <label class="form-check-label"style="font-size: 110%" id="shipto">

                                                            {{$data->Address}} <br>
                                                            {{$data->City_name}} - {{$data->Province_name}}

                                                        </label>
                                                    <?php
                                                }

                                            ?>
                                        @php
                                            $ctr++;
                                        @endphp
                                    @endforeach
                                </div>
                            </div>
                            </div>

                        <?php
                    }
                ?>
                
                
                <form action="#">
                    <div class="table-content table-responsive">
                        <div style='border: 0px solid black;'>
                            <table>
                                
                                <thead>
                                    
                                    <tr>
                                        <th>images</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                               
                                
                                <tbody>
                                    @php
                                        $totalsemua=0;
                                    @endphp
                                    @foreach ($cart as $cr)
                                        <?php 
                                            if($cr->Id_cart!=-1) // -1 adalah cart yg di delete
                                            {
                                                ?>
                                                    @php
                                                    $Id_variation="";
                                                    $harga="";
                                                    $option_name="";
                                                    $stock ="";
                                                    
                                                
                                                    @endphp
                                                    <tr>
                                                    @foreach ($variation as $var)
                                                        @php
                                                            if($cr->Id_variation == $var->Id_variation) 
                                                            {
                                                                $Id_variation = $cr->Id_variation;
                                                                $harga = $var->Sell_price;
                                                                $option_name = $var->Option_name;
                                                                $stock = $var->Stock - $var->Stock_atc - $var->Stock_pay;
                                                                if($option_name=="NONE")
                                                                {
                                                                    $option_name="-";
                                                                }
                                                                $totalweight = $totalweight + ($var->Weight * $cr->Qty);
                                                            }
                                                        @endphp
                                                    @endforeach
                                                    {{-- <td class=""><button class="btn btn-danger btn-lg" onclick="deletecart('{{$cr->Id_cart}}')"><i class="pe-7s-close"></i></button></td> --}}
                                                    <td class="product-thumbnail">
                                                        @php
                                                            $ctrimg=0;
                                                        @endphp
                                                        @foreach ($productimage as $img)
                                                            <?php
                                                                if($img->Id_product == $cr->Id_product)
                                                                {
                                                                    ?>
                                                                        @php
                                                                            $ctrimg=1;
                                                                        @endphp
                                                                        <a href="#"><img src="{{asset('Uploads/Product/'.$img->Image_name)}}" width='150px' height='150px' alt=""></a>
                                                                    <?php
                                                                }

                                                            ?>
                                                        @endforeach

                                                        <?php
                                                        if($ctrimg==0)
                                                        {
                                                            ?>
                                                                <a href="#"><img src="{{asset('Uploads/Product/default.jpg')}}" width='150px' height='150px' alt=""></a>
                                                            <?php
                                                        }
                                                    ?>
                                                    </td>
                                                    @php
                                                        $name="";
                                                        $Id_product="";
                                                    @endphp
                                                    @foreach ($product as $pro)
                                                        @php
                                                            if($pro->Id_product == $cr->Id_product)
                                                            {
                                                                $name=$pro->Name;
                                                                $Id_product = $pro->Id_product;
                                                            }
                                                        @endphp                                        
                                                    @endforeach
                                                    <td class="product-name" style="text-align: left;"><a href="{!! url('Cust_show_product/'.$Id_product); !!}">

                                                    <?php
                                                        if($option_name=="-")
                                                        {
                                                            ?>
                                                                {{$name}}
                                                            <?php
                                                        }
                                                        else {
                                                            ?>
                                                            {{$name}} - {{$option_name}} 
                                                            <?php
                                                        }

                                                    ?>


                                                    </a></td>
                                                    {{-- <td>Stock : {{$stock}}</td> --}}


                                                    <?php
                                                        
                                                        $sale=0;
                                                        $model ="";
                                                        $discount=0;
                                                        foreach ($dtpromoheader as $promoheader) {
                                                            if($promoheader->Id_variation == $Id_variation)
                                                            {
                                                                $model = $promoheader->Model;
                                                                foreach ($dtpromodetail as $promodetail) {
                                                                    if($promoheader->Id_promo == $promodetail->Id_promo)
                                                                    {
                                                                        if($cr->Qty >= $promodetail->Minimum_qty)
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
                                                                $hargabaru = $harga - ($harga * ($discount/100));
                                                            
                                                                ?>
                                                            <td class="product-price-cart"><span class="amount"><s>Rp.{{number_format($harga)}}</s></span><br><span class="amount">Rp.{{number_format($hargabaru)}}</span></td>

                                                            <input type="hidden" id="harga{{$Id_variation}}" value="{{$hargabaru}}">
                                                        
                                                                <?php
                                                            }
                                                            else if($model=="RP")
                                                            {
                                                                $hargabaru = $harga - $discount;

                                                                ?>
                                                                <td class="product-price-cart"><span class="amount"><s>Rp.{{number_format($harga)}}</s></span><br><span class="amount">Rp.{{number_format($hargabaru)}}</span></td>

                                                                    <input type="hidden" id="harga{{$Id_variation}}" value="{{$hargabaru}}">
                                                            
                                                                <?php
                                                            }

                                                        
                                                        }
                                                        else {
                                                            ?>
                                                            <td class="product-price-cart"><span class="amount">Rp.{{number_format($harga)}}</span></td>
                                                            <input type="hidden" id="harga{{$Id_variation}}" value="{{$harga}}">
                                                            <?php
                                                        }
                                                    ?>

                                                    <td class="product-quantity">
                                                        <input value="{{$cr->Qty}}" readonly="true" type="number" id="qtycart{{$Id_variation}}" onchange="updateqtycart('{{$Id_variation}}','{{$cr->Id_cart}}')">
                                                    </td>

                                                    <td class="product-subtotal" id="subtotal{{$Id_variation}}">
                                                        <?php
                                                            if($sale==0)
                                                            {
                                                                ?>
                                                                    Rp. {{number_format($cr->Qty * $harga)}}

                                                                
                                                                <?php 
                                                                $totalsemua+=$cr->Qty * $harga;
                                                            }
                                                            else {
                                                                ?>
                                                                    Rp. {{number_format($cr->Qty * $hargabaru)}}
                                                                <?php 
                                                                $totalsemua+=$cr->Qty * $hargabaru;
                                                            }
                                                        ?>
                                                        

                                                    </td>
                                                    {{-- <td class=""><button class="btn btn-primary" onclick="">Add to cart</button></td> --}}
                                                    </tr>
                                            <?php
                                            }
                                            ?>
                                    @endforeach
                                </tbody>
                               
                            </table>
                        </div>
                    </div>
                    
                </form>

                <div class="row">
                    <div class="col-md-6">
                        <div class="jumbotron">
                            <div class="row">
                                <div class="col-md-12">
                                    Total weight:
                                    <input type="hidden" id="weight_hidden" value="{{$totalweight}}"> {{--weight--}}
                                    <span id="totalweight">{{$totalweight / 1000}}</span> Kg
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-md-12">
                                   Choose Shipping

                                   <?php
                                        if($Id_member=="") //guess
                                        {
                                            ?>
                                                {{ Form::select('cb_courier', ['JNE','POS','TIKI'], 'Kosong', ['placeholder'=>'Choose Courier','class'=>'form-control', 'id'=>'cb_courier','Onchange'=>'change_courier(0)' ]) }}
                                            <?php
                                        }
                                        else {
                                            ?>
                                                {{ Form::select('cb_courier', ['JNE','POS','TIKI'], 'Kosong', ['placeholder'=>'Choose Courier','class'=>'form-control', 'id'=>'cb_courier','Onchange'=>'change_courier(1)' ]) }}
                                            <?php
                                        }
                                   ?>
                                 
                               </div>
                           </div>
                           <br><br>
                           <div class="row">
                               <div class="col-md-12">
                                <input type="hidden" id="courier_hidden" value=""> {{--nama kurir--}}
                                <input type="hidden" id="courier_packet_text_hidden" value=""> {{--nama paket kurir--}}
                                    <div id="courier_packet">
                                       
                                    </div>
                               </div>
                           </div>
                         
                        </div>
                    </div>

                    <?php
                        if($Id_member!="")
                        {
                            ?>
                                <div class="col-md-6">
                                    <div class="jumbotron">
                                        <div class="row">
                                            <div class="col-md-12">
                                                Voucher <br>
            
                                                <button class="btn btn-primary"  data-toggle="modal" data-target="#My_voucher">Choose voucher</button>
                                                <button class="btn btn-secondary"  onclick="clear_voucher()">Clear voucher</button>
                                                {{-- <span id="totalweight">{{$totalweight / 1000}}</span> Kg --}}
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="voucher_show" style="color:red">

                                                </div>
                                                <input type="hidden" id="voucher_hidden_asli" value=""> {{--jumlah asli awal--}}
                                                <input type="hidden" id="voucher_hidden" value=""> {{--jumlah--}}
                                                <input type="hidden" id="Type_voucher_hidden" value="">
                                                <input type="hidden" id="Id_voucher_hidden" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php
                        }

                    ?>
                    
                </div>
                

                
            
            </div>
            {{-- <div class="button-box" style="text-align:right">
                <button type="submit" name="update_profile" class="default-btn">Pay now</button>
            </div> --}}
        </div>

        <div class="row" style="font-size:115%">
            <div class="col-md-9">

            </div>

            <div class="col-md-2">
                TOTAL :
            </div>
            <div class="col-md-1">
                <input type="hidden" id="total_awal_hidden" value="{{$totalsemua}}">
               Rp.{{number_format($totalsemua)}}
            </div>
        </div>

        <div class="row" style="font-size:115%">
            <div class="col-md-9">

            </div>

            <div class="col-md-2">
                {{-- <input type="hidden" id="total_awal" value="{{$totalsemua}}"> --}}
                Shipping Cost :
            </div>
            <div class="col-md-1" id="ongkir">
                 
            </div>
            <input type="hidden" id="ongkir_hidden" value="0">
            
        </div>

        <?php

            if($Id_member!="")
            {
                ?>
                    <div class="row" style="color: red; font-size:115% ">
                        <div class="col-md-9">

                        </div>

                        <div class="col-md-2">
                            Discount Voucher :
                        </div>
                        <div class="col-md-1" id="discount_voucher">
                        
                        </div>
                        {{-- <input type="hidden" id="discount_voucher_hidden" value="0"> --}}
                    </div>
                <?php
            }

        ?>
        
        <br><br>
        <div class="row" style="font-size: 115%">
            <div class="col-md-9">

            </div>

            <div class="col-md-2">
                Grand Total :
            </div>
            <div class="col-md-1" id="grand_total">
               Rp.
            </div>
            <input type="hidden" id="grand_total_hidden" value="0">
        </div>

        <br><br>
        <div class="row">
            <div class="col-md-12 float-right">
                <button class="btn btn-primary float-right" onclick="pay()">Pay</button>
            </div>
        </div>
        
    </div>
</div>

<div class="modal fade" id="Choose_address">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><b>Address </b> </h4>
          {{-- <h4 class="modal-title">Info Product</h4> --}}
        
        </div>
        <div class="container">
            <div class="row">
             
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class='table table-striped display table_id_3'>
                        <thead>
                            <tr>
                                <th>Address</th>
                                <th>Province</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($dtaddress as $data)
                                <tr>
                                    <td>{{$data->Address}}</td>
                                    <td>{{$data->Province_name}}</td>
                                    <td>{{$data->City_name}}</td>
                                    <td>
                                        {{-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit_modal" data-cat="{{$data->Id_category}}">Edit</button> --}}
                                        {{ Form::button('Select', ['name'=>'btn_select','class'=>'btn btn-warning btn-sm ','onclick'=>'select_address('.$data->Id_address.')']) }}
                                        {{-- {{ Form::button('Delete', ['name'=>'btn_delete','class'=>'btn btn-danger btn-sm ','onclick'=>'delete_address('.$data->Id_address.')']) }} --}}
                                      
                                      </td>
                                </tr>   
                            @endforeach
                        </tbody>
                        
                    
                    </table>
                </div>
            </div>

            <br><br>
  
       
        </div>
            <div class="modal-footer">
              {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
            </div>
       
      </div>
    </div>
  </div>





<div class="modal fade" id="My_voucher">
<div class="modal-dialog modal-xl">
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title"><b>My Voucher </b> </h4>
        {{-- <h4 class="modal-title">Info Product</h4> --}}
    
    </div>
    <div class="container">
        <div class="row">
            
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class='table table-striped display table_id_3'>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Discount</th>
                            <th>Join Promo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($dtvouchermember as $dtvm)
                          @foreach ($dtvoucher as $data)
                            <?php
                              if($dtvm->Id_voucher == $data->Id_voucher)
                              {
                                ?>
                                    <tr>
                                      <td>{{$data->Voucher_name}}</td>
        
                                      <?php
                                        if($data->Voucher_type == "Disc Selected Product")
                                        {
                                          ?>
                                            <td>{{$data->Voucher_type}}  <button class="btn btn-warning" data-toggle="modal" data-target="#info_product" data-vcr="{{$data->Id_voucher}}"> info </button></td>
                                          <?php
                                        }
                                        else {
                                          ?>
                                            <td>{{$data->Voucher_type}} </td>
                                          <?php
                                        }
                                      ?>
                                    
                                      <td>{{"Rp. ".number_format($data->Discount)}}
                                      </td>
                                      {{-- <td>{{$data->Point}}</td>
                                      <td>{{ date("d-m-Y", strtotime($data->Redeem_due_date)) }}</td> --}}
                                      <td>
                                          <?php
                                            if($data->Joinpromo==1)
                                            {
                                                ?>
                                                Yes
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                No
                                                <?php
                                            }
                                          ?>
                                      
                                    
                                        </td>

                                        <td>
                                            <button class="btn btn-success" onclick="use_voucher({{$data->Id_voucher}})"> Use </button>
                                        </td>
                                    </tr>
                                <?php
                              }
                            ?>
                          @endforeach
                        @endforeach
                    </tbody>
                    
                
                </table>
            </div>
        </div>

        <br><br>

    
    </div>
        <div class="modal-footer">
            {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
        </div>
    
    </div>
</div>
</div>



<div class="modal fade" id="info_product">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><b>LIST PRODUCT FOR VOUCHER - </b> <b id="isi_voucher_name"></b></h4>
          {{-- <h4 class="modal-title">Info Product</h4> --}}
        
        </div>
        <div class="container">
            <div class="row">
              <div class="col-md-12" id="isi_info_product">
               
                <table class='table table-striped display table_id_3'>
                  <thead>
                    <tr>
                      <th>Product Image</th>
                      <th>Name</th>
                      <th>Brand</th>
                      <th>Type</th>
                      <th>Variation</th>
                    </tr>
                </thead>
              
                <tbody>
                  
                </tbody>
                  
              
                </table>
              </div>
            </div>
  
       
        </div>
            <div class="modal-footer">
              {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
            </div>
       
      </div>
    </div>
  </div>
  
@endsection


@push('custom-js')

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script src ="{{ asset ('js/jquery.js') }}"></script>
<script src ="{{ asset ('js/bootstrap.js') }}"></script>
<!-- CDN DATA TABLE -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

<script>
    $(document).ready(function(){

      $('.login-info-box').fadeOut();
      $('.login-show').addClass('show-log-panel');


  });
  
  String.prototype.number_format = function(d) {
    var n = this;
    var c = isNaN(d = Math.abs(d)) ? 2 : d;
    var s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + ',' : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + ',');
}




</script>

<script src ="{{ asset ('js/register-login/register-login.js') }}"></script>

<script>
    update_grand_total();
    $('.table_id_3').DataTable();
    var myurl = "<?php echo URL::to('/'); ?>";


    $('#info_product').on('show.bs.modal', function(event){
    // alert('aaa');
    var button = $(event.relatedTarget);
    var id = button.data('vcr');
    var modal = $(this);
    //modal.find('.modal-body #id_category').val(id);


    var myurl = "<?php echo URL::to('/'); ?>";

      $.get(myurl + '/get_voucher_selected_product',
      {Id_voucher: id},
      function(result){
       
        var cut = result.split("#");

        $('#isi_info_product').html(cut[0]);
        $('.table_id_3').DataTable();
        $('#isi_voucher_name').html(cut[1]);
        

        
      });

  });


  function load_city()
  {

    $('#courier_packet_text_hidden').val('');
    $('#courier_packet').html('');
    $('#cb_courier').val('');


    var Id_province = $("#cb_province").val();
    
    $.get(myurl + '/get_city',
    {Id_province: Id_province},
    function(result){
      var arr = (result);
     var kal ="";
     for(var i =0;i< arr.length;i++)
     {
      // alert(arr[i]['Option_name']);
       kal = kal + "<option value='"+arr[i]['Id_city']+"'>" +arr[i]['Type']+ " "+arr[i]['City_name'] + "</option>";
     }
     $("#cb_city").html(kal);

    });


  
  }


    function updateqtycart(id_var,id_cart)
    {
        // alert($("#qtywish"+id).val());
        // alert($("#harga"+id).val());
        // alert($("#qtywish"+id).val() * $("#harga"+id).val());
         $("#subtotal"+id_var).html('Rp. '+ ($("#qtycart"+id_var).val() * $("#harga"+id_var).val()).toString().number_format());
        // alert($("#qtywish"+id).val());
        

        $.get(myurl + '/updateqtycart',
        {Id_cart: id_cart,Qty:$("#qtycart"+id_var).val()},
        function(result){

        });
    }

    function deletecart(id_cart)
    {
        alert(id_cart);
        $.get(myurl + '/deletecart',
        {Id_cart: id_cart},
        function(result){
            location.reload();
        });

        $.get(myurl + '/update_cart',
        {},
        function(result){
            $('#badgecart').html(result);
            toastr["success"]("Success delete cart", "Success");
        });
    }


    function select_address(Id_address)
    {
        // alert(Id_address);
        $('#courier_packet_text_hidden').val('');
        $('#courier_packet').html('');
        $('#cb_courier').val('');
        $('#ongkir').html("");
        $('#ongkir_hidden').val("");
        
        $.get(myurl + '/Get_address',
        {Id_address:Id_address},
        function(result){
            var cut = result.split("#");

            var Address = cut[0];
            var City = cut[1];
            var Province = cut[2];

            var jadi = Address + "<br>" + City +" - "+Province;

            // alert(jadi);
            $('#shipto').html(jadi)
            // $('#Choose_address').modal('toggle'); 
        });
        // $('#Choose_address').modal('toggle'); 


        update_grand_total();
    }

    function change_courier(login_type)
    {
        //JNE 0
        //POS 1
        //TIKI 2

        $('#courier_packet_text_hidden').val('');
        $('#ongkir').html("");
        $('#ongkir_hidden').val("");

        if(login_type==0) //guess
        {
            var courier = $('#cb_courier').val();
            var weight = $('#totalweight').html();
            var Id_city = $('#cb_city').val();
            var str_courier="";
            if(courier==0)
            {
                str_courier ="jne";
            }
            else if(courier==1)
            {
                str_courier="pos";
            }
            else if(courier==2)
            {
                str_courier ="tiki";
            }

            $.get(myurl + '/Get_cost_shipping',
            {courier:str_courier,weight:weight,Id_city:Id_city},
            function(result){
                // alert(result);
                 $('#courier_packet').html(result);
            });
        }
        else //login
        {
            var courier = $('#cb_courier').val();
            var weight = $('#totalweight').html();
            var str_courier="";
            if(courier==0)
            {
                str_courier ="jne";
            }
            else if(courier==1)
            {
                str_courier="pos";
            }
            else if(courier==2)
            {
                str_courier ="tiki";
            }

            $.get(myurl + '/Get_cost_shipping',
            {courier:str_courier,weight:weight,Id_city:0},
            function(result){
                $('#courier_packet').html(result);
            });
        }
       

        update_grand_total();
    } 

    function use_voucher(Id_voucher)
    {
        // alert(Id_voucher);

        $.get(myurl + '/Use_voucher',
        {Id_voucher:Id_voucher},
        function(result){
            if(result=="no join promo")
            {
                toastr["error"]("Voucher cannot join with promo product", "Error");
            }
            else if (result=="no product selected")
            {
                toastr["error"]("No product support for this voucher", "Error");
            }
            else
            {
                toastr["success"]("Success to use voucher", "Success");

                var cut = result.split('#');

                $('#Id_voucher_hidden').val(cut[0]);


                if(cut[2]!=3)
                {
                    $('#voucher_show').html(cut[1] + " - Discount Product(s)");
                }
                else
                {
                    $('#voucher_show').html(cut[1] + " - Discount Shipping Cost");
                }

                $('#Type_voucher_hidden').val(cut[2]);
                $('#voucher_hidden').val(cut[3]);
                $('#voucher_hidden_asli').val(cut[3]);


                $('#discount_voucher').html("Rp."+cut[3].toString().number_format());
                update_grand_total();
            }
        });

        // update_grand_total();
    }

    function pilih_paket_kurir(kode)
    {
        $('#courier_packet_text_hidden').val(kode);
        $('#courier_hidden').val($('#cb_courier').val());
        alert(kode);

        var cut = kode.split("-");

        $('#ongkir').html("Rp."+ (cut[1].toString().number_format()));
        $('#ongkir_hidden').val(cut[1]);

        update_grand_total();
    }

    function choose_city() //guess
    {
        $('#courier_packet_text_hidden').val('');
        $('#courier_packet').html('');
        $('#cb_courier').val('');

        $('#ongkir').html("");
        $('#ongkir_hidden').val("");

        update_grand_total();
    }

    function update_grand_total()
    {

        if($('#guess').val()=="yes") //GUESS(no login)
        {
            // alert('1');
            var grand_total =  $('#total_awal_hidden').val()*1 + $('#ongkir_hidden').val()*1;
        }
        else
        {
            if($('#Type_voucher_hidden').val()*1 == 3)
            {
                
                if($('#ongkir_hidden').val()*1 == 0)
                {
                    // alert('2');
                    //kembalikan voucher asli normal
                    var voucher_asli = $('#voucher_hidden_asli').val();
                    $('#voucher_hidden').val(voucher_asli);
                    $('#discount_voucher').html("Rp."+voucher_asli.toString().number_format());
                }
                else
                {
                   
                    if(($('#ongkir_hidden').val()*1 < $('#voucher_hidden_asli ').val()*1))
                    {
                        // alert('3');
                        var ong = $('#ongkir_hidden').val()*1;
                        $('#voucher_hidden').val(ong);
                        $('#discount_voucher').html("Rp."+ong.toString().number_format());
                    }
                    else
                    {
                        // alert('4');
                        //kembalikan voucher asli normal
                        var voucher_asli = $('#voucher_hidden_asli').val();
                        $('#voucher_hidden').val(voucher_asli);
                        $('#discount_voucher').html("Rp."+voucher_asli.toString().number_format());
                    }
                }
            
            }
            else
            {
                // alert('5');
                //kembalikan voucher asli normal
                var voucher_asli = $('#voucher_hidden_asli').val();
               
                $('#voucher_hidden').val(voucher_asli);
                $('#discount_voucher').html("Rp."+voucher_asli.toString().number_format());
            }

            var grand_total =  $('#total_awal_hidden').val()*1 + $('#ongkir_hidden').val()*1 - $('#voucher_hidden').val()*1;
        }
        


        

        if(grand_total<0)
        {
            $('#grand_total').html('Rp.0');
            $('#grand_total_hidden').val(0);
        }
        else
        {
            $('#grand_total').html('Rp.'+(grand_total.toString().number_format()));
            $('#grand_total_hidden').val(grand_total);
        }
        
    }

    function clear_voucher()
    {
        $('#voucher_hidden_asli').val("0");
        $('#voucher_hidden').val("0");
        $('#discount_voucher').html("");
        $('#voucher_show').html("");

         update_grand_total();
    }

    
    function pay()
    {
        var Address= "";
        var Id_city= 0;
        var Id_province = 0;
        var Phone = 0;
        var Email = "";
        var Name = "";
        var Courier = $('#courier_hidden').val();

        var Courier_packet = $('#courier_packet_text_hidden').val();
        var cut = Courier_packet.split('-');
        var Courier_packet = cut[0];


        var Id_voucher= $('#Id_voucher_hidden').val();
        var Weight =$('#weight_hidden').val();
        var Gross_total = $('#total_awal_hidden').val();
        var Shipping_cost = $('#ongkir_hidden').val();
        var Discount = $('#voucher_hidden').val();

        if(Discount=="" || Discount==null)
        {
            Discount=0;
        }

        if(Id_voucher=="" || Id_voucher==null)
        {
            Id_voucher=0;
        }
        var Grand_total =  $('#grand_total_hidden').val();

        if($('#guess').val()=="yes")
        {
            var Address= $('#txt_address').val();
            var Id_city= $('#cb_city').val();
            var Id_province = $('#cb_province').val();
            var Phone = $('#txt_phone').val();
            var Email = $('#txt_email').val();
            var Name = $('#txt_name').val();    
        }


        $.get(myurl + '/Pay_cust',
        {Address:Address,Id_city:Id_city,Id_province:Id_province,Phone:Phone,Email:Email,Name:Name,Courier:Courier,
            Courier_packet:Courier_packet,Id_voucher:Id_voucher,Weight:Weight,Gross_total:Gross_total,Shipping_cost:Shipping_cost
            ,Discount:Discount,Grand_total:Grand_total},
        function(result){

            if($('#guess').val()=="yes")
            {
                var no = result;


                var snaptoken = $("#txtsnaptoken" + no).val(); 
                snap.pay(snaptoken, {
                    // Optional
                    onSuccess: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        console.log("masuk mode onSuccess"); 
                        console.log(result)
                    },
                    // Optional
                    onPending: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        console.log("masuk mode onPending"); 
                        console.log(result)
                    },
                    // Optional
                    onError: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        console.log("masuk mode onError"); 
                        console.log(result)
                    }
                }); 




                // //langsung jalankan midtrans
                // $.get(myurl + '/pay_now_guess',
                // {order_id:result},
                // function(result){
                //     alert('berhasil');
                // });

            }
            else
            {
                window.location = myurl + "/My_order/";
            }
            
        });

    }

    
    
</script>
 
@endpush








@extends('layout_frontend.Master')


@push('custom-css')

    {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="{{ asset ('css/register-login/register-login.css') }}" rel="stylesheet" type="text/css">  --}}

@endpush




@section('Content')
<!-- shopping-cart-area start -->
<div class="cart-main-area pt-95 pb-100 wishlist">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1 class="cart-heading">Cart</h1>
                <form action="#">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>remove</th>
                                    <th>images</th>
                                    <th>Product</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalcart =0;
                                @endphp
                                @foreach ($cart as $cr)
                                <?php 
                                    if($cr->Id_cart!=-1) //-1 itu cart yang di delete
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
                                                    }
                                                @endphp
                                            @endforeach
                                            <td class=""><button class="btn btn-danger btn-lg" onclick="deletecart('{{$cr->Id_cart}}')"><i class="pe-7s-close"></i></button></td>
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
                                            <td>Stock : {{$stock}}</td>


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
                                                <input value="{{$cr->Qty}}" type="number" id="qtycart{{$Id_variation}}" onchange="updateqtycart('{{$Id_variation}}','{{$cr->Id_cart}}')">
                                            </td>
                                            <td class="product-subtotal" id="subtotal{{$Id_variation}}">
                                                <?php
                                                    if($sale==0)
                                                    {
                                                        ?>
                                                            Rp. {{number_format($cr->Qty * $harga)}}
                                                        <?php 
                                                        $totalcart+= $cr->Qty * $harga;
                                                    }
                                                    else {
                                                        ?>
                                                            Rp. {{number_format($cr->Qty * $hargabaru)}}
                                                        <?php 
                                                        $totalcart+= $cr->Qty * $hargabaru;
                                                    }
                                                ?>
                                                

                                            </td>
                                            {{-- <td class=""><button class="btn btn-primary" onclick="">Add to cart</button></td> --}}
                                            </tr>
                                 <?php
                                    }
                                ?>
                                    
                                @endforeach
                                
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> <b style="font-size: 200%">TOTAL :</b> </td>
                                    <td> 
                                      <b style="font-size: 200%">  Rp. {{number_format($totalcart)}}
                                       
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                    </div>
                    
                </form>
            
            </div>
            <div class="button-box" style="text-align:right">
                <button type="button" name="update_profile" class="default-btn" onclick="to_checkout()">Checkout{{--<a href="{!!url('Cust_checkout')!!}">Checkout</a>--}}</button>
            </div>
        </div>
    </div>
</div>

@endsection


@push('custom-js')

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
    var myurl = "<?php echo URL::to('/'); ?>";
    function updateqtycart(id_var,id_cart)
    {
        $("#subtotal"+id_var).html('Rp. '+ ($("#qtycart"+id_var).val() * $("#harga"+id_var).val()).toString().number_format());
        $.get(myurl + '/updateqtycart',
        {Id_cart: id_cart,Qty:$("#qtycart"+id_var).val()},
        function(result){
        });
    }

    function to_checkout()
    {
        $.get(myurl + '/to_checkout',
        {},
        function(result){
            if(result!="")
            {
                toastr["error"](result, "Error");
            }
            else
            {
                window.location = myurl + "/Cust_checkout/";
            }
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
</script>

@endpush








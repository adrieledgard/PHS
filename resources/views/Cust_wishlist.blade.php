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
                <h1 class="cart-heading">wishlist</h1>
                    <div class="table-content table-responsive">
                        <table>
                            {{-- <thead>
                                <tr>
                                    <th>remove</th>
                                    <th>images</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead> --}}
                            <tbody>
                                
                                @foreach ($wishlist as $wish)
                                    @php
                                        $Id_variation="";
                                        $harga="";
                                        $option_name="";
                                        $stock ="";
                                    @endphp
                                <tr>
                                    @foreach ($variation as $var)
                                        @php
                                            if($wish->Id_variation == $var->Id_variation) 
                                            {
                                                $Id_variation = $wish->Id_variation;
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
                                    <td class=""><button class="btn btn-danger btn-lg" onclick="deletewishlist('{{$wish->Id_wishlist}}')"><i class="pe-7s-close"></i></button></td>
                                    <td class="product-thumbnail">
                                        @foreach ($productimage as $img)
                                            <?php
                                                if($img->Id_product == $wish->Id_product)
                                                {
                                                    ?>
                                                   
                                                        <a href="#"><img src="{{asset('Uploads/Product/'.$img->Image_name)}}" width='150px' height='150px' alt=""></a>
                                                    <?php
                                                }

                                            ?>
                                        @endforeach
                                       
                                    </td>
                                    @php
                                        $name="";
                                        $Id_product="";
                                    @endphp
                                    @foreach ($product as $pro)
                                        @php
                                            if($pro->Id_product == $wish->Id_product)
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
                                                        if($wish->Qty >= $promodetail->Minimum_qty)
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
                                        <input value="{{$wish->Qty}}" type="number" id="qtywish{{$Id_variation}}" onchange="updateqtywishlist('{{$Id_variation}}','{{$wish->Id_wishlist}}')">
                                    </td>
                                    <td class="product-subtotal" id="subtotal{{$Id_variation}}">
                                        <?php
                                            if($sale==0)
                                            {
                                                ?>
                                                    Rp. {{number_format($wish->Qty * $harga)}}
                                                <?php 
                                            }
                                            else {
                                                ?>
                                                    Rp. {{number_format($wish->Qty * $hargabaru)}}
                                                <?php 
                                            }
                                        ?>
                                        
                                    
                                    </td>
                                    <td class=""><button class="btn btn-primary" onclick="atc('{{$wish->Id_wishlist}}')">Add to cart</button></td>
                                </tr>
                                @endforeach
                                
                               
                            </tbody>
                        </table>
                    </div>
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
    function updateqtywishlist(id_var,id_wish)
    {
        // alert($("#qtywish"+id).val());
        // alert($("#harga"+id).val());
        // alert($("#qtywish"+id).val() * $("#harga"+id).val());
         $("#subtotal"+id_var).html('Rp. '+ ($("#qtywish"+id_var).val() * $("#harga"+id_var).val()).toString().number_format());
        // alert($("#qtywish"+id).val());
        

        $.get(myurl + '/updateqtywishlist',
        {Id_wishlist: id_wish,Qty:$("#qtywish"+id_var).val()},
        function(result){

        });
    }

    function deletewishlist(id_wish)
    {
        alert(id_wish);
        $.get(myurl + '/deletewishlist',
        {Id_wishlist: id_wish},
        function(result){
            location.reload();
        });
    }

    function atc(Id_wishlist)
    {
        $.get(myurl + '/atc_from_wishlist',
        {Id_wishlist: Id_wishlist},
        function(result){
            if(result=="sukses")
            {
                location.reload();
            }
            else if(result=="stok tidak cukup")
            {
                toastr["error"]("Stock no enough", "Error");
            }
            else if(result=="kembar")
            {
                toastr["error"]("Proucts & variation already in your cart", "Error");
            }
            // 
        });
    }
</script>

@endpush








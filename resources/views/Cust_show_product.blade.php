@extends('layout_frontend.Master')


@push('custom-css')

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="{{ asset ('css/register-login/register-login.css') }}" rel="stylesheet" type="text/css"> 


    <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}">

		<!-- all css here -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/pe-icon-7-stroke.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/icofont.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.min.css')}}">
        {{-- <link rel="stylesheet" href="{{ asset('assets/css/easyzoom.css')}}"> --}}
        <link rel="stylesheet" href="{{ asset('assets/css/bundle.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css')}}">
        <script src="{{ asset('assets/js/vendor/modernizr-3.11.7.min.js')}}"></script>


        
 

@endpush




@section('Content')

<div class="product-details ptb-100 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-7 col-12">
                <div class="product-details-img-content">
                    <div class="product-details-tab mr-70">
                        <div class="product-details-large tab-content">
                            @php
                                $ctr=1;
                                $ada=0;
                            @endphp

                            @foreach ($dtproductimage as $img)
                                @php
                                    $ada=1;
                                    if($ctr==1)
                                    {
                                        $act = "active";
                                    }
                                    else {
                                        
                                        $act="";
                                    }
                                @endphp

                                <div class="tab-pane {{$act}} show fade" id="pro-details{{$ctr}}" role="tabpanel">
                                    {{-- <div class="easyzoom easyzoom--overlay"> --}}
                                        <a href="{{asset('Uploads/Product/'.$img->Image_name)}}">
                                            <img src="{{asset('Uploads/Product/'.$img->Image_name)}}" alt="" width="600px" height="656px">
                                            {{-- <img src="{{ asset('assets/img/product-details/l1.jpg')}}" alt=""> --}}
                                        </a>
                                    {{-- </div> --}}
                                </div>

                                {{-- <a class="{{$act}} mr-12" href="#pro-details{{$ctr}}" data-bs-toggle="tab" role="tab" aria-selected="true">
                                    <img src="{{asset('Uploads/Product/'.$img->Image_name)}}" width='141px' height='135px' alt="">
                                </a> --}}

                                @php
                                    $ctr++;
                                @endphp
                            @endforeach

                            <?php

                                if($ada==0)
                                {
                                    ?>

                                        <div class="tab-pane active show fade"  role="tabpanel">
                                            {{-- <div class="easyzoom easyzoom--overlay"> --}}
                                                <a href="{{asset('Uploads/Product/default.jpg')}}">
                                                    <img src="{{asset('Uploads/Product/default.jpg')}}" alt="" width="600px" height="656px">
                                                    {{-- <img src="{{ asset('assets/img/product-details/l1.jpg')}}" alt=""> --}}
                                                </a>
                                            {{-- </div> --}}
                                        </div>

                                    <?php
                                }
                            ?>
                        </div>
                        <div class="product-details-small nav mt-12" role="tablist">
                            @php
                                $ctr=1;
                            @endphp
                            @foreach ($dtproductimage as $img)

                                @php
                                    if($ctr==1)
                                    {
                                        $act = "active";
                                    }
                                    else {
                                        
                                        $act="";
                                    }
                                @endphp

                                <a class="{{$act}} mr-12" href="#pro-details{{$ctr}}" data-bs-toggle="tab" role="tab" aria-selected="true">
                                    <img src="{{asset('Uploads/Product/'.$img->Image_name)}}" width='150px' height='100px' alt="">
                                </a>

                                @php
                                    $ctr++;
                                @endphp
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-5 col-12">
                <div class="product-details-content">
                    <h3>{{$dtproduct[0]->Name}}</h3>
                    <div class="rating-number">
                        <div class="quick-view-rating">
                            @php
                                for($i = 1; $i <= 5; $i++){
                                    if($i <= ceil($dtproduct[0]->Rating)){
                                        echo '<i class="fas fa-star"></i>';
                                    }else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                            @endphp
                        </div>
                        <div class="quick-view-number">
                            <span>{{$dtproduct[0]->Rating}} Rating (S)</span>
                        </div>
                    </div>
                    <div class="details-price">
                        <?php
                        foreach ($dtvariation as $vari) {
                           $sale=0;
                            $model ="";
                            $discount=0;
                            foreach ($dtpromoheader as $promoheader) {
                                if($promoheader->Id_variation == $vari->Id_variation)
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
                                    $hargabaru = $vari->Sell_price - ($vari->Sell_price * ($discount/100));
                                
                                    ?>
                                    <span id="harga">
                                        <span style="color: slategrey;font-size:65%"><s>Rp. {{number_format($vari->Sell_price)}}</s><b style='font-size:100%;color:red'>(Discount {{number_format($discount)}} %)</b></span>
                                        <br>
                                        <span style="font-size:120%">Rp. {{number_format($hargabaru)}}</span>
                                    </span>
                                    <?php
                                }
                                else if($model=="RP")
                                {
                                    $hargabaru = $vari->Sell_price - $discount;

                                    ?>
                                    <span id="harga">
                                        <span style="color: slategrey;font-size:65%"><s>Rp. {{number_format($vari->Sell_price)}}</s><b style='font-size:100%;color:red'>(Discount Rp. {{number_format($discount)}})</b></span>
                                        <br>
                                        <span style="font-size:120%">Rp. {{number_format($hargabaru)}}</span>
                                    </span>
                                    <?php
                                }

                               
                            }
                            else {
                                ?>

                                <span id="harga">
                                    <span style="font-size:120%">Rp. {{number_format($vari->Sell_price)}}</span>
                                </span>
                               
                               
                               <?php
                            }

                           
                            break;
                        }
                        ?>
                       
                    </div>

                    <p>
                        <div class="row">
                            <div class="col-md-4">
                                <b>Type: </b>  {{$dtproduct[0]->Type_name}}
                            </div>
                            <div class="col-md-4">
                                <b>Brand: </b>  {{$dtproduct[0]->Brand_name}}
                            </div>
                            <div class="col-md-4">
                                <b>Packaging: </b>  {{$dtproduct[0]->Packaging}}
                            </div>
                        </div>
                       <br>
                        <div class="row">
                            <div class="col-md-12">
                                <b id="stock">Stock : {{$dtvariation[0]['Stock']*1 - $dtvariation[0]['Stock_atc']*1 - $dtvariation[0]['Stock_pay']*1}}</b> 
                            </div>
                        </div>
                        
                    </p>
                  
                    <p>
                        {{$dtproduct[0]->Description}}
                    </p>

                    <?php
                        if($dtproduct[0]->Variation == "NONE")
                        {
                            foreach ($dtvariation as $vari) {
                                        //adrielga
                                ?>
                                <input type="hidden" id="var-none" value="{{$vari->Id_variation}}">
                                <?php
                            }
                        }
                        else {
                            ?>
                            <div class="quick-view-select">
                                <div class="select-option-part">
                                    <label>{{$dtproduct[0]->Variation}}</label>
                                    <select id="varian" class="select" onchange="gantivarian()">
                                        <?php
                                            foreach ($dtvariation as $vari) {
                                                ?>
                                                <option value="{{$vari->Id_variation}}">{{$vari->Option_name}}</option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <?php
                        }
                    ?>
                    
                    <div class="quickview-plus-minus">
                        <div class="cart-plus-minus">
                            <input type="text" value="1" name="qtybutton" class="cart-plus-minus-box" id="qty" onchange="changeqty(3)">
                        </div>
                        <div class="quickview-btn-cart" style="color:white">
                            <a class="btn-hover btn-primary" onclick="add_cart()">add to cart</a>
                        </div>
                       
                        <div class="quickview-btn-wishlist" style="color: white">
                            <a class="btn-hover btn-danger" onclick="add_wishlist()" ><i class="pe-7s-like"></i></a>
                        </div>
                    </div>


                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            
                            <i class="fa fa-info" aria-hidden="true"><a data-toggle="modal" data-target="#info_discount"> Click for discount info</a></i>
                            {{-- {{ Form::button('<i class="fa fa-info" aria-hidden="true"></i> Info Discount', ['class'=>'btn btn-secondary','data-toggle'=>'modal','data-target'=>'#info_discount']) }} --}}
                         
                        </div>
                        
                    </div>



                    <div class="product-details-cati-tag mt-35">
                        <ul>
                            <li class="categories-title">Categories :</li>

                            @foreach ($subcat as $sub)
                             <li>{{$sub->Sub_category_name}}</li>
                            @endforeach
                           
                            {{-- <li><a href="#">electronics</a></li>
                            <li><a href="#">toys</a></li>
                            <li><a href="#">food</a></li>
                            <li><a href="#">jewellery</a></li> --}}
                        </ul>
                    </div>
                    <br>
                    {{-- <div class="product-details-cati-tag mtb-10">
                        <ul>
                            <li class="categories-title">Tags :</li>
                            <li><a href="#">fashion</a></li>
                            <li><a href="#">electronics</a></li>
                            <li><a href="#">toys</a></li>
                            <li><a href="#">food</a></li>
                            <li><a href="#">jewellery</a></li>
                        </ul>
                    </div> --}}
                    {{-- <div class="product-share">
                        <ul>
                            <li class="categories-title">Share :</li>
                            <li>
                                <a href="#">
                                    <i class="icofont icofont-social-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icofont icofont-social-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icofont icofont-social-pinterest"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icofont icofont-social-flikr"></i>
                                </a>
                            </li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product-description-review-area pb-90">
    <div class="container">
        <div class="product-description-review text-center">
            <div class="description-review-title nav" role="tablist">
                <a class="active" href="#pro-dec" data-bs-toggle="tab" role="tab" aria-selected="true">
                    Info Product
                </a>
                <a href="#pro-review" data-bs-toggle="tab" role="tab" aria-selected="false">
                    Reviews ({{count($dtproductreview)}})
                </a>
            </div>
            <div class="description-review-text tab-content">
                <div class="tab-pane active show fade" id="pro-dec" role="tabpanel">
                    <p style="text-align: left">
                        <br>
                        <b style="font-size: 140%">Composition</b> <br>
                        {{$dtproduct[0]->Composition}} <br><br>

                        <b style="font-size: 140%">Efficacy</b> <br>
                        {{$dtproduct[0]->Efficacy}}<br><br>

                        <b style="font-size: 140%">Dose</b> <br>
                        {{$dtproduct[0]->Dose}}<br><br>

                        <b style="font-size: 140%">Disclaimer</b> <br>
                        {{$dtproduct[0]->Disclaimer}}<br><br>

                        <b style="font-size: 140%">Bpom</b> <br>
                        {{$dtproduct[0]->Bpom}}<br><br>

                    </p>
                </div>
                <div class="tab-pane fade" id="pro-review" role="tabpanel">
                    <p class="text-right"><button class="btn btn-sm" type="button" onclick="sort({{$dtproduct[0]->Id_product}})"><i class="fa fa-sort"></i> Sort by date</button></p>
                    <div class="overflow-auto" style="height: 300px;">
                        <p style="text-align: left" class="review_area">
                            @php
                                if(count($dtproductreview) > 0){
                                    foreach ($dtproductreview as $review) {
                                        echo "
                                        <b>$review->Username</b><br>
                                        $review->Review <br>
                                        <i>". date("d-m-Y H:i:s", strtotime($review->created_at)) ."</i>
                                        <br><br>
    
                                        ";
                                    }
                                }
                            @endphp
                        </p>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product-area pb-95">
    <div class="container">
        <div class="section-title-3 text-center mb-50">
            <h2>Related products</h2>
        </div>
        <div class="product-style">
            <div class="related-product-active owl-carousel">
               

                @foreach ($subcat as $sc)
                    <?php
                        $Id_subcat = $sc->Id_sub_category;

                        foreach ($subcat2 as $sc2) 
                        {
                            
                            if($sc2->Id_sub_category == $Id_subcat)
                            {
                                $Id_product = $sc2->Id_product;

                                foreach ($dtproductsubcat as $product) {
                                    # code...
                                    if($product->Id_product ==$Id_product && $product->Id_product != $dtproduct[0]->Id_product)
                                    {
                                        ?>
                                            <div class="product-wrapper">
                                                <div class="product-img">
                                                    @php
                                                        $sale=0;
                                                        $upto= "";
                                                        $maxrupiah=0;
                                                        $mahal=0;
                                                        $tes=0;
                                                        foreach ($dtpromoheader2 as $promoheader ) {
                                                            if($promoheader->Id_product == $product->Id_product)
                                                            {
                                                                $sale=1;
                                                                $model= $promoheader->Model;
                                                                $Id_variation = $promoheader->Id_variation;
                                                                $sellprice=0;

                                                                foreach ($dtvariasi2 as $vari) {
                                                                    if($vari->Id_variation==$Id_variation)
                                                                    {
                                                                        $sellprice=$vari->Sell_price;
                                                                    }
                                                                }

                                                                foreach ($dtpromodetail2 as $promodetail) {
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
                                                            @endphp
                                                            <span class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem;align-content: center; font-size:70%">
                                                                Sale
                                                            </span>
                                                            @php
                                                        }

                                                    @endphp
                                                    <!-- Product image-->
                                                    @php
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
                                                    @endphp

                                                    <a href="{!! url('Cust_show_product/'.$product->Id_product); !!}">
                                                        <img src="{{asset('Uploads/Product/'.$gambardata)}}" alt="">
                                                    </a>
                                                    <div class="product-action">
                                                        <a class="animate-left" title="Wishlist" onclick="add_wishlist()" href="#">
                                                            <i class="pe-7s-like"></i>
                                                        </a>
                                                        <a class="animate-top" title="Add To Cart" href="#">
                                                            <i class="pe-7s-cart"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="funiture-product-content text-center">
                                                    <h4><a href="{!! url('Cust_show_product/'.$product->Id_product); !!}">{{$product->Name}}</a></h4>

                                                    <!-- Product price-->
                                                    @php
                                                        $Id_product=$product->Id_product;
                                                        $fixharga="";
                                                        $murah=999999999999;
                                                        $mahal=0;
                                                        $ctr=0;
                                                        foreach ($dtvariasi2 as $datavariasi) {
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
                                                    @endphp


                                                <span> 
                                                    @php
                                                        echo $fixharga;
                                                    @endphp
                                                </span>
                                                <br>
                                            <?php
                                                if($sale==1)
                                                {
                                                    ?>
                                                    <span style="color: red">
                                                        Discount up to 
                                                        @php
                                                            echo $upto;
                                                        @endphp
                                                    </span>
                                                    <?php

                                                }
                                                ?>
                                                
                                                </div>
                                            </div>
                                        <?php
                                    }
                                }
                            }
                        }
                    ?>
                @endforeach



            </div>
        </div>
    </div>
</div>
<!-- product area end -->




<div class="modal fade" id="info_discount">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Discount</h4>
          <button style="color:black" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    {{ Form::label('Variant :','') }}
                    {{-- {{ Form::select('cb_variant', [], 'Kosong', ['class'=>'select', 'id'=>'cb_variant' ]) }} --}}
    
    
                    <select id="modal_variant" class="select" onchange="modal_gantivariant()">
                        <option value="-1"></option>
                        <?php
                            foreach ($dtvariation as $vari) {
                                ?>
                                <option value="{{$vari->Id_variation}}">{{$vari->Option_name}}</option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <span id="isi-promo">

                    </span>
                </div>
            </div>
            
            <br><br><br><br><br><br>
            
        </div>
            {{-- <div class="modal-footer">
              {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
            </div> --}}
       
      </div>
    </div>
</div>



@endsection


@push('custom-js')

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js')}}"></script>
<script src="{{ asset('assets/js/popper.js')}}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{ asset('assets/js/isotope.pkgd.min.js')}}"></script>
<script src="{{ asset('assets/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.counterup.min.js')}}"></script>
<script src="{{ asset('assets/js/waypoints.min.js')}}"></script>
<script src="{{ asset('assets/js/ajax-mail.js')}}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js')}}"></script>
<script src="{{ asset('assets/js/plugins.js')}}"></script>
<script src="{{ asset('assets/js/main.js')}}"></script> 
<script src="{{asset('assets\plugins\moment\moment.min.js')}}"></script>



<!-- jQuery -->
<link href="{{ asset ('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<script src ="{{ asset ('js/jquery.js') }}"></script>
<script src ="{{ asset ('js/bootstrap.js') }}"></script>




<script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
<script src="{{ asset('assets/js/ajax-mail.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>


<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function(){

      $('.login-info-box').fadeOut();
      $('.login-show').addClass('show-log-panel');

      var duplicate_dec_elements = document.querySelectorAll("div.dec");
      var duplicate_inc_elements = document.querySelectorAll("div.inc");
      var count_duplicate = duplicate_dec_elements.length;
      for(var i = 0; i < count_duplicate; i++){
          if(i+1 != count_duplicate){
              duplicate_dec_elements[i].remove();
              duplicate_inc_elements[i].remove();
          }
      }
    //   while()
        
  });
  var sort_format = "desc";
  var myurl = "<?php echo URL::to('/'); ?>";
  function gantivarian()
  {
    var Id_variation = $("#varian").val();

    $.get(myurl + '/getpricevariant',
    {Id_variation: Id_variation},
    function(result){
        // alert(result);
        var cut = result.split("#");
        
        $("#harga").html(cut[0]);
        $("#stock").html("Stock : "+cut[1]);
        
        $('#qty').val(1);
    
    });
  }

  function sort(Id_product){
    $.get(myurl + '/sort_review',
    {Id_product: Id_product, format : sort_format},
    function(result){
        console.log(result);
        sort_format = sort_format == 'desc' ? 'asc' : 'desc';
        var review_area = document.getElementsByClassName("review_area")[0];
        var review = "";
        result.forEach(res => {
            review += "<b>"+ res.Username +"</b> <br> "+ res.Review +" <br> <i>"+ moment(res.created_at).format("DD-MM-YYYY HH:mm:ss") +"</i><br><br>";
        });

        review_area.innerHTML = review;
    });
  }

  function modal_gantivariant()
  {
    var Id_variation = $("#modal_variant").val();

    $.get(myurl + '/getpromovariant',
    {Id_variation: Id_variation},
    function(result){
        //  alert(result);
        $("#isi-promo").html(result);
        
    
    });
  }

  function changeqty(kode)
  {
      var jumqty=0;
      if(kode==3)
      {
        var qty = $('#qty');
        if(Number(qty.val()) <=1)
        {
            jumqty=1;
            // alert(1);
        }
        else
        {
            jumqty=qty.val();
            // alert(qty.val());
        }
        
       
      }
      else
      {
          if(kode==1)
          {
            var qty = $('#qty');

            if(Number(qty.val()) <1)
            {
                jumqty=1;
                // alert(1);
            }
            else
            {
                jumqty=Number(qty.val()) + 1;
                // alert(Number(qty.val()) + 1);
            }
           
          }
          else if(kode==0)
          {
            var qty = $('#qty');

            if(Number(qty.val()) <1)
            {
                jumqty=1;
                // alert(1);
            }
            else
            {
                jumqty=Number(qty.val()) - 1;
                // alert(Number(qty.val()) - 1);
            }
            
          }
      
      }
     
    var Id_variation = $("#varian").val();
    $.get(myurl + '/getpricechangeqty',
    {Id_variation: Id_variation, Jumqty:jumqty},
    function(result){
        
        $("#harga").html(result);
    
    });

  }

  function add_wishlist()
  {
      var Id_variation = $('#varian').val();
      var Qty = $('#qty').val();

      if(Id_variation==null || Id_variation=="")
      {
        Id_variation = $('#var-none').val();
      }

    $.get(myurl + '/add_wishlist',
    {Id_variation: Id_variation, Qty:Qty},
    function(result){
        if(result=="double")
        {
            toastr["error"]("The item already in wishlist", "Error");
        }
        else if(result =="mustlogin")
        {
            toastr["error"]("You must log in to use wishlist", "Error");
        }
        else
        {
            $.get(myurl + '/update_wishlist',
            {},
            function(result){
                $('#badgewishlist').html(result);
                toastr["success"]("Success add wishlist", "Success");
            });
        }
       
    });

  }


  function add_cart()
  {
      var Id_variation = $('#varian').val();
      var Qty = $('#qty').val();

      if(Id_variation==null || Id_variation=="")
      {
        Id_variation = $('#var-none').val();
      }

    $.get(myurl + '/add_cart',
    {Id_variation: Id_variation, Qty:Qty},
    function(result){   
        if(result=="double")
        {
            toastr["error"]("The item already in cart", "Error");
        }
        else if(result=="stok habis")
        {
            toastr["error"]("Out of stock", "Error");
        }
        else
        {
            $.get(myurl + '/update_cart',
            {},
            function(result){
                $('#badgecart').html(result);
                toastr["success"]("Success add cart", "Success");
            });
        }
       
    });

  }
</script>



@endpush








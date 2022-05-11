@extends('layout_frontend.Master')


@push('custom-css')

     <!-- Favicon-->
     <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
     <!-- Bootstrap icons-->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
     <!-- Core theme CSS (includes Bootstrap)-->
     <link href="css/styles_home.css" rel="stylesheet" />
@endpush

@section('Content')
 <!-- header end -->
 <div class="slider-area">
    <div class="slider-active owl-carousel">

        @foreach ($banner as $data)
        {{-- <img src="{{asset('Uploads/Product/'.$gambardata)}}" alt=""> --}}
        <div class="single-slider-4 slider-height-6 bg-img" style="background-image: url(Uploads/Banner/{{$data->Banner_image}})">
            <div class="container">
                <div class="row">
                    <div class="ms-auto col-lg-6">
                        <div class="furniture-content fadeinup-animated">
                            <h2 class="animated">{{$data->Banner_header}}</h2>
                            <p class="animated">{{$data->Banner_content}}</p>
                            <a class="furniture-slider-btn btn-hover animated" href="{!! url('Cust_show_product/'.$data->Id_product); !!}">{{$data->Banner_cta}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
        
    </div>
</div>
<!-- product area start -->
<div class="popular-product-area wrapper-padding-3 pt-115 pb-115" >
    <div class="container-fluid">
        <div class="section-title-6 text-center mb-50">
            <h2>Popular Product</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p>
        </div>
        {{-- <script type='text/javascript' charset='utf-8'>                                                                     var iframe = document.createElement('iframe');                                                                       document.body.appendChild(iframe);                                                                iframe.src = 'https://localhost/PusatHerbalStore/public/embed_code/39/8dppa1aa94atv';                                                                       iframe.width = '100%';                                                                iframe.height = 600;                                                                </script>; --}}
        {{-- <script type='text/javascript' charset='utf-8'>                                                                     var iframe = document.createElement('iframe');                                                                       document.body.appendChild(iframe);                                                                iframe.src = 'https://localhost/PusatHerbalStore/public/embed_code/38/8dppa1aa94atv';                                                                       iframe.width = '100%';                                                                iframe.height = 600;                                                                </script>; --}}
        <script type='text/javascript' charset='utf-8'>                                                                     var iframe = document.createElement('iframe');                                                                       document.body.appendChild(iframe);                                                                iframe.src = 'https://localhost/PusatHerbalStore/public/embed_code/40/8dppa1aa94atv';                                                                       iframe.width = '100%';                                                                iframe.height = 600;                                                                </script>;
        <div class="product-style">
            <div class="popular-product-active owl-carousel" style="z-index: 100">

            

                @foreach ($dtproduct as $product)
                    <?php
                        if($product->status == 1)
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
                                    </div>
                                    <div class="funiture-product-content text-center">
                                        <h4><a href="{!! url('Cust_show_product/'.$product->Id_product); !!}">{{$product->Name}}</a></h4>
                                        {{-- <div class="rating-number" style="align-content: center;align-text:center"> --}}
                                            <div class="quick-view-rating">
                                                @php
                                                    for($i = 1; $i <= 5; $i++){
                                                        if($i <= ceil($product->Rating)){
                                                            echo '<i class="fas fa-star"></i>';
                                                        }else {
                                                            echo '<i class="far fa-star"></i>';
                                                        }
                                                    }
                                                @endphp
                                            </div>
                                            <div class="quick-view-number">
                                                <span>{{$product->Rating}} Rating (S)</span>
                                            </div>
                                        {{-- </div> --}}
                                        <!-- Product price-->
                                        @php
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
                    ?>
                    
                    
                    
                
                @endforeach

               


                
            </div>
        </div>
    </div>
</div>
<!-- product area end -->
<!-- discount area start -->
{{-- <div class="discount-area pt-70 pb-120">
    <div class="container">
        <div class="row">
            <div class="ms-auto col-lg-7">
                <div class="discount-img pl-70">
                    <img src="assets/img/banner/28.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-5">
                <div class="discount-details-wrapper">
                    <h5>Verified quality</h5>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    <h2>Summer Discount <br>Up to 30%</h2>
                    <p class="discount-peragraph">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                    <a class="discount-btn btn-hover" href="product-details.html">Buy Now</a>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- discount area end -->
<!-- premium area start -->
<div class="premium-banner-area" >
    <div class="container">
        <div class="discount-wrapper" style="z-index: 50">
{{-- //jennifer --}}
            @foreach ($banner_2 as $data)
            <img src="Uploads/Banner/{{$data->Banner_image}}" alt="">
            <div class="discount-content">
                <h2>{{$data->Banner_header}}</h2>
                <a href="{!! url('Cust_show_product/'.$data->Id_product); !!}">{{$data->Banner_cta}}</a>
            </div>
            @endforeach
            
        </div>
    </div>
</div>
<!-- premium area end -->

<!-- product area start -->
<div class="product-style-area pt-120">
    <div class="coustom-container-fluid">
        <div class="section-title-7 text-center">
            <h2>Products Category</h2>
            {{-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p> --}}
        </div>
        <!-- product area start -->
        <div class="popular-product-area wrapper-padding-3 pt-115 pb-115">
            <div class="container-fluid">
                <div class="product-style">
                    <div class="popular-product-active owl-carousel" style="padding-top: 48%;margin-top: -58%;">
                        
                        @foreach ($category as $cat)
                           
                            <div class="product-wrapper" >
                                <div class="menu-style-2 furniture-menu" style="padding-bottom: 350%;">
                                    <nav>
                                        <ul>
                                            <li>
                                                <a onclick="pilihcat('cat','{{$cat->Id_category}}')" style='z-index:150'>{{$cat->Category_name}}</a>
                                                <ul class="single-dropdown" >

                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                           
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- product area end -->

        <div class="tab-content" style="margin-top: -75%; z-index:10">
            <div class="tab-pane active show fade" id="furniture1" role="tabpanel">
                <div class="coustom-row-5" id="isi-product-category">
                    @php
                        $count=0;
                    @endphp
                    @foreach ($dtproduct as $product)
                        @php
                            $count=$count+1;
                        @endphp

                        <?php 
                            if($count<=12)
                            {
                                ?>
                                    <div class='custom-col-three-5 custom-col-style-5 mb-65'>
                                        <div class='product-wrapper' style='z-index:100'>
                                            <div class='product-img'>
                                                @php
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
            
                                            </div>
            
                                            <div class='funiture-product-content text-center'>
                                                <h4><a href="{!! url('Cust_show_product/'.$product->Id_product); !!}">{{$product->Name}}</a></h4>
                                                <div class="quick-view-rating">
                                                    @php
                                                        for($i = 1; $i <= 5; $i++){
                                                            if($i <= ceil($product->Rating)){
                                                                echo '<i class="fas fa-star"></i>';
                                                            }else {
                                                                echo '<i class="far fa-star"></i>';
                                                            }
                                                        }
                                                    @endphp
                                                </div>
                                                <div class="quick-view-number">
                                                    <span>{{$product->Rating}} Rating (S)</span>
                                                </div>
            
                                                <!-- Product price-->
                                                @php
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
                                    </div>
                                <?php
                            }
                        ?>
                        
                    @endforeach
                </div>
            </div>

            


            <div class="tab-pane fade" id="furniture2" role="tabpanel">
                <div class="coustom-row-5">
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/15.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Network Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/14.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Menga Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/13.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Seafront Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/12.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Trivia Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/11.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Trucker Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/10.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Daystar Sofa</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/9.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Ardenboro Sofa</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/8.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Bladen Sofa</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/7.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Darcy Sofa</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/6.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Power Reclining Sofa</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="furniture3" role="tabpanel">
                <div class="coustom-row-5">
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/10.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Trucker Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/9.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Trivia Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/8.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Seafront Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/6.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Network Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/15.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html"> Power Reclining Sofa</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/14.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Whitevil Reclining Sofa</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/13.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Ardenboro Sofa</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/12.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Jarreau Chaise Sleeper</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/11.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Darcy Sofa</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/10.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Daystar Sofa</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="furniture4" role="tabpanel">
                <div class="coustom-row-5">
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/10.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Trucker Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/9.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Trivia Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/6.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Seafront Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/9.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Menga Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/15.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Network Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/10.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Darcy Sofa</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/14.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Bladen Sofa</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/11.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Daystar Sofa</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/14.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">trucker Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/7.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Seafront Accent Chair</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="furniture5" role="tabpanel">
                <div class="coustom-row-5">
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/8.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Fashin Comfort 240b</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/6.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Fashin Comfort 240b</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/7.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Fashin Comfort 240b</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/10.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Fashin Comfort 240b</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/9.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Fashin Comfort 240b</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/12.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Fashin Comfort 240b</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/11.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Fashin Comfort 240b</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/14.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Fashin Comfort 240b</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/13.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Fashin Comfort 240b</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-col-three-5 custom-col-style-5 mb-65">
                        <div class="product-wrapper">
                            <div class="product-img">
                                <a href="#">
                                    <img src="assets/img/product/furniture/15.jpg" alt="">
                                </a>
                                <div class="product-action">
                                    <a class="animate-left" title="Wishlist" href="#">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                    <a class="animate-top" title="Add To Cart" href="#">
                                        <i class="pe-7s-cart"></i>
                                    </a>
                                    <a class="animate-right" title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">
                                        <i class="pe-7s-look"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="funiture-product-content text-center">
                                <h4><a href="product-details.html">Fashin Comfort 240b</a></h4>
                                <span>$90.00</span>
                                <div class="product-rating-5">
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star black"></i>
                                    <i class="pe-7s-star"></i>
                                    <i class="pe-7s-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        
        <div class="view-all-product text-center" style="z-index:9999999">
            <a onclick="view_more()">View More</a>
        </div>
    </div>
</div>
<!-- product area end -->


<?php

// echo "<div class='custom-col-three-5 custom-col-style-5 mb-65'>";
//     echo "<div class='product-wrapper' style='background-color: seagreen;  z-index :99;'>";
//         echo "<div class='product-img'>";
//             echo "<a href='#'>";
//                 echo "<img src='assets/img/product/furniture/6.jpg' alt=''>";
//                 echo "</a>";
//             echo"<div class='product-action'>";
//                 echo"<a class='animate-left' title='Wishlist' href='#'>";
//                     echo"<i class='pe-7s-like'></i>";
//                     echo"</a>";
//                 echo"<a class='animate-top' title='Add To Cart' href='#'>";
//                     echo"<i class='pe-7s-cart'></i>";
//                 echo"</a>";
//                 echo"<a class='animate-right' title='Quick View' data-bs-toggle='modal' data-bs-target='#exampleModal' href='#'>";
//                     echo"<i class='pe-7s-look'></i>";
//                 echo"</a>";
//             echo"</div>";
//         echo"</div>";
//         echo"<div class='funiture-product-content text-center'>";
//             echo"<h4><a href='product-details.html'>aaaaaa</a></h4>";
//             echo"<span>$90.00</span>";
//             echo"<div class='product-rating-5'>";
//                 echo"<i class='pe-7s-star black'></i>";
//                 echo"<i class='pe-7s-star black'></i>";
//                 echo"<i class='pe-7s-star'></i>";
//                 echo"<i class='pe-7s-star'></i>";
//                 echo"<i class='pe-7s-star'></i>";
//                 echo"</div>";
//                 echo"</div>";
//     echo"</div>";
// echo"</div>";


?>








<!-- testimonials area start -->
<div class="testimonials-area pt-120 pb-115">
    <div class="container">
        <div class="testimonials-active owl-carousel">
            <div class="single-testimonial-2 text-center">
                <img src="assets/img/team/1.png" alt="">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
                <img src="assets/img/team/2.png" alt="">
                <h4>tayeb rayed</h4>
                <span>uiux Designer</span>
            </div>
        </div>
    </div>
</div>
<!-- testimonials area end -->
<!-- services area start -->
<div class="services-area wrapper-padding-4 gray-bg pt-120 pb-80">
    <div class="container-fluid">
        <div class="services-wrapper">
            <div class="single-services mb-40">
                <div class="services-img">
                    <img src="assets/img/icon-img/26.png" alt="">
                </div>
                <div class="services-content">
                    <h4>Free Shippig</h4>
                    <p>Contrary to popular belief, Lorem Ipsum is random text. </p>
                </div>
            </div>
            <div class="single-services mb-40">
                <div class="services-img">
                    <img src="assets/img/icon-img/27.png" alt="">
                </div>
                <div class="services-content">
                    <h4>24/7 Support</h4>
                    <p>Contrary to popular belief, Lorem Ipsum is random text. </p>
                </div>
            </div>
            <div class="single-services mb-40">
                <div class="services-img">
                    <img src="assets/img/icon-img/28.png" alt="">
                </div>
                <div class="services-content">
                    <h4>Secure Payments</h4>
                    <p>Contrary to popular belief, Lorem Ipsum is random text. </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- services area end -->
<!-- footer area start -->
<footer class="footer-area">
    <div class="footer-top-area pt-70 pb-35 wrapper-padding-5">
        <div class="container-fluid">
            <div class="widget-wrapper">
                <div class="footer-widget mb-30">
                    <a href="#"><img src="assets/img/logo/2.png" alt=""></a>
                    <div class="footer-about-2">
                        <p>There are many variations of passages of Lorem Ipsum <br>the majority have suffered alteration in some form, by <br> injected humour</p>
                    </div>
                </div>
                <div class="footer-widget mb-30">
                    <h3 class="footer-widget-title-5">Contact Info</h3>
                    <div class="footer-info-wrapper-3">
                        <div class="footer-address-furniture">
                            <div class="footer-info-icon3">
                                <span>Address: </span>
                            </div>
                            <div class="footer-info-content3">
                                <p>66 Sipu road Rampura Banasree <br>USA- 10800</p>
                            </div>
                        </div>
                        <div class="footer-address-furniture">
                            <div class="footer-info-icon3">
                                <span>Phone: </span>
                            </div>
                            <div class="footer-info-content3">
                                <p>+8801 (33) 123456789 <br>+8801 (66) 123456789</p>
                            </div>
                        </div>
                        <div class="footer-address-furniture">
                            <div class="footer-info-icon3">
                                <span>E-mail: </span>
                            </div>
                            <div class="footer-info-content3">
                                <p><a href="#"> email@domain.com</a> <br><a href="#"> domain@mail.info</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-widget mb-30">
                    <h3 class="footer-widget-title-5">Newsletter</h3>
                    <div class="footer-newsletter-2">
                        <p>Send us your mail or next updates</p>
                        <div id="mc_embed_signup" class="subscribe-form-5">
                            <form action="https://devitems.us11.list-manage.com/subscribe/post?u=6bbb9b6f5827bd842d9640c82&amp;id=05d85f18ef" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                                <div id="mc_embed_signup_scroll" class="mc-form">
                                    <input type="email" value="" name="EMAIL" class="email" placeholder="Enter mail address" required>
                                    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                    <div class="mc-news" aria-hidden="true"><input type="text" name="b_6bbb9b6f5827bd842d9640c82_05d85f18ef" tabindex="-1" value=""></div>
                                    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom ptb-20 gray-bg-8">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="copyright-furniture">
                        <p>Copyright © <a href="hastech.company/">HasTech</a> 2021 . All Right Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span class="pe-7s-close" aria-hidden="true"></span>
    </button>
    <div class="modal-dialog modal-quickview-width" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="qwick-view-left">
                    <div class="quick-view-learg-img">
                        <div class="quick-view-tab-content tab-content">
                            <div class="tab-pane active show fade" id="modal1" role="tabpanel">
                                <img src="assets/img/quick-view/l1.jpg" alt="">
                            </div>
                            <div class="tab-pane fade" id="modal2" role="tabpanel">
                                <img src="assets/img/quick-view/l2.jpg" alt="">
                            </div>
                            <div class="tab-pane fade" id="modal3" role="tabpanel">
                                <img src="assets/img/quick-view/l3.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="quick-view-list nav" role="tablist">
                        <a class="active" href="#modal1" data-bs-toggle="tab" role="tab">
                            <img src="assets/img/quick-view/s1.jpg" alt="">
                        </a>
                        <a href="#modal2" data-bs-toggle="tab" role="tab">
                            <img src="assets/img/quick-view/s2.jpg" alt="">
                        </a>
                        <a href="#modal3" data-bs-toggle="tab" role="tab">
                            <img src="assets/img/quick-view/s3.jpg" alt="">
                        </a>
                    </div>
                </div>
                <div class="qwick-view-right">
                    <div class="qwick-view-content">
                        <h3>Handcrafted Supper Mug</h3>
                        <div class="price">
                            <span class="new">$90.00</span>
                            <span class="old">$120.00  </span>
                        </div>
                        <div class="rating-number">
                            <div class="quick-view-rating">
                                <i class="pe-7s-star"></i>
                                <i class="pe-7s-star"></i>
                                <i class="pe-7s-star"></i>
                                <i class="pe-7s-star"></i>
                                <i class="pe-7s-star"></i>
                            </div>
                            <div class="quick-view-number">
                                <span>2 Ratting (S)</span>
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adip elit, sed do tempor incididun ut labore et dolore magna aliqua. Ut enim ad mi , quis nostrud veniam exercitation .</p>
                        <div class="quick-view-select">
                            <div class="select-option-part">
                                <label>Size*</label>
                                <select class="select">
                                    <option value="">- Please Select -</option>
                                    <option value="">900</option>
                                    <option value="">700</option>
                                </select>
                            </div>
                            <div class="select-option-part">
                                <label>Color*</label>
                                <select class="select">
                                    <option value="">- Please Select -</option>
                                    <option value="">orange</option>
                                    <option value="">pink</option>
                                    <option value="">yellow</option>
                                </select>
                            </div>
                        </div>
                        <div class="quickview-plus-minus">
                            <div class="cart-plus-minus">
                                <input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
                            </div>
                            <div class="quickview-btn-cart">
                                <a class="btn-hover-black" href="#">add to cart</a>
                            </div>
                            <div class="quickview-btn-wishlist">
                                <a class="btn-hover" href="#"><i class="pe-7s-like"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal -->
<div class="modal fade" id="exampleCompare" tabindex="-1" role="dialog" aria-hidden="true">
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span class="pe-7s-close" aria-hidden="true"></span>
    </button>
    <div class="modal-dialog modal-compare-width" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="#">
                    <div class="table-content compare-style table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>
                                        <a href="#">Remove <span>x</span></a>
                                        <img src="assets/img/cart/4.jpg" alt="">
                                        <p>Blush Sequin Top </p>
                                        <span>$75.99</span>
                                        <a class="compare-btn" href="#">Add to cart</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="compare-title"><h4>Description </h4></td>
                                    <td class="compare-dec compare-common">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has beenin the stand ard dummy text ever since the 1500s, when an unknown printer took a galley</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Sku </h4></td>
                                    <td class="product-none compare-common">
                                        <p>-</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Availability  </h4></td>
                                    <td class="compare-stock compare-common">
                                        <p>In stock</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Weight   </h4></td>
                                    <td class="compare-none compare-common">
                                        <p>-</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Dimensions   </h4></td>
                                    <td class="compare-stock compare-common">
                                        <p>N/A</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>brand   </h4></td>
                                    <td class="compare-brand compare-common">
                                        <p>HasTech</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>color   </h4></td>
                                    <td class="compare-color compare-common">
                                        <p>Grey, Light Yellow, Green, Blue, Purple, Black </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>size    </h4></td>
                                    <td class="compare-size compare-common">
                                        <p>XS, S, M, L, XL, XXL </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"></td>
                                    <td class="compare-price compare-common">
                                        <p>$75.99 </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@push('custom-js')
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<script>
    var myurl = "<?php echo URL::to('/'); ?>";
    function pilihcat(type,id)
    {
          alert(type);
          alert(id);

        $.get(myurl + '/Cust_show_cat',
        {type:type,id:id},
        function(result){
        //  alert(result);
         alert(result);
        $("#isi-product-category").html(result);
        
        });
    }

    function view_more()
    {
        $.get(myurl + '/view_more_halaman_home',
        {},
        function(result){
            window.location.href = "{!!url('Advance_search')!!}";
        });
    }
</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/61923a4e6885f60a50bbd753/1fkho083g';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
@endpush

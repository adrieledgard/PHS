@extends('layout_frontend.Master')


@push('custom-css')


{{-- hapus --}}
{{-- <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script> --}}



<link rel="stylesheet" href="{{ asset ('assets/css/bootstrap-4.5.2.min.css') }}">
<link rel="stylesheet" href="{{ asset ('assets/css/bootstrap-example.min.css') }}">
<link rel="stylesheet" href="{{ asset ('assets/css/bootstrap-multiselect.css') }}">



<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css"> 





<link href="{{ asset ('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">



@endpush




@section('Content')
<div class="shop-page-wrapper shop-page-padding ptb-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="shop-sidebar mr-50">
                    <div class="sidebar-widget mb-50">
                        <h3 class="sidebar-title">Search Products</h3>
                        <div class="sidebar-search">
                            <form action="#">
                             
                                <input placeholder="Search Products..." value="{{session()->get('search_name')}}" type="text" id="search_name">
                                {{-- <button><i class="ti-search"></i></button> --}}
                            </form>
                        </div>
                    </div>

                    <div class="sidebar-widget mb-45">
                        <h3 class="sidebar-title">Price range</h3>
                        <div class="row">
                            <div class="col-md-5">
                                <input placeholder="Start price" type="number" value="{{session()->get('start_price')}}" id="search_price_start">
                            </div>
                          _
                            
                            <div class="col-md-5">
                                <input placeholder="End price" type="number" value="{{session()->get('end_price')}}" id="search_price_end">
                            </div>
                        </div>

                    
                    </div>
                    
                    <div class="sidebar-widget mb-45">
                        <div class="row">
                            <div class="col-md-5">
                                <h3 class="sidebar-title">Categories</h3>
                            </div>
                            <div class="col-md-7">
                                
                            </div>
                        </div>  

                        <select id="combo1" multiple="multiple">
                            @php
                                $ctrcat=0;
                                $ctrsub=0;
                            @endphp

                            @foreach ($category as $cat)
                                @php
                                    $ctrcat=$ctrcat+1;
                                    $ctrsub=0;
                                    $temp=0;
                                @endphp

                                @foreach ($subcategory as $sub)
                                    @php
                                        if($sub->Id_category == $cat->Id_category)
                                        {
                                            $temp=1;
                                        }
                                    @endphp
                                @endforeach
                                
                                <?php
                                    if($temp==1)
                                    {
                                        ?>
                                            <optgroup label="{{$cat->Category_name}}">
                                                @foreach ($subcategory as $sub)
                                                    <?php
                                                        if($cat->Id_category == $sub->Id_category)
                                                        {
                                                            $ctrsub = $ctrsub+1;

                                                            $sc = session()->get('kumpulan_id_sub_cat');
                                                            $t  = explode(',', $sc); 
                                                            $centang =0;
                                                            for($i = 0; $i < count($t); $i++) {
                                                                if($t[$i] == $sub->Id_sub_category)
                                                                {
                                                                    $centang =1;
                                                                }
                                                            }

                                                            if($centang==1)
                                                            {
                                                                ?>

                                                                <option class="search_sub_category" value="{{$sub->Id_sub_category}}" selected>{{$sub->Sub_category_name}}</option>

                                                                <?php
                                                            }
                                                            else {
                                                                ?>

                                                                <option class="search_sub_category" value="{{$sub->Id_sub_category}}">{{$sub->Sub_category_name}}</option>

                                                                <?php
                                                            }
                                                           
                                                        }
                                                    ?>
                                                @endforeach
                                            </optgroup>
                                        <?php
                                    }

                                ?>

                                
                            @endforeach




                            {{-- <optgroup label="Group 1">
                            <option value="1-1">Option 1.1</option>
                            <option value="1-2" selected="selected">Option 1.2</option>
                            <option value="1-3" selected="selected">Option 1.3</option>
                            </optgroup>
                            <optgroup label="Group 2">
                            <option value="2-1">Option 2.1</option>
                            <option value="2-2">Option 2.2</option>
                            <option value="2-3">Option 2.3</option>
                            </optgroup>
                            <optgroup label="Group 3">
                            <option value="3-1">Option 2.1</option>
                            <option value="3-2">Option 2.2</option>
                            <option value="3-3">Option 2.3</option>
                            </optgroup>
                            <optgroup label="Group 4">
                            <option value="4-1">Option 2.1</option>
                            <option value="4-2">Option 2.2</option>
                            <option value="4-3">Option 2.3</option>
                            </optgroup> --}}

                        </select>
                        
                    </div>

                    <div class="sidebar-widget mb-40">
                        <h3 class="sidebar-title">Brand</h3>
                        <div class="auto">
                            <div class="row" style="width:200px;height:150px">
                                @foreach ($brand as $br)
                                    <div class="form-check form-check-inline" style="margin-left: 8%">
                                        <?php
                                            $kbr = session()->get('kumpulan_id_brand');
                                            $t  = explode(',', $kbr); 
                                            $centang =0;
                                            for($i = 0; $i < count($t); $i++) {
                                                if($t[$i] == $br->Id_brand)
                                                {
                                                    $centang =1;
                                                }
                                            }

                                            if($centang == 1)
                                            {
                                                ?>
                                                    <input class="form-check-input search_brand" type="checkbox" id="inlineCheckbox1"  value="{{$br->Id_brand}}" checked>
                                                <?php
                                            }
                                            else {
                                                ?>
                                                    <input class="form-check-input search_brand" type="checkbox" id="inlineCheckbox1"  value="{{$br->Id_brand}}" >
                                                <?php
                                            }
                                        ?>


                                       
                                        <label class="form-check-label" for="inlineCheckbox1">{{$br->Brand_name}}</label> 
                                    </div>   
                            
                                @endforeach
                            </div>
                        </div>
                            {{-- <div class="product-size">
                                <ul>
                                    <li><a href="#">xl</a></li>
                                    <li><a href="#">m</a></li>
                                    <li><a href="#">l</a></li>
                                    <li><a href="#">ml</a></li>
                                    <li><a href="#">lm</a></li>
                                </ul>
                            </div> --}}
                       
                    </div>
                    <div class="sidebar-widget mb-40">
                        <h3 class="sidebar-title">Rating</h3>
                        {{-- <div class="product-size">
                            <ul>
                                <li><a href="#">xl</a></li>
                                <li><a href="#">m</a></li>
                                <li><a href="#">l</a></li>
                                <li><a href="#">ml</a></li>
                                <li><a href="#">lm</a></li>
                            </ul>
                        </div> --}}
                    </div>
                    {{ Form::button('Filter', ['name'=>'btn_filter','class'=>'btn btn-secondary btn-sm', 'onclick'=>'filter()']) }}
                    {{ Form::button('Clear', ['name'=>'btn_clear','class'=>'btn btn-danger btn-sm', 'onclick'=>'clears()']) }}
                    {{-- <button type="button" class="btn btn-secondary" onclick="muncul()">Filter</button> --}}
                </div>
            </div>
            <div class="col-lg-9">
                <div class="shop-product-wrapper res-xl res-xl-btn">
                    <div class="shop-bar-area">
                        <div class="shop-bar pb-60">
                            <div class="shop-found-selector">
                                <div class="shop-found">
                                    <p><span id="found">0</span> Product Found</p>
                                </div>
                                <div class="shop-selector">
                                    <label>Sort By : </label>
                                    @php
                                        $sort = session()->get('sortby');
                                    @endphp
                                    <select name="select" onchange="ganti_sort()" id="sort">
                                        <?php
                                            if($sort=='ASC')
                                            {
                                                ?>
                                                    <option value="1">Default</option>
                                                    <option value="2" selected>A to Z</option>
                                                    <option value="3"> Z to A</option>
                                                    <option value="4" >Most expensive</option>
                                                    <option value="5" >Cheapest</option>
                                                    <option value="6" >Best seller</option>
                                                <?php
                                            }
                                            else if($sort=='DESC')
                                            {
                                                ?>
                                                    <option value="1">Default</option>
                                                    <option value="2" >A to Z</option>
                                                    <option value="3" selected> Z to A</option>
                                                    <option value="4" >Most expensive</option>
                                                    <option value="5" >Cheapest</option>
                                                    <option value="6" >Best seller</option>
                                                <?php
                                            }
                                            else if($sort=='CHEAP')
                                            {
                                                ?>
                                                    <option value="1">Default</option>
                                                    <option value="2" >A to Z</option>
                                                    <option value="3"> Z to A</option>
                                                    <option value="4" >Most expensive</option>
                                                    <option value="5" selected>Cheapest</option>
                                                    <option value="6" >Best seller</option>
                                                <?php
                                            }
                                            else if($sort=='EXP')
                                            {
                                                ?>
                                                    <option value="1">Default</option>
                                                    <option value="2" >A to Z</option>
                                                    <option value="3"> Z to A</option>
                                                    <option value="4" selected>Most expensive</option>
                                                    <option value="5" >Cheapest</option>
                                                    <option value="6" >Best seller</option>
                                                <?php
                                            }
                                            else {
                                                ?>
                                                    <option value="1">Default</option>
                                                    <option value="2" >A to Z</option>
                                                    <option value="3"> Z to A</option>
                                                    <option value="4" >Most expensive</option>
                                                    <option value="5" >Cheapest</option>
                                                    <option value="6" >Best seller</option>
                                                   
                                                <?php
                                            }
                                        ?>
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="shop-filter-tab">
                                <div class="shop-tab nav" role=tablist>
                                    {{-- <a class="active" href="#grid-sidebar1" data-bs-toggle="tab" role="tab" aria-selected="false">
                                        <i class="ti-layout-grid4-alt"></i>
                                    </a> --}}
                                   
                                </div>
                            </div>
                        </div>
                        <div class="shop-product-content tab-content">
                            <div id="grid-sidebar1" class="tab-pane fade active show">
                                <div class="row" id="isi-product-search">
                                    <div class="col-lg-6 col-md-6 col-xl-3">
                                        <div class="product-wrapper mb-30">
                                            <div class="product-img">
                                                <a href="#">
                                                    <img src="assets/img/product/fashion-colorful/1.jpg" alt="">
                                                </a>
                                                <span>hot</span>
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
                                            <div class="product-content">
                                                <h4><a href="#">Homme Tapered Smart </a></h4>
                                                <span>$115.00</span>
                                            </div>
                                        </div>
                                   </div>
                                    
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="pagination-style mt-30 text-center">
                    <ul>
                        <li><a onclick="pageprevious()"><i class="ti-angle-left"></i></a></li>
                        <li><span id="pagenumber"></span></li>
                        <li><a onclick="pagenext()"><i class="ti-angle-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="categories">
    <div class="modal-dialog modal-md ">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Select Categories</h4>
          <button style="color:black" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
            @foreach ($category as $cat)
            <div class="form-check form-check-inline" style="margin-left: 3%">
                <input class="form-check-input subcat" type="checkbox" id="inlineCheckbox1" value="cat-{{$cat->Id_category}}">
                <label class="form-check-label" for="inlineCheckbox1">{{$cat->Category_name}}</label>
            </div>

                @foreach ($subcategory as $sub)
                    <?Php
                        if($sub->Id_category == $cat->Id_category)
                        {
                            ?>

                                <div class="form-check form-check-inline" style="margin-left: 8%">
                                    <input class="form-check-input subcat" type="checkbox" id="inlineCheckbox1" value="sub-{{$sub->Id_sub_category}}">
                                    <label class="form-check-label" for="inlineCheckbox1">{{$sub->Sub_category_name}}</label>
                                </div>

                            <?php
                        }

                    ?>
                @endforeach
            @endforeach
          

            <div class="row">
                <div class="col-md-10 float-right">
                    <span class="float-right">

                        {{ Form::button('Select', ['name'=>'btn_filter','onclick'=>'muncul()','class'=>'btn btn-secondary btn-sm ']) }}
                        {{-- {{ Form::button('Select', ['name'=>'btn_filter','onclick'=>'muncul()','class'=>'btn btn-secondary btn-sm ']) }} --}}
                    </span>
                   
                </div>
            </div>

            <br>
           
        
        {{-- <div class="modal-body">

        </div> --}}


            {{-- <div class="modal-footer">
              {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
            </div> --}}
       
      </div>
    </div>
</div>

@endsection


@push('custom-js')

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript">

 $(document).ready(function() {
    
    $('#combo1').multiselect({
            enableClickableOptGroups: true
            });


            
        // slider range 
        $( "#slider-range" ).slider({
            range: true,
            min: 0,
            max: 1000000,
            values: [ 0, 1000000 ],
            slide: function( event, ui ) {
                $( "#amount" ).val( "Rp" + ui.values[ 0 ] + " - Rp" + ui.values[ 1 ] );
            }
        });
        $( "#amount" ).val( "Rp" + $( "#slider-range" ).slider( "values", 0 ) +
        " - Rp" + $( "#slider-range" ).slider( "values", 1 ) );

        $('#example-getting-started').multiselect();

        $('.login-info-box').fadeOut();
        $('.login-show').addClass('show-log-panel');

       


    });


</script>



<script src ="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}


<!-- Include the plugin's CSS and JS: -->

<script src ="{{ asset ('assets/js/jquery-2.2.4.min.js') }}"></script>

<script src ="{{ asset ('assets/js/bootstrap.bundle-4.5.2.min.js') }}"></script>
<script src ="{{ asset ('assets/js/bootstrap-multiselect.js') }}"></script>



<script>
  muncul_awal_search();
  disable_search_atas();
  var myurl = "<?php echo URL::to('/'); ?>";


  function disable_search_atas()
  {

      $("#s_name").prop('disabled', true); 
      $("#button_search").prop('disabled', true); 
  }

  function gantivarian()
  {
    var Id_variation = $("#varian").val();

    $.get(myurl + '/getpricevariant',
    {Id_variation: Id_variation},
    function(result){
        // alert(result);
        $("#harga").html(result);
        
        $('#qty').val(1);
    
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


  
 
  

  function muncul()
  {
      var a= $(".subcat").val();
    //   alert(a);

      let semua_cb_centang =$(".subcat:checked")
          
        var kumpulan_id_produk = "";

        $.each(semua_cb_centang,function(index,elm){

        if(index==semua_cb_centang.length-1)
        {
            kumpulan_id_produk = kumpulan_id_produk + elm.value;
        }
        else
        {
            kumpulan_id_produk = kumpulan_id_produk + elm.value+"," ;
        }
        
        })

        alert(kumpulan_id_produk)
  }


  function filter()
  {
      var name = $("#search_name").val();
      var start_price = $("#search_price_start").val();
      var end_price = $("#search_price_end").val();

        let semua_cb_centang =$(".search_brand:checked")
            
        var kumpulan_id_brand = "";

        $.each(semua_cb_centang,function(index,elm){

            if(index==semua_cb_centang.length-1)
            {
                kumpulan_id_brand = kumpulan_id_brand + elm.value;
            }
            else
            {
                kumpulan_id_brand = kumpulan_id_brand + elm.value+"," ;
            }
        
        })
        let semua_cb_centang2 =$(".search_sub_category:checked")
            
        var kumpulan_id_sub_cat= "";

        $.each(semua_cb_centang2,function(index,elm){

            if(index==semua_cb_centang2.length-1)
            {
                kumpulan_id_sub_cat = kumpulan_id_sub_cat + elm.value;
            }
            else
            {
                kumpulan_id_sub_cat = kumpulan_id_sub_cat + elm.value+"," ;
            }
        
        })

      
      if(end_price<start_price)
      {
        toastr["error"]("Error price range", "Error");
      }
      else
      {
        $.get(myurl + '/search_multi',
        {name: name,start_price:start_price,end_price:end_price,kumpulan_id_brand:kumpulan_id_brand,kumpulan_id_sub_cat:kumpulan_id_sub_cat },
        function(result){
            // alert(result);
            var potong = result.split("||");
            $("#isi-product-search").html(potong[0]);
            $("#found").html(potong[1]);
            $("#pagenumber").html(potong[2]);
        });
      }
   
  }

  function muncul_awal_search()
  {
    $.get(myurl + '/muncul_awal_search',
    {},
    function(result){
        // alert(result);
        var potong = result.split("||");
        $("#isi-product-search").html(potong[0]);
        $("#found").html(potong[1]);
        $("#pagenumber").html(potong[2]);
    });
  }


  function pageprevious()
  {
    var tipe="previous";
    $.get(myurl + '/page_next_previous',
    {tipe:tipe},
    function(result){
        // alert(result);
        var potong = result.split("||");
        $("#isi-product-search").html(potong[0]);
        $("#found").html(potong[1]);
        $("#pagenumber").html(potong[2]);
    });
  }

  function pagenext()
  {
    var tipe="next";
    $.get(myurl + '/page_next_previous',
    {tipe:tipe},
    function(result){
        // alert(result);
        var potong = result.split("||");
        $("#isi-product-search").html(potong[0]);
        $("#found").html(potong[1]);
        $("#pagenumber").html(potong[2]);
    });
  }

  function clears()
  {
    //   alert('aa');
    $.get(myurl + '/clear_search',
        {},
        function(result){
            // alert('ss');
            window.location = myurl + "/Advance_search/";
        });


  }

  function ganti_sort()
  {
    var e = document.getElementById("sort");
    // alert(e.value);
    // alert(e.options[e.selectedIndex].text);

    $.get(myurl + '/ganti_Sort',
    {urutan : e.value},
    function(result){
        var potong = result.split("||");
        $("#isi-product-search").html(potong[0]);
        $("#found").html(potong[1]);
        $("#pagenumber").html(potong[2]);
    });
  }
</script>


<style>
    .auto{
      display:block;
      border: 1px;
      padding:5px;
      margin-top:5px;
      width:200px;
      height:500%;
      overflow:auto;
 } 
 </style>


@endpush








@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('masterproduct_atv')
  active
@endsection

@section('menu_master')
   menu-open
@endsection
{{-- ------------- --}}


@section('title2')
    Detail Product
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active"><a href="{{url('master_product')}}">Master Product</a></li>
    <li class="breadcrumb-item active">Detail Product</li>
@endsection


@section('title')
  Detail Product
@endsection


@push('custom-css')
    <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}">


  
@endpush


@section('Content')
<form method="post" class="row g-3" action="{{route('edit_product_detail')}}" enctype="multipart/form-data">
{{-- {{Form::open(array('url'=>'edit_product_detail','method'=>'post'))}} --}}
  @csrf
  @if(count($errors)>0)
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
      @endforeach
    </ul>
  </div>
  @endif
<div class="jumbotron row g-3">
  <div class="col-md-12">
  {{ Form::hidden('txt_id_product', $dtproduct[0]->Id_product, ['class'=>'form-control','id'=>'txt_product_name']) }}
    {{ Form::label('Status :','') }}
    {{ Form::select('cb_status', ['Not Active','Active'], $Ix_status, ['placeholder'=>'Product status','class'=>'form-control', 'id'=>'cb_status' ]) }}
  </div>
  <div class="col-md-6">
    {{ Form::label('Product Name :','') }}
    {{ Form::text('txt_product_name', $dtproduct[0]->Name, ['class'=>'form-control','id'=>'txt_product_name']) }}
  </div>
  <div class="col-md-6">
    @php
        try {
          @endphp
          {{ Form::label('Type :','') }}
      {{ Form::select('cb_type', $arr_type , $Ix_type, ['class'=>'form-control', 'id'=>'cb_type' ]) }}
      @php
      } catch (\Throwable $th) {
        @endphp
        {{ Form::select('cb_type', $arr_type , '', ['class'=>'form-control', 'id'=>'cb_type' ]) }}
        @php
        }
    @endphp
    
  </div>
  <div class="col-md-6">
    {{ Form::label('Packaging :','') }}
    {{ Form::text('txt_packaging', $dtproduct[0]->Packaging, ['class'=>'form-control','id'=>'txt_packaging']) }}
  </div>
  <div class="col-md-6">
    @php
          try {
          @endphp
          {{ Form::label('Brand :','') }}
    {{ Form::select('cb_brand', $arr_brand, $Ix_brand, ['class'=>'form-control', 'id'=>'cb_brand' ]) }}
      @php
      } catch (\Throwable $th) {
        @endphp
        {{ Form::select('cb_brand', $arr_brand, '', ['class'=>'form-control', 'id'=>'cb_brand' ]) }}
        @php
        }
    @endphp
   
  </div>
  <div class="col-md-6">
    {{ Form::label('Composition :','') }}
    {{ Form::textarea('txt_composition', $dtproduct[0]->Composition, ['class'=>'form-control','id'=>'txt_composition']) }}
  </div>
  <div class="col-md-6">
    {{ Form::label('Efficacy :','') }}
    {{ Form::textarea('txt_efficacy', $dtproduct[0]->Efficacy, ['class'=>'form-control','id'=>'txt_efficacy']) }}
  </div>
  <div class="col-md-12">
    {{ Form::label('Description :','') }}
    {{ Form::textarea('txt_description', $dtproduct[0]->Description, ['class'=>'form-control','id'=>'txt_description']) }}
  </div>
  <div class="col-md-6">
    {{ Form::label('Bpom :','') }}
    {{ Form::text('txt_bpom', $dtproduct[0]->Bpom, ['class'=>'form-control','id'=>'txt_bpom']) }}
  </div>
  <div class="col-md-6">
    {{ Form::label('Storage way :','') }}
    {{ Form::text('txt_storage_way', $dtproduct[0]->Storage, ['class'=>'form-control','id'=>'txt_storage_way']) }}
  </div>
  <div class="col-md-6">
    {{ Form::label('Dose :','') }}
    {{ Form::textarea('txt_dose', $dtproduct[0]->Dose, ['class'=>'form-control','id'=>'txt_dose']) }}
  </div>
  <div class="col-md-6">
    {{ Form::label('Disclaimer :','') }}
    {{ Form::textarea('txt_disclaimer', $dtproduct[0]->Disclaimer, ['class'=>'form-control','id'=>'txt_disclaimer']) }}
  </div>
    
</div>

<div class="jumbotron">
  <div class="row">

    
  <div class="col-md-6"> 
    {{ Form::label('Category :','') }}
    {{ Form::select('cb_category', $arr_category, 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_category', 'onchange' => 'loadsubcategory()' ]) }}


    {{ Form::label('Sub Category :','') }}
    {{ Form::select('cb_sub_category', [], 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_sub_category' ]) }}
    <br>
    {{ Form::button('Add sub-category', ['name'=>'add_sub','id'=>'add_sub', 'class'=>'btn btn-primary', 'onclick' => 'add_subcat()']) }}
  </div>


  <div class="col-md-6">
    <div id="err_cat">

    </div>
    <table id="cat" class="table table-dark">
      <thead>
        <tr>
          <th>Category</th>
          <th>Sub Category</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="sub_body">

      </tbody>
    </table>
  </div>

</div>
</div>



<div class="jumbotron">
  {{ Form::label('Product model :','') }}
  <div class="row">
    <div class="col-md-3">
      <div class="list-group" id="list-tab" role="tablist">
        @php
            $class_simple="";
            $class_variation="";

            $class_simple_pane="";
            $class_variation_pane="";

            if ($product_model=="")
            {
              $class_simple="list-group-item list-group-item-action active";
              $class_variation="list-group-item list-group-item-action";
              $class_simple_pane = "tab-pane fade show active";
              $class_variation_pane = "tab-pane fade bootstrap-tagsinput";
            } 
            else {
              $class_simple="list-group-item list-group-item-action";
              $class_variation="list-group-item list-group-item-action active";
              $class_simple_pane = "tab-pane fade bootstrap-tagsinput";
              $class_variation_pane = "tab-pane fade show active";
              
            }
        @endphp
        <a class="@php echo($class_simple); @endphp" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-simple" onclick="tipeproduk('simple')">Simple</a>
        <a class="@php echo($class_variation); @endphp" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-variation" onclick="tipeproduk('variation')"> Variation</a>
      </div>
    </div>


    <div class="col-md-9">
      <div class="tab-content" id="nav-tabContent">
        <div class="@php echo($class_simple_pane); @endphp" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
          <div class="card">
            <div class="card-header">
              SIMPLE (No Variation)
            </div>
            <div class="card-body">
              @php
                  $di = $dtvariasi[0]->Dimension;
                  $pecah = explode("X", $di);
              @endphp
              <div class="row">
                <div class="col-md-6">
                  {{ Form::label('Purchase price :','') }}
                  {{ Form::number('txt_purchase_price', $dtvariasi[0]->Purchase_price, ['class'=>'form-control','id'=>'txt_purchase_price','readonly'=>'true']) }}
                </div>
                <div class="col-md-6">
                  {{ Form::label('Sell Price :','') }}
                  {{ Form::number('txt_sell_price', $dtvariasi[0]->Sell_price, ['class'=>'form-control','id'=>'txt_sell_price']) }}
                </div>
                <div class="col-md-6">
                  {{ Form::label('Weight :','') }}
                  {{ Form::number('txt_weight', $dtvariasi[0]->Weight, ['class'=>'form-control','id'=>'txt_weight']) }}
                </div>
                <div class="col-md-2">
                  {{ Form::label('Length :','') }}
                  {{ Form::number('txt_length', $pecah[0], ['class'=>'form-control','id'=>'txt_length']) }}
                </div>
                <div class="col-md-2">
                  {{ Form::label('Width :','') }} 
                  {{ Form::number('txt_width', $pecah[1], ['class'=>'form-control','id'=>'txt_width']) }} 
                </div>
                <div class="col-md-2">
                  {{ Form::label('Height :','') }}
                  {{ Form::number('txt_height', $pecah[2], ['class'=>'form-control','id'=>'txt_height']) }}
                </div>
                <div class="col-md-6">
                  {{ Form::label('Stock :','') }}
                  {{ Form::number('txt_stock', ($dtvariasi[0]->Stock*1 - $dtvariasi[0]->Stock_atc*1 - $dtvariasi[0]->Stock_pay*1), ['class'=>'form-control','id'=>'txt_stock','readonly'=>'true']) }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="@php echo($class_variation_pane); @endphp" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  {{ Form::label('Variation name','') }}
                </div>
                <div class="card-body">
                  {{ Form::text('txt_variation_name', $product_model, ['placeholder'=>'Ukuran,Warna','class'=>'form-control','id'=>'txt_variation_name']) }}
                </div>
              </div>
            </div>
            <hr class="my-4">
            <div class="col-md-12">
              <br> 
             
              <div class="card">
                <div class="card-header">
                  {{ Form::label('Option','') }}
                </div>
                <div id="err_option">

                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Add Option Variation', ['name'=>'add_variation','id'=>'add_variation', 'class'=>'btn btn-primary float-right btn-md', 'data-toggle' => 'modal', 'data-target' => '#variation_modal_add']) }}
                    </div>

                    <div class="col-md-12">
                      <br><br>
                      <table id="option" class="table table-dark">
                        <thead>
                          <tr>
                            <th>Option name</th>
                            <th>Purchase price</th>
                            <th>Sell price</th>
                            <th>Weight</th>
                            <th>Dimension</th>
                            <th>Stock</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="option_body">
              
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            
            </div>
          
          </div>


        </div>
      </div>

    </div>

  </div>

</div>
<div>
  <div class="jumbotron">
    {{ Form::label('Images :','') }}
    <div class="row">
      <div class="col-lg-12">
        <div class="" id="list-tab" role="tablist">
            <input type="file" name="foto[]" multiple>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="" style="float: left">
          @foreach ($dtproductimage as $data)
          <div style="float: left">
            <img onmousedown=tekandown({{$data->Image_order}}) src="{{ asset('Uploads/Product/'.$data->Image_name )}}" style="width: 150px; height:150px;"  class="center"> 
            <label onclick=hapus({{ $data->Id_image}},{{ $data->Image_order}}) style='cursor: pointer; color:#000;
              margin:-105% -8% 0px 0px;
              float:right;
              border-radius: 100%;
              background-color : black; 
              color: white;
              padding:5%;'>X</label>
          </div>
              
          
          @endforeach
      </div>
    </div>
  </div>
</div>

{{-- 
<input type="submit" value="SAVE CHANGES"  name="edit_product_detail" id="edit_product_detail"> --}}

<div class="jumbotron g-3" style="margin-top:200px; position:absolute; bottom:362px; margin-left:60%; ">
  <div class="row">
    <div class="col-lg-12" style="width: 300px;">
      {{ Form::submit('SAVE CHANGES', ['name'=>'edit_product_detail', 'class'=>'btn btn-primary float-right', 'style' => 'margin-top:200px; position:absolute; bottom:0px']) }}
    </div>
  </div>
</div>
{{ Form::close() }}

</form>

  

<div>

   <!--ADD Modal -->
   <div class="modal fade" id="variation_modal_add">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Insert Variation Option</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                {{ Form::label('Option name :','') }}
                {{ Form::text('txt_option_name_add_detail', 'ada', ['class'=>'form-control','id'=>'txt_option_name_add_detail']) }}
                </div>
                <div class="col-md-12">
                  {{-- {{ Form::label('Purchase price :','') }} --}}
                  {{ Form::hidden('txt_purchase_price_add_detail', 0, ['class'=>'form-control','id'=>'txt_purchase_price_add_detail']) }}
                </div>
                <div class="col-md-12">
                  {{ Form::label('Sell Price :','') }}
                  {{ Form::number('txt_sell_price_add_detail', '1', ['class'=>'form-control','id'=>'txt_sell_price_add_detail']) }}
                </div>
                <div class="col-md-12">
                  {{ Form::label('Weight :','') }}
                  {{ Form::number('txt_weight_add_detail', '1', ['class'=>'form-control','id'=>'txt_weight_add_detail']) }}
                </div>
                <div class="col-md-4">
                  {{ Form::label('Length :','') }}
                  {{ Form::number('txt_length_add_detail', '1', ['class'=>'form-control','id'=>'txt_length_add_detail']) }}
                </div>
                <div class="col-md-4">
                  {{ Form::label('Width :','') }} 
                  {{ Form::number('txt_width_add_detail', '1', ['class'=>'form-control','id'=>'txt_width_add_detail']) }} 
                </div>
                <div class="col-md-4">
                  {{ Form::label('Height :','') }}
                  {{ Form::number('txt_height_add_detail', '1', ['class'=>'form-control','id'=>'txt_height_add_detail']) }}
                </div>
                <div class="col-md-12">
                  {{-- {{ Form::label('Stock :','') }} --}}
                  {{ Form::hidden('txt_stock_add_detail', 0, ['class'=>'form-control','id'=>'txt_stock_add_detail']) }}
                </div>
            </div>
            
              
          </div>
          <div class="modal-footer">
            {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
           
              {{ Form::button('Add option (+)', ['name'=>'add_option','id'=>'add_option', 'class'=>'btn btn-primary float-right', 'data-dismiss'=>'modal','onClick' => 'addoption()']) }}
            
           
          </div>
        <div class="container-fluid">
          
        </div>
      </div>
    </div>
  </div>


  <!--EDIT Modal -->
  <div class="modal fade" id="variation_modal_edit">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Variation Option</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              {{ Form::label('Option name :','') }}
              {{ Form::text('txt_option_name_edit_detail', '', ['class'=>'form-control','id'=>'txt_option_name_edit_detail','readonly'=>'true']) }}
              </div>
              <div class="col-md-12">
                {{ Form::label('Purchase price :','') }}
                {{ Form::number('txt_purchase_price_edit_detail', '', ['class'=>'form-control','id'=>'txt_purchase_price_edit_detail','readonly'=>'true']) }}
              </div>
              <div class="col-md-12">
                {{ Form::label('Sell Price :','') }}
                {{ Form::number('txt_sell_price_edit_detail', '', ['class'=>'form-control','id'=>'txt_sell_price_edit_detail']) }}
              </div>
              <div class="col-md-12">
                {{ Form::label('Weight :','') }}
                {{ Form::number('txt_weight_edit_detail', '', ['class'=>'form-control','id'=>'txt_weight_edit_detail']) }}
              </div>
              <div class="col-md-4">
                {{ Form::label('Length :','') }}
                {{ Form::number('txt_length_edit_detail', '', ['class'=>'form-control','id'=>'txt_length_edit_detail']) }}
              </div>
              <div class="col-md-4">
                {{ Form::label('Width :','') }} 
                {{ Form::number('txt_width_edit_detail', '', ['class'=>'form-control','id'=>'txt_width_edit_detail']) }} 
              </div>
              <div class="col-md-4">
                {{ Form::label('Height :','') }}
                {{ Form::number('txt_height_edit_detail', '', ['class'=>'form-control','id'=>'txt_height_edit_detail']) }}
              </div>
              <div class="col-md-12">
                {{ Form::label('Stock :','') }}
                {{ Form::number('txt_stock_edit_detail', '', ['class'=>'form-control','id'=>'txt_stock_edit_detail','readonly'=>'true']) }}
              </div>
          </div>
          
              
          </div>
          <div class="modal-footer">
            {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
           
            {{ Form::button('Edit option', ['name'=>'add_option','id'=>'add_option', 'class'=>'btn btn-primary float-right', 'data-dismiss'=>'modal','onClick' => "edit_variation()"]) }}
            
           
          </div>
        <div class="container-fluid">
          
        </div>
      </div>
    </div>
  </div>
@endsection



@push('custom-script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script> 


{{-- {{-- <!-- jQuery UI 1.11.4 --> --}}
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('assets/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/dist/js/pages/dashboard.js') }}"></script> 

  

   
<script language="javascript">

  var myurl = "<?php echo URL::to('/'); ?>";
  var crt = "<?php echo csrf_token(); ?>";
  var penampungsub=[];
  var penampungoptionname=[];

  showcart_sub();
  add_subcat_session();

  showcart_option()
  add_option_session();
 
 

  $('#variation_modal_edit').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget);
      var option_name = button.data('option');
      // var modal = $(this);
      // modal.find('.modal-body #txt_username').val(id);

      var myurl = "<?php echo URL::to('/'); ?>";

        $.get(myurl + '/get_variation',
        {option_name: option_name},
        function(result){

          var potong = result.split(",");

          
          $("#txt_option_name_edit_detail").val(potong[0]);
          $("#txt_purchase_price_edit_detail").val(potong[1]);
          $("#txt_sell_price_edit_detail").val(potong[2]);
          $("#txt_weight_edit_detail").val(potong[3]);

          var dimension = potong[4].split('X');

          $("#txt_length_edit_detail").val(dimension[0]);
          $("#txt_width_edit_detail").val(dimension[1]);
          $("#txt_height_edit_detail").val(dimension[2]);

          $("#txt_stock_edit_detail").val(potong[5]);
        });
      })


      function edit_variation()
      {
        var option_name = $("#txt_option_name_edit_detail").val();
        var purchase_price = $("#txt_purchase_price_edit_detail").val();
        var sell_price = $("#txt_sell_price_edit_detail").val();
        var weight = $("#txt_weight_edit_detail").val();
        var dimension = $("#txt_length_edit_detail").val() + "X" + $("#txt_width_edit_detail").val() + "X" + $("#txt_height_edit_detail").val();
        var stock = $("#txt_stock_edit_detail").val();
    

        $.get(myurl + '/edit_variation',
        {option_name: option_name,purchase_price:purchase_price,sell_price:sell_price,weight:weight,dimension:dimension,stock:stock},
        function(result){
          
          showcart_option();
        });
      }
      
  function loadsubcategory()
  {
    
    var kodecategory = $("#cb_category").val();
    
    $.get(myurl + '/getsubcategoryname',
    {kodecategory: kodecategory},
    function(result){
      
      var arr = JSON.parse(result);
     var kal ="";
     for(var i =0;i< arr.length;i++)
     {
       kal = kal + "<option value='"+arr[i]['Id_sub_category']+"'>" + arr[i]['Sub_category_name'] + "</option>";
     }
     $("#cb_sub_category").html(kal);
    });
  
  }

  function add_subcat_session()
  {
    $.get(myurl + '/add_subcat_session',
    { },
    function(result){
     
     var temp = result.split(",");
     for (let index = 0; index < temp.length-1; index++) {
 
       penampungsub.push(temp[index]);
     }
     
    });   
  }



  function add_subcat() //add-sub category
  {

    var cat = $("#cb_category option:selected").text();
    var sub = $("#cb_sub_category option:selected").text();


    if(cat != "" && sub != "")
    {
      var idsub = $("#cb_sub_category option:selected").val();

      if(penampungsub.includes(idsub))
      {
        $("#err_cat").html("<div class='alert alert-danger'>Sub category already Exist</div>");
     
      }
      else
       {
      //   alert('aa');
        $.get(myurl + '/add_sub_table',
        {
          cat:cat,sub:sub,idsub:idsub

        },
        function(result){
          //alert(result);
          $("#err_cat").html("<div></div>");
         showcart_sub();
        
         penampungsub.push(idsub); 
        });                    


      }
    }
    else
    {
      $("#err_cat").html("<div class='alert alert-danger'>Please Choose sub-category</div>");
     
    }
    
  }


  
  function showcart_sub()
  {
    $.get(myurl + '/show_cart_sub',
    {},
    function(result){
      // alert(result);
     $("#sub_body").html(result);
     
    });
  }

  function delete_sub(ix)
  {
   
    $.get(myurl + '/delete_sub',
    {ix:ix},
    function(result){
      showcart_sub();
     penampungsub.splice(ix, 1); 
    });

  }


//untuk pilihan simple/variation
  function tipeproduk(x)
  {
    $.get(myurl + '/product_model',
    {model:x},
    function(result){

    });

  }

  function add_option_session()
  {
    $.get(myurl + '/add_option_session',
    { },
    function(result){
     
     var temp = result.split(",");
     for (let index = 0; index < temp.length-1; index++) {
 
       penampungoptionname.push(temp[index].toLowerCase());
     }
     
    });   
  }



  function addoption()
  { 
    var option_name= $("#txt_option_name_add_detail").val();
    var stock= $("#txt_stock_add_detail").val();
    var purchase_price = $("#txt_purchase_price_add_detail").val();
    var sell_price= $("#txt_sell_price_add_detail").val();
    var weight= $("#txt_weight_add_detail").val();

    var l = $("#txt_length_add_detail").val();
    var w = $("#txt_width_add_detail").val();
    var h = $("#txt_height_add_detail").val();



    if(option_name == "")
    {
      $("#err_option").html("<div class='alert alert-danger'>Option name cannot empty</div>");
    }
    else if(stock == "")
    {
      $("#err_option").html("<div class='alert alert-danger'>Stock cannot empty</div>");
    }
    else if(purchase_price == "")
    {
      $("#err_option").html("<div class='alert alert-danger'>Purchase price cannot empty</div>");
    }
    else if(sell_price == "")
    {
      $("#err_option").html("<div class='alert alert-danger'>Sell price cannot empty</div>");
    }
    else if(weight == "")
    {
      $("#err_option").html("<div class='alert alert-danger'>Weight cannot empty</div>");
    }
    else if(l == "")
    {
      $("#err_option").html("<div class='alert alert-danger'>length cannot empty</div>");
    }
    else if(w == "")
    {
      $("#err_option").html("<div class='alert alert-danger'>Width cannot empty</div>");
    }
    else if(h == "")
    {
      $("#err_option").html("<div class='alert alert-danger'>Height cannot empty</div>");
    }
    else
    {

      if(penampungoptionname.includes(option_name.toLowerCase()))
      {
        $("#err_option").html("<div class='alert alert-danger'>Option name already exist</div>");
      }
      else
      {
        penampungoptionname.push(option_name.toLowerCase());
        $("#err_option").html("<div></div>");
        var dimension= l+"X"+w+"X"+h;

        $.get(myurl + '/add_option_product',
        {
          option_name: option_name
        ,stock:stock,purchase_price:purchase_price,
        sell_price:sell_price,weight:weight,dimension:dimension

        },
        function(result){
          // alert(result);
        showcart_option();
        });                                             
      }

     
    }

    
  }
  

  function showcart_option()
  {
    $.get(myurl + '/show_cart_option',
    {},
    function(result){
     $("#option_body").html(result);
    });
  }



  function delete_option(ix)
  {
    $.get(myurl + '/delete_option',
    {ix:ix},
    function(result){
     showcart_option();
     penampungoptionname.splice(ix, 1); 
    });
  }

</script>


    
    
@endpush


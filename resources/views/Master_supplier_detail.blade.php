@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('mastersupplier_atv')
  active
@endsection

@section('menu_master')
   menu-open
@endsection
{{-- ------------- --}}

@section('title2')
    Detail Supplier
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active"><a href="{{url('master_supplier')}}">Master Supplier</a></li>
    <li class="breadcrumb-item active">Detail/Edit Supplier</li>
@endsection


@section('title')
  Master Supplier 
@endsection



@push('custom-css')
 <!-- CDN data table -->
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
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
  <div class="container-fluid">
    @if(count($errors)>0)
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{$error}}</li>
        @endforeach
      </ul>
    </div>
    @endif

   {{Form::open(array('url'=>'edit_supplier','method'=>'post'))}}
  @csrf
    <div class="row">
      <div class="col-md-12">
       
          @csrf
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">

                {{--  --}}
  
                {{ Form::label('Status :','') }}
                {{ Form::select('cb_status', ['Not Active','Active'], $supplier[0]->Status, ['placeholder'=>'Supplier status','class'=>'form-control', 'id'=>'cb_status' ]) }}
              </div>
              <div class="col-md-6">
                {{ Form::hidden('txt_id_supplier', $supplier[0]->Id_supplier, ['class'=>'form-control']) }}
                {{ Form::label('Supplier Name','') }}
                {{ Form::text('txt_supplier_name', $supplier[0]->Supplier_name, ['class'=>'form-control']) }}
              </div>
              <div class="col-md-4">
                {{ Form::label('Supplier Email','') }}
                {{ Form::email('txt_supplier_email', $supplier[0]->Supplier_email, ['class'=>'form-control']) }}
              </div>
              <div class="col-md-4">
                {{ Form::label('Supplier Phone 1','') }}
                {{ Form::number('txt_supplier_phone1', $supplier[0]->Supplier_phone1, ['class'=>'form-control']) }}
              </div>
              <div class="col-md-4">
                {{ Form::label('Supplier Phone 2','') }}
                {{ Form::number('txt_supplier_phone2', $supplier[0]->Supplier_phone2, ['class'=>'form-control']) }}
              </div>
              <div class="col-md-6">
                {{ Form::label('Supplier Address','') }}
                {{ Form::textarea('txt_supplier_address', $supplier[0]->Supplier_address, ['class'=>'form-control']) }}
              </div>
              <div class="col-md-6">
                {{ Form::label('Credit due date','') }}
                {{ Form::number('txt_credit_due_date', $supplier[0]->Credit_due_date, ['class'=>'form-control']) }}
              </div>
            </div>
            
            
            
          </div>
          
      
      </div>
    </div>
    
    <div class="jumbotron">
      {{ Form::label('Supply Product :','') }}
      <div class="row">
        <div class="col-md-3">
          <div class="list-group" id="list-tab" role="tablist">

            <?php
                if($jum_supplier_product==0)
                {
            ?>
                  <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home" onclick="supplier_product('all')">All Product</a>
            
                  <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile" onclick="supplier_product('select')"> Select Product</a>
            <?php

                }
                else {
                  ?>
                       <a class="list-group-item list-group-item-action" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home" onclick="supplier_product('all')">All Product</a>
            
                       <a class="list-group-item list-group-item-action active" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile" onclick="supplier_product('select')"> Select Product</a>

                  <?php
                }
            ?>
           
          </div>
        </div>


        <div class="col-md-9">
          <div class="tab-content" id="nav-tabContent">

            @php
                $class1 ="";
                $class2 ="";
                if($jum_supplier_product<=0)
                {
                  $class1= "tab-pane fade show active";
                  $class2= "tab-pane fade bootstrap-tagsinput";
                }
                else {
                  $class2= "tab-pane fade show active";
                  $class1= "tab-pane fade bootstrap-tagsinput";
                }
            @endphp

            <div class="@php echo $class1 @endphp" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
              
            </div>
            

            <div class="@php echo $class2 @endphp" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
              <div class="row">
                
                <div class="col-md-12">
               
                  <div class="card">
                    <div class="card-header">
                      {{ Form::label('Add Products','') }}
                    </div>
                    <div id="err_option">

                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          {{ Form::button('Add Product (+)', ['name'=>'select_supplier','id'=>'select_supplier', 'class'=>'btn btn-primary float-right btn-sm', 'data-toggle' => 'modal', 'data-target' => '#modal-product','onclick'=>'add_product()']) }}

                        </div>
                        
                        <div class="col-md-12">
                          <br><br>
                          <table id="option" class="table table-dark">
                            <thead>
                              <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Action</th>
                            
                              </tr>
                            </thead>
                            <tbody id="product_body">
                              
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
    </div>

    <div class="modal-footer">
      {{-- {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }} --}}
      {{ Form::submit('Save Changes', ['name'=>'edit_supplier', 'class'=>'btn btn-primary']) }}
    </div>
    </form>
  </div>

{{-- Modal Product --}}
<div class="modal fade" id="modal-product">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Product</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            
            {{ Form::button('<i class="fa fa-mouse-pointer" aria-hidden="true"></i> Insert',['class'=>'btn btn-primary btn-lg float-right','onClick'=>"select_product()"]) }}
          
            <br><br>   <br><br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class='table table-striped display' id="table_id">
              <thead>
                <tr>
                  {{-- <th><center><input type="checkbox" id="cb_all" style="transform: scale(1.5)"></center></th> --}}

                  <th></th>
                  <th width='150px'>Image</th>
                  <th>Product Name</th>
                  <th>Brand</th>
                  <th>Type</th>
                  <th>Variation</th>
                </tr>
            </thead>
          
            <tbody id="product_modal_body">
              
              



            </tbody>
              
          
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>




@endsection



@push('custom-script')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script> 


  <!-- CDN DATA TABLE -->
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

    <script>
      $(document).ready( function () {
        enter_product_supplier();
        start_product_session();
      } );
    </script>


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



    <script>
        
        // function add_product()
        // {
        //   $("#cb_all").prop('checked',false)
        // }


        // $("#cb_all").on('click', function(){
        //   if($("#cb_all").prop('checked')==true)
        //   {
        //     $(".cb_child").prop('checked',true)
            
        //   }
        //   else
        //   {
        //     $(".cb_child").prop('checked',false)
        //   }
        // })


        // $(".cb_child").on('click',function(){

        //   $("#cb_all").prop('checked',false)
        // })


        function enter_product_supplier()
        {
          var myurl = "<?php echo URL::to('/'); ?>";
        
          $.get(myurl + '/enter_product_supplier',
          {},
          function(result){
         


          $("#product_modal_body").html(result);
          $('#table_id').DataTable();
          });

         
        }

       function start_product_session()
       {
        var myurl = "<?php echo URL::to('/'); ?>";
        $.get(myurl + '/start_session_product_supplier',
          {},
          function(result){
          $("#product_body").html(result);
           
          });
       }




        function select_product()
        {
          var myurl = "<?php echo URL::to('/'); ?>";
          let semua_cb_centang =$(".cb_child:checked")
          
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

      
          $.get(myurl + '/enter_session_product_supplier',
          {kumpulan_id_produk: kumpulan_id_produk},
          function(result){
          $("#product_body").html(result);
            $.get(myurl + '/enter_product_supplier',
              {},
              function(result){

              $("#product_modal_body").html(result);
              });
          });


          }

          function deleteproduct(Id_product)
          {
            var myurl = "<?php echo URL::to('/'); ?>";
            $.get(myurl + '/delete_session_product_supplier',
            {Id_product: Id_product},
            function(result){
              
            $("#product_body").html(result);
            });

            setTimeout(function(){
            
            var myurl = "<?php echo URL::to('/'); ?>";
            $.get(myurl + '/enter_product_supplier',
            {},
            function(result){

            $("#product_modal_body").html(result);
            });
            
            
            }, 500);

            toastr["success"]("Success to delete", "Delete");
          }


        function supplier_product(tipe)
        {
          var myurl = "<?php echo URL::to('/'); ?>";
          $.get(myurl + '/session_tipe_supplier_product',
          {tipe:tipe},
          function(result){
          });
        }



    </script>
@endpush


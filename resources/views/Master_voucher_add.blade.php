@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('mastervoucher_atv')
  active
@endsection

@section('menu_master')
   menu-open
@endsection
{{-- ------------- --}}

@section('title2')
    Add Voucher
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active"><a href="{{url('master_voucher')}}">Master Voucher</a></li>
    <li class="breadcrumb-item active">Add Voucher</li>
@endsection


@section('title')
  Master Voucher
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
    {{-- @if(count($errors)>0)
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{$error}}</li>
        @endforeach
      </ul>
    </div>
    @endif --}}

    @php
        $msgerror = "";
        if($errors->any()){
          foreach ($errors->all() as $error) {
            $msgerror = $error;
          }
        }
    @endphp


    <form class="" method='post' action='add_voucher'>
    <div class="row">
      <div class="col-md-8">
       
          @csrf
          <div class="modal-body">
            {{-- <div class="col-md-12">
              {{ Form::label('Status :','') }}
              {{ Form::select('cb_status', ['Not Active','Active'], 'Kosong', ['placeholder'=>'Supplier status','class'=>'form-control', 'id'=>'cb_status' ]) }}
            </div> --}}
          
            <div class="col-md-12">
              {{ Form::label('Voucher Name','') }}
              {{ Form::text('txt_voucher_name', '', ['class'=>'form-control']) }}
            </div>
            
          </div>
          
      
      </div>
    </div>
    
    <div class="jumbotron">
      {{ Form::label('Voucher_type :','') }}
      <div class="row">
        <div class="col-md-3">
          <div class="list-group" id="list-tab" role="tablist">
              <a class="list-group-item list-group-item-action active" id="list-1-list" data-bs-toggle="list" href="#list-1" role="tab" aria-controls="list-1" onclick="Type_voucher(1)">Discount All Product</a>
              <a class="list-group-item list-group-item-action" id="list-2-list" data-bs-toggle="list" href="#list-2" role="tab" aria-controls="list-2" onclick="Type_voucher(2)">Discount Selected Product</a>
              <a class="list-group-item list-group-item-action" id="list-3-list" data-bs-toggle="list" href="#list-3" role="tab" aria-controls="list-3" onclick="Type_voucher(3)"> Discount Shipping Cost</a>
              
          </div>
        </div>


        <div class="col-md-9">
          <div class="row">
            <div class="col-md-6">
              {{ Form::label('Discount:','') }}
              {{ Form::number('txt_discount', '', ['class'=>'form-control','id'=>'txt_discount']) }}
            </div>
            <br><br><br><br>
          </div>

          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-1" role="tabpanel" aria-labelledby="list-1-list">
          

            </div>

            <div class="tab-pane fade bootstrap-tagsinput" id="list-2" role="tabpanel" aria-labelledby="list-2-list">
              <div class="row">
                
                <div class="col-md-12">
               
                  <div class="card">
                    
                    <div class="card-header">
                      {{ Form::label('select product','') }}
                    </div>

                  
                    <div id="err_option">

                    </div>
                    <div class="card-body">
                      
                      <div class="row">
                        <div class="col-md-12">
                          {{ Form::button('Add Product (+)', ['name'=>'add_product','class'=>'btn btn-primary float-right btn-sm', 'data-toggle' => 'modal', 'data-target' => '#modal-product','onclick'=>'add_product()']) }}

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



            <div class="tab-pane fade bootstrap-tagsinput" id="list-3" role="tabpanel" aria-labelledby="list-3-list">
          
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-2">
        {{ Form::label('Quota','') }}
        {{ Form::number('txt_quota', 0, ['class'=>'form-control']) }}
      </div>
    </div>


    <div class="row">
      <div class="col-md-2">
        {{ Form::label('Redeem Point','') }}
        {{ Form::number('txt_point', 0, ['class'=>'form-control']) }}
      </div>
    </div>

    <div class="row">
      <div class="col-md-2">
        {{ Form::label('Join promo :','') }}
        {{ Form::select('select_promo', ['No Join','Join'], 0, [ 'class'=>'form-control', 'id'=>'select_promo' ]) }}
      </div>
    </div>

    {{ Form::label('redeem due date :','') }} 
    <div class="row">
      <div class="col-md-3">
        <div class="input-group date" id="reservationdate" data-target-input="nearest" onchange="clickdate()">
          
          <br>
          {{ Form::text('txt_date', 0, ['id'=>'txt_date','class'=>'form-control datetimepicker-input','data-target' => '#reservationdate','readonly' => 'true','onchange'=>'clickdate()']) }}
            {{-- <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"/> --}}
            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
      </div>
    </div>

    </div>

    <div class="modal-footer">
      {{-- {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }} --}}
      {{ Form::submit('Insert', ['name'=>'add_voucher', 'class'=>'btn btn-primary']) }}
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

<!-- TOASTR Utk ERROR -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- InputMask -->
<script src="{{ asset('assets/plugins/moment/moment.min.js')}} "></script>
<script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js')}} "></script>
<!-- date-range-picker -->
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js')}} "></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}} "></script>
{{-- <!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js')}}"></script> --}}
<!-- CDN DATA TABLE -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
 


    <script>
      $(document).ready( function () {
        enter_product_supplier();
      } );
    </script>

  <script>
    $(function () {
     
      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
      //Money Euro
      $('[data-mask]').inputmask()
  
      //Date picker
      $('#reservationdate').datetimepicker({
        defaultDate: new Date(),
          viewMode: 'days',
          format: 'DD/MM/YYYY'
      });
  
  
      $('#reservationdate2').datetimepicker({
        defaultDate: new Date(),
          viewMode: 'days',
          format: 'DD/MM/YYYY'
      });

      $('#reservationdate3').datetimepicker({
        defaultDate: new Date(),
          viewMode: 'days',
          format: 'DD/MM/YYYY'
      });


      $('#reservationdate4').datetimepicker({
        defaultDate: new Date(),
          viewMode: 'days',
          format: 'DD/MM/YYYY'
      });
  
     
  
      //Date and time picker
      $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });
  
      //Date range picker
      $('#reservation').daterangepicker()
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
          format: 'MM/DD/YYYY hh:mm A'
        }
      })
      //Date range as a button
      $('#daterange-btn').daterangepicker(
        {
          ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate  : moment()
        },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      )
   
      //Timepicker
      $('#timepicker').datetimepicker({
        format: 'LT'
      })
    })
  
  </script>


    <script>
        
        // function add_product()
        // {
        //   $("#cb_all").prop('checked',false)
        // }


        $("#cb_all").on('click', function(){
          if($("#cb_all").prop('checked')==true)
          {
            $(".cb_child").prop('checked',true)
            
          }
          else
          {
            $(".cb_child").prop('checked',false)
          }
        })


        $(".cb_child").on('click',function(){

          $("#cb_all").prop('checked',false)
        })



        function clickdate()
        {
          var duedate= $("#txt_date").val();

          var duedate2 = duedate[3]+duedate[4]+"/"+duedate[0]+duedate[1]+"/"+duedate[6]+duedate[7]+duedate[8]+duedate[9];
          const fixduedate = new Date(duedate2);




          var today = new Date();
          var dd = today.getDate();

          var mm = today.getMonth()+1; 
          var yyyy = today.getFullYear();
          if(dd<10) 
          {
              dd='0'+dd;
          } 

          if(mm<10) 
          {
              mm='0'+mm;
          } 

          today = yyyy+'/'+mm+'/'+dd;
          var CurrentDate = new Date(today);


          if(fixduedate<CurrentDate)
          {
            toastr["error"]("Redeem due date must bigger than today", "Failed");

            $("#txt_date").val("");
          }
        }


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
            toastr["success"]("Success to Add Product(s)", "Add");
            });
          });


          


          // setTimeout(function(){
            
          //   var myurl = "<?php echo URL::to('/'); ?>";
           
            
            
          //   }, 500);

          }














          function deleteproduct(Id_product)
          {
            var myurl = "<?php echo URL::to('/'); ?>";
            $.get(myurl + '/delete_session_product_supplier',
            {Id_product: Id_product},
            function(result){
              
            $("#product_body").html(result);
              $.get(myurl + '/enter_product_supplier',
              {},
              function(result){

              $("#product_modal_body").html(result);
              toastr["success"]("Success to delete", "Delete");
              });
            });

            // setTimeout(function(){
            
            // var myurl = "<?php echo URL::to('/'); ?>";
         
            
            
            // }, 500);

          
          }


        function Type_voucher(tipe)
        {
          var myurl = "<?php echo URL::to('/'); ?>";
          $.get(myurl + '/session_tipe_voucher',
          {tipe:tipe},
          function(result){
            //  alert(result);
          });
        }



    </script>

    <script>

      var temp = "<?php echo $msg; ?>";  //non validate
      var msgerror = "<?php echo $msgerror ?>"; //validate
      if(temp == "productfail")
      {
        toastr["error"]("Please Choose Product(s)", "Failed");
      }
      else if(msgerror != "")
      {
        toastr["error"](msgerror, "Failed");
      }


    </script>
@endpush


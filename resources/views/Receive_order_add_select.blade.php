{{-- @extends('layout.Nav_dashboard_admin')

@section('isi')
@endsection --}}



@extends('layout.Master')

@section('receive_atv')
  active
@endsection

@section('title2')
Receive Order
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Purchase</li>
    <li class="breadcrumb-item active"><a href="{{url('Receive_order_add')}}">Receive</a></li>
    <li class="breadcrumb-item active">@php echo $noinv @endphp</li>
@endsection


@section('title')
Receive Order
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
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">

 <!-- TOASTR Utk ERROR -->
 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
 
 <style>
   #supplier_name{
     color:red;
     font-size: 150%;

   }

    #variationdetail
    {
      color: red;
      font-size: 85%;
    }

    #lbl_no_detail
    {
      color: white;
    }

    
  
 </style>
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
    
    
    
   
    <div class="row">
      <div class="col-md-4">
        <div class="card card-primary">
          <div class="card-body">
            <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  {{ Form::label('No Invoice: ', '', [ 'id'=>'lbl_noinv']) }}
                  <b id='lbl_no_invoice'>@php echo $noinv;  @endphp</b>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  {{ Form::label('Purchase date: ', '', [ 'id'=>'lbl_purchase_date']) }}
                  @php
                      echo $purchase_header[0]['Purchase_date'];
                  @endphp
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  {{ Form::label('Supplier name: ', '', [ 'id'=>'lbl_supplier_name']) }}
                  @php
                      echo $purchase_header[0]['Supplier_name'];
                  @endphp
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-primary">
          <div class="card-body">
            <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  {{ Form::label('Receive date: ', '', [ 'id'=>'lbl_no_invoice']) }}
                  @php
                      echo date('d/m/Y');
                  @endphp
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  {{ Form::label('Input By: ', '', [ 'id'=>'lbl_no_invoice']) }}
                  @php
                  use App\member;
                    $user=session()->get('userlogin');

                    if($user['Role']=="SHIPPER")
                    {
                      echo $user['Username']."-".$user['Role'];
                    }
                    else {
                      $shipper = member::where('Role','=','SHIPPER')
                      ->where('Status','=',1)
                      ->select('Username','Id_member')
                      ->get();

                      $arr=[];
                      $arr2=[];

                      
                      for ($i=0; $i < count($shipper) ; $i++) { 
                        try {
                          //code...
                          // array_push($arr,$shipper[$i]->Username);

                          $arr[$shipper[$i]->Id_member] = $shipper[$i]->Username; 
                        
                        } catch (\Throwable $th) {
                          //throw $th;
                        }
                      


                      }

                      @endphp
                   
                         {{ Form::select('cb_shipper', $arr, 'Kosong', ['placeholder'=>'SHIPPER','class'=>'form-control', 'id'=>'cb_shipper' ]) }}
                      @php
                    }

                     
                  @endphp
                </div>
              </div>

              
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card card-primary">
         
          <div class="card-body">
            <div class="form-group">
                {{-- UNTUK KEPERLUAN TRACKING SESSION --}}
                  
                  {{-- <button type="button" onclick='showsession()'>SHOW</button> 

                   <textarea name="" id="showsessiontextarea" cols="100" rows="10"></textarea>  --}}

              <div class="row">
                <div class="col-md-12">
                 <b> No Reff Supplier : </b>
                 
                </div>
                <div class="col-md-4">
                  {{ Form::text('txt_no_reff_supplier', '', ['class'=>'form-control','id'=>'txt_no_reff_supplier','placeholder'=>'No Reff Supplier']) }}
                </div>
              </div>
              <br><br>
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-dark">
                    <thead>
                      <tr>
                      
                        <th>Image</th>
                        <th>Product</th>
                        <th>Purchase Qty</th>
                        <th>Remaining Qty</th>
                        <th>Receive Qty</th>
                        <th>Action</th>

                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($purchase_detail as $data)
                    
                    <tr>
                      @php
                      $imgname = "default.jpg";
                      $remaining = $data->Qty;
                      @endphp
                      @foreach ($product_image as $img)
                          @php
                            $idp = $data->Id_product;
                            $idi = $img->Id_product;
                            $urutan = $img->Image_order;
                            
                            if (($idp == $idi) && ($urutan==1))
                            {
                              $imgname = $img->Image_name;
                            }
                          @endphp
                      @endforeach

                      @php
                          $namaproduk="";
                          $namabrand="";
                          $namatype="";
                          $namaoption="";
                          $packaging="";
                      @endphp
                      @foreach ($dtproduct as $pro)
                          @php
                              if($data->Id_product == $pro->Id_product)
                              {
                                $namaproduk=$pro->Name;
                                $namabrand=$pro->Brand_name;
                                $namatype=$pro->Type_name;
                              }
                          @endphp
                      @endforeach
                      @foreach ($dtproduct as $pro)
                          @php
                              if($data->Id_product == $pro->Id_product)
                              {
                                $namaproduk=$pro->Name;
                                $namabrand=$pro->Brand_name;
                                $namatype=$pro->Type_name;
                                $packaging= $pro->Packaging;
                              }
                          @endphp
                      @endforeach
                      @foreach ($dtvariation as $var)
                          @php
                              if($data->Id_variation == $var->Id_variation)
                              {
                                $namaoption=$var->Option_name;
                              }
                          @endphp
                      @endforeach


                      @php
                      $remaining=0;
                      $qtysum=0;
                      @endphp
                      @foreach ($receive_header as $rec_head)
                        @php
                            $no_receive = $rec_head->No_receive;
                        @endphp
                       @foreach ($receive_detail as $rec_detail)
                           @php
                               if($rec_detail->No_receive == $rec_head->No_receive)
                               {
                                 if($rec_detail->No_purchase_detail == $data->No_detail)
                                 {
                                   $qtysum = $qtysum + $rec_detail->Qty;
                                 }
                               }
                           @endphp
                       @endforeach
                      @endforeach

                      @php
                          $remaining = $data->Qty - $qtysum;
                      @endphp

                     





                      <td width='150px'>
                        <img src="{{ asset('Uploads/Product/'.$imgname )}}" width='150px' height='150px' class="center"> 
                      </td>

                      <td>
                        <div class="row">
                          <div class="col-md-12">
                            <p style="font-size: 75%"><b><p id="productname{{$data->No_detail}}">{{$namaproduk}}</p></b></p>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <p style="font-size: 75%">
                              <b>Variation:</b> 
                              <b id="optionname{{$data->No_detail}}">{{$namaoption}}</b>
                            </p>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <p style="font-size: 75%"><b>Type:</b> {{$namatype}}</p>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <p style="font-size: 75%"><b>Brand:</b> {{$namabrand}}</p>
                          </div>
                        </div>
                      </td>
                      <td> 
                        <b>{{$data->Qty}} ({{$packaging}})</b>
                      </td>
                      <td>
                        <p style="font-size: 100%">
                          <b id="remaining{{$data->No_detail}}" >{{$remaining}}</b>
                          <b>({{$packaging}})</b>
                        </p>
                        
                      </td>
                      <td>
                      
                        {{ Form::number('txt_receive', 0, ['class'=>'form-control','min'=>'0','id'=>'txt_receive'.$data->No_detail , 'onchange' => "changeqtyreceive('$data->No_detail')",'onkeyup' => "changeqtyreceive('$data->No_detail')"]) }}
                        <br>
                        <button type='button' id='btn_expire{{$data->No_detail}}' class='btn btn-warning btn-sm' data-toggle='modal' data-nodetail='{{$data->No_detail}}' data-target='#modal-expired'> Expired Date </button>
                      </td>

                      <td>
                        {{ Form::button('<i class="fa fa-mouse-pointer" aria-hidden="true"></i> Select',['class'=>'btn btn-warning btn-sm','id'=>'btn_select'.$data->No_detail,'onClick'=>"btn_select('$data->No_detail')"]) }}
                      </td>
                    </tr>

                    @endforeach
                    </tbody>
                  </table>
                  <div class="row float-right ">
                    {{ Form::button('Input Receive Order', ['name'=>'input_receive_order', 'class'=>'btn btn-primary float-right', 'onclick'=>"input_receive_order()"]) }}
                  </div>
                </div>
                
              </div>
              
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        {{ Form::label('', 'HISTORY', [ 'id'=>'lbl_history']) }}
        <div class="card card-primary">
          <div class="card-body">
            <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  <table id="table_id" class="table">
                    <thead>
                      <tr>
                        <th>No Receive</th>
                        <th>No Invoice</th>
                        <th>Receive Date</th>
                        <th>Shipper</th>
                        <th>Action</th>

                      </tr>
                    </thead>
                    <tbody id="table_ro">
                     
                    </tbody>
                  </table>
                </div>
              </diV>
            </diV>
          </diV>
        </diV>
      </div>
    </div>
  </div><!-- /.container-fluid -->

  

  {{-- MODAL EXPIRED --}}
  <div class="modal fade" id="modal-expired">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">SET EXPIRED DATE</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <br>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4">
              {{ Form::label('lbl_name_head', 'Name :', [ 'id'=>'lbl_name_head']) }}
            </div>
            <div class="col-md-8">
              {{ Form::label('lbl_name', '', [ 'id'=>'lbl_name']) }}
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              
              {{ Form::label('lbl_variation_head', 'Variation :', [ 'id'=>'lbl_variation_head']) }}
            </div>
            <div class="col-md-8">
              {{ Form::label('lbl_variation', '', [ 'id'=>'lbl_variation']) }}
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              {{ Form::label('lbl_qty_head', 'Receive Qty :', [ 'id'=>'lbl_qty_head']) }}
            </div>
            <div class="col-md-8">
              {{ Form::label('lbl_receive_qty', '', [ 'id'=>'lbl_receive_qty']) }}
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              {{ Form::label('lbl_qty_head', 'Not set yet Qty :', [ 'id'=>'lbl_qty_head']) }}
            </div>
            <div class="col-md-8">
              {{ Form::label('lbl_qty', '', [ 'id'=>'lbl_not_set_yet_qty']) }}
            </div>
          </div>
          <hr color="black" width="100%" size="120%" noshade>
          <div id="err">

          </div>
          {{-- kasi warna putih --}}
          {{ Form::label('lbl_no_detail', '', ['id'=>'lbl_no_detail']) }} 
          <div class="row">
            <div class="col-md-5">
              {{ Form::label('lbl_qty_judul', 'Qty', [ 'id'=>'lbl_qty']) }}
            </div>
            <div class="col-md-5">
              {{ Form::label('lbl_tggl_judul', 'Expired Date', [ 'id'=>'lbl_qty']) }}
            </div>
            <div class="col-md-2">
              
            </div>
          </div>
          <div class="row">
            <div class="col-md-5">
              <input type='number' min='1' id='txt_qty' class="form-control" >
            </div>
            <div class="col-md-5">
              <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
                <input type="text" id='txt_expired_date' class="form-control datetimepicker-input" data-target="#reservationdate2"/>
              </div>
            </div>
            <div class="col-md-2">
              <button type='button' class='btn btn-warning btn-md' onclick="setqtyexpired()" > Set </button>
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="col-md-12">
              <table class='table table-dark'>
                <thead>
                  <tr>
                    <th>Qty</th>
                    <th>Expired Date</th>
                    <th>Action</th>
                  </tr>
              </thead>
              <tbody id="qty_expire">

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


{{-- modal detail --}}
  <div class="modal fade" id="modal-detailreceive">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Receive Order</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <br>
        <div class="container-fluid">
         
          <div class="row">
            <div class="col-md-12">
              <table class='table table-dark'>
                <thead>
                  <tr>
                    <th>No Receive</th>
                    <th>Product Name</th>
                    <th>Variation</th>
                    <th>Qty</th>
                  </tr>
              </thead>
              <tbody id="detail_receive">

              </tbody>
              </table>
            </div>
          </div>
          

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>


  
  
@endsection




@push('custom-script')
{{-- untuk MD5 --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>

<!-- CDN DATA TABLE -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
 

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



<script>
  $(document).ready( function () {
    
    showtablero();

  } );
</script>
  
<script>

$("input[data-type='currency']").on({

    keyup: function() {
     
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
});


function formatNumber(n) {
  // format number 1000000 to 1,234,567
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}

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
  var myurl = "<?php echo URL::to('/'); ?>";

  function changeqtyreceive(no_detail)
  {
   // alert(no_detail);
    var tampung = $('#remaining'+no_detail).html();
    var qty_receive = $('#txt_receive'+no_detail).val();

    tampung = tampung*1;
    tampungqty = qty_receive*1;
    $('#txt_receive'+no_detail).val(tampungqty);
    if(qty_receive>tampung)
    {
      $('#txt_receive'+no_detail).val($('#remaining'+no_detail).html());
      qty_receive =$('#txt_receive'+no_detail).val();
    }

    $.get(myurl + '/change_receive_qty',
    {no_detail:no_detail, qty_receive:qty_receive},
    function(result){
      // $("#showsessiontextarea").html(result);
      $("#btn_expire"+no_detail).removeClass("btn-success");
          $("#btn_expire"+no_detail).addClass("btn-warning");
         
          $("#btn_expire"+no_detail).html('Expired Date');

          btn_select_warning(no_detail);
     
    });
  }

  function showtablero()
  {
    $.get(myurl + '/show_table_ro',
    {},
    function(result){
     // alert('tes');
       $("#table_ro").html(result);
       $('#table_id').DataTable();

    

     
    });
  } 

  function input_receive_order()
  {
    var myurl = "<?php echo URL::to('/'); ?>";

    var noinv = $('#lbl_no_invoice').html();
    var noreff = $('#txt_no_reff_supplier').val();

    var cb_shipper = "";

    try {
      cb_shipper = $('#cb_shipper').val();
    } catch (error) {
      // alert("aaa");
      cb_shipper=="";
    }

    // alert(cb_shipper);



    if(noreff=="")
    {
      toastr["error"]("No reff supplier cannot be empty", "Error");
    }
    else
    {
      if(cb_shipper==null )
      {
        $.get(myurl + '/input_receive_order',
        {noinv:noinv,noreff:noreff},
        function(result){
          if(result=="no")
          { 
            toastr["error"]("Please select one or more record", "Error");

          }
          else if(result=="yes")
          {
            
            toastr["success"]("Success to input Receive Order", "Success");
            window.location = myurl + "/Receive_order/";
          }
        });
      }
      else
      {

        if(cb_shipper==0)
        {
          toastr["error"]("Please Choose SHIPPER", "Error");
        }
        else
        {

          var nama;
          $.get(myurl + '/get_shipper_data',
          {Id_member:cb_shipper},
          function(result){
            var cut = result.split("#");
           nama=cut[0];

          
           swal("Password - "+nama+":", {
            content: {
              element: "input",
              attributes: {
                placeholder: "Type your password",
                type: "password",
              },
            }
            })
            .then((value) => {

              if(cut[1] ==`${CryptoJS.MD5(value)}` )
              {
                 $.get(myurl + '/input_receive_order_shipper',
                {noinv:noinv,noreff:noreff,Id_member:cb_shipper},
                function(result){
                  if(result=="no")
                  { 
                    toastr["error"]("Please select one or more record", "Error");

                  }
                  else if(result=="yes")
                  {
                    
                    toastr["success"]("Success to input Receive Order", "Success");
                    window.location = myurl + "/Receive_order/";
                  }
                });
                // toastr["success"]("Success to input Receive Order", "Success");
              }
              else
              {
                toastr["error"]("Password Wrong", "Error");
              }
             
              // swal(`You typed: ${value}`);
            });

          });

        }
          
        
       
      }
      
    }

    
  }

  function showsession()
  {
    $.get(myurl + '/showsessionreceive',
    {},
    function(result){
       $("#showsessiontextarea").html(result);

     
    });

  }


  function deleteproduct(nomer)
  {
    
  
    $.get(myurl + '/delete_product_session',
    {nomer: nomer},
    function(result){
    $("#product_session").html(result);
    });


  }



  $('#modal-expired').on('show.bs.modal', function(event){
    
    var button = $(event.relatedTarget);
    var no_detail = button.data('nodetail');
    var modal = $(this);
    //modal.find('.modal-body #id_category').val(id);


    var myurl = "<?php echo URL::to('/'); ?>";
    var namaproduk = $("#productname"+no_detail).html();
    var namaoption = $("#optionname"+no_detail).html();
    var qty = $("#txt_receive"+no_detail).val();
    //alert(namaproduk);

    $("#lbl_name").html(namaproduk);
    $("#lbl_variation").html(namaoption);
    $("#lbl_receive_qty").html(qty);
    $("#lbl_no_detail").html(no_detail);

    $.get(myurl + '/get_session_receive',
      {no_detail:no_detail},
      function(result){

        var cut = result.split("#");
        $("#lbl_not_set_yet_qty").html(cut[0]);
        $('#txt_qty').val(cut[0]);

        $('#qty_expire').html(cut[1]);
    

      });

  })




  $('#modal-detailreceive').on('show.bs.modal', function(event){
    
    var button = $(event.relatedTarget);
    var no_receive = button.data('noreceive');
    var modal = $(this);
    //modal.find('.modal-body #id_category').val(id);

    var myurl = "<?php echo URL::to('/'); ?>";
    $.get(myurl + '/show_detail_receive',
      {no_receive:no_receive},
      function(result){
        $('#detail_receive').html(result);

      });

  })

  function setqtyexpired()
  {
    var remain = $('#lbl_not_set_yet_qty').html();
    var qty= $('#txt_qty').val();
    var exp= $('#txt_expired_date').val();
    
    // alert(exp);
    var expbaru = exp[6]+exp[7]+exp[8]+exp[9]+"-"+exp[3]+exp[4]+"-"+exp[0]+exp[1];
    
    var GivenDate = new Date(expbaru);


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

    today = yyyy+'-'+mm+'-'+dd;
    var CurrentDate = new Date(today);

    // alert(CurrentDate);
    // alert(GivenDate);

    var no_detail = $("#lbl_no_detail").html();

    
    var remain2 = parseInt(remain);

    try {
      var qty2 = parseInt(qty);
    
      
    } catch (error) {
      qty2=0;
    }
    

    if(remain2 < qty2)
    {
      $("#err").html("<div class='alert alert-danger'>Qty must be smaller than REMAINING QTY<br>REMAINING QTY : "+remain+"</div>");
    }
    else if((qty2<=0)||(qty=="")||(qty==null))
    {
      $("#err").html("<div class='alert alert-danger'>Qty must be bigger than 0</div>");
    }
    else if(GivenDate <= CurrentDate )
    {
      $("#err").html("<div class='alert alert-danger'>Exp date must be bigger than today</div>");
    }
    else
    {
      var sisa=0;
      $("#err").html("");
      var myurl = "<?php echo URL::to('/'); ?>";
      $.get(myurl + '/add_expire_qty_session',
      {no_detail: no_detail,qty:qty,exp:exp},
      function(result){
      // var arr = JSON.parse(result);
     
        sisa = remain2-qty2;
       
        $('#lbl_not_set_yet_qty').html(sisa);
        
        $('#qty_expire').html(result);

        if(sisa==0)
        {
          
          $("#btn_expire"+no_detail).removeClass("btn-warning");
          $("#btn_expire"+no_detail).addClass("btn-success");
         
          $("#btn_expire"+no_detail).html('Expired Date <i class="fas fa-check-circle"></i>');
        }
     
      });

     
    }
 
   
  }


  function deleteqtyexpire(no_detail,kode_exp)
  {
    $.get(myurl + '/delete_expire_qty_session',
      {no_detail:no_detail,kode_exp:kode_exp},
      function(result){
      // var arr = JSON.parse(result);
       // alert(result);
      var cut = result.split("#");
        
        $('#lbl_not_set_yet_qty').html(cut[1]);
        
        $('#qty_expire').html(cut[0]);//tabel

        if(cut[1]==0)
        {
          $("#btn_expire"+no_detail).removeClass("btn-warning");
          $("#btn_expire"+no_detail).addClass("btn-success");
         
          $("#btn_expire"+no_detail).html('Expired Date <i class="fas fa-check-circle"></i>');
        }
        else
        {
          $("#btn_expire"+no_detail).removeClass("btn-success");
          $("#btn_expire"+no_detail).addClass("btn-warning");
         
          $("#btn_expire"+no_detail).html('Expired Date');

          btn_select_warning(no_detail);
        }
      });
  }


  function btn_select_success(no_detail)
  {
    $("#btn_select"+no_detail).removeClass("btn-warning");
        $("#btn_select"+no_detail).addClass("btn-success");
        $("#btn_select"+no_detail).html('<i class="fa fa-mouse-pointer" aria-hidden="true"></i> Unselect');
        
        $.get(myurl + '/set_id_reveice_session',
        {no_detail:no_detail,idx:1},
        function(result){


        });
  }

  function btn_select_warning(no_detail)
  {
    $("#btn_select"+no_detail).removeClass("btn-success");
      $("#btn_select"+no_detail).addClass("btn-warning");

      $("#btn_select"+no_detail).html('<i class="fa fa-mouse-pointer" aria-hidden="true"></i> Select');
    
      $.get(myurl + '/set_id_reveice_session',
        {no_detail:no_detail,idx:0},
        function(result){


        });
  }


  function btn_select(no_detail)
  {
   

    if($("#btn_select"+no_detail).html()=='<i class="fa fa-mouse-pointer" aria-hidden="true"></i> Select')
    {
      if($("#btn_expire"+no_detail).html()=='Expired Date <i class="fas fa-check-circle"></i>')
      {
        btn_select_success(no_detail);
     
      }
      else
      {
        toastr["error"]("Please complete Expired Date", "Error");
      }
     
    }
    else
    {
      btn_select_warning(no_detail);
    }
    
  }



  String.prototype.number_format = function(d) {
    var n = this;
    var c = isNaN(d = Math.abs(d)) ? 2 : d;
    var s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + ',' : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + ',');
}

  

  
</script>

 
@endpush



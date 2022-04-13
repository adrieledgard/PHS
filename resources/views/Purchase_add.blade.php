{{-- @extends('layout.Nav_dashboard_admin')

@section('isi')
@endsection --}}



@extends('layout.Master')

@section('purchase_atv')
  active
@endsection

@section('title2')
   Purchase Order
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Purchase</li>
    <li class="breadcrumb-item active">Order</li>
@endsection


@section('title')
Purchase Order
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
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
 <!-- CDN data table -->
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
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

    #lbl_id
    {
      color: white;
    }

    
  
 </style>
@endpush





@section('Content')

{{Form::open(array('url'=>'Insert_purchase','method'=>'post'))}}
  @csrf
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
      <div class="col-md-6">
        <div class="card card-primary">
          <div class="card-header">
            <h6 class="card-title">Date</h6>
          </div>
          <div class="card-body">
            <!-- Date -->
            <div class="form-group">
              {{ Form::label('Invoice Date:','') }} 
                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                  {{ Form::text('txt_invoice_date', '', ['class'=>'form-control datetimepicker-input','data-target' => '#reservationdate','readonly' => 'true']) }}
                    {{-- <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"/> --}}
                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card card-primary">
          <div class="card-header">
            <h6 class="card-title">Supplier</h6>
          </div>
          <div class="card-body">
            <!-- Date -->
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  {{ Form::label('Choose Supplier','') }}
                  {{-- <input type='text' name='currency-field' id='currency-field' pattern='^\$\d{1,3}(,\d{3})*(\.\d+)?$' value='' data-type='currency' placeholder='$1,000,000.00'> --}}
                </div>
                <div class="col-md-4">
                  {{ Form::button('Select Supplier', ['name'=>'select_supplier','id'=>'select_supplier', 'class'=>'btn btn-primary float-right btn-sm', 'data-toggle' => 'modal', 'data-target' => '#modal-supplier']) }}
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  {{ Form::hidden('id_supplier', '', ['class'=>'form-control','id'=>'id_supplier']) }}
                  {{ Form::text('supplier_name', '', ['class'=>'form-control','id' => 'supplier_name','readonly' => 'true']) }}
                  {{-- {{ Form::label('supplier_name', ' ', array('id' => 'supplier_name')) }} --}}
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  {{ Form::label('Email  ','') }} 
                </div>
                <div class="col-md-9">
                  {{ Form::label('', '', array('id' => 'supplier_email')) }}
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  {{ Form::label('Phone 1  ','') }} 
                </div>
                <div class="col-md-9">
                  {{ Form::label('', '', array('id' => 'supplier_phone1')) }}
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  {{ Form::label('Phone 2  ','') }} 
                </div>
                <div class="col-md-9">
                  {{ Form::label('', '', array('id' => 'supplier_phone2')) }}
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  {{ Form::label('Address  ','') }} 
                </div>
                <div class="col-md-9">
                  {{ Form::label('', '', array('id' => 'supplier_address')) }}

                  {{-- <input type="text" name="currency-field" id="currency-field" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" value="" data-type="currency" placeholder="$1,000,000.00"> --}}
                </div>
              </div>
            
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary">
         
          <div class="card-body">
            <div class="form-group">
              
              <div class="row">
                <div class="col-md-2">
                  {{ Form::label('Select Product','') }} 
                 
                </div>
                <div class="col-md-2">
                  {{ Form::button('Add Product (+)', ['name'=>'select_supplier','id'=>'select_supplier', 'class'=>'btn btn-primary float-right btn-sm', 'data-toggle' => 'modal', 'data-target' => '#modal-product']) }}
                  <br><br>
               
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <table id="purchase_product" class="table table-dark">
                    <thead>
                      <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Variation</th>
                        <th>Purchase Price</th>
                        <th>Qty</th>
                        <th>Total</th>

                      </tr>
                    </thead>
                    <tbody id="product_session">
                     
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row float-right ">
                {{ Form::submit('Insert Purchase', ['name'=>'insert_purchase', 'class'=>'btn btn-primary float-right']) }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->


  {{-- Modal Supplier --}}
  <div class="modal fade" id="modal-supplier">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Supplier</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <br>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <table class='table table-striped display table_id'>
                <thead>
                  <tr>
                    <th>Supplier Name</th>
                    <th >Supplier Email</th>
                    <th>Supplier Phone</th>
                    {{-- <th>Supplier Phone 2</th> --}}
                    <th>Supplier Address</th>
                    <th>Action</th>
                  </tr>
                </thead>
            
                <tbody>
                  @foreach ($dtsupplier as $data)
                  <tr>
                    <td>{{$data->Supplier_name}}</td>
                    <td>{{$data->Supplier_email}}</td>
                    <td>{{$data->Supplier_phone1.' / '.$data->Supplier_phone2}}</td>
                    {{-- <td>{{$data->Supplier_phone2}}</td> --}}
                    <td>{{$data->Supplier_address}}</td>
                  
              
                    <td>
                      {{-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit_modal" data-cat="{{$data->Id_category}}">Edit</button> --}}
                      {{-- {{ Form::button('Select', ['name'=>'btn_select','class'=>'btn btn-warning btn-sm ','data-cat'=>$data->Id_supplier,'data-bs-toggle'=>'modal','data-bs-target'=>'#edit_modal']) }} --}}
                      {{ Form::button('<i class="fa fa-mouse-pointer" aria-hidden="true"></i> Choose',['class'=>'btn btn-warning btn-sm','onClick'=>"choose_supplier('$data->Id_supplier')"]) }}
                      {{-- class="close" data-dismiss="modal" aria-label="Close" --}}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                
            
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{ Form::close() }}


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
              <table class='table table-striped display table_id'>
                <thead>
                  <tr>
                    <th width='150px'>Image</th>
                    <th>Product Name</th>
                    <th>Brand</th>
                    <th>Type</th>
                    <th>Variation</th>
                    <th>Action</th>
                  </tr>
              </thead>
            
              <tbody id="modal-product-supplier">
                
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
              {{ Form::label('lbl_qty_head', 'Remaining Qty :', [ 'id'=>'lbl_qty_head']) }}
            </div>
            <div class="col-md-8">
              {{ Form::label('lbl_qty', '', [ 'id'=>'lbl_qty']) }}
            </div>
          </div>
          <hr color="black" width="100%" size="120%" noshade>
          <div id="err">

          </div>
          {{-- kasi warna putih --}}
          {{ Form::label('lbl_id', '', ['id'=>'lbl_id']) }} 
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
  
@endsection




@push('custom-script')
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


function formatCurrency(input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  var input_val = input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }
  
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = input.prop("selectionStart");
    
  // check for decimal
  if (input_val.indexOf(".") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(".");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
      right_side += "00";
    }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 2);

    // join number by .
    input_val = "$" + left_side + "." + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    input_val = "$" + input_val;
    
    // final formatting
    if (blur === "blur") {
      input_val += ".00";
    }
  }
  
  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}



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

  //NAMPILKAN SESSION JIKA ADA DI TABEL
  $.get(myurl + '/show_table_session',
  {},
  function(result){
  
    $("#product_session").html(result);
  
  });

  //supplier name kasi kosong
  $('#supplier_name').val('');


  //Kasi hide combobox no variation
  // $('#selecthide').style.visibility = "hidden";
 // document.getElementById("selecthide").style.visibility = "hidden";




  function showsession()
  {
    $.get(myurl + '/showsession',
    {},
    function(result){
       $("#showsession2").html(result);

     
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
    var nomer = button.data('urutan');
    var modal = $(this);
    //modal.find('.modal-body #id_category').val(id);


    var myurl = "<?php echo URL::to('/'); ?>";

     $('#err').html('');
      $.get(myurl + '/get_data_product_session',
      {nomer: nomer},
      function(result){
        
      var cut = result.split("#");
      $("#lbl_name").html(cut[0]);
      $("#lbl_variation").html(cut[1]);
      $("#lbl_qty").html(cut[2]);
      $("#txt_qty").val(cut[2]);
      $("#lbl_id").html(cut[3]);
      $("#lbl_id").html(cut[3]);
      $('#qty_expire').html(cut[4]);
      });

  })


  function setqtyexpired()
  {
    var remain = $('#lbl_qty').html();
    var qty= $('#txt_qty').val();
    var exp= $('#txt_expired_date').val();
    var nomer = $("#lbl_id").html();

    
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
    else
    {
      var sisa=0;
      $("#err").html("");
      var myurl = "<?php echo URL::to('/'); ?>";
      $.get(myurl + '/add_expire_qty_session',
      {nomer: nomer,qty:qty,exp:exp},
      function(result){
      // var arr = JSON.parse(result);
     
        sisa = remain2-qty2;
        $('#lbl_qty').html(sisa);
        
        $('#qty_expire').html(result);

        if(sisa==0)
        {
          $('#checkexpire'+nomer).html('<i class="fas fa-check-circle"></i>');
        }
     
      });

     
    }
 
   
  }


  function deleteqtyexpire(kode_pro,kode_exp)
  {
    $.get(myurl + '/delete_expire_qty_session',
      {kode_pro:kode_pro,kode_exp:kode_exp},
      function(result){
      // var arr = JSON.parse(result);
       // alert(result);
      var cut = result.split("#");
        
        $('#lbl_qty').html(cut[1]);
        
        $('#qty_expire').html(cut[0]);//tabel

        if(cut[1]==0)
        {
          $('#checkexpire'+kode_pro).html('<i class="fas fa-check-circle"></i>');
        }
        else
        {
          $('#checkexpire'+kode_pro).html('');
        }
      });
  }



  String.prototype.number_format = function(d) {
    var n = this;
    var c = isNaN(d = Math.abs(d)) ? 2 : d;
    var s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + ',' : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + ',');
}

  

  function changecboption(nomer)
  {
    var nilaicb = $("#cboption" + nomer).val();
    var cut = nilaicb.split("#");
    var hargabeli = cut[1];
    var Id_variation = cut[2];
   
    $("#txt_purchase_price" + nomer).val( hargabeli);

    var qtybeli = $("#txt_qty" + nomer).val();

    var subtotal = hargabeli*qtybeli;

    $("#txt_subtotal" + nomer).html("Rp. "+ subtotal.toString().number_format());

    
    $.get(myurl + '/changecboption',
    {nomer: nomer,hargabeli:hargabeli,qtybeli:qtybeli,Id_variation:Id_variation},
    function(result){
    // TOTAL BAGIAN PALING BAWAH
    $("#txt_total").html("<b>Rp. "+ result.toString().number_format()+"</b>");
    $("#txt_grandtotal").val(result);
    });

  }

  function changetxtpurchase(nomer)
  {
    var nilaicb = $("#cboption" + nomer).val();
    var cut = nilaicb.split("#");
    var Id_variation = cut[2];

    var hargabeli =  $("#txt_purchase_price" + nomer).val();

    var qtybeli = $("#txt_qty" + nomer).val();

    if(hargabeli=="")
    {
      $("#txt_purchase_price" + nomer).val(0);
    }

    var subtotal = hargabeli*qtybeli;
    $("#txt_subtotal" + nomer).html("Rp. "+ subtotal.toString().number_format());


    $.get(myurl + '/changecboption',
    {nomer: nomer,hargabeli:hargabeli,qtybeli:qtybeli,Id_variation:Id_variation},
    function(result){
    // TOTAL BAGIAN PALING BAWAH
    $("#txt_total").html("<b>Rp. "+ result.toString().number_format()+"</b>");
    $("#txt_grandtotal").val(result);
      
    });
  }

  function changetxtqty(nomer)
  {
    var nilaicb = $("#cboption" + nomer).val();
    var cut = nilaicb.split("#");
    var Id_variation = cut[2];

    var hargabeli =  $("#txt_purchase_price" + nomer).val();

    var qtybeli = $("#txt_qty" + nomer).val();

    if(qtybeli=="")
    {
      $("#txt_qty" + nomer).val(1);
    }

    var subtotal = hargabeli*qtybeli;
    $("#txt_subtotal" + nomer).html("Rp. "+ subtotal.toString().number_format());


   
    $.get(myurl + '/changecboption',
      {nomer: nomer,hargabeli:hargabeli,qtybeli:qtybeli,Id_variation:Id_variation,bentuk:'txt_qty'},
      function(result){
      // TOTAL BAGIAN PALING BAWAH
      $("#txt_total").html("<b>Rp. "+ result.toString().number_format()+"</b>");
      $("#txt_grandtotal").val(result);
      });

      $('#checkexpire'+nomer).html('');
  }



  function select_product(idpro)
  {
    $('#modal-product').modal('toggle'); 
    $.get(myurl + '/add_product_session',
    {idpro: idpro},
    function(result){
    
      $("#product_session").html(result);
   
    });


  }

  function choose_supplier(idsup)
  {
    $('#modal-supplier').modal('toggle'); 

    $('#product_session').html("");

    $.get(myurl + '/show_supplier',
    {idsup: idsup},
    function(result){
    var arr = JSON.parse(result);

    $("#id_supplier").val(arr[0]['Id_supplier']);
    $("#supplier_name").val(arr[0]['Supplier_name']);
    $("#supplier_email").html(': '+arr[0]['Supplier_email']);
    $("#supplier_phone1").html(': '+arr[0]['Supplier_phone1']);
    $("#supplier_phone2").html(': '+arr[0]['Supplier_phone2']);
    $("#supplier_address").html(': '+arr[0]['Supplier_address']);
      
    
    $.get(myurl + '/Add_product_modal',
    {idsup: idsup},
    function(result){
   
    $('#modal-product-supplier').html(result);

    $('.table_id').DataTable();

    });
      
    });


    
      
  }
</script>

 
@endpush



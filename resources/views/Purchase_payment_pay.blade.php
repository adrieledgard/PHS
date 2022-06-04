
@extends('layout.Master')

@section('menu_purchase')
   menu-open
@endsection


@section('purchasepayment_atv')
  active
@endsection

@section('title2')
Purchase Payment Pay
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Purchase</li>
    <li class="breadcrumb-item active"><a href="{{url('Purchase_payment')}}">Payment</a></li>
    <li class="breadcrumb-item active">Pay</li>
@endsection


@section('title')
Purchase payment pay
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
<div class="row">
  {{Form::open(array('url' => 'Insert_purchase_payment', 'method' => 'post', 'files' => true))}}
  <div class="col-md-12">
    @php
        if($receive_header[0]['Payment']==1)
        {
          @endphp
          <button type='button' class='btn btn-success btn-sm' disabled>PAID</button>
          @php
        }
        else {
          @endphp
          <button type='button' class='btn btn-danger btn-sm' disabled>UNPAID</button>
          @php
        }
    @endphp
    
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-4">
        <b>Receive Date</b> 
      </div>
      <div class="col-md-5">
        <b>
          {{ Form::text('Receive_date',$receive_header[0]['Receive_date'], ['readonly'=>'true']) }}
        {{-- @php
            echo ": ".$receive_header[0]['Receive_date'];
        @endphp --}}
        </b>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <b>Due Date</b> 
      </div>
      <div class="col-md-5">
        <b> 
          {{ Form::text('Due_date',$duedate, ['readonly'=>'true']) }}
      
        </b>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <b>No Receive</b> 
      </div>
      <div class="col-md-5">
        <b>
          {{ Form::text('No_receive',$receive_header[0]['No_receive'],['readonly'=>'true']) }}
          {{-- @php
           echo ": ".;
          @endphp --}}
        </b>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <b style="font-size: 100%">No Invoice PO</b> 
      </div>
      <div class="col-md-5">
        <b>
          {{ Form::text('No_invoice',$receive_header[0]['No_invoice'], ['readonly'=>'true']) }}
          {{-- @php
              echo ": ".$receive_header[0]['No_invoice'];
          @endphp --}}
        </b>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <b style="font-size: 100%">No reff Supplier</b> 
      </div>
      <div class="col-md-5">
        <b> 
          {{ Form::text('No_reff_supplier',$receive_header[0]['No_reff_supplier'], ['readonly'=>'true']) }}
          {{-- @php
              echo ": ".$receive_header[0]['No_reff_supplier'];
          @endphp   --}}
        </b>
      </div>
    </div>
  </div>


  <div class="col-md-6">
    <div class="row">
      <div class="col-md-3">
        <b>Supplier</b> 
      </div>
      <div class="col-md-8">
        <b>
          {{ Form::text('Supplier',$supp, ['readonly'=>'true']) }}
          {{-- @php
              echo ": ".$supp;
          @endphp   --}}
        </b>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <b>Shipper</b> 
      </div>
      <div class="col-md-8">
        <b>
          {{ Form::text('Shipper',$receive_header[0]['Username'], ['readonly'=>'true']) }}
          {{-- @php
             echo ": ".$receive_header[0]['Username'];
          @endphp --}}
        </b>
      </div>
    </div>

   
  </div>
</div>
<hr>

<div class="row">
  <div class="col-md-12">
    <table class='table table-dark'>
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Variation</th>
          <th>Qty</th>
          <th>Purchase Price</th>
          <th>Total</th>
        </tr>
    </thead>
    <tbody>
      @php
          $total=0;
      @endphp
      @foreach ($receive_detail as $data)
          <tr>
            <td>
              {{$data->Name}}
            </td>
            <td>
              {{$data->Option_name}}
            </td>
            <td>
              {{number_format($data->Qty)}}
            </td>
            <td>
              Rp. {{number_format($data->Purchase_price)}}
            </td>
            <td>
              Rp. {{number_format($data->Qty*$data->Purchase_price)}}
            </td>

            @php
                $total = $total +($data->Qty*$data->Purchase_price);
            @endphp
           

          </tr>
      @endforeach
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><b>TOTAL :</b></td>
        <td><b>Rp. 
          @php
            echo number_format($total);
        @endphp
        </b></td>
      </tr>

    </tbody>
    </table>
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <b>Payment Method: </b>
  </div>
</div>
<div class="row">
  <div class="col-md-2">
    <div class="list-group" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home" onclick="payment_method('cash')">Cash</a>
      
        <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile" onclick="payment_method('bank_transfer')"> Bank Transfer</a>
        
    </div>
  </div>


  <div class="col-md-5">
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
        <br>
        @php
            $total2 = "Rp. ".number_format($total);
        @endphp
        {{ Form::label('CASH','') }}
        {{ Form::text('txt_variation_name', $total2, ['placeholder'=>'Ukuran,Warna','class'=>'form-control','id'=>'txt_variation_name','disabled'=>'true']) }}
      </div>

      <div class="tab-pane fade bootstrap-tagsinput" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
        <br>
        @php
            $total2 = "Rp. ".number_format($total);
        @endphp
        {{ Form::label('BANK TRANSFER','') }}
        {{ Form::text('txt_variation_name', $total2, ['placeholder'=>'Ukuran,Warna','class'=>'form-control','id'=>'txt_variation_name','disabled'=>'true']) }}
       <br>
        {{ Form::label('FROM','') }}
        {{ Form::select('cb_bank', $bank, '', ['class'=>'form-control', 'id'=>'cb_bank' ]) }}
     
      </div>
    </div>

  </div>

  <div class="col-md-5">
    {{ Form::label('Transaction Receipt','') }}
    <br>
    {{ Form::file('foto',['id'=>'foto'])}}
    {{-- {!! Form::submit('SAVE', ['name'=>'Save','class'=>'btn btn-info btn-md']) !!} --}}
  </div>
  
</div>
<br><br><br><br><br><br>
{{ Form::submit('Input Payment', ['name'=>'input_purchase_payment', 'class'=>'btn btn-primary float-right']) }}
{{ Form::close() }}
</div><!-- /.container-fluid -->

<br><br><br>



@endsection



@push('custom-script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script> 


<!-- CDN DATA TABLE -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script>
  $(document).ready( function () {
   
    $('#table_id2').DataTable();
    
  } );
  </script>
    <!-- jQuery UI 1.11.4 -->
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
       $('#modal-detailreceive').on('show.bs.modal', function(event){
     
      var button = $(event.relatedTarget);
      var norcv = button.data('norcv');
      var modal = $(this);
      var myurl = "<?php echo URL::to('/'); ?>";
      

      $.get(myurl + '/get_receive_detail_payment',
        {norcv:norcv},
        function(result){

          var cut = result.split("#");
          $(".detail_receive").html(cut[0]);
      
          $(".norcv").html(": "+cut[1]);
          $(".nopo").html(": "+cut[2]);
          $(".supp").html(": "+cut[3]);
          $(".operator").html(": "+cut[4]);
          $(".tgl").html(": "+cut[5]);
          $(".noreffsupp").html(": "+cut[6]);
          $(".Status_payment").html(cut[7]);
          $(".duedate").html(": "+cut[8]);
          


        });

     })

    </script>



<script>
  $('#modal-paid').on('show.bs.modal', function(event){
     
     var button = $(event.relatedTarget);
     var norcv = button.data('norcv');
     var modal = $(this);
     var myurl = "<?php echo URL::to('/'); ?>";
     
     $.get(myurl + '/get_receive_detail_payment',
       {norcv:norcv},
       function(result){

         var cut = result.split("#");
         $(".detail_receive").html(cut[0]);
     
         $(".norcv").html(": "+cut[1]);
         $(".nopo").html(": "+cut[2]);
         $(".supp").html(": "+cut[3]);
         $(".operator").html(": "+cut[4]);
         $(".tgl").html(": "+cut[5]);
         $(".noreffsupp").html(": "+cut[6]);
         $(".Status_payment").html(cut[7]);
         $(".duedate").html(": "+cut[8]);
         


       });

    })


    function payment_method(method)
    {
    

       var myurl = "<?php echo URL::to('/'); ?>";
          $.get(myurl + '/payment_method_select',
          {method:method},
          function(result){
            // alert(result);
          });
    }

    function input_purchase_payment()
    {
      var foto = $('#foto');

      // alert(foto);
      var myurl = "<?php echo URL::to('/'); ?>";
          $.get(myurl + '/input_purchase_payment',
          {foto:foto},
          function(result){
            // alert(result);
          });
    }


    
</script>
@endpush


    
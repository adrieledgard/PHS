@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('stockcard_atv')
  active
@endsection

@section('menu_report')
   menu-open
@endsection
{{-- ------------- --}}

@section('title2')
    Stock Card
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Report</li>
    <li class="breadcrumb-item active">Stock Card</li>
@endsection


@section('title')
 Stock Card
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

  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@endpush

@section('Content')
 
<div class="col-md-6"> 
  {{ Form::label('Product :','') }}
  {{ Form::select('cb_product', $arr_product, 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_product', 'onchange' => 'loadvariation()' ]) }}


  {{ Form::label('Variation :','') }}
  {{ Form::select('cb_variation', [], 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_variation' ]) }}
  <br>
  <div class="input-group date" id="reservationdate" data-target-input="nearest">
      {{-- <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"/> --}}
      <input type="text" class="form-control date_range_picker" />
  </div>
  
  
  
  {{ Form::button('Process', ['name'=>'process','id'=>'process', 'class'=>'btn btn-primary', 'onclick' => 'process()']) }}


  
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <table id="table_id" class='table table-striped display'>
      <thead>
        <tr>
          <th>Id</th>
          <th>Date</th>
          <th>Type</th>
          <th>Product</th>
          <th>Variation</th>
          <th>Expire Date</th>
          <th>First Stock</th>
          <th>Debet</th>
          <th>Credit</th>
          <th>Last Stock</th>
          <th>Fifo Stock</th>
          <th>Transaction price</th>
          <th>Capital</th>
        </tr>
      </thead>
  
      <tbody id="stock_card">

      </tbody>
    </table>
  </div>
</div>


@endsection



@push('custom-script')

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
       <!-- CDN DATA TABLE -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>



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
     $(".date_range_picker").daterangepicker({
        opens: 'center',
        locale: {
            format: 'YYYY-MM-DD'
        }
    });
  function loadvariation()
  {
    var myurl = "<?php echo URL::to('/'); ?>";
    var Id_product = $("#cb_product").val();
    
    $.get(myurl + '/get_variation_product',
    {Id_product: Id_product},
    function(result){
       
      var arr = JSON.parse(result);
      // alert(arr);
     var kal ="";
     for(var i =0;i< arr.length;i++)
     {
      // alert(arr[i]['Option_name']);
       kal = kal + "<option value='"+arr[i]['Id_variation']+"'>" + arr[i]['Option_name'] + "</option>";
     }
     $("#cb_variation").html(kal);
    });
  
  }

  function process()
  {
    var myurl = "<?php echo URL::to('/'); ?>";
    // alert('aa');
    var Id_variation = $("#cb_variation").val();

    if(Id_variation=="" || Id_variation==null)
    {
      toastr["error"]("Please Choose Variation", "Error");
    }
    else
    {
      $.get(myurl + '/show_table_stock_card',
      {Id_variation: Id_variation},
      function(result){
        
        $('#stock_card').html(result);
        $('#table_id').DataTable();
        
      });
    }



    // 
   
  }

</script>
@endpush
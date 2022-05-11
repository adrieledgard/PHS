@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('populer_affilite_product_report_atv')
  active
@endsection

@section('menu_report')
   menu-open
@endsection
{{-- ------------- --}}

@section('title2')
    Populer Affiliate Product
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Report</li>
    <li class="breadcrumb-item active">Populer Affiliate Product</li>
@endsection


@section('title')
 Populer Affiliate Product
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

  {{-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" /> --}}

  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
@endpush

@section('Content')
<div class="row">
  <div class="col-md-12"> 
    {{Form::open(array('url'=>'populer_affiliate_product/show','method'=>'get','class'=>''))}}
    {{ Form::label('Affiliate Type :','') }}
    {{ Form::select('type_affiliate', ["all" => "All", "LINK" => 'Link', 'EBOOK' =>'Ebook', 'EMBED' => "Embed"], $type_affiliate, [ 'class'=>'form-control', 'id'=>'type_affiliate']) }}
    <br>
    {!! Form::submit('Filter', ['class' => 'btn btn-primary']) !!}
    {{ Form::button('Print', ['name'=>'process','id'=>'process', 'class'=>'btn btn-primary', 'onclick' => 'print()']) }}
    
    {!! Form::close() !!}
    
      
    </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <table id="table_populer_affiliate_product" class='table table-striped display'>
      <thead>
        <tr>
          <th>Product</th>
          <th>Variation</th>
          <th>Qty</th>
        </tr>
      </thead>
  
      <tbody id="">
        @foreach ($products as $product)
            <tr>
              <td>{{ $product->Name}}</td>
              <td>{{ $product->Option_name}}</td>
              <td>{{ $product->qty}}</td>
            </tr>
        @endforeach
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
  $(document).ready(function(){
    $("#table_populer_affiliate_product").DataTable({"order": [] });
  })
  function print(){
    var myurl = "<?php echo URL::to('/'); ?>";
    var type_affiliate = $("#type_affiliate").val();
    window.open(myurl + '/populer_affiliate_product/print?type_affiliate=' + type_affiliate, "_blank");
  }
</script>
@endpush
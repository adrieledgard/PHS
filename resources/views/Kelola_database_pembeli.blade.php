@extends('layout.Master')

{{-- UNTUK SIDEBAR --}}
@section('menu_database_pembeli_atv')
  active
@endsection

@section('menu_kelola_database')
   menu-open
@endsection
{{-- ------------- --}}


@section('title2')
    Database Pembeli
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Database Pembeli</li>
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

  <link rel="stylesheet" href="{{asset('css/summernote-bs4.css')}}">
@endpush


@section('Content')
@if($errors->any())
<div class="alert alert-danger" role="alert">
  {{$errors->first()}}
</div>
@endif
  <div class="container-fluid" style="height:100%;">
    
    <div class="row">
      <div class="col-md-12">
        <table id="table_id"  class='table table-striped display'>
          <thead>
            <tr>
              <td>Name</td>
              <td>Total Transaksi</td>
              <td>Tanggal Transaksi Terakhir</td>
              <td>Action</td>
            </tr>
          </thead>
          <tbody>
            @foreach ($member as $customer)
                <tr>
                    <td>{{$customer->Username}}</td>
                    <td>{{$customer->total_order}}</td>
                    <td>{{$customer->last_order_date}}</td>
                    <td>
                        <a href="https://wa.me/{{$customer->Phone}}" class='btn btn-success btn-sm ' target="_blank">Follow up WA</a>
                        {{ Form::button('Detail item order', ['name'=>'btn_edit','class'=>'btn btn-info btn-sm ','data-item-order'=>json_encode($customer->items),'data-toggle'=>'modal','data-target'=>'#rincian_item_order']) }}
                    </td>
                    
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div id="rincian_item_order" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Rincian item </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <table class="table-rincian-item-order">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Total dipesan</th>
                    </tr>
                </thead>
                <tbody class="table-body-rincian-item-order">
                    
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      {{Form::close()}}
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

<script>
$(document).ready( function () {
  $('#table_id').DataTable();
});
</script>

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

<script src="{{ asset('js/summernote-bs4.js') }}"></script>

<script>
// $('.summernote').summernote();

$("#rincian_item_order").on('show.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var items = button.data('item-order');
    $(".table-body-rincian-item-order").html("");
    Object.keys(items).forEach(item_name => {
        $(".table-body-rincian-item-order").append(`
            <tr>
                <td>
                    `+item_name+`
                </td>
                <td>
                    `+items[item_name]+`
                </td>
            </tr>
        `)
    });
    $(".table-rincian-item-order").DataTable();
 });
</script>
    
@endpush
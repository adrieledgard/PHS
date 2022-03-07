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

  <style>
    .dataTables_scrollHeadInner {
width: 100% !important;
}
.dataTables_scrollHeadInner table {
width: 100% !important;
}
  </style>
@endpush


@section('Content')
<input type="hidden" class="csrf_token" value="{{csrf_token()}}">
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
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
              <td>Catatan</td>
              <td>Action</td>
            </tr>
          </thead>
          <tbody>
            @foreach ($member as $customer)
                <tr>
                    <td>{{$customer->Username}}</td>
                    <td>{{$customer->total_order}}</td>
                    <td>{{$customer->last_order_date}}</td>
                    <td>{{$customer->Catatan}}</td>
                    <td>
                        <a href="https://wa.me/{{$customer->Phone}}" class='btn btn-success btn-sm ' target="_blank">Follow up WA</a>
                        {{ Form::button('Follow up email', ['name'=>'btn_edit','class'=>'btn btn-warning btn-sm ','data-idmember'=>$customer->Id_member,'data-toggle'=>'modal','data-target'=>'#send_email']) }}
                        {{ Form::button('Detail order', ['name'=>'btn_edit','class'=>'btn btn-info btn-sm ','data-order'=>json_encode($customer->orders),'data-toggle'=>'modal','data-target'=>'#rincian_order']) }}
                        {{ Form::button('Catatan', ['name'=>'btn_edit','class'=>'btn btn-info btn-sm ','data-idmember'=>$customer->Id_member,'data-toggle'=>'modal','data-target'=>'#catatan']) }}
                    </td>
                    
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
  <div id="rincian_order" class="modal fade" role="dialog" style="max-height:calc(100% - 80px)">
    <div class="modal-dialog modal-dialog-scrollable modal-xl"> 
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Rincian Order </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="overflow-y: scroll">
            <table class="table-rincian-order">
                <thead style="width:100%">
                    <tr>
                        <th>Nomor Transaksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Alamat</th>
                        <th>Kurir</th>
                        <th>Grand Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-body-rincian-order">
                    
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div id="rincian_order_detail" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Rincian Order </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <table class="table-rincian-item-order">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Total dipesan</th>
                        <th>Subtotal</th>
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
    </div>
  </div>
  <div id="send_email" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Kirim Email</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="col-md-6">
            {{ Form::label('Subject :','') }}
            {{ Form::text('subject', '', ['class'=>'form-control','id'=>'subject', 'placeholder' => "Subject", 'required' => 'required']) }}
          </div>
  
          <div class="col-md-12">
            {{ Form::label('Content :','') }}
            {{ Form::textarea('content', '', ['class'=>'form-control','id'=>'content', 'placeholder' => "content", 'required' => 'required']) }}
          </div>
          {!! Form::hidden('id_member', 0, ['class' => 'id_member']) !!}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          {{ Form::button('Send', ['name'=>'btn_edit','class'=>'btn btn-success btn-sm button_send', 'onclick' => 'send_email()']) }}
        </div>
      </div>
    </div>
  </div>

  <div id="catatan" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        {{Form::open(array('url'=>'simpan_catatan','method'=>'post'))}}
        <div class="modal-header">
          <h4 class="modal-title">Catatan</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
          <div class="col-md-12">
            {{ Form::label('Catatan :','') }}
            {{ Form::textarea('Catatan', '', ['class'=>'form-control','id'=>'catatan', 'placeholder' => "Catatan", 'required' => 'required']) }}
          </div>
          {!! Form::hidden('Id_member', 0, ['class' => 'id_member']) !!}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          {{ Form::submit('Simpan', ['name'=>'btn_edit','class'=>'btn btn-success btn-sm button_send']) }}
        </div>
        {!! Form::close() !!}
      </div>
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
<script src ="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset('js/summernote-bs4.js') }}"></script>

<script>

$("#rincian_order").on('show.bs.modal', function(event){
    var formatter = new Intl.NumberFormat('en-US', {style:'currency', 'currency':"IDR", currencyDisplay:'narrowSymbol'});
    if ($.fn.DataTable.isDataTable('.table-rincian-order') ) {
      $('.table-rincian-order').DataTable().destroy();
    }
    var button = $(event.relatedTarget);
    var orders = button.data('order')
    $(".table-body-rincian-order").html("");
    orders.forEach(order => {
        $(".table-body-rincian-order").append(`
            <tr>
                <td>
                    `+order.Id_order+`
                </td>
                <td>
                    `+order.Date_time+`
                </td>
                <td>
                    `+order.Address+`, `+order.City_name+`, `+order.Province_name+`
                </td>
                <td>
                    `+order.Courier+`
                </td>
                <td>
                    `+formatter.format(order.Grand_total)+`
                </td>
                <td>
                  <button class='btn btn-sm btn-info' data-toggle='modal' data-target='#rincian_order_detail' data-order-detail='`+JSON.stringify(order.detail_order)+`'>Rincian</button>  
                </td>
            </tr>
        `)
    });
    $(".table-rincian-order").DataTable()
 });

$("#rincian_order_detail").on('show.bs.modal', function(event){
    var formatter = new Intl.NumberFormat('en-US', {style:'currency', 'currency':"IDR", currencyDisplay:'narrowSymbol'});
    if ( $.fn.DataTable.isDataTable('.table-rincian-item-order') ) {
      $('.table-rincian-item-order').DataTable().destroy();
    }
    var button = $(event.relatedTarget);
    var detail_order = button.data('order-detail');
    $(".table-body-rincian-item-order").html("");
    detail_order.forEach(detail => {
        $(".table-body-rincian-item-order").append(`
            <tr>
                <td>
                    `+detail.Name+`
                </td>
                <td>
                    `+detail.Fix_price+`
                </td>
                <td>
                    `+detail.Qty+`
                </td>
                <td>
                    `+formatter.format(detail.Qty * detail.Fix_price)+`
                </td>
            </tr>
        `)
    });
    $(".table-rincian-item-order").DataTable();
 });

$("#send_email").on('show.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var id_member = button.data('idmember');
    $(".id_member").val(id_member);
 });

$("#catatan").on('show.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var id_member = button.data('idmember');
    $(".id_member").val(id_member);
 });

 function send_email() {
  $(".button_send").attr('disabled', 'disabled')
  var token = $(".csrf_token").val();
  var Id_member = $(".id_member").val();
  var Subject = $("#subject").val();
  var Content = $("#content").val();
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': token
      }
    });

    $.post(myurl + '/send_email',
    {Id_member: Id_member, CSRF: token, Subject : Subject, Content: Content},
    function(result){
      $(".button_send").attr('disabled', false)
        if(result == 'sukses'){
          toastr["success"]("Sukses", "Success");
        }
        
    });
 }
</script>
    
@endpush
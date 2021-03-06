@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('report_followup_atv')
  active
@endsection

@section('menu_report')
   menu-open
@endsection
{{-- ------------- --}}

@section('title2')
    Follow Up
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Report</li>
    <li class="breadcrumb-item active">Follow Up</li>
@endsection


@section('title')
 Follow Up
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
    <div class="col-md-6"> 
        {{ Form::label('Select customer service :','') }}
        {{ Form::select('cs_id', $arr, 'Kosong', [ 'class'=>'form-control', 'id'=>'cs_id']) }}
        <br>
        {{ Form::label('Select date period :','') }}
        <input type="text" class="form-control date_range_picker" />
        <br>
        {{ Form::button('Process', ['name'=>'process','id'=>'process', 'class'=>'btn btn-primary', 'onclick' => 'process()']) }}
        {{ Form::button('Print', ['name'=>'print','id'=>'print', 'class'=>'btn btn-info', 'onclick' => 'print()']) }}
        
      </div>
      <div class="col-md-6"> 
        <div class="card">
            <div class="card-body">
                <h5>Summary</h5>
                Total Follow Up : <label class="total_followup"></label><br>
                Total Failed Follow Up : <label class="total_failed_followup"></label><br>
                Total Success Follow Up : <label class="total_success_followup"></label>
            </div>
        </div>
        
      </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <table id="table_id" class='table table-striped display'>
      <thead>
        <tr>
          <th>Customer Service Name</th>
          <th>Customer Name</th>
          <th>Period</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
  
      <tbody id="followup_cs">

      </tbody>
    </table>
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
                    <th>Gross Total</th>
                    <th>Shipping Cost</th>
                    <th>Diskon Voucher</th>
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
                    <th>Variant</th>
                    <th>Normal Price</th>
                    <th>Discount</th>
                    <th>Fix Price</th>
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

  function print(){
    var myurl = "<?php echo URL::to('/'); ?>";
    var cs_id = $("#cs_id").val();
    var date_range = $(".date_range_picker").val();
    if(cs_id=="" || cs_id==null)
    {
      toastr["error"]("Please Choose Variation", "Error");
    }
    else
    {
      window.open(myurl + '/print_followup_report?Id_customer_service=' + cs_id + "&date_period=" + date_range, "_blank");
    }
  }
  function process()
  {
    var myurl = "<?php echo URL::to('/'); ?>";
    var cs_id = $("#cs_id").val();
    var date_range = $(".date_range_picker").val();
    console.log(date_range);
    if(cs_id=="" || cs_id==null)
    {
      toastr["error"]("Please Choose Variation", "Error");
    }
    else
    {
      $.get(myurl + '/show_table_followup_cs',
      {Id_customer_service: cs_id, date_period: date_range},
      function(result){
        
        $('#followup_cs').html(result[0]);
        $(".total_followup").html(`<span class="badge bg-primary">${result[1][0]}</span>`);
        $(".total_failed_followup").html(`<span class="badge bg-danger">${result[1][1]}</span>`);
        $(".total_success_followup").html(`<span class="badge bg-success">${result[1][2]}</span>`);
        $('#table_id').DataTable();
        
      });
    }
  }
  $("#rincian_order").on('show.bs.modal', function(event){
    var formatter = new Intl.NumberFormat('en-US', {style:'currency', 'currency':"IDR", currencyDisplay:'narrowSymbol'});
    if ($.fn.DataTable.isDataTable('.table-rincian-order') ) {
      $('.table-rincian-order').DataTable().destroy();
    }
    var button = $(event.relatedTarget);
    var order = button.data('order')
    $(".table-body-rincian-order").html("");
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
                  `+order.Courier+ " (" +order.Courier_packet+`)
                </td>
                <td>
                  `+formatter.format(order.Gross_total) +`
                </td>
                <td>
                  `+formatter.format(order.Shipping_cost) +`
                </td>
                <td>
                  `+formatter.format(order.Discount) +`
                </td>
                <td>
                    `+formatter.format(order.Grand_total)+`
                </td>
                <td>
                  <button class='btn btn-sm btn-info' data-toggle='modal' data-target='#rincian_order_detail' data-order-detail='`+JSON.stringify(order.detail)+`'>Rincian</button>  
                </td>
            </tr>
        `)
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
                    `+detail.Variant_name + `(`+ detail.Variant_option_name+`)
                </td>
                <td>
                    `+formatter.format(detail.Normal_price)+`
                </td>
                <td>
                    `+formatter.format(detail.Discount_promo)+`
                </td>
                <td>
                    `+formatter.format(detail.Fix_price)+`
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

</script>
@endpush
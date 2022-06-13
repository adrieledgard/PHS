@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('pembelian_report_atv')
  active
@endsection

@section('menu_report')
   menu-open
@endsection
{{-- ------------- --}}

@section('title2')
    Pembelian
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Report</li>
    <li class="breadcrumb-item active">Pembelian</li>
@endsection


@section('title')
Pembelian
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
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          {{Form::open(array('url'=>'pembelian','method'=>'get','class'=>''))}}
          <div class="row ">
            <div class="form-check">
                @if (request()->input('filter') == "bulan" || !request()->has('filter'))
                <input class="form-check-input" type="radio" name="filter" id="filter_bulan" value="bulan" checked>
                @else
                <input class="form-check-input" type="radio" name="filter" id="filter_bulan" value="bulan">
                @endif
                <label class="form-check-label" for="filter_bulan">
                  Pilih bulan
                </label>
            </div>
            <div class="col-12 ">
                <select class="form-control filter_bulan" name="filter_bulan" id="" value="">
                    @foreach ($filter_bulan as $bulan_number => $bulan)
                        @if (request()->input("filter_bulan") == $bulan_number)
                        <option value="{{$bulan_number}}" selected>{{$bulan}}</option>
                        @else
                        <option value="{{$bulan_number}}">{{$bulan}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
          </div>
          <br>
          <div class="row ">
            <div class="form-check">
                @if (request()->input('filter') == "tahun")
                <input class="form-check-input" type="radio" name="filter" id="filter_tahun" value="tahun" checked>
                @else
                <input class="form-check-input" type="radio" name="filter" id="filter_tahun" value="tahun">
                @endif
                
                <label class="form-check-label" for="filter_tahun">
                  Pilih tahun
                </label>
            </div>
            <div class="col-12 ">
                <select class="form-control filter_tahun" name="filter_tahun" id="">
                    @foreach ($filter_tahun as $tahun)
                      @if (request()->input("filter_tahun") == $tahun)
                      <option value="{{$tahun}}" selected> {{$tahun}}</option>
                      @else
                      <option value="{{$tahun}}"> {{$tahun}}</option>
                      @endif
                    @endforeach
                </select>
            </div>
          </div>
          <div class="row mt-3 ">
            <div class="form-check">
                @if (request()->input('filter') == "date_range")
                <input class="form-check-input" type="radio" name="filter" value="date_range" id="filter_date_range" checked>
                @else
                <input class="form-check-input" type="radio" name="filter" value="date_range" id="filter_date_range">
                @endif
                
                <label class="form-check-label" for="filter_date_range">
                    Date range
                </label>
            </div>
            <div class="col-12">
              <input type="text" class="form-control date_range_picker filter_date_range" name="filter_date_range" value="{{request()->input('filter_date_range')}}"/>
            </div>
          </div>
          <br>
          {{ Form::submit('Filter', ['class'=>'btn btn-primary btn-sm float-left']) }}
          {{Form::close()}}

          @if (request()->has('filter'))
          <a href="{{url('pembelian_print?filter=' . request()->input('filter') . "&filter_".request()->input('filter'). "=" . request()->input("filter_". request()->input('filter')))}}" class="btn btn-warning btn-sm"  style="margin-left:10px;" target="_blank">Print</a>    
          @else
          <a href="{{url('pembelian_print')}}" class="btn btn-warning btn-sm" style="margin-left:10px;"  target="_blank">Print</a>
          @endif
          
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          Total Order : {{count($purchases)}}
          <br>
          Total Order to Supplier : Rp. {{number_format($total_pengeluaran)}}
        </div>
      </div>
    </div>
  </div>
  
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <table id="table_populer_product" class='table table-striped display'>
      <thead>
        <tr>
          <th>No. Order</th>
          <th>Date</th>
          <th>Status</th>
          <th>Supplier Name</th>
          <th>Supplier Email</th>
          <th>Supplier Phone</th>
          <th>Grand Total</th>
          <th>Receive Purchase</th>

        </tr>
      </thead>
  
      <tbody id="">
        @foreach ($purchases as $purchase)
            <tr>
              <td><a data-toggle="modal" data-purchase-detail="{{$purchase->detail}}" href="#purchase_detail" >{{ $purchase->No_invoice}}</a></td>
              <td>{{ $purchase->Purchase_date}}</td>
              @php
                  $stat="";
                  if($purchase->purchasestat==0){
                    $stat='Void';
                  }else if($purchase->purchasestat==1){
                    $stat='Open';
                  }else if($purchase->purchasestat==2){
                    $stat='Partially processed';
                  }else if($purchase->purchasestat==3){
                    $stat='Partially processed (close)';
                  }else if($purchase->purchasestat==4){
                    $stat='Complete (close)';
                  }

              @endphp
              <td>{{ $stat }}</td>
              <td>{{ $purchase->Supplier_name}}</td>
              <td>{{ $purchase->Supplier_email}}</td>
              <td>{{ $purchase->Supplier_phone1}}, {{ $purchase->Supplier_phone2}}</td>
              <td>Rp. {{ number_format($purchase->Grand_total)}}</td>
              <td><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#receive" data-receive="{{$purchase->receive}}">Rincian</button></td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<div id="purchase_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Rincian Purchase </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <table class="table-rincian-item-purchase">
              <thead>
                  <tr>
                    <th>Nama Produk</th>
                    <th>Variant</th>
                    <th>Purchase Price</th>
                    <th>Total dipesan</th>
                    <th>Subtotal</th>
                  </tr>
              </thead>
              <tbody class="table-body-rincian-item-purchase">
                  
              </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div id="receive" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Receive </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <table class="table-rincian-receive">
              <thead>
                  <tr>
                    <th>No. Receive</th>
                    <th>Date Receive</th>
                    <th>Payment</th>
                  </tr>
              </thead>
              <tbody class="table-body-rincian-receive">
                  
              </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div id="receive_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Rincian Receive </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <table class="table-rincian-item-receive">
              <thead>
                  <tr>
                    <th>Nama Produk</th>
                    <th>Variant</th>
                    <th>Qty</th>
                  </tr>
              </thead>
              <tbody class="table-body-rincian-item-receive">
                  
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
  $(document).ready(function(){
    var filter = "{!! request()->input('filter') !!}";

    $("#table_populer_product").DataTable({"order": [] });
    $(".date_range_picker").daterangepicker({
        opens: 'center',
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    if(filter == 'tahun'){
      $("#filter_tahun").trigger('click');
    }else if(filter == 'date_range'){
      $("#filter_date_range").trigger('click');
    }else {
      $(".filter_bulan").attr('disabled', false);
      $(".filter_tahun").attr('disabled', 'disabled');
      $(".filter_date_range").attr("disabled", 'disabled');
    }

    
  })
  
  $("#filter_bulan").click(function(){
      $('.filter_bulan').attr('disabled', false);
      $(".filter_tahun").attr('disabled', 'disabled');
      $(".filter_date_range").attr("disabled", 'disabled');
  });
  $("#filter_tahun").click(function(){
    
      $('.filter_bulan').attr("disabled", 'disabled');
      // $(".filter_bulan").prop('disabled', true);
      $(".filter_tahun").attr('disabled', false);
      $(".filter_date_range").attr("disabled", 'disabled');
  });
  $("#filter_date_range").click(function(){
      $('.filter_bulan').attr("disabled", 'disabled');
      $(".filter_tahun").attr('disabled', 'disabled');
      $(".filter_date_range").attr("disabled", false);
  });

$("#purchase_detail").on('show.bs.modal', function(event){
    var formatter = new Intl.NumberFormat('en-US', {style:'currency', 'currency':"IDR", currencyDisplay:'narrowSymbol'});
    if ( $.fn.DataTable.isDataTable('.table-rincian-item-purchase') ) {
      $('.table-rincian-item-purchase').DataTable().destroy();
    }
    var button = $(event.relatedTarget);
    var detail_purchase = button.data('purchase-detail');
    console.log(detail_purchase);
    $(".table-body-rincian-item-purchase").html("");
    detail_purchase.forEach(detail => {
        $(".table-body-rincian-item-purchase").append(`
            <tr>
              <td>
                    `+detail.Name+`
                </td>
                <td>
                    `+detail.Variation_name + `(`+ detail.Option_name+`)
                </td>
                <td>
                    `+formatter.format(detail.Purchase_price)+`
                </td>
                <td>
                    `+detail.Qty+`
                </td>
                <td>
                    `+formatter.format(detail.Qty * detail.Purchase_price)+`
                </td>
            </tr>
        `)
    });
    $(".table-rincian-item-purchase").DataTable();
 });

$("#receive").on('show.bs.modal', function(event){
    if ( $.fn.DataTable.isDataTable('.table-rincian-receive') ) {
      $('.table-rincian-receive').DataTable().destroy();
    }
    var button = $(event.relatedTarget);
    var receives = button.data('receive');
    
    $(".table-body-rincian-receive").html("");
    receives.forEach(receive => {
        let payment_status = "-";
        let receive_status = "";
       
        if(receive.Payment == 1){
          payment_status = "Yes";
        }
        $(".table-body-rincian-receive").append(`
            <tr>
              <td>
                    <a href="#receive_detail" data-toggle="modal" data-receive-detail='`+JSON.stringify(receive.detail)+`'>`+receive.No_receive+`</a>
                </td>
                <td>
                    ` + receive.Receive_date +`
                </td>
               
                <td>
                    `+ payment_status +`
                </td>
            </tr>
        `)
    });
    $(".table-rincian-receive").DataTable();
 });

$("#receive_detail").on('show.bs.modal', function(event){
    if ( $.fn.DataTable.isDataTable('.table-rincian-item-receive') ) {
      $('.table-rincian-item-receive').DataTable().destroy();
    }
    var button = $(event.relatedTarget);
    var detail_receive = button.data('receive-detail');
    $(".table-body-rincian-item-receive").html("");
    detail_receive.forEach(detail => {
        $(".table-body-rincian-item-receive").append(`
            <tr>
              <td>
                    `+detail.Name+`
                </td>
                <td>
                    `+detail.Variation_name + `(`+ detail.Option_name+`)
                </td>
                <td>
                    `+detail.Qty+`
                </td>
            </tr>
        `)
    });
    $(".table-rincian-item-receive").DataTable();
 });

</script>
@endpush
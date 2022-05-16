@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('penukaran_point_report_atv')
  active
@endsection

@section('menu_report')
   menu-open
@endsection
{{-- ------------- --}}

@section('title2')
    Penukaran Point Member
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Report</li>
    <li class="breadcrumb-item active">Penukaran Point Member</li>
@endsection


@section('title')
Penukaran Point Member
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
    {{-- <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          {{Form::open(array('url'=>'omzet_affiliator','method'=>'get','class'=>''))}}
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
          <a href="{{url('omzet_affiliator_print?filter=' . request()->input('filter') . "&filter_".request()->input('filter'). "=" . request()->input("filter_". request()->input('filter')))}}" class="btn btn-warning btn-sm"  style="margin-left:10px;" target="_blank">Print</a>    
          @else
          <a href="{{url('omzet_affiliator_print')}}" class="btn btn-warning btn-sm" style="margin-left:10px;"  target="_blank">Print</a>
          @endif
          
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          Total Omzet : Rp. {{number_format($total_omzet)}}
        </div>
      </div>
    </div> --}}
    <a href="{{url('penukaran_point_member_print')}}" class="btn btn-warning btn-sm" style="margin-left:10px;"  target="_blank">Print</a>
  </div>
  
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <table id="table_populer_product" class='table table-striped display'>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Total Point Sisa</th>
          <th>Total Point Ditukar</th>
        </tr>
      </thead>
  
      <tbody id="">
        @foreach ($members as $member)
            <tr>
              <td>{{ $member->Username}}</td>
              <td>{{ $member->Email}}</td>
              <td>{{ $member->Phone}}</td>
              <td>{{ $member->Point}}</td>
              <td><a href="#rincian_penukaran_point" data-toggle="modal" data-rincian-penukaran = "{{$member->rincian_penukaran}}">{{$member->total_point_ditukar}}</a></td>
              
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<div id="rincian_penukaran_point" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Rincian Penukaran Point </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <table class="table-rincian-penukaran-point">
              <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Voucher</th>
                    <th>Point</th>
                    
                  </tr>
              </thead>
              <tbody class="table-body-rincian-penukaran-point">
                  
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

    // if(filter == 'tahun'){
    //   $("#filter_tahun").trigger('click');
    // }else if(filter == 'date_range'){
    //   $("#filter_date_range").trigger('click');
    // }else {
    //   $(".filter_bulan").attr('disabled', false);
    //   $(".filter_tahun").attr('disabled', 'disabled');
    //   $(".filter_date_range").attr("disabled", 'disabled');
    // }

    
  })
  
  // $("#filter_bulan").click(function(){
  //     $('.filter_bulan').attr('disabled', false);
  //     $(".filter_tahun").attr('disabled', 'disabled');
  //     $(".filter_date_range").attr("disabled", 'disabled');
  // });
  // $("#filter_tahun").click(function(){
    
  //     $('.filter_bulan').attr("disabled", 'disabled');
  //     // $(".filter_bulan").prop('disabled', true);
  //     $(".filter_tahun").attr('disabled', false);
  //     $(".filter_date_range").attr("disabled", 'disabled');
  // });
  // $("#filter_date_range").click(function(){
  //     $('.filter_bulan').attr("disabled", 'disabled');
  //     $(".filter_tahun").attr('disabled', 'disabled');
  //     $(".filter_date_range").attr("disabled", false);
  // });

$("#rincian_penukaran_point").on('show.bs.modal', function(event){
    // var formatter = new Intl.NumberFormat('en-US', {style:'currency', 'currency':"IDR", currencyDisplay:'narrowSymbol'});
    if ( $.fn.DataTable.isDataTable('.table-rincian-penukaran-point') ) {
      $('.table-rincian-penukaran-point').DataTable().destroy();
    }
    var button = $(event.relatedTarget);
    var rincian_penukaran = button.data('rincian-penukaran');
    $(".table-body-rincian-penukaran-point").html("");
    rincian_penukaran.forEach(voucher => {
        $(".table-body-rincian-penukaran-point").append(`
            <tr>
                <td>
                    `+voucher.Date_card+`
                </td>
                <td>
                    `+voucher.Voucher_name+`
                </td>
                <td>
                    `+voucher.Point+`
                </td>
            </tr>
        `)
    });
    $(".table-rincian-penukaran-point").DataTable({ 'order' : [ ]});
 });

</script>
@endpush
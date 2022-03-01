@extends('layout.Master')

{{-- UNTUK SIDEBAR --}}
@section('menu_broadcast_pembeli')
  active
@endsection
{{-- ------------- --}}

@section('menu_broadcast')
   menu-open
@endsection


@section('title2')
    Broadcast
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Broadcast Pembeli</li>
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

@endpush


@section('Content')
  <div class="container-fluid">
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif
    {{Form::open(array('url'=>'broadcast_pembeli','method'=>'post','class'=>''))}}
    <div class="card">
        <div class="card-header">
            Filter
        </div>
        <div class="card-body">
            <div class="row ">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter" id="filter_produk" value="produk" checked>
                    <label class="form-check-label" for="filter_produk">
                      Pilih produk
                    </label>
                </div>
                <div class="col-12 ">
                    
                    @foreach ($product as $id_produk => $name)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input filter_produk" name="produk[]" type="checkbox" id="checkbox_{{$id_produk}}" value="{{$id_produk}}">
                        <label class="form-check-label" for="checkbox_{{$id_produk}}">{{$name}}</label>
                      </div>
                    @endforeach
                </div>
            </div>
            <div class="row mt-3 ">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter" id="filter_total_transaksi" value="total_transaksi">
                    <label class="form-check-label" for="filter_total_transaksi">
                        Total Transaksi
                    </label>
                </div>
                <div class="col-12 ">
                    <input type="number" name="total_transaksi" class="form-control filter_total_transaksi" id="" placeholder="0" required>
                </div>
            </div>
            <div class="row mt-3 ">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter" value="status_transaksi" id="filter_status_transaksi">
                    <label class="form-check-label" for="filter_status_transaksi">
                        Status Transaksi
                    </label>
                </div>
                <div class="col-12">
                    <select class="form-select form-control filter_status_transaksi" name="status_transaksi">
                        <option value="0">Cancelled</option>
                        <option value="1">Pending</option>
                        <option value="2">Payment receive</option>
                        <option value="3">Processing</option>
                        <option value="4">Shipping</option>
                        <option value="5">Complete</option>
                      </select>
                </div>
            </div>
        </div>
    </div>  
    <div class="card"}>
        <div class="card-body">
            <div class="col-md-6">
                {{ Form::label('Subject :','') }}
                {{ Form::text('subject', '', ['class'=>'form-control','id'=>'subject', 'placeholder' => "Subject", 'required' => 'required']) }}
              </div>
      
              <div class="col-md-12">
                {{ Form::label('Content :','') }}
                {{ Form::textarea('content', '', ['class'=>'form-control','id'=>'content', 'placeholder' => "content", 'required' => 'required']) }}
              </div>
        </div>
    </div>
      <div class="col-12">
        {{ Form::submit('Broadcast', ['class'=>'btn btn-primary btn-lg float-right']) }}
      
      </div>
    {{Form::close()}}
  </div>

@endsection

@push('custom-script')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script> 
  

  {{-- {{-- <!-- jQuery UI 1.11.4 --> --}}
  <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
      $(function() {
            $(".filter_produk").attr('disabled', false);
            $(".filter_total_transaksi").attr('disabled', 'disabled');
            $(".filter_status_transaksi").attr("disabled", 'disabled');
        });
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
  <!--End of Tawk.to Script-->

    <script>
        $("#filter_produk").click(function(){
            $(".filter_produk").attr('disabled', false);
            $(".filter_total_transaksi").attr('disabled', 'disabled');
            $(".filter_status_transaksi").attr("disabled", 'disabled');
        });
        $("#filter_total_transaksi").click(function(){
            $(".filter_produk").attr('disabled', 'disabled');
            $(".filter_total_transaksi").attr('disabled', false);
            $(".filter_status_transaksi").attr("disabled", 'disabled');
        });
        $("#filter_status_transaksi").click(function(){
            $(".filter_produk").attr('disabled', 'disabled');
            $(".filter_total_transaksi").attr('disabled', 'disabled');
            $(".filter_status_transaksi").attr("disabled", false);
        });
    </script>
@endpush
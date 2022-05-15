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
  <link rel="stylesheet" href="{{ asset ('assets/css/bootstrap-multiselect.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
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
                    <select class="filter_produk" id="" multiple="multiple" name="produk[]">
                        @foreach ($product as $id_produk => $name)
                        <option class="" value="{{$id_produk}}">{{$name}}</option>
                        @endforeach
                    </select>
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
    <div class="card">
        <div class="card-body">
            <div class="col-md-6">
                {{ Form::label('Subject :','') }}
                {{ Form::text('subject', '', ['class'=>'form-control','id'=>'subject', 'placeholder' => "Subject", 'required' => 'required']) }}
              </div>
      
              <div class="col-md-12">
                {{ Form::label('Content :','') }}
                {{ Form::textarea('content', '', ['class'=>'form-control','id'=>'summernote', 'placeholder' => "content", 'required' => 'required']) }}
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
  
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
      $(function() {
            $(".filter_produk").attr('disabled', false);
            $(".filter_total_transaksi").attr('disabled', 'disabled');
            $(".filter_status_transaksi").attr("disabled", 'disabled');

        });
  $.widget.bridge('uibutton', $.ui.button)
  </script>
  <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
  <script src="assets/js/popper.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.magnific-popup.min.js"></script>
  <script src="assets/js/isotope.pkgd.min.js"></script>
  <script src="assets/js/imagesloaded.pkgd.min.js"></script>
  <script src="assets/js/jquery.counterup.min.js"></script>
  <script src="assets/js/waypoints.min.js"></script>
  <script src="assets/js/ajax-mail.js"></script>
  <script src="assets/js/owl.carousel.min.js"></script>
  <script src="assets/js/plugins.js"></script>
  <script src="assets/js/main.js"></script>
  <script src ="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <!-- Include the plugin's CSS and JS: -->

    <script src ="{{ asset ('assets/js/jquery-2.2.4.min.js') }}"></script>

    <script src ="{{ asset ('assets/js/bootstrap.bundle-4.5.2.min.js') }}"></script>
    <script src ="{{ asset ('assets/js/bootstrap-multiselect.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $('.filter_produk').multiselect();
        $('#summernote').summernote();
        $("#filter_produk").click(function(){
            $('.filter_produk').multiselect('enable');
            $(".filter_total_transaksi").attr('disabled', 'disabled');
            $(".filter_status_transaksi").attr("disabled", 'disabled');
        });
        $("#filter_total_transaksi").click(function(){
            $('.filter_produk').multiselect('disable');
            // $(".filter_produk").prop('disabled', true);
            $(".filter_total_transaksi").attr('disabled', false);
            $(".filter_status_transaksi").attr("disabled", 'disabled');
        });
        $("#filter_status_transaksi").click(function(){
            $('.filter_produk').multiselect('disable');
            $(".filter_total_transaksi").attr('disabled', 'disabled');
            $(".filter_status_transaksi").attr("disabled", false);
        });
    </script>
@endpush
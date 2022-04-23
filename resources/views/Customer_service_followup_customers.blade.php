@extends('layout.Master')

{{-- UNTUK SIDEBAR --}}
@section('list_available_customer_atv')
  active
@endsection

@section('menu_master')
   menu-open
@endsection
{{-- ------------- --}}


@section('title2')
    List Available Customer
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">List Available Customer</li>
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

  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
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
            <div class="card">
                <div class="card-body">
                    {{Form::open(array('url'=>'list_available_customer/','method'=>'get','class'=>'row g-3'))}}
                    {{ Form::label('Jumlah Transaksi :','') }}
                    {{ Form::number('jum_transaksi', app('request')->input('jum_transaksi'), ['class'=>'form-control','id'=>'jumlah_transaksi', 'placeholder' => "0", 'required' => 'required']) }}
                    {{ Form::label('Lama Tidak Transaksi (dalam hari):','') }}
                    {{ Form::number('lama_tidak_transaksi', app('request')->input('lama_tidak_transaksi'), ['class'=>'form-control','id'=>'lama_tidak_transaksi', 'placeholder' => "0", 'required' => 'required']) }}
                    <br>
                    {{ Form::submit('Search', ['class'=>'btn btn-primary']) }}
                    {{Form::close()}}
                </div>
            </div>
        </div>  
    </div>
    <div class="row">
      <div class="col-md-12">
        <table id="table_id"  class='table table-striped display'>
          <thead>
            <tr>
              <td>Name</td>
              <td>Total Transaksi</td>
              <td>Lama Tidak Belanja</td>
              <td>Action</td>
            </tr>
          </thead>
          <tbody>
            @foreach ($available_customers as $customer)
                <tr>
                    <td>{{$customer->Username}}</td>
                    <td>{{$customer->total_transaksi}}</td>
                    <td>{{$customer->lama_tidak_belanja}} Hari</td>
                    <td>
                        {{ Form::button('Follow up email', ['name'=>'btn_edit','class'=>'btn btn-primary btn-sm ','data-idmember'=>$customer->Id_member,'data-toggle'=>'modal','data-target'=>'#followup_email']) }}
                    </td>
                    
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div id="followup_email" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Follow Up</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          {{Form::open(array('url'=>'followup/','method'=>'post','class'=>'row g-3'))}}
          <div class="col-md-12">
            {{ Form::textarea('follow_up_description', '', ['class'=>'form-control','id'=>'summernote', 'placeholder' => "Masukkan kata-kata", 'required' => 'required']) }}
            {{-- <input type="text" class="follow_up_description" name="follow_up_description" id="summernote"> --}}
            <input type="hidden" class="Id_member" name="Id_member">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          {{ Form::submit('Follow up', ['name'=>'closed_request_assist', 'class'=>'btn btn-primary btn-md float-right']) }}
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>



$('#summernote').summernote();

$("#followup_email").on('show.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var id = button.data('idmember');
    $(".Id_member").val(id);
 });
</script>
    
@endpush
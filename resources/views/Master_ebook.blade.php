@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('masterebook_atv')
  active
@endsection

@section('menu_master')
   menu-open
@endsection
{{-- ------------- --}}

@section('title2')
    Master Ebook
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Master Ebook</li>
@endsection


@section('title')
  Master Ebook
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
@endpush

@section('Content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <a href="{{ url('master_ebook/create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Insert</a>
      </div>
        
        <br>
        <br>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <table id="table_id" class='table table-striped display'>
          <thead>
            <tr>
              <th>Image</th> 
              <th>Title Ebook</th>
              <th>Sub-Category</th>
              <th>Action</th>
            </tr>
          </thead>
      
          <tbody>
            @foreach ($ebooks as $data)
            <tr>
              <td><img src="{{ asset('Uploads/Ebook/'.$data->Image )}}" width='150px' height='150px' class="center"> </td>
              <td>{{$data->Title}}</td>
              <td>{{$data->sub_category->Sub_category_name}}</td>
              <td>
                <a href="{{url('master_ebook/edit/' . $data->Id_ebook)}}" class="btn btn-warning btn-sm">Edit</a>
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{$data->Title}}', {{$data->Id_ebook}})">Delete</button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>    
      
    </div>
  </div>

  <!--ADD Modal -->
  <div class="modal fade" id="confirm_delete">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Insert Bank</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure to delete <label class="title-ebook"></label>
          {!! Form::hidden('id', '', ['class' => 'id_ebook']) !!}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button onclick="deleteebook()">Confirm</button>
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
<script>
  $(document).ready( function () {
    $('#table_id').DataTable({order: [],});
  } );
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
  <script>
    function deleteebook() 
    {
      let id = $(".id_ebook").val();

      window.location.href=`{!! url('master_ebook/delete/${id}') !!}`
    }
    function confirmDelete(title, id)
    {
      $(".title-ebook").html(title);
      $(".id_ebook").val(id);
      $("#confirm_delete").modal("show");
    }
  </script>
@endpush
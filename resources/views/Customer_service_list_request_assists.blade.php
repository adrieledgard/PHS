@extends('layout.Master')

{{-- UNTUK SIDEBAR --}}
@section('request_assist_atv')
  active
@endsection

@section('menu_master')
   menu-open
@endsection
{{-- ------------- --}}


@section('title2')
    List Request Assists
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Request Assists</li>
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
  <div class="container-fluid" style="height:100%;">
    <div class="row">
      <div class="col-md-12">
          <a href="{!! url('request_assist_add'); !!}">
            {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Insert',['class'=>'btn btn-primary','name'=>'btn_add']) }}
            {{-- <button class="btn btn-primary"><i class="fa fa-plus"></i> Insert</button> --}}
          </a>
        </div>
        
        <br>
        <br>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table id="table_id"  class='table table-striped display'>
          <thead>
            <tr>
              <td>Title</td>
              <td>Description</td>
              <td>Solved</td>
              <td>Status</td>
              <td>Actions</td>
            </tr>
          </thead>
          <tbody>
            @foreach ($tickets as $ticket)
              <tr>
                <td>{{$ticket->title}}</td>
                <td>{{$ticket->description}}</td>
                <td>{{$ticket->conclusion}}</td>
                @php
                    if($ticket->status == "OPEN"){
                      echo "<td><button type='button' class='btn btn-warning btn-sm'>$ticket->status</button></td>";
                    }
                    else if($ticket->status == "CLOSED"){
                      echo "<td><button type='button' class='btn btn-danger btn-sm'>$ticket->status</button></td>";
                    }
                @endphp
                <td>
                  <button class="btn btn-sm btn-warning" {{$ticket->status == "CLOSED" ? "disabled" : ""}} onclick="onEdit({{$ticket->id}})">Edit</button>
                  @php
                    if((session()->get('userlogin'))->Role == "ADMIN"){
                      if($ticket->status != "CLOSED"){
                          echo '<button type="button" class="btn btn-danger btn-sm" onclick="openModal(' . $ticket->id. ')">Closed</button>';
                        }
                    }
                      
                  @endphp
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div id="closedAssist" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Conclusion</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
          {{Form::open(array('url'=>'closed_request_assist/','method'=>'post','class'=>'row g-3'))}}
          <div class="col-md-12">
            {{ Form::label('conclusion :','') }}
            {{ Form::textarea('conclusion', '', ['class'=>'form-control','id'=>'conclusion', 'placeholder' => "Conclusion", 'required' => 'required']) }}
            {{ Form::hidden('id', '1', ['class' => 'ticket_id']) }}
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          {{ Form::submit('Update', ['name'=>'closed_request_assist', 'class'=>'btn btn-primary btn-md float-right']) }}
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
function openModal(id){
  $(".ticket_id").val(id);

  $("#closedAssist").modal();
}

function onEdit(id){
  window.location.href= `{!! url('request_assist_update/${id}') !!}`
}
</script>
    
@endpush
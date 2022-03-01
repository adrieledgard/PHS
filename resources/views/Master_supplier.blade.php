@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('mastersupplier_atv')
  active
@endsection

@section('menu_master')
   menu-open
@endsection
{{-- ------------- --}}

@section('title2')
    Master Supplier
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Master Supplier</li>
@endsection


@section('title')
  Master Supplier
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
        
        <a href="{!! url('master_supplier_add'); !!}">
          {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Insert',['class'=>'btn btn-primary','name'=>'btn_add']) }}
          {{-- <button class="btn btn-primary"><i class="fa fa-plus"></i> Insert</button> --}}
        </a>

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
              <th>Status</th> 
              <th>Supplier Name</th>
              <th>Supplier Email</th>
              <th>Supplier Phone</th>
              {{-- <th>Supplier Phone 2</th> --}}
              {{-- <th>Supplier Address</th>
              <th>Credit due date (day)</th> --}}
              <th>Action</th>
            </tr>
        </thead>
      
        <tbody>
          @foreach ($dtsupplier as $data)
          <tr>
            @php
            if($data->Status == 1)
            {
              echo "<td><button type='button' class='btn btn-success btn-sm' disabled>Active</button></td>";
            }
            else if($data->Status ==0)
            {
              echo "<td><button type='button' class='btn btn-danger btn-sm' disabled>Not Active</button></td>";
            }
            @endphp
            <td>{{$data->Supplier_name}}</td>
            <td>{{$data->Supplier_email}}</td>
            <td>{{$data->Supplier_phone1}} / {{$data->Supplier_phone2}}</td>
            {{-- <td>{{$data->Supplier_address}}</td>
            <td>{{$data->Credit_due_date}}</td> --}}
           
      
            <td>
              {{-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit_modal" data-cat="{{$data->Id_category}}">Edit</button> --}}
              {{-- {{ Form::button('Edit', ['name'=>'btn_edit','class'=>'btn btn-warning btn-sm ','data-cat'=>$data->Id_supplier,'data-toggle'=>'modal','data-target'=>'#edit_modal']) }} --}}
          
              <a href="{!! url('Master_supplier_detail/' .$data->Id_supplier); !!}">
                {{ Form::button('<i class="fa fa-edit" aria-hidden="true"></i> View / Edit',['class'=>'btn btn-warning btn-sm']) }}
        
              </a>
          
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
  <div class="modal fade" id="add_modal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Insert Supplier</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form class="" method='get' action='add_supplier'>
            @csrf
            <div class="modal-body">
              <div class="col-md-12">
                {{ Form::label('Supplier Name','') }}
                {{ Form::text('txt_supplier_name', '', ['class'=>'form-control']) }}
              </div>
              <div class="col-md-12">
                {{ Form::label('Supplier Email','') }}
                {{ Form::email('txt_supplier_email', '', ['class'=>'form-control']) }}
              </div>
              <div class="col-md-12">
                {{ Form::label('Supplier Phone 1','') }}
                {{ Form::number('txt_supplier_phone1', 0, ['class'=>'form-control']) }}
              </div>
              <div class="col-md-12">
                {{ Form::label('Supplier Phone 2','') }}
                {{ Form::number('txt_supplier_phone2', 0, ['class'=>'form-control']) }}
              </div>
              <div class="col-md-12">
                {{ Form::label('Supplier Address','') }}
                {{ Form::textarea('txt_supplier_address', '', ['class'=>'form-control']) }}
              </div>
              <div class="col-md-12">
                {{ Form::label('Credit due date','') }}
                {{ Form::number('txt_credit_due_date', '', ['class'=>'form-control']) }}
              </div>
              
              
            </div>
            <div class="modal-footer">
              {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
              {{ Form::submit('Insert', ['name'=>'add_supplier', 'class'=>'btn btn-primary']) }}
            </div>
        </form>
        <div class="container-fluid">
          
        </div>
      </div>
    </div>
  </div>


  <!--EDIT Modal -->
  <div class="modal fade" id="edit_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Supplier</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        {{Form::open(array('class'=>'','url'=>'edit_supplier','method'=>'get'))}}
        @csrf
        <div class="modal-body">
          <div class="col-md-12">
            {{ Form::hidden('txt_id_supplier', '', ['class'=>'form-control','id' =>'txt_id_supplier']) }}
            {{ Form::label('Supplier Name','') }}
            {{ Form::text('txt_supplier_name', '', ['class'=>'form-control','id' =>'txt_supplier_name']) }}
          </div>
          <div class="col-md-12">
            {{ Form::label('Supplier Email','') }}
            {{ Form::email('txt_supplier_email', '', ['class'=>'form-control','id'=>'txt_supplier_email']) }}
          </div>
          <div class="col-md-12">
            {{ Form::label('Supplier Phone 1','') }}
            {{ Form::number('txt_supplier_phone1', 0, ['class'=>'form-control','id'=>'txt_supplier_phone1']) }}
          </div>
          <div class="col-md-12">
            {{ Form::label('Supplier Phone 2','') }}
            {{ Form::number('txt_supplier_phone2', 0, ['class'=>'form-control','id'=>'txt_supplier_phone2']) }}
          </div>
          <div class="col-md-12">
            {{ Form::label('Supplier Address','') }}
            {{ Form::textarea('txt_supplier_address', '', ['class'=>'form-control','id'=>'txt_supplier_address']) }}
          </div>
          <div class="col-md-12">
            {{ Form::label('Credit due date','') }}
            {{ Form::number('txt_credit_due_date', 0, ['class'=>'form-control','id'=>'txt_credit_due_date']) }}
          </div>
          
          
          
        </div>
        <div class="modal-footer">
          {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
          {{ Form::submit('Edit', ['name'=>'edit_supplier', 'class'=>'btn btn-primary']) }}
        </div>
     {{ Form::close() }}
        <div class="container-fluid">
          
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
      $('#edit_modal').on('show.bs.modal', function(event){
    
    var button = $(event.relatedTarget);
    var id = button.data('cat');
    var modal = $(this);
    //modal.find('.modal-body #id_category').val(id);


    var myurl = "<?php echo URL::to('/'); ?>";

      $.get(myurl + '/getsupplier',
      {id: id},
      function(result){
      var arr = JSON.parse(result);
    
      // var nama ="";

      // for(var i =0;i< arr.length;i++)
      // {
      //   nama= arr[i]['Supplier_name'];
      // }
      // // $("#id_type").val(id);
      // $("#txt_supplier_name").val(nama);
      $("#txt_id_supplier").val(id);
      $("#txt_supplier_name").val(arr[0]['Supplier_name']);
      $("#txt_supplier_email").val(arr[0]['Supplier_email']);
      $("#txt_supplier_phone1").val(arr[0]['Supplier_phone1']);
      $("#txt_supplier_phone2").val(arr[0]['Supplier_phone2']);
      $("#txt_supplier_address").val(arr[0]['Supplier_address']);
      $("#txt_credit_due_date").val(arr[0]['Credit_due_date']);
      
      
      });

  })
    </script>
@endpush


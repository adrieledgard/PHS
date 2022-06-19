@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('mastervoucher_atv')
  active
@endsection

@section('menu_master')
   menu-open
@endsection
{{-- ------------- --}}

@section('title2')
    Master Voucher
    <br>
    {{-- <span style="font-size: 50%">Voucher(s) that have been claimed by customer cannot be deleted</span> --}}
    
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Master Voucher</li>
@endsection


@section('title')
  Master Voucher
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
      
      <a href="{!! url('master_voucher_add'); !!}">
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
            <th>Voucher Name</th>
            <th>Voucher Type</th>
            <th>Discount</th>
            <th>Redeem Due Date</th>
            <th>Action</th>
          </tr>
      </thead>
    
      <tbody>
        @foreach ($dtvoucher as $data)
            <tr>
              @php
              if($data->Status ==1) //Active //0 Deleted
              {
                echo "<td><button type='button' class='btn btn-success btn-sm' disabled>Active</button></td>";
              }
              else if($data->Status == 2) //Expire
              {
                echo "<td><button type='button' class='btn btn-danger btn-sm' disabled>Expire</button></td>";
              }
            
            

              //  echo "<td> <span class='label label-info'>Info Label</span></td>";
            @endphp
              <td>{{$data->Voucher_name}}</td>
              <td>{{$data->Voucher_type}}</td>
              <td>{{"Rp. ".number_format($data->Discount)}}
              <td>{{ date("d-m-Y", strtotime($data->Redeem_due_date)) }}</td>
              {{-- <td>{{$data->Redeem_due_date}}</td> --}}
              </td>
        
              <td>
                {{-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit_modal" data-cat="{{$data->Id_category}}">Edit</button> --}}
                {{-- {{ Form::button('Edit', ['name'=>'btn_edit','class'=>'btn btn-warning btn-sm ','data-cat'=>$data->Id_bank,'data-toggle'=>'modal','data-target'=>'#edit_modal']) }} --}}
               
               
                <a href="{!! url('Master_voucher_detail/' .$data->Id_voucher); !!}">
                  {{ Form::button('<i class="fa fa-edit" aria-hidden="true"></i> View / Edit',['class'=>'btn btn-warning btn-sm']) }}
          
                </a> 
                {{ Form::button('Delete', ['name'=>'btn_delete','class'=>'btn btn-danger btn-sm ','onclick'=>'deletevoucher('.$data->Id_voucher.')']) }}
              
              </td>
            </tr>
        @endforeach
        {{-- @foreach ($dtsupplier as $data) --}}
        {{-- <tr>
          <td>{{$data->Supplier_name}}</td>
          <td>{{$data->Supplier_email}}</td>
          <td>{{$data->Supplier_phone1}} / {{$data->Supplier_phone2}}</td>
          <td>
           
            <a href="{!! url('Master_supplier_detail/' .$data->Id_supplier); !!}"> --}}
              {{-- {{ Form::button('<i class="fa fa-edit" aria-hidden="true"></i> View / Edit',['class'=>'btn btn-warning btn-sm']) }} --}}
      
            {{-- </a>
        
          </td>
        </tr> --}}
        {{-- @endforeach --}}
      </tbody>
        
    
      </table>
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
       var myurl = "<?php echo URL::to('/'); ?>";
      function deletevoucher(Id_voucher)
      {
        swal({
        title: "Are you sure to Delete this?",
        text: '',
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          
          // alert(Id_voucher);
          $.get(myurl + '/delete_voucher',
          {Id_voucher:Id_voucher},
          function(result){
            if(result=="sukses")
            {
              toastr["success"]("Success to delete", "Delete");
              window.location = myurl + "/master_voucher/";
            }
          });


        } else {
        // swal("Cancelled");
        }
      });  
      }
    </script>
    
@endpush
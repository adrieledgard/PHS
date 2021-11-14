@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('masterteammember_atv')
  active
@endsection

@section('menu_master')
   menu-open
@endsection
{{-- ------------- --}}

@section('title2')
    Master Team Member
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Master Team Member</li>
@endsection


@section('title')
  Master Team Member
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
        {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Insert', ['class'=>'btn btn-primary','data-toggle'=>'modal','data-target'=>'#add_modal']) }}
      </div>
        
        <br>
        <br>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <table id='table_id' class='table table-striped display'>
          <thead>
            <tr>
              <th>STATUS</th>
              <th>USERNAME</th>
              <th>EMAIL</th>
              <th>PHONE</th>
              <th>ROLE</th>
              <th>ACTION</th>
            </tr>
          </thead>
      
          <tbody>
            @foreach ($dtteam_member as $data)
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
              <td>{{$data->Username}}</td>
              <td>{{$data->Email}}</td>
              <td>{{$data->Phone}}</td>
              <td>{{$data->Role}}</td>
              <td>
               
                {{ Form::button('Edit', ['name'=>'btn_edit','class'=>'btn btn-warning btn-sm ','data-team'=>$data->Id_member,'data-toggle'=>'modal','data-target'=>'#edit_modal']) }}
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
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Insert Team Member</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        {{Form::open(array('class'=>'','url'=>'add_team_member','method'=>'post'))}}
        {{-- <form class="row g-3" method='post' action='add_team_member'> --}}
          @csrf
          <div class="modal-body">
            <div class="col-md-12">
              {{ Form::label('Status :','') }}
              {{ Form::select('cb_status', ['Not Active','Active'], 'Kosong', ['placeholder'=>'Member status','class'=>'form-control', 'id'=>'cb_status' ]) }}
            </div>
            <div class="col-md-12">
              {{ Form::label('Username','') }}
              {{ Form::text('txt_username', '', ['class'=>'form-control']) }}
            </div>
            <div class="col-md-12">
              {{ Form::label('Email','') }}
              {{ Form::email('txt_email', '', ['class'=>'form-control']) }}
            </div>
            <div class="col-12">
              {{ Form::label('Phone','') }}
              {{ Form::number('txt_phone', '', ['class'=>'form-control']) }}
            </div>
            <div class="col-12">
              {{ Form::label('Password','') }}
              {{ Form::password('txt_password', array( "class" => "form-control")) }}
            </div>
            <div class="col-12">
              {{ Form::label('Password Confirmation','') }}
              {{ Form::password('txt_konpassword', array( "class" => "form-control")) }}
            </div>
            <div class="col-12">
              {{ Form::label('Role','') }}
              {{ Form::select('cb_role', array( 'ADMIN' => 'ADMIN', 'CUSTOMER SERVICE' => 'CUSTOMER SERVICE', 'SHIPPER' => 'SHIPPER'),null, ['Class' => 'form-control'])}}
            </div>
            
          </div>
          <div class="modal-footer">
            {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
            {{ Form::submit('Insert', ['name'=>'add_team_member', 'class'=>'btn btn-primary']) }}
          </div>
        {{Form::close()}}
        <div class="container-fluid">
          
        </div>
      </div>
    </div>
  </div>


  <!--EDIT Modal -->
  <div class="modal fade" id="edit_modal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Brand</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        {{Form::open(array('class'=>'','url'=>'edit_team_member','method'=>'post'))}}

        @csrf
        <div class="modal-body">
          <div class="col-md-12">
            {{-- {{ Form::hidden('stat', '', ['class'=>'form-control','id'=>'stat']) }} --}}
            {{-- @php
                $status = session()->get('IxEditMember');
            @endphp --}}
            {{ Form::label('Status :','') }}
            {{ Form::select('cb_status', ['Not Active','Active'], '', ['placeholder'=>'Member status','class'=>'form-control', 'id'=>'cb_status' ]) }}
          </div>
          <div class="col-md-12">
            {{ Form::hidden('Id_member', '', ['class'=>'form-control','id'=>'Id_member']) }}
            {{ Form::label('Username','') }}
            {{ Form::text('txt_username', '', ['class'=>'form-control', 'id'=>'txt_username']) }}
          </div>
          <div class="col-md-12">
            {{ Form::label('Email','') }}
            {{ Form::email('txt_email', '', ['class'=>'form-control', 'id'=>'txt_email']) }}
          </div>
          <div class="col-12">
            {{ Form::label('Phone','') }}
            {{ Form::number('txt_phone', '', ['class'=>'form-control','id'=>'txt_phone']) }}
          </div>
          <div class="col-12">
            {{ Form::label('Password','') }}
            {{ Form::password('txt_password', array( "class" => "form-control", 'id'=>'txt_password')) }}
          </div>
          <div class="col-12">
            {{ Form::label('Password Confirmation','') }}
            {{ Form::password('txt_konpassword', array( "class" => "form-control",'id'=>'txt_konpassword')) }}
          </div>
          <div class="col-12">
            {{ Form::label('Role','') }}
            {{ Form::select('cb_role', array( 'ADMIN' => 'ADMIN', 'CUSTOMER SERVICE' => 'CUSTOMER SERVICE', 'SHIPPER' => 'SHIPPER'),null, ['Class' => 'form-control','id'=>'cb_role'])}}
          </div>
          
        </div>
        <div class="modal-footer">
          {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
          {{ Form::submit('Edit', ['name'=>'edit_team_member', 'class'=>'btn btn-primary']) }}
        </div>
      {{Form::close()}}
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
    var id = button.data('team');
    var modal = $(this);
    modal.find('.modal-body #txt_username').val(id);


    var myurl = "<?php echo URL::to('/'); ?>";


      $.get(myurl + '/getteammember',
      {id: id},
      function(result){
      var arr = JSON.parse(result);

      var username ="";
      var email ="";
      var phone ="";
      var role ="";
      var status ="";
      // alert($status);
      for(var i =0;i< arr.length;i++)
      {
        username= arr[i]['Username'];
        email= arr[i]['Email'];
        phone = arr[i]['Phone'];
        role = arr[i]['Role'];
        status = arr[i]['Status'];
       

      }
    //  alert(status);
    //   $("#cb_status").val(status);
      $("#txt_username").val(username);
      $("#txt_email").val(email);
      $("#txt_phone").val(phone);
      $('#cb_role').val(role);
      $('#Id_member').val(id);
      });
      
      

      // foreach ($dtteam_member as $data)
      // $("#txt_username").val($data->Email);
      
      // endforeach


  })
    
    </script>
@endpush


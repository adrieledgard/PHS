@extends('layout.Master')

{{-- UNTUK SIDEBAR --}}
@section('masterproduct_atv')
  active
@endsection

@section('menu_master')
   menu-open
@endsection
{{-- ------------- --}}


@section('title2')
    Update Request Assist
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Update Request Assist</li>
@endsection


@section('title')
Update Request Assist
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
    
      @if(count($errors)>0)
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
          @endforeach
        </ul>
      </div>
      @endif
  
  
      @if (isset($msg))
        <div class="alert alert-success">
          <p>{{$msg}}</p>
        </div>
      @endif
  
  
  
      <div class="jumbotron">
       {{Form::open(array('url'=>'update_request_assist/' . $ticket->id,'method'=>'post','class'=>'row g-3'))}}
        <div class="col-md-12">
          {{ Form::label('Title :','') }}
          {{ Form::text('title', $ticket->title, ['class'=>'form-control','id'=>'title', 'placeholder' => "Title", 'required' => 'required']) }}
        </div>
        <div class="col-md-12">
          {{ Form::label('Platform Komunikasi :','') }}
          {{ Form::text('platform_komunikasi', $ticket->platform_komunikasi, ['class'=>'form-control','id'=>'platform_komunikasi', 'placeholder' => "Platform Komunikasi", 'required' => 'required']) }}
        </div>
        <div class="col-md-6">
          {{ Form::label('Email :','') }}
          {{ Form::email('email', $ticket->email, ['class'=>'form-control','id'=>'email', 'placeholder' => "email", 'required' => 'required']) }}
        </div>
        <div class="col-md-6">
          {{ Form::label('Phone :','') }}
          {{ Form::text('phone',  $ticket->phone, ['class'=>'form-control','id'=>'phone', 'placeholder' => "phone", 'required' => 'required']) }}
        </div>
        <div class="col-md-12">
          {{ Form::label('Description :','') }}
          {{ Form::textarea('description', $ticket->description, ['class'=>'form-control','id'=>'description', 'placeholder' => "Description", 'required' => 'required']) }}
        </div>
        <div class="col-md-12">
          {{ Form::label('Bukti Chat :','') }}
          {{ Form::textarea('bukti_chat', $ticket->bukti_chat, ['class'=>'form-control','id'=>'bukti_chat', 'placeholder' => "Copy dan paste bukti chat", 'required' => 'required']) }}
        </div>
        
      </div>
      <div class="col-12">
        {{ Form::submit('Update', ['name'=>'update_request_assist', 'class'=>'btn btn-primary btn-lg float-right']) }}
      
      </div>
    {{Form::close()}}
      
    
  </div><!-- /.container-fluid -->

@endsection



@push('custom-script')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script> 
  

    {{-- {{-- <!-- jQuery UI 1.11.4 --> --}}
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
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

@endpush


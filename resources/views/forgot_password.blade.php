<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Forgot Password (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  {{-- {{ asset('assets/plugins/fontawesome-free/css/all.min.css') }} --}}
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  {{-- <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css"> --}}
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
  {{-- <link rel="stylesheet" href="../../dist/css/adminlte.min.css"> --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<body class="hold-transition login-page">
<input type="hidden" class="csrf_token" value="{{csrf_token()}}">
<div class="login-box">
  @if(!empty($success))
    <div class="alert alert-success">
        {{ $success }}
    </div>
  @endif
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{URL::to('/')}}" class="h2"><b>Pusat Herbal Store</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
      
        <div class="input-group mb-3">
          <input type="email" class="form-control requested_email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="button" class="btn btn-primary btn-block button_send" onclick="request_otp()">Request OTP</button>
          </div>
          <!-- /.col -->
        </div>
        {{Form::open(array('url'=>'ganti_password','method'=>'post',))}}
        <div class="row">
          <div class="col-md-12">
            <input type="password" class="form-control" placeholder="New password" name="new_password">
            @error('new_password')
              <div class="err" style="color:red; font-size: 10px;">
                  {{$message}}
              </div>
        
            @enderror

          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <input type="password" class="form-control" placeholder="Confirmation password"  name="kon_new_password">
            @error('kon_new_password')
              <div class="err" style="color:red; font-size: 10px;">
                  {{$message}}
              </div>
        
            @enderror

          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <input type="number" class="form-control" placeholder="OTP" name="kode_otp">
            @error('kode_otp')
              <div class="err" style="color:red; font-size: 10px;">
                  {{$message}}
              </div>
        
            @enderror

          </div>
        </div>
        {{ Form::submit('Ubah', ['name'=>'add_request_assists', 'class'=>'btn btn-primary btn-sm']) }}
        {{-- {{ Form::text('txt_option_name_add_detail', 'ada', ['class'=>'form-control','id'=>'txt_option_name_add_detail']) }} --}}
        {{Form::close()}}
      <p class="mt-3 mb-1">
        
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
{{-- <script src="../../plugins/jquery/jquery.min.js"></script> --}}
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{-- <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
<!-- AdminLTE App -->
{{-- <script src="../../dist/js/adminlte.min.js"></script> --}}
<link rel="stylesheet" href="{{ asset('assets/dist/js/adminlte.min.js') }}">
<script src ="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
  function request_otp() {
    $(".button_send").attr('disabled', true)
    var myurl = "<?php echo URL::to('/'); ?>";
    var token = $(".csrf_token").val();
    var email = $(".requested_email").val();
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': token
      }
    });

    $.post(myurl + '/request_otp',
    {Email: email, CSRF: token},
    function(result){
      if(result == 'sukses'){
        toastr["success"]("Kode OTP sudah dikirim. Silahkan cek email anda", "Success");
      }else if(result == 'email_tidak_terdaftar'){
        toastr["error"]("Email tidak terdaftar", "Error");
      }
        
    });
    setTimeout(() => {
      $(".button_send").attr('disabled', false);
    }, 15000);
  }
</script>

</body>
</html>

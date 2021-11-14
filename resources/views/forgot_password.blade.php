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
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="" class="h2"><b>Pusat Herbal Store</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
      <form action="recover-password.html" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request OTP</button>
          </div>
          <!-- /.col -->
        </div>

        {{-- {{ Form::text('txt_option_name_add_detail', 'ada', ['class'=>'form-control','id'=>'txt_option_name_add_detail']) }} --}}
      </form>
      <p class="mt-3 mb-1">
        <a href="login.html">Login</a>
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
</body>
</html>

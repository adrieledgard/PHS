@extends('layout_frontend.Master')


@push('custom-css')

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="{{ asset ('css/register-login/register-login.css') }}" rel="stylesheet" type="text/css"> 

@endpush




@section('Content')
{{-- kalau transaksi penjualan cek promo masih berlaku gak --}}
<div class="login-reg-panel">
   
    <div class="login-info-box">
        <h2>Have an account?</h2>
        <label id="label-register" for="log-reg-show">Login</label>
        <input type="radio" name="active-log-panel" id="log-reg-show"  >
        {{-- checked="checked" --}}
    </div>
                        
    <div class="register-info-box">
        <h2>Don't have an account?</h2>
        <label id="label-login" for="log-login-show">Register</label>
        <input type="radio" name="active-log-panel" id="log-login-show" >
    </div>
                        
    <div class="white-panel">
        <div class="login-show">
            <div class="row">
                <h2><b>LOGIN</b></h2>
            </div>
            <br>
            <form class="row g-3" method='post' action='loginProcess'>
                {{-- {{Form::open(array('class'=>'row g-3','url'=>'loginProcess','method'=>'post'))}}
                --}}
                @csrf
               
                <div class="row">
                    <div class="col-md-12">
                        @error('txt_username_email')
                        <div class="err" style="color:red; font-size: 10px;">
                            {{$message}}
                        </div>
                  
                        @enderror

                        @php
                            $msgerror = "";
                            if($errors->any()){
                                foreach ($errors->all() as $error) {
                                $msgerror = $error;
                                }
                            }
                        @endphp


                    {{ Form::text('txt_username_email', '', ['placeholder'=>'Username/Email','id'=>'input_sub']) }}
                    </div>

                    <div class="col-md-12">
                        @error('txt_password')
                        <div class="err" style="color:red; font-size: 10px;">
                            {{$message}}
                        </div>
                  
                        @enderror
                    {{ Form::password('txt_password', array('placeholder'=>'Password','id'=>'input_sub')) }}
                    </div>
                    <div class="col-md-12">
                        {{ Form::submit('Login', ['name'=>'login', 'id'=>'btn_sub']) }}
                    </div>
                    
                    {{-- <input type="submit" class="btn btn-primary" name="login" value="login"> --}}
                </div>
                
                {{-- {{Form::close()}} --}}
            </form>

            <div class="row">
                <div class="col-md-12 float-right">
                    <a href="{!! url('forgot_password'); !!}" class="float-right">Forgot password?</a>
                </div>
            </div>
            
        </div>
        <div class="register-show">
            <div class="row">
                <h2><b>REGISTER</b></h2>
            </div>
            <form class="row g-3" method='post' action='registerProcess'>
                {{-- {{Form::open(array('class'=>'row g-3','url'=>'loginProcess','method'=>'post'))}}
                --}}
                @csrf
               
                <div class="row">
                    <div class="col-md-12">
                        @error('txt_username')
                        <div class="err" style="color:red; font-size: 10px;">
                            {{$message}}
                        </div>
                  
                        @enderror
                        {{ Form::text('txt_username', '', ['placeholder'=>'Username','id'=>'input_sub']) }}
                    </div>

                    <div class="col-md-7">
                        @error('txt_email')
                        <div class="err" style="color:red; font-size: 10px;">
                            {{$message}}
                        </div>
                  
                        @enderror
                        {{ Form::text('txt_email', '', ['placeholder'=>'Email','id'=>'input_sub']) }}
                    </div>

                    <div class="col-md-5">
                        @error('txt_phone')
                        <div class="err" style="color:red; font-size: 10px;">
                            {{$message}}
                        </div>
                  
                        @enderror
                        {{ Form::text('txt_phone', '', ['placeholder'=>'Phone','id'=>'input_sub']) }}
                    </div>

                    <div class="col-md-6">
                        @error('txt_password_regist')
                        <div class="err" style="color:red; font-size: 10px;">
                            {{$message}}
                        </div>
                  
                        @enderror
                        {{ Form::password('txt_password_regist', array('placeholder'=>'Password','id'=>'input_sub')) }}
                    </div>

                    <div class="col-md-6">
                        @error('txt_konpassword')
                        <div class="err" style="color:red; font-size: 10px;">
                            {{$message}}
                        </div>
                  
                        @enderror
                        {{ Form::password('txt_konpassword', array('placeholder'=>'Password Confirmarion','id'=>'input_sub')) }}
                    </div>

                    <div class="col-md-12">
                        {{ Form::submit('Register', ['name'=>'register', 'id'=>'btn_sub']) }}
                    </div>
                    
                    {{-- <input type="submit" class="btn btn-primary" name="login" value="login"> --}}
                </div>
                
                {{-- {{Form::close()}} --}}
        </div>
    </div>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>



@endsection


@push('custom-js')

<script>
    $(document).ready(function(){

      $('.login-info-box').fadeOut();
      $('.login-show').addClass('show-log-panel');


  });

  var temp = "<?php echo $msg; ?>";  //non validate
  var msgerror = "<?php echo $msgerror ?>"; //validate
  if(msgerror != "")
  {
    toastr["error"](msgerror, "Failed");
  }
  else if(temp != "")
  {
    toastr["error"](temp, "Failed");
  }
  
</script>
<script src ="{{ asset ('js/register-login/register-login.js') }}"></script>

@endpush








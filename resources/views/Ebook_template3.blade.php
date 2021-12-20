<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>{{ $ebook->Title }}</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
    <link rel="shortcut icon" href="favicon.ico"> 
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:700|Roboto:400,400i,700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome JS-->
    <script defer src="{{ asset('assets/fontawesome/js/all.min.js') }}"></script>

    <!-- Theme CSS -->  
    <link id="theme-style" rel="stylesheet" href="{{ asset('assets/css/ebook_template_theme.css') }}">

</head> 

<body>    
    <header class="header">	    
        <div class="branding">
            <div class="container-fluid position-relative py-3">
                <div class="logo-wrapper">
	                <div class="site-logo"><a class="navbar-brand" href="index.html"><img class="logo-icon me-2" src="{{ asset('assets/img/logo/2.png') }}" alt="logo" ></a></div>    
                </div><!--//docs-logo-wrapper-->
	        
            </div><!--//container-->
        </div><!--//branding-->
    </header><!--//header-->
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif
    <section class="hero-section">
	    <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 pt-5 mb-5 align-self-center" style="text-align: center">
                    <h1 class="headline mb-3">
                        {{ $ebook->Title }} 
                    </h1><!--//headline-->
                </div>
            </div>
		    <div class="row">
			    <div class="col-12 col-md-7 pt-5 mb-5 align-self-center">
				    <div class="promo pe-md-3 pe-lg-5">
					    <div class="subheadline mb-4">
						    {{ $ebook->Content }}
					    </div><!--//subheading-->
				    </div><!--//promo-->
			    </div><!--col-->
			    <div class="col-12 col-md-5 mb-5 align-self-center">
				    <div class="book-cover-holder">
					    <img class="img-fluid book-cover" src="{{ asset("Uploads/Ebook/$ebook->Image")  }}" alt="book cover" style="height:600px !important; width:450px !important">
				    </div><!--//book-cover-holder-->
			    </div><!--col-->
		    </div><!--//row-->
	    </div><!--//container-->
    </section><!--//hero-section-->
    
    <section id="form-section" class="form-section">
	    <div class="container">
		    <div class="lead-form-wrapper single-col-max mx-auto theme-bg-light rounded p-5">
			    <div class="form-wrapper mx-auto">		
                    {{Form::open(array('url'=>"master_ebook/$ebook->Id_ebook/email_submitted/$user_token",'method'=>'post','class'=>'signup-form row g-2 align-items-center'))}}			
	                    <div class="col-12 col-lg-12">
                            {{ Form::text('name', '', ["required" => "required",  "class" => "form-control me-md-1 semail", "placeholder" => "Your Name"]) }}
	                    </div>
	                    <div class="col-12 col-lg-12">
                            {{ Form::text('phone', '', ["required" => "required",  "class" => "form-control me-md-1 semail", "placeholder" => "Your Phone Number"]) }}
	                    </div>
	                    <div class="col-12 col-lg-12">
                            {{ Form::email('email', '', ["required" => "required",  "class" => "form-control me-md-1 semail", "placeholder" => "Your Email"]) }}
	                    </div>
	                    <div class="col-12 col-lg-12">
	                        <button type="submit" class="btn btn-primary btn-submit w-100">{{ $ebook->Call_to_action }}</button>
	                    </div>
	                </form><!--//signup-form-->
			    </div><!--//form-wrapper-->
		    </div><!--//lead-form-wrapper-->
	    </div><!--//container-->
    </section><!--//form-section-->
    
       
    <!-- Javascript -->          
    <script src="{{ asset('assets/ebook_assets/popper.min.js')}}"></script>
    <script src="{{ asset('assets/ebook_assets/bootstrap/js/bootstrap.min.js') }}"></script> 
    <script src="{{ asset('assets/ebook_assets/smoothscroll.min.js') }}"></script> 
    
    <script src="{{ asset('assets/js/ebook_template.js') }}"></script>

</body>
</html> 


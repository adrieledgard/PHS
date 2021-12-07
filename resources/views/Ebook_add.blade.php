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
    Add Ebook
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Add Ebook</li>
@endsection


@section('title')
  Add Ebook
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
       {{Form::open(array('url'=>'master_ebook/store','method'=>'post','class'=>'row g-3', 'files' => true))}}
        <div class="col-md-6">
          {{ Form::label('Title :','') }}
          {{ Form::text('title', '', ['class'=>'form-control','id'=>'title', 'placeholder' => "Title", 'required' => 'required']) }}
        </div>
        <div class="col-md-6">
          {{ Form::label('Sub Category :','') }}
          {{ Form::select('sub_catgory', $sub_category, '',['class'=>'form-control','id'=>'title', 'placeholder' => "Sub Category", 'required' => 'required']) }}
        </div>
        <div class="col-md-6">
          {{ Form::label('Call to Action :','') }}
          {{ Form::text('call_to_action', '', ['class'=>'form-control','id'=>'call_to_action', 'placeholder' => "Call to action", 'required' => 'required']) }}
        </div>
        <div class="col-md-12">
          {{ Form::label('Content :','') }}
          {{ Form::textarea('content', '', ['class'=>'form-control','id'=>'content', 'placeholder' => "content", 'required' => 'required']) }}
        </div>
        <div class="col-md-6">
          {{ Form::label('Image :','') }}
          {{ Form::file('image', ['id' => 'image_upload'])}}
          <button type="button" onclick="readURL();">Preview</button>
        </div>
        <div class="col-md-6">
          {{ Form::label('PDF :','') }}
          {{ Form::file('pdf', ['id' => 'pdf_upload'])}}
          <button type="button" onclick="previewPDF();">Preview</button>
        </div>
        <div class="col-md-12">
          {{ Form::label('Template :','') }}
          {{Form::radio('id_template', '1', true)}} Template 1
          {{Form::radio('id_template', '2', false)}} Template 2
          {{Form::radio('id_template', '3', false)}} Template 3
          <br>
          {{Form::button("Preview Selected Template", ["onclick" => "previewTemplate()", "class" => "btn btn-secondary btn-sm"])}}
        </div>
      </div>
      <div class="col-12">
        {{ Form::submit('Insert', ['name'=>'add_request_assists', 'class'=>'btn btn-primary btn-lg float-right']) }}
      
      </div>
    {{Form::close()}}
      
    
  </div><!-- /.container-fluid -->

  <div class="modal fade" id="preview_pdf" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Preview PDF</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <embed 
          
          class="embed_pdf"
          style="width:100%; height:100vh">
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="preview_image" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Preview Image</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <embed 
          
          class="embed_image"
          style="width:100%; height:100vh">
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="preview_template1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Preview Template 1</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row"  style=" text-align:center">
            <div class="col-md-12">
              <div style="width: 100%; height:200px; border:1px solid black; display:block; margin-left:auto; margin-right:auto">
                PICTURE
              </div>
            </div>
          </div>
          <div class="row"  style=" text-align:center">
            <div class="col-md-12 mt-3">
              <div style="width: 100%; height:50px; border:1px solid black; display:block; margin-left:auto; margin-right:auto;">
                TITLE
              </div>
            </div>
          </div>
          <div class="row"  style=" text-align:center">
            <div class="col-md-12 mt-3">
              <div style="width: 100%; height:150px; border:1px solid black; display:block; margin-left:auto; margin-right:auto;">
                CONTENT
              </div>
            </div>
          </div>
          <div class="row"  style=" text-align:center">
            <div class="col-md-12 mt-3">
              <div style="width: 100%; height:100px; border:1px solid black; display:block; margin-left:auto; margin-right:auto;">
                SUBMIT EMAIL
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="preview_template2" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Preview Template 2</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row"  style=" text-align:center">
            <div class="col-md-12">
              <div style="width: 100%; height:50px; border:1px solid black; display:block; margin-left:auto; margin-right:auto;">
                TITLE
              </div>
            </div>
          </div>
          <div class="row  mt-3"  style=" text-align:center">
            <div class="col-md-12">
              <div style="width: 100%; height:200px; border:1px solid black; display:block; margin-left:auto; margin-right:auto">
                PICTURE
              </div>
            </div>
          </div>
          <div class="row"  style=" text-align:center">
            <div class="col-md-12 mt-3">
              <div style="width: 100%; height:150px; border:1px solid black; display:block; margin-left:auto; margin-right:auto;">
                CONTENT
              </div>
            </div>
          </div>
          <div class="row"  style=" text-align:center">
            <div class="col-md-12 mt-3">
              <div style="width: 100%; height:100px; border:1px solid black; display:block; margin-left:auto; margin-right:auto;">
                SUBMIT EMAIL
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="preview_template3" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Preview Template 3</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row"  style=" text-align:center">
            <div class="col-md-12">
              <div style="width: 100%; height:50px; border:1px solid black; display:block; margin-left:auto; margin-right:auto;">
                TITLE
              </div>
            </div>
          </div>
          <div class="row  mt-3"  style=" text-align:center">
            <div class="col-md-6">
              <div style="width: 100%; height:150px; border:1px solid black; display:block; margin-left:auto; margin-right:auto;">
                CONTENT
              </div>
            </div>
            <div class="col-md-6">
              <div style="width: 100%; height:150px; border:1px solid black; display:block; margin-left:auto; margin-right:auto">
                PICTURE
              </div>
            </div>
          </div>
          <div class="row"  style=" text-align:center">
            <div class="col-md-12 mt-3">
              <div style="width: 100%; height:100px; border:1px solid black; display:block; margin-left:auto; margin-right:auto;">
                SUBMIT EMAIL
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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

    <script>
      function previewTemplate() {
        let template = $('input[name="id_template"]:checked').val();
        $("#preview_template" + template).modal("show");
      }

      function readURL() {
        let input = document.getElementById('image_upload');
        
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            $('.embed_image').attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
          
        }
        $("#preview_image").modal("show");
      }

      function previewPDF() {
        let input = document.getElementById('pdf_upload');
        
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            console.log( e.target.result);
            $('.embed_pdf').attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
          
        }
        $("#preview_pdf").modal("show");
      }
    </script>
@endpush


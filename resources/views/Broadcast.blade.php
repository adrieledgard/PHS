@extends('layout.Master')

{{-- UNTUK SIDEBAR --}}
@section('menu_broadcast_prospek')
  active
@endsection
{{-- ------------- --}}

@section('menu_broadcast')
   menu-open
@endsection


@section('title2')
    Broadcast Prospek
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Broadcast Prospek</li>
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
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
@endpush


@section('Content')
  <div class="container-fluid">
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif
  
      <div class="jumbotron">
       {{Form::open(array('url'=>'broadcast','method'=>'post','class'=>'row g-3'))}}
        <div class="col-md-6">
          {{ Form::label('Subject :','') }}
          {{ Form::text('subject', '', ['class'=>'form-control','id'=>'subject', 'placeholder' => "Subject", 'required' => 'required']) }}
        </div>
        <div class="col-md-6">
          {{ Form::label('product :','') }}
          <input type="hidden" name="product" class="product">
          <button type="button" class="form-control product_name" data-toggle="modal" data-product="{{$product}}" data-target="#modal-product">Select Product</button>
          {{-- {{ Form::select('product', $product, '',['class'=>'form-control','id'=>'product', 'placeholder' => "Product", 'required' => 'required']) }} --}}
        </div>
        <div class="col-md-12">
          {{ Form::label('Content :','') }}
          {{ Form::textarea('content', '', ['class'=>'form-control','id'=>'summernote', 'placeholder' => "content", 'required' => 'required']) }}
        </div>
      </div>
      <div class="col-12">
        {{ Form::submit('Insert', ['name'=>'add_request_assists', 'class'=>'btn btn-primary btn-lg float-right']) }}
      
      </div>
    {{Form::close()}}
  </div>
  <div class="modal fade" id="modal-product">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Product</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <br>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <table class='table table-striped display table_id'>
                <thead>
                  <tr>
                    <th width='150px'>Image</th>
                    <th>Product Name</th>
                    <th>Brand</th>
                    <th>Type</th>
                    <th>Variation</th>
                    <th>Action</th>
                  </tr>
              </thead>
            
              <tbody id="modal-body-product">
                
              </tbody>
                
            
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
  <!--End of Tawk.to Script-->
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
  <script>
    $('#summernote').summernote();

    $('#modal-product').on('show.bs.modal', function(event){
      if ( $.fn.DataTable.isDataTable('.table_id') ) {
         $('.table_id').DataTable().destroy();
       }
      var button = $(event.relatedTarget);
      var products = button.data('product');
      var modal = $(this);
      
      $("#modal-body-product").html("");
      products.forEach(product => {

        $("#modal-body-product").append(`
          <tr>
            <td><img src="${product.url_image}" width='150px' height='150px' class='center'></img></td>
            <td>${product.Name}</td>
            <td>${product.Brand_name}</td>
            <td>${product.Type_name}</td>
            <td>${product.vari2}</td>
            <td><button class="btn btn-sm btn-warning" onclick="select_product('${product.Name}', ${product.Id_product})">Select</button></td>
          </tr>
        `)
      });
      $(".table_id").DataTable();
    })

    function select_product(product_name, product_id) {
      $(".product").val(product_id);
      $(".product_name").html(product_name);

      $("#modal-product .close").click();
    }
  </script>

@endpush
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
    Master Product
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Master Product</li>
@endsection


@section('title')
  Master Product
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

  <style>
    #variationdetail
    {
      color: black;
      font-style: italic;
      font-size: 85%;
    }
  </style>
@endpush


@section('Content')
<input type="hidden" class="csrf_token" value="{{csrf_token()}}">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <a href="{!! url('master_product_add'); !!}">
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
              <th>Image</th>
              <th>Product Name</th>
              <th>Brand</th>
              <th>Type</th>
              <th>Variation</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
        </thead>
      
        <tbody>
          @foreach ($dtproduct as $data)
          <tr>
            @php
                $imgname = "default.jpg";
            @endphp
            @foreach ($dtproductimage as $img)
                @php
                  $idp = $data->Id_product;
                  $idi = $img->Id_product;
                  $urutan = $img->Image_order;
                  
                  if (($idp == $idi) && ($urutan==1))
                  {
                    $imgname = $img->Image_name;
                  }
                @endphp
            @endforeach
            <td width='150px'>
              <img src="{{ asset('Uploads/Product/'.$imgname )}}" width='150px' height='150px' class="center"> 
            </td>
            <td>{{$data->Name}}</td>
            <td>{{$data->Brand_name}}</td>
            <td>{{$data->Type_name}}</td>
            <td>
              @php
                $vari="";
                $vari2="";
                if($data->Variation == "NONE")
                {

                }
                else
                {
                  foreach ($dtvariationname as $datavar) {
                    if($datavar->Id_product == $data->Id_product)
                    {
                      $vari.=$datavar->Option_name." , ";
                    }
                  }
                  $vari2=substr($vari,0,-2);
                }
              @endphp

              {{$data->Variation}}

              <p id="variationdetail">
                @php
                  if($vari2!="")
                  {
                    echo "( ".$vari2.")";
                  }
                    
                @endphp
              </p>
            
            
            </td>
            <td>{{$data->status_user}}</td>
      
            <td>
              <a href="{!! url('Master_product_detail/' .$data->Id_product); !!}">
                {{ Form::button('<i class="fa fa-edit" aria-hidden="true"></i> View / Edit',['class'=>'btn btn-warning btn-sm']) }}
        
              </a>
              <br><br>
              <a href="{!! url('Master_product_images/' .$data->Id_product); !!}">
                {{ Form::button('<i class="fa fa-camera" aria-hidden="true"></i> Images',['class'=>'btn btn-info btn-sm']) }}
              </a>
              <br><br>
              {{ Form::button('Rating/Review', ['name'=>'btn_edit','class'=>'btn btn-info btn-sm ','data-rating'=>$data->rating,'data-toggle'=>'modal','data-target'=>'#rating']) }}
            </td>
          </tr>
          @endforeach
        </tbody>
          
      
        </table>
      </div>
    </div>    
      
    </div>
  </div><!-- /.container-fluid -->
  <div id="rating" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Rating dan Review</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <table class="table-rating-review">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-body-rating-review">
                    
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
      $("#rating").on('show.bs.modal', function(event){
        if ($.fn.DataTable.isDataTable('.table-rating-review') ) {
          $('.table-rating-review').DataTable().destroy();
        }
        var button = $(event.relatedTarget);
        var daftar_rating = button.data('rating')
        $(".table-body-rating-review").html("");
        daftar_rating.forEach(rating => {
            var disable = rating.Status == 'Deleted' ? "disabled" : "";
            var bintang = "";
            for(var i =1; i <= 5; i++){
              if(i <= Math.floor(rating.Rate)){
                bintang += '<i class="fas fa-star"></i>';
              }else {
                bintang += '<i class="far fa-star"></i>'
              }
            }
            $(".table-body-rating-review").append(`
                <tr>
                    <td>
                        `+rating.Username+`
                    </td>
                    <td>
                        `+bintang+`
                    </td>
                    <td>
                        `+rating.Review+`
                    </td>
                    <td>
                        `+rating.Status+`
                    </td>
                    <td>
                      <button class="btn btn-sm btn-danger" onclick="delete_rating(`+rating.Id_product+`, `+rating.id+` )" ${disable}>Hapus</button>
                    </td>
                </tr>
            `)
        });
        $(".table-rating-review").DataTable()
    });

    function delete_rating(Id_product, Id_rating)
    {
      swal({
            title: "Are you sure to delete this?",
            text: "",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              var token = $(".csrf_token").val();
              $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
              });
              var myurl = "<?php echo URL::to('/'); ?>";
              $.post(myurl + '/hapus_rating_product',
              {Id_product:Id_product, Id_rating: Id_rating},
                function(result){
                  location.reload();
                });

            } else {
            }
          });  


    
    }
    </script>
@endpush


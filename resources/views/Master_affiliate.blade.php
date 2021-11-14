@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('masteraffiliate_atv')
  active
@endsection

@section('menu_master')
   menu-open
@endsection
{{-- ------------- --}}

@section('title2')
    Master Affiliate <br> edit? delete?
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Master Affiliate</li>
@endsection


@section('title')
  Master Affiliate
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
    @php
    $msgerror = "";
    if($errors->any()){
      foreach ($errors->all() as $error) {
        $msgerror = $error;
      }
    }
    @endphp

    {{-- <div class="row">
      <div class="col-md-12">
        {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Insert', ['class'=>'btn btn-primary','data-toggle'=>'modal','data-target'=>'#add_modal']) }}
      </div>
        
        <br>
        <br>
    </div>
    <br> --}}
    <div class="row">
      <div class="col-md-12">
        <table id="table_id" class='table table-striped display'>
          <thead>
            <tr>
              <th>Status</th>
              <th>Image</th>
              <th>Product</th>
              {{-- <th>Poin</th> --}}
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


            @php
              $affiliate = 0;
              $poin=0;
            @endphp
            @foreach ($dtaffiliate as $aff)
              @php
                $idp = $data->Id_product;
                $ida = $aff->Id_product;
                if (($idp == $ida) && $aff->Status == 1)
                {
                  $affiliate = 1;
                }
               if($idp == $ida)
                {
                  $poin = $aff->Poin;
                }
              @endphp
             @endforeach
            
          <?php

                if($affiliate==1)
                {
                  ?>
                    <td><button type='button' class='btn btn-success btn-sm' disabled>Active</button></td>

                  <?php
                }
                else {
                  ?>
                    <td><button type='button' class='btn btn-danger btn-sm' disabled>Non-Active</button></td>

                  <?php
                }

          ?>


          <td width='150px'>
            <img src="{{ asset('Uploads/Product/'.$imgname )}}" width='150px' height='150px' class="center"> 
          </td>



          {{-- @php
          $type = 0;
          @endphp
          @foreach ($dtaffiliate as $aff)
            @php
              $idp = $data->Id_product;
              $ida = $aff->Id_product;
              if (($idp == $ida))
              {
                $affiliate = 1;
              }
            @endphp
          @endforeach --}}
          <td>
            <b>{{$data->Name}}</b> <br>
            Type:
            {{$data->Type_name}} <br>
            Brand:
            {{$data->Brand_name}} <br>

          </td>

          {{-- <td>
            {{number_format($poin)}}
          </td> --}}
      
            <td>
            
              {{ Form::button('Edit', ['name'=>'btn_edit','class'=>'btn btn-warning btn-sm ','data-cat'=>$data->Id_product,'data-toggle'=>'modal','data-target'=>'#edit_modal']) }}
              {{-- {{ Form::button('Delete', ['name'=>'btn_delete','class'=>'btn btn-danger btn-sm ','onclick'=>'deleteaffiliate('.$data->Id_affiliate.')']) }} --}}
            </td>
          </tr>
          @endforeach
        </tbody>
          
      
        </table>
      </div>
    </div>    
      
    </div>
  </div>




  <!--EDIT Modal -->
  <div class="modal fade" id="edit_modal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Affiliate</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        {{Form::open(array('class'=>'','url'=>'edit_affiliate','method'=>'post'))}}
        @csrf
        {{-- <form class="" method='post' action='edit_affiliate'>
          @csrf --}}
          <div class="modal-body">
            <div class="col-md-6">
              {{ Form::hidden('Id_product', '', ['class'=>'form-control','id'=>'Id_product']) }}
              {{ Form::label('Status :','') }}
              {{ Form::select('cb_status', ['Not Active','Active'], 'Kosong', ['placeholder'=>'Product status','class'=>'form-control', 'id'=>'cb_status' ]) }}
            
<br><br>
              {{ Form::label('Poin :','') }}



              <span id="isi-variasi">

              </span>

                {{-- {{ Form::number('txt_poin', 0, ['class'=>'form-control','id'=>'txt_poin']) }} --}}
            
            </div>
            
          </div>
          <div class="modal-footer">
            {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
            {{ Form::submit('Edit', ['name'=>'edit_affiliate', 'class'=>'btn btn-primary']) }}
          </div>
        {{ Form::close() }}
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
    var Id_product = button.data('cat');
    var modal = $(this);
    //modal.find('.modal-body #id_category').val(id);


    var myurl = "<?php echo URL::to('/'); ?>";
      // alert(Id_product);
      $("#Id_product").val(Id_product);
      $.get(myurl + '/getaffiliatedata',
      {Id_product: Id_product},
      function(result){
        var cut = result.split("#");
      $("#cb_status").val(cut[0]);
      $("#isi-variasi").html(cut[1]);
     



      });

  })
    
    </script>


<script>
  var myurl = "<?php echo URL::to('/'); ?>";
  function deletetype(id)
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
    
    $.get(myurl + '/delete_type',
    {Id_type:id},
    function(result){
      if(result=="sukses")
      {
        toastr["success"]("Success to delete", "Delete");
        window.location = myurl + "/master_type/";
      }
      else if(result=="producterror")
      {
        toastr["error"]("Delete failed, product already use this type", "Failed");
      // window.location = myurl + "/Purchase/";
      }
      else
      {
        toastr["error"]("Delete failed", "Failed");
      // window.location = myurl + "/Purchase/";
      }
      
    });


  } else {
   // swal("Cancelled");
  }
});      

  }
</script>

<script>

  var temp = "<?php echo $msg; ?>";  //non validate
  var msgerror = "<?php echo $msgerror ?>"; //validate
   if(msgerror != "")
  {
    toastr["error"](msgerror, "Failed");
  }


</script>
@endpush


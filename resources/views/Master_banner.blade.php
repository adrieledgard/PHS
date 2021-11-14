@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('banner_atv')
  active
@endsection

@section('menu_profile')
   menu-open
@endsection
{{-- ------------- --}}

@section('title2')
    Master Banner
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Master Banner</li>
@endsection


@section('title')
  Master Brand
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
   
  <div class="row">
   <div class="col-md-12">
      <h1>Main carousel banner</h1>
      <br><br>
      {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Insert', ['class'=>'btn btn-primary','data-toggle'=>'modal','data-target'=>'#add_banner']) }}
      
    
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
              <th>Banner Header</th>
              <th>Banner Content</th>
              <th>Call to action</th>
              <th>Product</th>
              <th>Order</th>
              <th>Action</th>
            </tr>
          </thead>
      
          <tbody>
            @foreach ($dtbanner as $data)
            <tr> 
              <td width='200px'>
                {{ Form::button('View Image', ['name'=>'viewimage','id'=>'viewimage','data-image'=>$data->Banner_image, 'class'=>'btn btn-secondary float-left btn-sm', 'data-toggle' => 'modal', 'data-target' => '#modal-image']) }}
                {{-- <img src="{{ asset('Uploads/Banner/'. $data->Banner_image )}}" width='150px' height='150px' class="center">  --}}
              </td>
              <td>{{$data->Banner_header}}</td>
              <td>{{$data->Banner_content}}</td>
              <td>{{$data->Banner_cta}}</td>
              <td>{{$data->Name}}</td>
              <td>{{$data->Urutan}}</td>
        
              <td>
                {{-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit_modal" data-cat="{{$data->Id_category}}">Edit</button> --}}
                {{ Form::button('Edit', ['name'=>'btn_edit','class'=>'btn btn-warning btn-sm ','data-banner'=>$data->Id_banner,'data-toggle'=>'modal','data-target'=>'#edit_banner']) }}
                {{ Form::button('Delete', ['name'=>'btn_delete','class'=>'btn btn-danger btn-sm ','onclick'=>'deletebanner('.$data->Id_banner.')']) }}
              
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>   
    
    <br><br>

    <div class="row">
      <div class="col-md-12">
         <h1>Second banner</h1>
         <br><br>
         {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Insert', ['class'=>'btn btn-primary','data-toggle'=>'modal','data-target'=>'#add_banner_2']) }}
         
       
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
                 <th>Banner Header</th>
                 <th>Call to action</th>
                 <th>Product</th>
                 <th>Action</th>
               </tr>
             </thead>
         
             <tbody>
               @foreach ($dtbanner2 as $data)
               <tr> 
                 <td width='200px'>
                   {{ Form::button('View Image', ['name'=>'viewimage','id'=>'viewimage','data-image'=>$data->Banner_image, 'class'=>'btn btn-secondary float-left btn-sm', 'data-toggle' => 'modal', 'data-target' => '#modal-image']) }}
                   {{-- <img src="{{ asset('Uploads/Banner/'. $data->Banner_image )}}" width='150px' height='150px' class="center">  --}}
                 </td>
                 <td>{{$data->Banner_header}}</td>
                 <td>{{$data->Banner_cta}}</td>
                 <td>{{$data->Name}}</td>
           
                 <td>
                   {{-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit_modal" data-cat="{{$data->Id_category}}">Edit</button> --}}
                   {{ Form::button('Edit', ['name'=>'btn_edit','class'=>'btn btn-warning btn-sm ','data-banner'=>$data->Id_banner,'data-toggle'=>'modal','data-target'=>'#edit_banner_2']) }}
                   {{ Form::button('Delete', ['name'=>'btn_delete','class'=>'btn btn-danger btn-sm ','onclick'=>'deletebanner_2('.$data->Id_banner.')']) }}
                 
                 </td>
               </tr>
               @endforeach
             </tbody>
           </table>
         </div>
       </div>
      
    </div>
  </div>

  
{{-- Modal ADD banner --}}
<div class="modal fade" id="add_banner">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Banner</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>
      <div class="container-fluid">
        @csrf
    {{Form::open(array('url'=>'Add_main_banner','method'=>'post','class'=>'g-3', 'files' => true))}}
        <div class="row">
          <div class="col-md-6">
            {{ Form::file('foto',['id'=>'foto'])}}
            <br>
            {{ Form::label('Banner Header','') }}
            {{ Form::text('txt_header_banner_1', '', ['class'=>'form-control']) }}
            <br>
    
            {{ Form::label('Banner Content','') }}
            {{ Form::textarea('txt_content_banner_1', '', ['class'=>'form-control']) }}
    
          </div>
          <div class="col-md-6">
            {{ Form::label('Call to action button (TEXT)','') }}
            {{ Form::text('txt_ctatext_banner_1', '', ['class'=>'form-control']) }}
    
          <br>
            {{ Form::label('Call to action product','') }}
            <br>
            {{ Form::button('Add Product (+)', ['name'=>'add_pro','id'=>'add_pro', 'class'=>'btn btn-warning float-left btn-sm', 'data-toggle' => 'modal', 'data-target' => '#modal-product']) }}
            {{ Form::hidden('txt_fix_product_id', '', ['class'=>'form-control','id'=>'Fix_product_id']) }}
            <br>
            {{ Form::text('txt_fix_product', '', ['class'=>'form-control','Id'=>'Fix_product','disabled'=>true]) }}
           
          </div>
          
        </div>
        {{ Form::submit('Insert', ['name'=>'Add_main_banner', 'class'=>'btn btn-primary float-right']) }}
        {{Form::close()}}
        <br><br>
     
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



{{-- Modal EDIT banner --}}
<div class="modal fade" id="edit_banner">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Banner</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>
      <div class="container-fluid">
        @csrf
    {{Form::open(array('url'=>'Edit_main_banner','method'=>'post','class'=>'g-3', 'files' => true))}}
        <div class="row">
          <div class="col-md-6">
            
            {{ Form::hidden('txt_id_banner_1_edit', '', ['class'=>'form-control','id'=>'txt_id_banner_1_edit']) }}
            {{ Form::file('foto_1_edit',['id'=>'foto_1_edit'])}}
            <br>
            {{ Form::label('Banner Header','') }}
            {{ Form::text('txt_header_banner_1_edit', '', ['class'=>'form-control','Id'=>'txt_header_banner_1_edit']) }}
            <br>
    
            {{ Form::label('Banner Content','') }}
            {{ Form::textarea('txt_content_banner_1_edit', '', ['class'=>'form-control','Id'=>'txt_content_banner_1_edit']) }}
    
          </div>
          <div class="col-md-6">
            {{ Form::label('Call to action button (TEXT)','') }}
            {{ Form::text('txt_ctatext_banner_1_edit', '', ['class'=>'form-control','Id'=>'txt_ctatext_banner_1_edit']) }}
    
          <br>
            {{ Form::label('Call to action product','') }}
            <br>
            {{ Form::button('Add Product (+)', ['name'=>'add_pro','id'=>'add_pro', 'class'=>'btn btn-warning float-left btn-sm', 'data-toggle' => 'modal', 'data-target' => '#modal-product']) }}
            {{ Form::hidden('txt_fix_product_id_1_edit', '', ['class'=>'form-control','id'=>'Fix_product_id_1_edit']) }}
            <br>
            {{ Form::text('txt_fix_product_1_edit', '', ['class'=>'form-control','Id'=>'Fix_product_1_edit','readonly'=>true]) }}
            <br>
            {{ Form::label('Banner Order','') }}
            {{ Form::number('txt_banner_order_1_edit', '', ['class'=>'form-control','Id'=>'txt_banner_order_1_edit']) }}
            <br>
          </div>
          
        </div>
        {{ Form::submit('Edit', ['name'=>'Edit_main_banner', 'class'=>'btn btn-primary float-right']) }}
        {{Form::close()}}
        <br><br>
     
       

       
         
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



{{-- Modal ADD banner 2 --}}
<div class="modal fade" id="add_banner_2">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Second Banner</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>
      <div class="container-fluid">
        @csrf
    {{Form::open(array('url'=>'Add_main_banner_2','method'=>'post','class'=>'g-3', 'files' => true))}}
        <div class="row">
          <div class="col-md-6">
            {{ Form::file('foto_2',['id'=>'foto_2'])}}
            <br>
            {{ Form::label('Banner Header','') }}
            {{ Form::text('txt_header_banner_2', '', ['class'=>'form-control']) }}
            <br>
    
          </div>
          <div class="col-md-6">
            {{ Form::label('Call to action button (TEXT)','') }}
            {{ Form::text('txt_ctatext_banner_2', '', ['class'=>'form-control']) }}
    
          <br>
            {{ Form::label('Call to action product','') }}
            <br>
            {{ Form::button('Add Product (+)', ['name'=>'add_pro','id'=>'add_pro', 'class'=>'btn btn-warning float-left btn-sm', 'data-toggle' => 'modal', 'data-target' => '#modal-product_2']) }}
            {{ Form::hidden('txt_fix_product_id_2', '', ['class'=>'form-control','id'=>'Fix_product_id_2']) }}
            <br>
            {{ Form::text('txt_fix_product_2', '', ['class'=>'form-control','Id'=>'Fix_product_2','disabled'=>true]) }}
           
          </div>
          
        </div>
        <br><br>
        {{ Form::submit('Insert', ['name'=>'Add_main_banner_2', 'class'=>'btn btn-primary float-right']) }}
        {{Form::close()}}
        <br><br>
     
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



{{-- Modal EDIT banner 2--}}
<div class="modal fade" id="edit_banner_2">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Banner</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>
      <div class="container-fluid">
        @csrf
    {{Form::open(array('url'=>'Edit_main_banner_2','method'=>'post','class'=>'g-3', 'files' => true))}}
        <div class="row">
          <div class="col-md-6">
            {{ Form::hidden('txt_id_banner_2_edit', '', ['class'=>'form-control','id'=>'txt_id_banner_2_edit']) }}
            {{ Form::file('foto_2_edit',['id'=>'foto'])}}
            <br>
            {{ Form::label('Banner Header','') }}
            {{ Form::text('txt_header_banner_2_edit', '', ['class'=>'form-control','Id'=>'txt_header_banner_2_edit']) }}
            <br>
    
          </div>
          <div class="col-md-6">
            {{ Form::label('Call to action button (TEXT)','') }}
            {{ Form::text('txt_ctatext_banner_2_edit', '', ['class'=>'form-control','Id'=>'txt_ctatext_banner_2_edit']) }}
    
          <br>
            {{ Form::label('Call to action product','') }}
            <br>
            {{ Form::button('Add Product (+)', ['name'=>'add_pro','id'=>'add_pro', 'class'=>'btn btn-warning float-left btn-sm', 'data-toggle' => 'modal', 'data-target' => '#modal-product_2']) }}
            {{ Form::hidden('txt_fix_product_id_2_edit', '', ['class'=>'form-control','id'=>'txt_fix_product_id_2_edit']) }}
            <br>
            {{ Form::text('txt_fix_product_2_edit', '', ['class'=>'form-control','Id'=>'txt_fix_product_2_edit','readonly'=>true]) }}
       
            <br>
          </div>
          
        </div>
        {{ Form::submit('Edit', ['name'=>'Edit_main_banner_2', 'class'=>'btn btn-primary float-right']) }}
        {{Form::close()}}
        <br><br>
     
       

       
         
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



{{-- Modal Product --}}
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
          
            <tbody id="isi-modal-product">
              
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



{{-- Modal Product 2 --}}
<div class="modal fade" id="modal-product_2">
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
          
            <tbody id="isi-modal-product_2">
              
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




{{-- modal view image --}}
<div class="modal fade" id="modal-image">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Image</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>
      <div class="container-fluid">
       
        <img src="" style="width: 100%; height:100%;" id="gambarbanner" class="center"> 
       
    </div>
  </div>
</div>
</div>




@endsection



@push('custom-script')
<!-- TOASTR Utk ERROR -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- InputMask -->
<script src="{{ asset('assets/plugins/moment/moment.min.js')}} "></script>
<script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js')}} "></script>
<!-- date-range-picker -->
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js')}} "></script>


<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}} "></script>

<!-- CDN DATA TABLE -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
 

{{-- 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
 --}}

  
<script>
$(document).ready( function () {
  // jQuery.noConflict();
  isi_modal_product();
  isi_modal_product_2();
} );

</script>




<script>
  $('#modal-image').on('show.bs.modal', function(event){
  
  var myurl = "<?php echo URL::to('/'); ?>";
  var button = $(event.relatedTarget);
  var imgname = button.data('image');
  
  // alert(imgname);
  
  $("#gambarbanner").attr("src",myurl + "/Uploads/Banner/"+imgname);
  // var modal = $(this);
  //modal.find('.modal-body #id_category').val(id);


  // var myurl = "<?php echo URL::to('/'); ?>";


})

</script>



<script>
  $('#edit_banner').on('show.bs.modal', function(event){
  
  var myurl = "<?php echo URL::to('/'); ?>";
  var button = $(event.relatedTarget);
  var Id_banner = button.data('banner');
  
  $.get(myurl + '/get_data_banner',
    {Id_banner:Id_banner},
    function(result){
      var arr = JSON.parse(result);
    
      var header ="";
      var content ="";
      var cta ="";
      var id_product ="";
      var nama_produk ="";
      var urutan ="";
      var id_banner="";

      for(var i =0;i< arr.length;i++)
      {
        header= arr[i]['Banner_header'];
        content= arr[i]['Banner_content'];
        cta= arr[i]['Banner_cta'];
        id_product = arr[i]['Id_product'];
        nama_produk = arr[i]['Name'];
        urutan = arr[i]['Urutan'];
        id_banner = arr[i]['Id_banner'];
      }

      $("#txt_id_banner_1_edit").val(id_banner);
      $("#txt_header_banner_1_edit").val(header);
      $("#txt_content_banner_1_edit").val(content);
      $("#txt_ctatext_banner_1_edit").val(cta);
      $("#Fix_product_id_1_edit").val(id_product);
      $("#Fix_product_1_edit").val(nama_produk);
      $("#txt_banner_order_1_edit").val(urutan);



      
    });

})





$('#edit_banner_2').on('show.bs.modal', function(event){
  
  var myurl = "<?php echo URL::to('/'); ?>";
  var button = $(event.relatedTarget);
  var Id_banner = button.data('banner');
  
  $.get(myurl + '/get_data_banner',
    {Id_banner:Id_banner},
    function(result){
      var arr = JSON.parse(result);
    
      var header ="";
      var cta ="";
      var id_product ="";
      var nama_produk ="";
      var id_banner="";

      for(var i =0;i< arr.length;i++)
      {
        header= arr[i]['Banner_header'];
        cta= arr[i]['Banner_cta'];
        id_product = arr[i]['Id_product'];
        nama_produk = arr[i]['Name'];
        id_banner = arr[i]['Id_banner'];
      }

      $("#txt_id_banner_2_edit").val(id_banner);
      $("#txt_header_banner_2_edit").val(header);
      $("#txt_ctatext_banner_2_edit").val(cta);
      $("#txt_fix_product_id_2_edit").val(id_product);
      $("#txt_fix_product_2_edit").val(nama_produk);



      
    });

})

</script>





<script>
  var myurl = "<?php echo URL::to('/'); ?>";
  


  function deletebanner(Id_banner)
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
        
        $.get(myurl + '/delete_banner',
        {Id_banner:Id_banner},
        function(result){
          toastr["success"]("Success to delete", "Delete");
            window.location = myurl + "/master_banner/";
        });

        


      } else {
      // swal("Cancelled");
      }
    });     
  }


  function deletebanner_2(Id_banner)
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
        
        $.get(myurl + '/delete_banner',
        {Id_banner:Id_banner},
        function(result){
          toastr["success"]("Success to delete", "Delete");
            window.location = myurl + "/master_banner/";
        });

        


      } else {
      // swal("Cancelled");
      }
    });     
  }

  function isi_modal_product()
  {
    $.get(myurl + '/isi_modal_product',
    {},
    function(result){
     $("#isi-modal-product").html(result);
   
      $('.table_id').DataTable();
    });

  }

  function isi_modal_product_2()
  {
    $.get(myurl + '/isi_modal_product_2',
    {},
    function(result){
     $("#isi-modal-product_2").html(result);
      $('.table_id').DataTable();
    });

  }

  function select_product(Id_product)
  {
    // $('#modal-product').modal('hide');
    // $('#modal-product').hide();
    $('#modal-product').modal('toggle');
     

    
    $.get(myurl + '/get_product_detail',
    {Id_product:Id_product},
    function(result){
      var cut = result.split("||");
      alert(cut[0]);
      $('#Fix_product_id').val(cut[0]);
      $('#Fix_product').val(cut[1]);

      $('#Fix_product_id_1_edit').val(cut[0]);
      $('#Fix_product_1_edit').val(cut[1]);

     
    });
  }

  function select_product_2(Id_product)
  {
    // $('#modal-product').modal('hide');
    // $('#modal-product').hide();
    $('#modal-product_2').modal('toggle');
     

    
    $.get(myurl + '/get_product_detail',
    {Id_product:Id_product},
    function(result){
      var cut = result.split("||");
      alert(cut[0]);
      $('#Fix_product_id_2').val(cut[0]);
      $('#Fix_product_2').val(cut[1]);

      $('#txt_fix_product_id_2_edit').val(cut[0]);
      $('#txt_fix_product_2_edit').val(cut[1]);

      
     
    });
  }

 

  var temp = "<?php echo $msg; ?>";  //non validate
  var msgerror = "<?php echo $msgerror ?>"; //validate
  if(msgerror != "")
  {
    toastr["error"](msgerror, "Failed");
  }
  else if(temp == "lebih5")
  {
    toastr["error"]("Main banner only 5", "Failed");
  }
  else if(temp == "lebih1")
  {
    toastr["error"]("Second banner only 1", "Failed");
  }
  else if(temp == "ordererror")
  {
    toastr["error"]("Banner order error", "Failed");
  }


</script>
@endpush


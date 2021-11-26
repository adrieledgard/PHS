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
    Master Ebook
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Master Ebook</li>
@endsection


@section('title')
  Master Ebook
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
    <div class="row">
      <div class="col-md-12">
        {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Insert', ['class'=>'btn btn-primary','data-toggle'=>'modal','data-target'=>'#add_modal']) }}
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
              <th>Title Ebook</th>
              <th>Action</th>
            </tr>
          </thead>
      
          <tbody>
            @foreach ($dtbank as $data)
            <tr>
              <td>{{$data->Bank_name}}</td>
              <td>{{$data->Account_number}}</td>
              <td>{{$data->Account_name}}</td>
              <td>{{$data->Bank_branch}}</td>
        
              <td>
                {{-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit_modal" data-cat="{{$data->Id_category}}">Edit</button> --}}
                {{ Form::button('Edit', ['name'=>'btn_edit','class'=>'btn btn-warning btn-sm ','data-cat'=>$data->Id_bank,'data-toggle'=>'modal','data-target'=>'#edit_modal']) }}
                {{ Form::button('Delete', ['name'=>'btn_delete','class'=>'btn btn-danger btn-sm ','onclick'=>'deletebank('.$data->Id_bank.')']) }}
              
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>    
      
    </div>
  </div>



<!--ADD Modal -->
  <div class="modal fade" id="add_modal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Insert Bank</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form class="" method='post' action='add_bank'>
            @csrf
            <div class="modal-body">
              <div class="col-md-6">
                {{ Form::label('Bank Name','') }}
                {{ Form::text('txt_bank_name', '', ['class'=>'form-control']) }}
              </div>

              <div class="col-md-6">
                {{ Form::label('Account Number','') }}
                {{ Form::number('txt_account_number', '', ['class'=>'form-control']) }}
              </div>

              <div class="col-md-6">
                {{ Form::label('Account Name','') }}
                {{ Form::text('txt_account_name', '', ['class'=>'form-control']) }}
              </div>


              <div class="col-md-6">
                {{ Form::label('Bank branch','') }}
                {{ Form::text('txt_bank_branch', '', ['class'=>'form-control']) }}
              </div>
              
              
            </div>
            <div class="modal-footer">
              {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
              {{ Form::submit('Insert', ['name'=>'add_bank', 'class'=>'btn btn-primary']) }}
            </div>
          </form>
        <div class="container-fluid">
          
        </div>
      </div>
    </div>
  </div>


  <!--EDIT Modal -->
  <div class="modal fade" id="edit_modal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Bank</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form class="" method='post' action='edit_bank'>
            @csrf
            <div class="modal-body">
              <div class="col-md-6">
                {{ Form::hidden('id_bank', '', ['class'=>'form-control','id'=>'id_bank']) }}
                {{ Form::label('Bank Name','') }}
                {{ Form::text('txt_bank_name', '', ['class'=>'form-control','id'=>'txt_bank_name']) }}
              </div>

              <div class="col-md-6">
                {{ Form::label('Account Number','') }}
                {{ Form::number('txt_account_number', '', ['class'=>'form-control','id'=>'txt_account_number']) }}
              </div>

              <div class="col-md-6">
                {{ Form::label('Account Name','') }}
                {{ Form::text('txt_account_name', '', ['class'=>'form-control','id'=>'txt_account_name']) }}
              </div>

              <div class="col-md-6">
                {{ Form::label('Bank Branch','') }}
                {{ Form::text('txt_bank_branch', '', ['class'=>'form-control','id'=>'txt_bank_branch']) }}
              </div>

              
            </div>
            <div class="modal-footer">
              {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
              {{ Form::submit('Edit', ['name'=>'edit_bank', 'class'=>'btn btn-primary']) }}
            </div>
        </form>
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
    var id = button.data('cat');
    var modal = $(this);
    //modal.find('.modal-body #id_category').val(id);


    var myurl = "<?php echo URL::to('/'); ?>";

      $.get(myurl + '/getbank',
      {id: id},
      function(result){
      var arr = JSON.parse(result);
    
      var bank_name ="";
      var account_number=0;
      var account_name="";
      var bank_branch="";

      for(var i =0;i< arr.length;i++)
      {
        bank_name= arr[i]['Bank_name'];
        account_number= arr[i]['Account_number'];
        account_name= arr[i]['Account_name'];
        bank_branch= arr[i]['Bank_branch'];
      }

      $("#id_bank").val(id);
      $("#txt_bank_name").val(bank_name);
      $("#txt_account_number").val(account_number);
      $("#txt_account_name").val(account_name);
      $("#txt_bank_branch").val(bank_branch);


      });

  })
    
    </script>
<script>
  var myurl = "<?php echo URL::to('/'); ?>";
  function deletebank(id)
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
    
    $.get(myurl + '/delete_bank',
    {Id_bank:id},
    function(result){
      
      if(result=="sukses")
      {
        toastr["success"]("Success to delete", "Delete");
        window.location = myurl + "/master_bank/";
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
@endpush
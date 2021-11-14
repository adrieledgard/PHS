
@extends('layout.Master')

@section('menu_purchase')
   menu-open
@endsection


@section('receive_req_atv')
  active
@endsection

@section('title2')
Receive Request
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Purchase</li>
    <li class="breadcrumb-item active">Receive Request</li>
@endsection


@section('title')
Receive Order
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
          
      </div>
    <br><br><br>
      <div class="col-md-12">
        <table id="table_id2" class='table table-striped display'>
          <thead>
            <tr>
              <th>Status</th>
              <th>Receive date</th>
              <th>No Receive</th>
              <th>No Invoice</th>
              <th>Operator</th>
              
              <th>Action</th>
            </tr>
          </thead>
      
          <tbody>
            @foreach ($receive_header as $data)
            <tr>
              @php
              if($data->STATUS_ORDER =="Pending")
              {
                echo "<td><button type='button' class='btn btn-warning btn-sm' disabled>".$data->STATUS_ORDER."</button></td>";
              }
              else if($data->STATUS_ORDER =="Success")
              {
                echo "<td><button type='button' class='btn btn-success btn-sm' disabled>".$data->STATUS_ORDER."</button></td>";
              }
              else if($data->STATUS_ORDER =="Void")
              {
                echo "<td><button type='button' class='btn btn-danger btn-sm' disabled>".$data->STATUS_ORDER."</button></td>";
              }
              @endphp

                 {{-- <td><button type='button' class='btn btn-warning btn-sm' disabled>sss</button></td>  --}}

              <td>{{ date("d-m-Y", strtotime($data->Receive_date)) }}</td>
              <td>{{$data->No_receive}}</td>
              <td>{{$data->No_invoice}}</td>
              <td>{{$data->Username}}</td>
              <td>
                <button type='button' id='btn_detail_purchase' class='btn btn-warning btn-sm' data-toggle='modal' data-norcv='{{$data->No_receive}}' data-target='#modal-detailreceive'> Detail </button>
                @php
                    if(session()->get('userlogin')->Role=="SHIPPER")
                    {

                    }
                    else
                    {
                      @endphp
                      <button class="btn btn-success btn-sm" onclick="Approve('{{$data->No_receive}}')">Approve</button>
                      <button class="btn btn-danger btn-sm" onclick="Reject('{{$data->No_receive}}')">Reject</button>
                      @php
                    }
                @endphp
            
              </td>
            
            </tr>
            @endforeach
          </tbody>
          
      
        </table>
      </div>
    </div>
  </div><!-- /.container-fluid -->


  {{-- modal detail --}}
  <div class="modal fade" id="modal-detailreceive">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Receive Order</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <br>
        <div class="container-fluid">
         <b id="norcv">  </b><br>
         <b id="nopo">  </b><br><br>
         <b id="supp">  </b><br>
         <b id="operator">  </b><br>
         <br> <br> 
          <div class="row">
            <div class="col-md-12">
              <table class='table table-dark'>
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Variation</th>
                    <th>Qty</th>
                  </tr>
              </thead>
              <tbody id="detail_receive">

              </tbody>
              </table>
            </div>
          </div>
          

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@endsection



@push('custom-script')
<!-- CDN DATA TABLE -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script>
  $(document).ready( function () {
   
    $('#table_id2').DataTable();
    
  } );
  </script>
    <!-- jQuery UI 1.11.4 -->
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
       $('#modal-detailreceive').on('show.bs.modal', function(event){
     
      var button = $(event.relatedTarget);
      var norcv = button.data('norcv');
      var modal = $(this);
      var myurl = "<?php echo URL::to('/'); ?>";
      

      $.get(myurl + '/get_receive_detail',
        {norcv:norcv},
        function(result){

          var cut = result.split("#");
          $("#detail_receive").html(cut[0]);
      
          $("#norcv").html("No Receive : "+cut[1]);
          $("#nopo").html("No Invoice PO : "+cut[2]);
          $("#supp").html("Supplier : "+cut[3]);
          $("#operator").html("Operator : "+cut[4]);
          
          
        });

     })


     function Approve(no_receive)
     {
      //  alert(no_receive)

      var myurl = "<?php echo URL::to('/'); ?>";
       swal({
      title: "Are you sure to Approve this?",
      text: "No Receive - "+no_receive+" | If you approve, it will update the stock ",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
      

        $.get(myurl + '/set_status_receive',
        {No_receive:no_receive,Status:2},
        function(result){
           alert(result);
          toastr["success"]("Success to Approve", "Success");
          window.location = myurl + "/Receive_request/";
          
        });


      // $.get(myurl + '/void_purchase',
      // {noinv:noinv},
      // function(result){
      //   if(result=="no")
      //   {
      //     toastr["error"]("Void can only if the status is open ", "Failed");
      //   }
      //   else
      //   {
      //   toastr["success"]("Success to void", "Success");
      //   window.location = myurl + "/Purchase/";
      //   }
        
      // });


      } else {
       // swal("Cancelled");
      }
    });     


     
     }



     function Reject(no_receive)
     {
      //  alert(no_receive)

      var myurl = "<?php echo URL::to('/'); ?>";
       swal({
      title: "Are you sure to Reject this?",
      text: "No Receive - "+no_receive,
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
      

        $.get(myurl + '/set_status_receive',
        {No_receive:no_receive,Status:3},
        function(result){

          toastr["success"]("Success to Reject", "Success");
          window.location = myurl + "/Receive_request/";
          
        });



      } else {
       // swal("Cancelled");
      }
    });     


     
     }
    </script>
@endpush


    
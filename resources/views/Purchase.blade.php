
@extends('layout.Master')

@section('menu_purchase')
   menu-open
@endsection


@section('purchase_atv')
  active
@endsection


@section('title2')
   Purchase Order
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Purchase</li>
    <li class="breadcrumb-item active">Order</li>
@endsection


@section('title')
Purchase Order
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
{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> --}}
@endpush


@section('Content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <a href="{!! url('Purchase_pre_add'); !!}">

          <input type="button" class="btn btn-primary" value="Insert Purchase">
          </a>
      </div>
    </div>
<br><br>
    <div class="row">
      <div class="col-md-12">
        <table class='table table-striped display' id='table_id'>
          <thead>
            <tr>
              <th>Status</th>
              <th>No Invoice</th>
              <th>Purchase_date</th>
              <th>Supplier name</th>
              <th>Grand total</th>
              
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($purchase_header as $data)
            <tr>
              @php
              if($data->STATUS_ORDER =="OPEN")
              {
                echo "<td><button type='button' class='btn btn-info btn-sm' disabled>".$data->STATUS_ORDER."</button></td>";
              }
              else if($data->STATUS_ORDER =="Partially Processed")
              {
                echo "<td><button type='button' class='btn btn-warning btn-sm' disabled>".$data->STATUS_ORDER."</button></td>";
              }
              else if($data->STATUS_ORDER =="Partially Processed (Close)")
              {
                echo "<td><button type='button' class='btn btn-success btn-sm' disabled>".$data->STATUS_ORDER."</button></td>";
              }
              else if($data->STATUS_ORDER =="Completed (Close)")
              {
                echo "<td><button type='button' class='btn btn-success btn-sm' disabled>".$data->STATUS_ORDER."</button></td>";
              }
              else {
                
                echo "<td><button type='button' class='btn btn-danger btn-sm' disabled>".$data->STATUS_ORDER."</button></td>";
              }

              //  echo "<td> <span class='label label-info'>Info Label</span></td>";
          @endphp  
              <td>{{$data->No_invoice}}</td>
           
              <td>{{ date("d-m-Y", strtotime($data->Purchase_date)) }}</td>
              <td>{{$data->Supplier_name}}</td>
              <td>{{"Rp. ".number_format($data->Grand_total)}}</td>
              
              

              {{-- <span class="label label-default">Default Label</span>
                  <span class="label label-primary">Primary Label</span>
                  <span class="label label-success">Success Label</span>
                  <span class="label label-info">Info Label</span>
                  <span class="label label-warning">Warning Label</span>
                  <span class="label label-danger">Danger Label</span> --}}
        
              <td>
                {{-- <button class="btn btn-warning btn-sm" onclick="Detail('{{$data->No_invoice}}')">Detail</button> --}}
               

                <button type='button' id='btn_detail_purchase' class='btn btn-warning btn-sm' data-toggle='modal' data-noinv='{{$data->No_invoice}}' data-target='#modal-detailpurchase'> Detail </button>
                <button class="btn btn-info btn-sm" onclick="Forceclose('{{$data->No_invoice}}')">Force close</button>
                <button class="btn btn-danger btn-sm" onclick="Void('{{$data->No_invoice}}')">Void</button>
             
              </td>
            </tr>
            @endforeach
          </tbody>
          
      
        </table>
      </div>
    </div>
    
      
    
  </div><!-- /.container-fluid -->






  {{-- modal detail --}}
  <div class="modal fade" id="modal-detailpurchase">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Purchase Order</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <br>
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-2">
              <b style="font-size: 100%">Date:</b> 
            </div>
            <div class="col-md-4">
              <b id="tgl">  </b>
            </div>
          </div>

          <div class="row">
            <div class="col-md-2">
              <b style="font-size: 100%">No Invoice:</b> 
            </div>
            <div class="col-md-4">
              <b id="noinv">  </b>
            </div>
          </div>

          <div class="row">
            <div class="col-md-2">
              <b style="font-size: 100%">Supplier:</b> 
            </div>
            <div class="col-md-4">
              <b id="supp">  </b>
            </div>
          </div>
         <br> <br> 
          <div class="row">
            <div class="col-md-12">
              <table class='table table-dark'>
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Variation</th>
                    <th>Qty</th>
                    <th>Purchase Price</th>
                    <th>Total</th>
                    <th>Qty Received</th>
                  </tr>
              </thead>
              <tbody id="detail_purchase">

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
  
 $("#table_id").DataTable();

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

  $('#modal-detailpurchase').on('show.bs.modal', function(event){
      
      var button = $(event.relatedTarget);
      var noinv = button.data('noinv');
      var modal = $(this);
      var myurl = "<?php echo URL::to('/'); ?>";
      

      $.get(myurl + '/get_purchase_detail',
        {noinv:noinv},
        function(result){

          var cut = result.split("#");
          $("#detail_purchase").html(cut[0]);
      
          $("#noinv").html(cut[1]);
          $("#tgl").html(cut[2]);
          $("#supp").html(cut[3]);


        });

    })





   var myurl = "<?php echo URL::to('/'); ?>";
   function Detail(noinv)
   {
     alert(noinv);
   }


   function Void(noinv)
   {
      swal({
      title: "Are you sure to Void this?",
      text: "No Invoice - "+noinv,
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        
        $.get(myurl + '/void_purchase',
        {noinv:noinv},
        function(result){
          if(result=="no")
          {
            toastr["error"]("Void can only if the status is open ", "Failed");
          }
          else
          {
          toastr["success"]("Success to void", "Success");
          window.location = myurl + "/Purchase/";
          }
          
        });


      } else {
       // swal("Cancelled");
      }
    });      



    
   }


   function Forceclose(noinv)
   {
    swal({
      title: "Are you sure to Force close this?",
      text: "No Invoice - "+noinv,
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        
        $.get(myurl + '/force_close_purchase',
        {noinv:noinv},
        function(result){
          if(result=="no")
          {
            toastr["error"]("Force close can only if the status is Partially processed ", "Failed");
          }
          else
          {
          toastr["success"]("Success to Force close", "Success");
          window.location = myurl + "/Purchase/";
          }
          
        });


      } else {
       // swal("Cancelled");
      }
    });   
   }

 </script>

    
@endpush


    
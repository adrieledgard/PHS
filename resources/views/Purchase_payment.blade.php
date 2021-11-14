
@extends('layout.Master')

@section('menu_purchase')
   menu-open
@endsection


@section('purchasepayment_atv')
  active
@endsection

@section('title2')
Payment
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Purchase</li>
    <li class="breadcrumb-item active">Payment</li>
@endsection


@section('title')
Purchase payment
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
          
      <div class="col-md-12">
        <table id="table_id2" class='table table-striped display'>
          <thead>
            <tr>
              <th>Status</th>
              <th>Supplier</th>
              <th>No Receive</th>
              <th>Receive date</th>
              <th>Due date</th>
              <th>Amount</th>
              <th>Action</th>
            </tr>
          </thead>
      
          <tbody>
            @php
                $ctr=-1;
            @endphp
            @foreach ($payment as $data)
            <tr>
              @php
              $ctr=$ctr+1;
              if($data->Payment =="Paid")
              {
                echo "<td><button type='button' class='btn btn-success btn-sm' disabled>".$data->Payment."</button></td>";
              }
              else if($data->Payment =="Unpaid")
              {
                echo "<td><button type='button' class='btn btn-danger btn-sm' disabled>".$data->Payment."</button></td>";
              }
              @endphp

              <td>{{$supp[$ctr]}}</td>
              <td>{{$data->No_receive}}</td>
              <td>{{ date("d-m-Y", strtotime($data->Receive_date)) }}</td>
              <td>{{ date("d-m-Y", strtotime($duedate[$ctr])) }}</td>
              {{-- <td>{{$duedate[$ctr]}}</td> --}}



              @php
              $jumlah=0;
                  for ($i=0; $i < count($detail) ; $i++) { 
                    
                    if($detail[$i]['No_receive'] == $data->No_receive)
                    {
                      $jumlah=$jumlah + ($detail[$i]['Qty'] * $detail[$i]['Purchase_price']);
                    }
                  }
              @endphp

            <td>Rp. {{number_format($jumlah)}}</td>

             <td>
                <button type='button' id='btn_detail_purchase' class='btn btn-warning btn-sm' data-toggle='modal' data-norcv='{{$data->No_receive}}' data-target='#modal-detailreceive'> Detail </button>
                
                {{-- <button type='button' id='btn_paid' class='btn btn-success btn-sm' data-toggle='modal' data-norcv='{{$data->No_receive}}' data-target='#modal-paid'> Paid </button> --}}
                
                {{-- <button id="btn_paid" class="btn btn-success btn-sm" onclick="Paid('{{$data->No_receive}}')">Paid</button> --}}
            @php
                if($data->Payment =="Paid")
                {
                  @endphp
                  {{ Form::button('<i class="fa fa-money-check-alt" aria-hidden="true"></i> Pay',['class'=>'btn btn-success btn-sm','disabled'=>'true']) }}
                  @php
                }
                else if($data->Payment =="Unpaid")
                {
                  @endphp
                  <a href="{!! url('Purchase_payment_pay/' .$data->No_receive); !!}">
                
                {{ Form::button('<i class="fa fa-money-check-alt" aria-hidden="true"></i> Pay',['class'=>'btn btn-success btn-sm']) }}
        
              </a>

                  @php

                  // echo "<td><button type='button' class='btn btn-danger btn-sm' disabled>".$data->Payment."</button></td>";
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

<div>
  {{-- modal detail --}}
  <div class="modal fade" id="modal-detailreceive">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail</h4>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <br>
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-1">
              <p class="Status_payment"></p>
            </div>
            <div class="col-md-4">
              <b class="No_payment"></b><br>
              <b class="payment_by">  </b>
            </div>
            <div class="col-md-5">
              <b class="payment_method">  </b><br>
              <b class="namabank">  </b><br>
              <b class="norekening">  </b><br>
              <b class="namapemilikrekening">  </b>
            </div>
            <div class="col-md-2">
              {{ Form::hidden('kode_image', '', ['class'=>'kode_image','id'=>'kode_image']) }}
              <p class="receipt_image"></p>
            </div>
          </div>


          {{-- <div class="row">
            <div class="col-md-1">
              
              <p class="Status_payment"></p>
              
            </div>
            <div class="col-md-8">
              <b class="No_payment"></b>
            </div>
          </div>

          <div class="row">
            <div class="col-md-1">

            </div>

            <div class="col-md-8">
              <b class="payment_by">  </b>
            </div>
          </div> --}}

          {{-- <div class="row">
            <div class="col-md-1">
              
            </div>
            <div class="col-md-8">
              <b class="receipt_image">  </b>
            </div>
          </div> --}}



          <hr>
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-5">
                  <b>Receive Date</b> 
                </div>
                <div class="col-md-7">
                  <b class="tgl">  </b>
                </div>
              </div>
    
              <div class="row">
                <div class="col-md-5">
                  <b>Due Date</b> 
                </div>
                <div class="col-md-7">
                  <b class="duedate">  </b>
                </div>
              </div>
    
              <div class="row">
                <div class="col-md-5">
                  <b>No Receive</b> 
                </div>
                <div class="col-md-7">
                  <b class="norcv">  </b>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <b style="font-size: 100%">No Invoice PO</b> 
                </div>
                <div class="col-md-7">
                  <b class="nopo">  </b>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <b style="font-size: 100%">No reff Supplier</b> 
                </div>
                <div class="col-md-7">
                  <b class="noreffsupp">  </b>
                </div>
              </div>
            </div>


            <div class="col-md-6">
              <div class="row">
                <div class="col-md-4">
                  <b>Supplier</b> 
                </div>
                <div class="col-md-8">
                  <b class="supp">  </b>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <b>Shipper</b> 
                </div>
                <div class="col-md-8">
                  <b class="operator">  </b>
                </div>
              </div>
    
              {{-- <div class="row">
                <div class="col-md-4">
                  <b>Payment by</b> 
                </div>
                <div class="col-md-8">
                  <b class="payment_by">  </b>
                </div>
              </div> --}}
            </div>
          </div>

          
          <hr>
          
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
                  </tr>
              </thead>
              <tbody class="detail_receive">

              </tbody>
              </table>
            </div>
          </div>
          

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>




<div>
  {{-- modal receipt purchase --}}
  <div class="modal fade" id="modal-receipt">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Receipt</h4>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <br>
        <div class="container-fluid">
          {{-- {{ Form::hidden('kode_image', '', ['class'=>'kode_image','id'=>'kode_image']) }} --}}
          @php
              
              $kodegambar = session()->get('kodegambarpayment');
              // echo $kodegambar;
          @endphp


          {{-- <p id="gambarreceipt"> </p> --}}
          {{-- {{ asset('Uploads/Purchase_payment_receipt/'.$kodegambar )}} --}}
          <img src="" style="width: 100%; height:100%;" id="gambarreceipt" class="center"> 
         
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
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
      

      $.get(myurl + '/get_receive_detail_payment',
        {norcv:norcv},
        function(result){

          var cut = result.split("#");
          $(".detail_receive").html(cut[0]);
      
          $(".norcv").html(": "+cut[1]);
          $(".nopo").html(": "+cut[2]);
          $(".supp").html(": "+cut[3]);
          $(".operator").html(": "+cut[4]);
          $(".tgl").html(": "+cut[5]);
          $(".noreffsupp").html(": "+cut[6]);
          $(".Status_payment").html(cut[7]);
          $(".duedate").html(": "+cut[8]);

          $(".No_payment").html(cut[9]);
          $(".kode_image").val(cut[10]);

          $(".payment_by").html("Payment by : "+cut[11]);
          $(".payment_method").html(cut[12]);
          $(".namabank").html(cut[13]);
          $(".norekening").html(cut[14]);
          $(".namapemilikrekening").html(cut[15]);

          if(cut[7]=="<button type='button' class='btn btn-success btn-sm' disabled>PAID</button>")
          {
           //paid
           if(cut[10]=="")
            {
              $(".receipt_image").html('');
            }
            else
            {
              $(".receipt_image").html("<button type='button' id='btn_modal_receipt' class='btn btn-warning btn-sm' data-toggle='modal' data-receipt='"+cut[10]+"' data-target='#modal-receipt'> View Receipt </button>");
            
            
           
            
            
            }
          }
          else
          {
            //unpaid
            $(".No_payment").html('');
            $(".kode_image").html('');

            $(".payment_by").html('');
            $(".payment_method").html("");
            $(".namabank").html('');
            $(".norekening").html('');
            $(".namapemilikrekening").html('');
          

            $(".receipt_image").html('');
             
            
          }


          
          
         
          


        });

     })

    </script>







<script>
  $('#modal-receipt').on('show.bs.modal', function(event){
     
     var button = $(event.relatedTarget);
     var kodegambar = button.data('receipt');
     var modal = $(this);
     var myurl = "<?php echo URL::to('/'); ?>";
   

     $("#gambarreceipt").attr("src",myurl + "/Uploads/Purchase_payment_receipt/"+kodegambar);
    


     
    })
</script>
@endpush


    
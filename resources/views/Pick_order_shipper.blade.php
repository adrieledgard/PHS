@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('cust_order_atv')
  active
@endsection

@section('menu_Cust_order')
   menu-open
@endsection
{{-- ------------- --}}


@section('title2')
    Cust order
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Cust order</li>
@endsection


@section('title')
  Order available
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
<!-- shopping-cart-area start -->
<div class="cart-main-area pt-95 pb-100 wishlist">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          Status :
          {{ Form::select('Choose Status', ['Payment receive','Processing','Shipping'], 'a',['class'=>'form-control','id'=>'filter', 'placeholder' => "Choose Status",'onchange' => 'ganti_filter()']) }}
         
        </div>
        <div class="col-md-3">
          Courier :
          {{ Form::select('Courier', ['JNE','POS','TIKI'], 'a',['class'=>'form-control','id'=>'courier', 'placeholder' => "Choose Status",'onchange' => 'ganti_filter()']) }}
         
        </div>

        <div class="col-md-3">
          Receipt number :
          {{ Form::text('txt_receipt_number', '', ['class'=>'form-control','id'=>'txt_receipt_number']) }}
         
        </div>

        <div class="col-md-3">
          Name :
          {{ Form::text('txt_name', '', ['class'=>'form-control','id'=>'txt_name']) }}
        </div>
        <br><br>  <br>
        <div class="col-md-12">
          {{ Form::button('Filter', ['name'=>'btn_filter','class'=>'btn btn-info btn-sm','onclick'=>'filter()']) }}
        </div>
      </div>
      <br>
      <hr>

      <div class="row">
        <div class="col-md-2">
          {{ Form::button('Mark as processing', ['name'=>'btn_filter','class'=>'btn btn-success btn-sm','onclick'=>'multi_select_order()']) }}
        </div>
        <div class="col-md-2">
          {{ Form::button('Print shipping label', ['name'=>'btn_filter','class'=>'btn btn-primary btn-sm','onclick'=>'multi_select_order()']) }}
        </div>
      </div>
      <br><br>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="datatransaksi">
           
                @php $no = 0; @endphp
                @foreach ($datatransaksi as $cr)
                
                    <div class="card" id='card{{ $cr->Id_order }}'>
                        <div class="card-body">
                          <input type='checkbox' class='cb_child' value={{ $cr->Id_order }} style='transform: scale(1.5)'>
                            <br>
                            <?php
                            if($cr->Status ==0)
                            {
                              echo "<td><button type='button' class='btn btn-danger btn-sm' disabled>Canceled</button></td>";
                            }
                            else if($cr->Status ==1)
                            {
                              echo "<td><button type='button' class='btn btn-warning btn-sm' disabled>Pending</button></td>";
                            }
                            else if($cr->Status ==2)
                            {
                              echo "<td><button type='button' class='btn btn-light btn-sm' disabled>Payment Receive</button></td>";
                            }
                            else if($cr->Status ==3)
                            {
                              echo "<td><button type='button' class='btn btn-primary btn-sm' disabled>Processing</button></td>";
                            }
                            else if($cr->Status ==4)
                            {
                              echo "<td><button type='button' class='btn btn-secondary btn-sm' disabled>Shipping</button></td>";
                            }
                            else if($cr->Status ==5)
                            {
                              echo "<td><button type='button' class='btn btn-success btn-sm' disabled>Complete</button></td>";
                            }

                            ?>
                            <br><br>
                            <h5 class="card-title">Nota : {{ $cr->Id_order }}</h5>
                            <p class="card-text">
                                <b><h5>{{ date("d-m-Y", strtotime($cr->Date_time)) }}</h5></b>
                                <b><h5>Name : {{($cr->Name) }}</h5></b>
                                <b><h5>Grand Total : Rp. {{number_format($cr->Grand_total) }}</h5></b>
                            </p>
                            {{ Form::button('View detail', ['name'=>'btn_edit','class'=>'btn btn-warning btn-sm ','data-idorder'=>$cr->Id_order,'data-toggle'=>'modal','data-target'=>'.viewdetail']) }}
                            <hr size="10px"  style="margin-top: 2%">
                            {{-- <input type='hidden' id='txtdatetime{{ $no }}' value='{{ $cr->jatuhtempo }}'> --}}
                            {{-- <input type='text' id='txtselisih{{ $no }}' value='0'> --}}
                        </div>
                    </div>           
                    <br><br>                 
                    @php $no++; @endphp
                @endforeach
            
            </div>
           
        </div>
    </div>
</div>


<div class="modal fade viewdetail">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail order</h4>
          <button style="color:black" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="row">
          <div class="col-md-2">
            <b style="font-size: 100%">Name:</b> 
          </div>
          <div class="col-md-4">
            <b id="name">  </b>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <b style="font-size: 100%">Phone:</b> 
          </div>
          <div class="col-md-4">
            <b id="phone">  </b>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <b style="font-size: 100%">Email:</b> 
          </div>
          <div class="col-md-4">
            <b id="email">  </b>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <b style="font-size: 100%">Address:</b> 
          </div>
          <div class="col-md-10">
            <b id="address">  </b>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <b style="font-size: 100%">Total weight:</b> 
          </div>
          <div class="col-md-10">
            <b id="weight">  </b>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <b style="font-size: 100%">Expedition:</b> 
          </div>
          <div class="col-md-10">
            <b id="ekspedisi">  </b>
          </div>
        </div>
        <div class="modal-body">
          {{ Form::hidden('Id_order', '', ['class'=>'form-control','id'=>'Id_order']) }}
            <div class="row">
                <div class="col-md-12">
                  <table class='table table-dark'>
                    <thead>
                      <tr>
                        <th>Product Name</th>
                        <th>Variation</th>
                        <th>Normal Price</th>
                        <th>Discount</th>
                        <th>Fix price</th>
                        <th>Qty</th>
                        <th>Total</th>
                      </tr>
                  </thead>
                  <tbody id="detail_order">
    
                  </tbody>
                  </table>
                </div>
              </div>

              <hr>
              <div class="row">
                <div class="col-md-3">
                  <b>Receipt number :</b> 
                  {{ Form::text('receipt_number', '', ['class'=>'form-control','id'=>'receipt_number']) }}
                </div>
               
                <div class="col-md-3">
                  <br>
                  {{ Form::button('Save', ['name'=>'btn_filter','id'=>'btn_save','class'=>'btn btn-info btn-sm','onclick'=>'save_receipt_number()']) }}
                </div>
              </div>
              <hr>
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
    var myurl = "<?php echo URL::to('/'); ?>";
   

    function cariSelisih(tgl2) {
        var dt = new Date();
        var time = dt.getFullYear() + "-" + (dt.getMonth()+1) + "-" + dt.getDate() + " " + dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();

        var t1 = new Date(time);
        var t2 = new Date(tgl2);
        var dif = t2.getTime() - t1.getTime();
        var jumdetik = dif / 1000;
        return jumdetik;
    }

    function formatSelisih(dtk) {
        var jam = Math.floor(dtk / 3600); 
        dtk     = dtk % 3600; 
        var mnt = Math.floor(dtk / 60); 
        dtk     = dtk % 60; 
        if(jam < 10) { jam = "0" + jam; }
        if(mnt < 10) { mnt = "0" + mnt; }
        if(dtk < 10) { dtk = "0" + dtk; }
        return jam + ":" + mnt + ":" + dtk; 
    }

    function animasi() {
        var maxno = parseInt($("#maxno").val()); 
        for(var i = 0; i < maxno; i++) {
            var tgl2 = $("#txtdatetime" + i).val(); 
            var dtk  = cariSelisih(tgl2);
            $("#txtselisih" + i).val(formatSelisih(dtk)); 
            if(dtk == 0) {
                // lakukan ajax utk update status = 0 
                // utk id = $("#txtnomernota" + i).val()
                $("#card" + i).fadeOut(); 
            }
        }
    }

    $(document).ready(function(){
        var tmr = setInterval("animasi()", 1000); 
    });

    function ganti_filter()
    {
     
    }


    function filter()
    {
      // alert();

      var Status = $('#filter').val();
      var Kurir = $('#courier').val();
      var Resi = $('#txt_receipt_number').val();
      var Nama = $('#txt_name').val();


      $.get(myurl + '/filter_cust_order',
      {Status: Status,Kurir:Kurir,Resi:Resi,Nama:Nama},
      function(result){
           $('#datatransaksi').html(result);

      });
    }

    function multi_select_order()
    {
      var myurl = "<?php echo URL::to('/'); ?>";
        let semua_cb_centang =$(".cb_child:checked")
        
        var kumpulan_id_order = "";

        $.each(semua_cb_centang,function(index,elm){

          if(index==semua_cb_centang.length-1)
          {
            kumpulan_id_order = kumpulan_id_order + elm.value;
          }
          else
          {
            kumpulan_id_order = kumpulan_id_order + elm.value+"," ;
          }
        
        })


        $.get(myurl + '/Proccess_cust_order',
        {kumpulan_id_order: kumpulan_id_order},
        function(result){


            swal({
              title: "Are you want to print shipping label ?",
              text: '',
              icon: "success",
              buttons: true,
              dangerMode: false,
            })
            .then((print) => {
              if (print) {
                
                alert('print shipping label');

              } else {
              // swal("Cancelled");
              window.location = myurl + "/Pick_order_shipper/";
              }
            });      

         });
    }

    function save_receipt_number()
    {
      var Receipt_number = $('#receipt_number').val();
      var Id_order = $('#Id_order').val();

      if(receipt_number=="")
      {
        toastr["error"]("Receipt number cannot be empty", "Failed");
      }
      else
      {
        $.get(myurl + '/save_receipt_number',
        {Id_order: Id_order,Receipt_number:Receipt_number},
        function(result){

          $("#card" + Id_order).fadeOut(); 
          toastr["success"]("This order changed to shipping", "Successs");
        });
        
      }
    }
</script>

<script>
  
  
    $('.viewdetail').on('show.bs.modal', function(event){
      // alert('aa');
      var button = $(event.relatedTarget);
      var id = button.data('idorder');
      var modal = $(this);
  
      $.get(myurl + '/get_cust_detail_order',
      {id: id},
      function(result){
          // alert(result);
          var cut = result.split("#");
           $("#detail_order").html(cut[0]);
           $("#name").html(cut[1]);
           $("#phone").html(cut[2]);
           $("#email").html(cut[3]);
           $("#address").html(cut[4]);
           $("#ekspedisi").html(cut[5]);
           $("#weight").html(cut[6] + "Gr");
           $("#receipt_number").val(cut[7]);
           $("#Id_order").val(cut[8]);
          //  $("#Status").val(cut[9]);

           if(cut[9]!=3 && cut[9]!=4) //Status order
           {
            document.getElementById("receipt_number").readOnly =true;
            document.getElementById("btn_save").disabled = true;
           }
           else
           {
            document.getElementById("receipt_number").readOnly =false;
            document.getElementById("btn_save").disabled = false;
           }
      });
       
   });
   
  </script>
@endpush








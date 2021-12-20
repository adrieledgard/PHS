@extends('layout_frontend.Master')

@push('custom-css')
    {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="{{ asset ('css/register-login/register-login.css') }}" rel="stylesheet" type="text/css">  --}}

    
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

          <?php
            $ix=0;
            if(session()->get('Filter_my_order'))
            {
              $ix = session()->get('Filter_my_order');
            }
          ?>
          {{ Form::select('Choose Status', ['Cancelled','Pending','Payment receive','Processing','Shipping','Complete','All'], $ix,['class'=>'form-control','id'=>'filter', 'placeholder' => "Choose Status",'onchange' => 'ganti_filter()']) }}
         
        </div>
        <div class="col-md-2">
          {{ Form::button('Filter', ['name'=>'btn_filter','class'=>'btn btn-info btn-sm','onclick'=>'filter()']) }}
        </div>
      </div>
      <br><br>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           
                <form action="#">
                            @php $no = 0; @endphp
                            @foreach ($datatransaksi as $cr)
                                <div class="card" id='card{{ $no }}'>
                                    <div class="card-body">
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
                                        <h5 class="card-title">Nota : {{ $cr->Id_order }}</h5>
                                        <p class="card-text">
                                            <b><h5>{{ date("d-m-Y", strtotime($cr->Date_time)) }}</h5></b>
                                            <b><h5>Grand Total : Rp. {{number_format($cr->Grand_total) }}</h5></b>
                                        </p>
                                        {{-- <button data-toggle="modal" data-target="#View_detail" class="btn-primary" data-Idorder="{{$cr->Id_order}}">View detail</button> --}}
                                        {{ Form::button('View detail', ['name'=>'btn_edit','class'=>'btn btn-warning btn-sm ','data-idorder'=>$cr->Id_order,'data-toggle'=>'modal','data-target'=>'.viewdetail']) }}
                                        {{ Form::button('Pay now', ['name'=>'btn_pay','class'=>'btn btn-success btn-sm']) }}
                                        <hr size="10px"  style="margin-top: 2%">
                                        <h6>Please finish transaction before : </h6>
                                        <input type='hidden' id='txtnomernota{{ $no }}' value='{{ $cr->Id_order }}'>
                                        <input type='hidden' id='txtdatetime{{ $no }}' value='{{ $cr->jatuhtempo }}'>
                                        <input type='text' id='txtselisih{{ $no }}' value='0'>
                                    </div>
                                </div>           
                                <br><br>                 
                                @php $no++; @endphp
                            @endforeach
                            <input type='text' id='maxno' value='{{ $no }}'>
                </form>
            
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

           
            
        </div>
            {{-- <div class="modal-footer">
              {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
            </div> --}}
       
      </div>
    </div>
</div>
@endsection


@push('custom-js')


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




<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js')}}"></script>
<script src="{{ asset('assets/js/popper.js')}}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{ asset('assets/js/isotope.pkgd.min.js')}}"></script>
<script src="{{ asset('assets/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.counterup.min.js')}}"></script>
<script src="{{ asset('assets/js/waypoints.min.js')}}"></script>
<script src="{{ asset('assets/js/ajax-mail.js')}}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js')}}"></script>
<script src="{{ asset('assets/js/plugins.js')}}"></script>
<script src="{{ asset('assets/js/main.js')}}"></script> 





<!-- jQuery -->
 <link href="{{ asset ('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<script src ="{{ asset ('js/jquery.js') }}"></script>
<script src ="{{ asset ('js/bootstrap.js') }}"></script>
 


<script>
  $('.viewdetail').on('show.bs.modal', function(event){
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
    });
     
 })
 
</script>


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
                var Id_order = $("#txtnomernota" + i).val()
                // alert(Id_order);
                $("#card" + i).fadeOut(); 
                $.get(myurl + '/update_status',
                {Id_order:Id_order,Status: 0},
                function(result){
                  
                });
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

      var stat = $('#filter').val();
      $.get(myurl + '/update_filter_session',
      {Status: stat},
      function(result){
           alert(result);

          window.location = myurl + "/My_order/";
      });
    }
</script>

@endpush








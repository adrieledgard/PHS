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
<link rel="stylesheet" href="{{ asset('assets/css/star-rating.css') }}">
@endpush

@section('Content')
<!-- shopping-cart-area start -->
<input type="hidden" class="csrf_token" value="{{csrf_token()}}">
<div class="cart-main-area pt-95 pb-100 wishlist">
    <div class="container">
      <div class="row">
        <div class="col-md-3">

          <?php
            $ix=1;
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

                                        <?php
                                          if($cr->Status == 4){ ?>
                                            {{ Form::button('Complete Order', ['name'=>'btn_edit','class'=>'btn btn-success btn-sm ','data-idorder'=>$cr->Id_order,'data-toggle'=>'modal','data-target'=>'.konfirmasi_selesai']) }}
                                         <?php } ?>
                                        
                                       
                                        <?php
                                          if($cr->Status ==1)
                                          {
                                            ?>
                                             {{ Form::button('Pay now', ['name'=>'btn_pay','class'=>'btn btn-success btn-sm', 'onclick' => 'pay_now('. $cr->Id_order . ')']) }}
                                             <input type='button' value='Bayar' onclick=bayarmidtrans('{{ $no }}') class='btn btn-warning btn-sm'>
     
                                              <hr size="10px"  style="margin-top: 2%">
                                              <h6>Please finish transaction before : </h6>
                                              <input type='text' id='txtsnaptoken{{ $no }}' value='{{ $cr->snap_token }}'>
                                              <input type='hidden' id='txtnomernota{{ $no }}' value='{{ $cr->Id_order }}'>
                                              <input type='hidden' id='txtdatetime{{ $no }}' value='{{ $cr->jatuhtempo }}'>
                                              <input type='text' id='txtselisih{{ $no }}' value='0'>
                                            <?php
                                          }
                                        ?>
                                       
                                        <?php
                                          if($cr->Status == 5){ ?>
                                            {{ Form::button('Give Review', ['name'=>'btn_edit','class'=>'btn btn-info btn-sm ','data-idorder'=>$cr->Id_order,'data-toggle'=>'modal','data-target'=>'.rating_review']) }}
                                        <?php } ?>
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

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    function bayarmidtrans(no) {
      var snaptoken = $("#txtsnaptoken" + no).val(); 
      snap.pay(snaptoken, {
          // Optional
          onSuccess: function(result) {
              /* You may add your own js here, this is just example */
              // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
              console.log("masuk mode onSuccess"); 
              console.log(result)
          },
          // Optional
          onPending: function(result) {
              /* You may add your own js here, this is just example */
              // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
              console.log("masuk mode onPending"); 
              console.log(result)
          },
          // Optional
          onError: function(result) {
              /* You may add your own js here, this is just example */
              // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
              console.log("masuk mode onError"); 
              console.log(result)
          }
      });        
    };
</script>

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
<div class="modal fade konfirmasi_selesai">
    <div class="modal-dialog modal-l">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi</h4>
          <button style="color:black" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="" class="confirmation_message"></label>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button class="btn btn-success btn-sm" onclick="konfirmasi_selesai()">Confirm</button>
        </div>
      </div>
    </div>
</div>
<div class="modal fade rating_review">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi</h4>
          <button style="color:black" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button class="btn btn-success btn-sm" onclick="konfirmasi_selesai()">Confirm</button>
        </div>
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
<script type="text/javascript" src="{{ asset('assets/js/star-rating.js')}}">

</script> 





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
 
 $(".konfirmasi_selesai").on('show.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var id = button.data('idorder');
    $(".confirmation_message").html("Apakah anda yakin ingin menyelesaikan order <b class='no_nota'>" + id + "</b>?");
    var modal = $(this);
 });

 $(".rating_review").on('show.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var id = button.data('idorder');
    $(".confirmation_message").html("Apakah anda yakin ingin menyelesaikan order <b class='no_nota'>" + id + "</b>?");
    var modal = $(this);

    $.get(myurl + '/get_cust_detail_order',
    {id: id, request_from: 'rating_review'},
    function(result){
      console.log(result);
      var html = "";
       result.forEach(item => {
         html += `
         <div class="row border-bottom-1">
          <div class="col-12">
          <strong>${item.Name}</strong>
          <div class="starrating risingstar d-flex justify-content-end flex-row-reverse">
                <input type="radio" id="star5-${item.Id_detail_order}" name="rating-${item.Id_detail_order}" value="5" /><label for="star5-${item.Id_detail_order}" title="5 star"></label>
                <input type="radio" id="star4-${item.Id_detail_order}" name="rating-${item.Id_detail_order}" value="4" /><label for="star4-${item.Id_detail_order}" title="4 star"></label>
                <input type="radio" id="star3-${item.Id_detail_order}" name="rating-${item.Id_detail_order}" value="3" /><label for="star3-${item.Id_detail_order}" title="3 star"></label>
                <input type="radio" id="star2-${item.Id_detail_order}" name="rating-${item.Id_detail_order}" value="2" /><label for="star2-${item.Id_detail_order}" title="2 star"></label>
                <input type="radio" id="star1-${item.Id_detail_order}" name="rating-${item.Id_detail_order}" value="1" /><label for="star1-${item.Id_detail_order}" title="1 star"></label>
            </div>
            <div class="form-group">
              <label>Review</label>
              <textarea class="form-control review-${item.Id_detail_order}" rows="3"></textarea>
            </div>
            <button type="button" class="btn btn-success btn-sm mb-2" onclick="send_rating_review">Submit</button>
          </div>
        </div> 
        `
        
       });
       $(".rating_review .modal-body .container-fluid").append(html);
    });
 });
</script>


<script>
    var myurl = "<?php echo URL::to('/'); ?>";
   
   function konfirmasi_selesai(){
      var token = $(".csrf_token").val();
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
      });
      
      var id = $(".no_nota").html();
      $.post(myurl + '/order_confirmation',
      {id: id, CSRF: token},
      function(result){
          if(result == 'sukses'){
            $("#filter").val("4");
            filter();
          }
          
      });
   }

   function send_rating_review(id_detail_order){
    var token = $(".csrf_token").val();
    var review = $(".review-" + id_detail_order).val();
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
      });

      $.post(myurl + '/rate_review_order',
      {id_detail_order: id_detail_order, CSRF: token, review : review},
      function(result){
          if(result == 'sukses'){
           console.log(result);
          }
          
      });
   }

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
            if(dtk <= 0) {
                // lakukan ajax utk update status = 0 
                var Id_order = $("#txtnomernota" + i).val()
                // alert(Id_order);
                
                $.get(myurl + '/update_status',
                {Id_order:Id_order,Status: 0},
                function(result){
                  $("#card" + i).fadeOut(); 
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

    function pay_now(id) {
      // $.ajaxSetup({
      //       headers:
      //       { 'X-CSRF-TOKEN': $(".csrf_token").val() }
      //   });
      // $.ajax({
      //       type: "POST",
      //       url: myurl + '/pay_now',
      //       data: { order_id : id}
      //   })
      //   .done(function( msg ) {
      //     alert(msg);
      //       console.log(msg);
      //   });


        $.get(myurl + '/pay_now',
        {order_id: id},
        function(result){
            alert(result);

        });

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
    (function() {
	
  //RATING ANIMATION
    
  });

</script>

@endpush








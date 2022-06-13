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
<style>
  ul.timeline {
    list-style-type: none;
    position: relative;
}
ul.timeline:before {
    content: ' ';
    background: #d4d9df;
    display: inline-block;
    position: absolute;
    left: 29px;
    width: 2px;
    height: 100%;
    z-index: 400;
}
ul.timeline > li {
    margin: 20px 0;
    padding-left: 35px;
    margin-left: 10px;
}
ul.timeline > li:before {
    content: ' ';
    background: white;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 3px solid var(--background);
    left: 20px;
    width: 20px;
    height: 20px;
    z-index: 400;
}
  </style>
@endpush

@section('Content')
<!-- shopping-cart-area start -->
<input type="hidden" class="csrf_token" value="{{csrf_token()}}">
<div class="cart-main-area pt-95 pb-100 wishlist">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
      </div>
      <br><br>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            
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
        <div class="row">
          <div class="col-md-2">
            <b style="font-size: 100%">No. Resi:</b> 
          </div>
          <div class="col-md-10">
            <b id="no_resi">  </b>
          </div>
        </div>
        <div class="modal-body">
            
          <div class="container">
            <div class="row" style="width: 100%;">
              <div class="col-12">
                <table class='table table-dark' style="width: 100%;">
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
            <div class="row mt-3" style="width: 100% !important;">
              
              <div class="col-md-6">
                <h4>History</h4>
                <ul class="timeline timeline_field">
                  
                </ul>
              </div>
              <div class="col-md-6">
                {{ Form::button('Complete Order', ['name'=>'btn_edit','class'=>'btn btn-success btn-sm button_konfirmasi_order','data-idorder'=>$id_order,'data-toggle'=>'modal','data-target'=>'.konfirmasi_selesai', 'style' => "display:none"]) }}
              </div>
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
  var id_order = {!! $id_order !!};
  $('.viewdetail').on('show.bs.modal', function(event){
    var button = $(event.relatedTarget);
    // var id = button.data('idorder');
    var modal = $(this);

    $.get(myurl + '/get_cust_detail_order',
    {id: id_order},
    function(result){
        // alert(result);
        var cut = result.split("#");
        console.log(cut);
        var history = JSON.parse(cut[11]);
         $("#detail_order").html(cut[0]);
         $("#name").html(cut[1]);
         $("#phone").html(cut[2]);
         $("#email").html(cut[3]);
         $("#address").html(cut[4]);
         $("#ekspedisi").html(cut[5]);
         $("#weight").html(cut[6] + "Gr");
         $("#no_resi").html(cut[7]);

         if(cut[9] == "4"){
           $(".button_konfirmasi_order").css('display', 'block');
         }

         $(".timeline_field").html("");
        history.forEach(timeline => {
          $(".timeline_field").append(`<li class="${timeline.id}">
                <label>${moment(timeline.created_at).format("DD-MM-YYYY HH:mm:ss")}</label>
                <p>${timeline.Record}</p>
                ${timeline.Order_status == 4 ? "No. resi : <p>" + cut[7] + "</p>" : ""}
              </li>`);
          
          var line = document.getElementsByClassName(`${timeline.id}`)[0];
          if(timeline.Order_status == 0)
          {
            line.style.setProperty('--background', "#cf4a4f");
          }
          else if(timeline.Order_status == 1)
          {
            line.style.setProperty('--background', "#4d88db");
          }
          else if(timeline.Order_status == 2)
          {
            line.style.setProperty('--background', "#4d88db");
          }
          else if(timeline.Order_status == 3)
          {
            line.style.setProperty('--background', "#9e9228");
          }
          else if(timeline.Order_status == 4)
          {
            line.style.setProperty('--background', "#a638c2");
          }
          else if(timeline.Order_status == 5)
          {
            line.style.setProperty('--background', "#53c95b");
          }
        });
    });
     
 })
 
 $(".konfirmasi_selesai").on('show.bs.modal', function(event){
    var button = $(event.relatedTarget);
    var id = button.data('idorder');
    $(".confirmation_message").html("Apakah anda yakin ingin menyelesaikan order <b class='no_nota'>" + id + "</b>?");
    var modal = $(this);
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
            window.location.reload();
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
        $(".viewdetail").modal("show");
        console.log('test');
    });

    function ganti_filter()
    {
     
    }

    // function pay_now(id) {
    //   // $.ajaxSetup({
    //   //       headers:
    //   //       { 'X-CSRF-TOKEN': $(".csrf_token").val() }
    //   //   });
    //   // $.ajax({
    //   //       type: "POST",
    //   //       url: myurl + '/pay_now',
    //   //       data: { order_id : id}
    //   //   })
    //   //   .done(function( msg ) {
    //   //     alert(msg);
    //   //       console.log(msg);
    //   //   });


    //     // $.get(myurl + '/pay_now',
    //     // {order_id: id},
    //     // function(result){
    //     //     alert(result);

    //     // });

    // }

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








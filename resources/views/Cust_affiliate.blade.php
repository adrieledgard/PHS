@extends('layout_frontend.Master')


@push('custom-css')
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
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush




@section('Content')
<!-- shopping-cart-area start -->
<div class="cart-main-area pt-95 pb-100 wishlist">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1 class="cart-heading">Affiliate Marketing</h1>
                <form action="#">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Variation</th>
                                    {{-- <th>Price</th>
                                    <th>Poin</th> --}}
                                    <th>Share Link</th>
                                    {{-- <th>Embed Code</th> --}}
                                    <th>Total Clicked</th>
                                    <th>Total Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($dtproduct as $dtpro)
                                
                                    @php
                                        $sudah=0;
                                    @endphp
                                    @foreach ($affiliate as $data_aff)
                                        
                                        <?php
                                            if(($data_aff->Id_product == $dtpro->Id_product ) && ($sudah==0))
                                            {
                                                $sudah=1;
                                                $imgname = "default.jpg";
                                                
                                                foreach ($dtproductimage as $img)
                                                {
                                                    
                                                    $idp = $dtpro->Id_product;
                                                    $idi = $img->Id_product;
                                                    $urutan = $img->Image_order;
                                                    
                                                    if (($idp == $idi) && ($urutan==1))
                                                    {
                                                        $imgname = $img->Image_name;
                                                    }
                                                }

                                                ?>
                                                    <tr>
                                                        <td>
                                                            <img src="{{ asset('Uploads/Product/'.$imgname )}}" width='150px' height='150px' class="center"> 
                                                        </td>
                                                        <td style="text-align: left">
                                                            <b>{{$dtpro->Name}}</b>
                                                            <br>Brand : {{$dtpro->Brand_name}}
                                                            <br>Type : {{$dtpro->Type_name}}
                                                        </td>
                                                        <td style="text-align: left">
                                                            @foreach ($dtvariation as $datavar)
                                                                <?php
                                                                    $poin=0;
                                                                    if($datavar->Id_product == $dtpro->Id_product)
                                                                    {
                                                                        ?>
                                                                            <b>
                                                                                {{$datavar->Option_name}}<br>

                                                                                @foreach ($affiliate as $data_aff_2)
                                                                                    @php
                                                                                        if($datavar->Id_variation == $data_aff_2->Id_variation)
                                                                                        {
                                                                                            $poin = $data_aff_2->Poin; 
                                                                                        }
                                                                                    @endphp
                                                                                @endforeach
                                                                            </b>
                                                                                Poin : {{number_format($poin)}} <br><br> 
                                                                            
                                                                        <?php
                                                                    }

                                                                ?>
                                                            @endforeach
                                                        </td>

                                                        <td>
                                                            <?php
                                                            $username="";
                                                            try {
                                                              //code...
                                                              if(session()->get('userlogin')->Role=="CUST")
                                                              {
                                                                  $randomcode = session()->get('userlogin')->Random_code;
                                                              }
                                                              
                                                            } catch (\Throwable $th) {
                                                              //throw $th;
                                                              
                                                              $randomcode="";
                                                            }
                                                            ?>
                                                            <input type="text" value="https://localhost/PusatHerbalStore/public/Cust_show_product/{{$dtpro->Id_product}}/{{$randomcode}}" id="linkshare_{{$dtpro->Id_product}}">
                                                             
                                                            <button class="btn btn-primary" onclick="copyToClipboard('{{$dtpro->Id_product}}')"> Copy</button>
                                                            
                                                        </td>
                                                        {{-- <td></td> --}}
                                                        {{-- <td>{{$data_aff->Total_diklik}} </td> --}}
                                                        <td>
                                                            @php
                                                            $totaldiklik=0;
                                                            if($data_aff->Total_diklik=='')
                                                            {
                                                                $totaldiklik=0;
                                                            }
                                                            else if( $data_aff->Id_member == session()->get('userlogin')->Id_member)
                                                            {
                                                                $totaldiklik = $data_aff->Total_diklik;
                                                            }
                                                        @endphp
                                                        {{$totaldiklik}}

                                                        </td>

                                                        @php
                                                            $count=0;
                                                            $daftarorder="";
                                                        @endphp

                                                        @foreach ($cust_order as $data)
                                                        @php
                                                           
                                                            if(str_contains($data->Tracking_code, 'LINK'))
                                                            {
                                                                $temp = explode("-" ,$data->Tracking_code);
                                                                $Id_product= $temp[1];
                
                                                                if($Id_product == $dtpro->Id_product)
                                                                {
                                                                    $count++;
                                                                    $daftarorder = $daftarorder.",".$data->Id_order;
                                                                    // cust_order_header::where("Id_member", $member->Id_member)->orderBy('Id_order', 'desc')->get();
                                                                }
                                                            }
                                                        @endphp
                                                        
                                                        
                                                    @endforeach
                                                    <td>
                                                        {{ $count }}
                                                    <br>
                                                        @if ($count > 0)
                                                        {{ Form::button('Detail order', ['name'=>'btn_edit','class'=>'btn btn-info btn-sm ','data-order'=>$daftarorder,'data-toggle'=>'modal','data-target'=>'#rincian_order']) }}
                                                        @endif
                                                    
                                                    </td>

                                                  
                                                    </tr>
                                                <?php
                                            }

                                        ?>
                                    @endforeach
                                   
                          
                                @endforeach
                                
                                 
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="rincian_order" class="modal fade" role="dialog" style="max-height:calc(100% - 80px)">
    <div class="modal-dialog modal-dialog-scrollable modal-xl"> 
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Rincian Order </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="overflow-y: scroll">
            <table class="table-rincian-order" id="table-order-1">
                <thead style="width:100%">
                    <tr>
                        <th>Nomor Transaksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Alamat</th>
                        <th>Kurir</th>
                        <th>Grand Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-body-rincian-order">
                    
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>





  <div id="rincian_order_detail" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Rincian Order </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <table class="table-rincian-item-order">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Total dipesan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody class="table-body-rincian-item-order">
                    
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script>
$(document).ready( function () {
//   $('#rincian_order').DataTable();
    // $("#table-order-1").DataTable();
  
    $('.login-info-box').fadeOut();
    $('.login-show').addClass('show-log-panel');
});
</script>

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
<!-- overlayScrollbars -->
<script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/dist/js/pages/dashboard.js') }}"></script>

<script src ="{{ asset ('js/register-login/register-login.js') }}"></script>


<script>
    function copyToClipboard(Id_product) {
        var copyText = document.getElementById('linkshare_'+Id_product)
        copyText.select();
        document.execCommand('copy')
        toastr["success"]("Success Copy", "Success");
        }

    var myurl = "<?php echo URL::to('/'); ?>";
    function updateqtywishlist(id_var,id_wish)
    {
        // alert($("#qtywish"+id).val());
        // alert($("#harga"+id).val());
        // alert($("#qtywish"+id).val() * $("#harga"+id).val());
         $("#subtotal"+id_var).html('Rp. '+ ($("#qtywish"+id_var).val() * $("#harga"+id_var).val()).toString().number_format());
        // alert($("#qtywish"+id).val());
        

        $.get(myurl + '/updateqtywishlist',
        {Id_wishlist: id_wish,Qty:$("#qtywish"+id_var).val()},
        function(result){

        });
    }

    function deletewishlist(id_wish)
    {
        alert(id_wish);
        $.get(myurl + '/deletewishlist',
        {Id_wishlist: id_wish},
        function(result){
            location.reload();
        });
    }
    $("#rincian_order").on('show.bs.modal', function(event){
       var button = $(event.relatedTarget);
       var orders = button.data('order')
       $(".table-body-rincian-order").html("");
   
       $.get(myurl + '/Show_detail_order',
       {kumpulan_id_order: orders},
       function(result){
          
           $(".table-body-rincian-order").append(result);
           $(".table-rincian-order").DataTable();
          
       });
    });
   
   
   
   
//    $("#rincian_order_detail").on('show.bs.modal', function(event){
//        var formatter = new Intl.NumberFormat('en-US', {style:'currency', 'currency':"IDR", currencyDisplay:'narrowSymbol'});
//        if ( $.fn.DataTable.isDataTable('.table-rincian-item-order') ) {
//          $('.table-rincian-item-order').DataTable().destroy();
//        }
//        var button = $(event.relatedTarget);
//        var detail_order = button.data('order-detail');
   
//        $(".table-body-rincian-item-order").html("");
//        detail_order.forEach(detail => {
//            $(".table-body-rincian-item-order").append(`
//                <tr>
//                    <td>
//                        `+detail.Name+`
//                    </td>
//                    <td>
//                        `+formatter.format(detail.Fix_price)+`
//                    </td>
//                    <td>
//                        `+detail.Qty+`
//                    </td>
//                    <td>
//                        `+formatter.format(detail.Qty * detail.Fix_price)+`
//                    </td>
//                </tr>
//            `)
//        });
//        $(".table-rincian-item-order").DataTable();
//     });
    
</script>



@endpush








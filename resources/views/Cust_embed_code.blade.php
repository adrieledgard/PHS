@extends('layout_frontend.Master')


@push('custom-css')

    {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="{{ asset ('css/register-login/register-login.css') }}" rel="stylesheet" type="text/css">  --}}
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
                <h1 class="cart-heading">Affiliate Embed code</h1>
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
                                    <th>Embed Code</th>
                                    <th>Total Checkout</th>
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

                                                                @php
                                                                //     $embedcode= "<script type='text/javascript' charset='utf-8'>     
                                                                // var iframe = document.createElement('iframe');       
                                                                // document.body.appendChild(iframe);
                                                                // iframe.src = 'https://localhost/PusatHerbalStore/public/embed_code/{$dtpro->Id_product}/{$randomcode}';       
                                                                // iframe.width = '100%';
                                                                // iframe.height = 600; 
                                                                // </script>;";

                                                                $embedcode= "<iframe src='https://localhost/PusatHerbalStore/public/embed_code/{$dtpro->Id_product}/{$randomcode}' frameborder='0' style='width:85%; height:80%; position:absolute'></iframe>";
                                                                @endphp
                                                            
                                                               

                                                            <input type="text" value="{{$embedcode}}" id="linkshare_{{$dtpro->Id_product}}">
                                                             
                                                            <button class="btn btn-primary" onclick="copyToClipboard('{{$dtpro->Id_product}}')"> Copy</button>
                                                            
                                                        </td>
                                                        {{-- <td></td> --}}
                                                        {{-- <td>{{$data_aff->Total_diklik}} </td> --}}
                                                        <td>
                                                            @php
                                                            $totaldiklik=0;
                                                            if(empty($data_aff->embed_aff))
                                                            {
                                                                $totaldiklik=0;
                                                            }
                                                            else
                                                            {
                                                                $totaldiklik = $data_aff->embed_aff->Total_diklik;
                                                            }
                                                        @endphp
                                                        {{$totaldiklik}}
                                                        <br>
                                                        @if ($totaldiklik > 0)
                                                        {{ Form::button('Detail Checkout', ['name'=>'btn_edit','class'=>'btn btn-info btn-sm ','data-checkout'=>$data_aff->embed_aff->submitted,'data-toggle'=>'modal','data-target'=>'#checkout_detail']) }}
                                                        @endif
                                                        </td>

                                                        @php
                                                            $count=0;
                                                            $daftarorder="";
                                                        @endphp

                                                        @foreach ($cust_order as $data)
                                                        @php
                                                            if(str_contains($data->Tracking_code, 'EMBED'))
                                                            {
                                                                $temp = explode("-" ,$data->Tracking_code);
                                                                $Id_product= $temp[1];
                
                                                                if($Id_product == $dtpro->Id_product)
                                                                {
                                                                    $count++;
                                                                    $daftarorder = $daftarorder.",".$data->Id_order;
                                                                }
                                                            }
                                                        @endphp
                                                        
                                                        
                                                    @endforeach
                                                    <td>{{ $count }} <br>
                                                        {{ Form::button('Detail order', ['name'=>'btn_edit','class'=>'btn btn-info btn-sm ','data-order'=>$daftarorder,'data-toggle'=>'modal','data-target'=>'#rincian_order']) }}
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

<div id="checkout_detail" class="modal fade" role="dialog" style="max-height:calc(100% - 80px)">
    <div class="modal-dialog modal-dialog-scrollable modal-xl"> 
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Rincian Checkout </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="overflow-y: scroll">
            <table class="table-checkout-detail" >
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Date checkout</th>
                        <th>Already buy</th>
                    </tr>
                </thead>
                <tbody class="table-body-checkout-detail">
                    
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                        <th>Name & Phone</th>
                        <th>Alamat</th>
                        {{-- <th>Kurir</th> --}}
                        <th>Gross Total</th>
                        <th>Shipping Cost</th>
                        <th>Diskon Voucher</th>
                        <th>Grand Total</th>
                        <th>Total Point</th>
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
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
  
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
                        <th>Variant</th>
                        <th>Normal Price</th>
                        <th>Discount</th>
                        <th>Fix Price</th>
                        <th>Total dipesan</th>
                        <th>Subtotal</th>
                        <th>Point</th>
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
<script src="{{asset('assets\plugins\moment\moment.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function(){

      $('.login-info-box').fadeOut();
      $('.login-show').addClass('show-log-panel');


  });
  
  function copyToClipboard(Id_product) {
  var copyText = document.getElementById('linkshare_'+Id_product)
  copyText.select();
  document.execCommand('copy')
  toastr["success"]("Success Copy", "Success");
}




  String.prototype.number_format = function(d) {
    var n = this;
    var c = isNaN(d = Math.abs(d)) ? 2 : d;
    var s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + ',' : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + ',');
}
</script>

<script src ="{{ asset ('js/register-login/register-login.js') }}"></script>





<script>
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
   
    
    $("#checkout_detail").on('show.bs.modal', function(event){
        if ( $.fn.DataTable.isDataTable('.table-checkout-detail') ) {
         $('.table-checkout-detail').DataTable().destroy();
       }
       var button = $(event.relatedTarget);
       var checkout_detail = button.data('checkout');
       $(".table-body-checkout-detail").html("");
       checkout_detail.forEach(detail => {
            console.log(moment);
            if(detail.Id_order == null)  // blm beli
            {
                $(".table-body-checkout-detail").append(`
               <tr>
                    <td>
                        `+detail.Name+`
                    </td>
                    <td>
                        `+detail.Email +`
                    </td>
                    <td>
                        `+detail.Phone+`
                    </td>
                    <td>
                        `+detail.namaproduk+` (`+detail.variasi+`)
                    </td>
                    <td>
                        `+detail.Qty+`
                    </td>
                    <td>
                        `+detail.submitted_date+`
                    </td>
                    <td>
                        No
                    </td>
                   
               </tr>
                `)
            }
            else
            {
                var potong = detail.Tracking_code.split("-"); //Pastikan embed
                // alert(potong);
                if(potong[0]=='EMBED')//Pastikan embed
                {
                    $(".table-body-checkout-detail").append(`
                    <tr>
                            <td>
                                `+detail.Name+`
                            </td>
                            <td>
                                `+detail.Email +`
                            </td>
                            <td>
                                `+detail.Phone+`
                            </td>
                            <td>
                                `+detail.namaproduk+` (`+detail.variasi+`)
                            </td>
                            <td>
                                `+detail.Qty+`
                            </td>
                            <td>
                                `+detail.submitted_date+`
                            </td>
                            <td>
                                Yes
                                <button class='btn btn-sm btn-info' data-toggle='modal' data-target='#rincian_order' data-order='`+detail.Id_order+`'>Rincian</button>
                                
                            </td>
                        
                    </tr>
                    `)

                }
                
            }
           
       });
       $(".table-checkout-detail").DataTable();
    });

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
   
   
   $("#rincian_order_detail").on('show.bs.modal', function(event){
       var formatter = new Intl.NumberFormat('en-US', {style:'currency', 'currency':"IDR", currencyDisplay:'narrowSymbol'});
       if ( $.fn.DataTable.isDataTable('.table-rincian-item-order') ) {
         $('.table-rincian-item-order').DataTable().destroy();
       }
       var button = $(event.relatedTarget);
       var detail_order = button.data('order-detail');

       $(".table-body-rincian-item-order").html("");
       detail_order.forEach(detail => {
           $(".table-body-rincian-item-order").append(`
               <tr>
                    <td>
                        `+detail.Name+`
                    </td>
                    <td>
                        `+detail.Variant_name + `(`+ detail.Variant_option_name+`)
                    </td>
                    <td>
                        `+formatter.format(detail.Normal_price)+`
                    </td>
                    <td>
                        `+formatter.format(detail.Discount_promo)+`
                    </td>
                    <td>
                        `+formatter.format(detail.Fix_price)+`
                    </td>
                    <td>
                        `+detail.Qty+`
                    </td>
                    <td>
                        `+formatter.format(detail.Qty * detail.Fix_price)+`
                    </td>
                    <td>
                        `+detail.point+`
                    </td>
               </tr>
           `)
       });
       $(".table-rincian-item-order").DataTable();
    });
</script>

@endpush








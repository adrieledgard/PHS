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
                <h1 class="cart-heading">Ebook Marketing</h1>
                <form action="#">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    {{-- <th>Subcategory</th> --}}
                                    <th>Title</th>
                                    {{-- <th>Content</th> --}}
                                    {{-- <th>Price</th>
                                    <th>Poin</th> --}}
                                    <th>Share Link</th>
                                    <th>Total Downloaded</th>
                                    <th>Total Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($ebooks as $ebook)
                                
                                <tr>
                                    <td>
                                        <img src="{{ asset('Uploads/Ebook/'.$ebook->Image )}}" width='150px' height='150px' class="center"> 
                                    </td>
                                    {{-- <td style="text-align: left">
                                        <b>{{$ebook->sub_category->Sub_category_name}}</b>
                                    </td> --}}
                                    <td style="text-align: left">
                                        <b>{{$ebook->Title}}</b>
                                    </td>
                                    {{-- <td style="text-align: left">
                                        <b>{{$ebook->Content}}</b>
                                    </td> --}}
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
                                        <input type="text" value="https://localhost/PusatHerbalStore/public/master_ebook/{{$ebook->Id_ebook}}/show/{{$randomcode}}" id="linkshare_{{$ebook->Id_ebook}}">
                                         
                                        <button class="btn btn-primary" onclick="copyToClipboard('{{$ebook->Id_ebook}}')"> Copy</button>
                                        
                                    </td>
                                    <td>
                                        @php
                                            $totaldownload=0;
                                            if($ebook->Total_didownload=='')
                                            {
                                                $totaldownload=0;
                                            }
                                            else if($ebook->Id_member == session()->get('userlogin')->Id_member)
                                            {
                                                $totaldownload = $ebook->Total_didownload;
                                            }
                                        @endphp
                                        {{$totaldownload}}
                                        <br>
                                        @if ($totaldownload > 0)
                                        {{ Form::button('Detail download', ['name'=>'btn_edit','class'=>'btn btn-info btn-sm ','data-download'=>$ebook->downloaded_detail,'data-toggle'=>'modal','data-target'=>'#download_detail']) }}
                                        @endif
                                    </td>
                                   
                                    @php
                                        $count=0;
                                        $daftarorder="";
                                    @endphp
                                    @foreach ($cust_order as $data)
                                        @php
                                            if(str_contains($data->Tracking_code, 'EBOOK'))
                                            {
                                                $temp = explode("-" ,$data->Tracking_code);
                                                $Id_ebook= $temp[1];

                                                if($Id_ebook == $ebook->Id_ebook)
                                                {
                                                    $count++;
                                                    $daftarorder = $daftarorder.",".$data->Id_order;
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
                                   
                          
                                @endforeach
                                
                                 
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="download_detail" class="modal fade" role="dialog" style="max-height:calc(100% - 80px)">
    <div class="modal-dialog modal-dialog-scrollable modal-lg"> 
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Rincian Download </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="overflow-y: scroll">
            <table class="table-download-detail" >
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Tanggal Download</th>
                        <th>Already buy</th>
                    </tr>
                </thead>
                <tbody class="table-body-download-detail">
                    
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
    $("#download_detail").on('show.bs.modal', function(event){
        if ( $.fn.DataTable.isDataTable('.table-download-detail') ) {
         $('.table-download-detail').DataTable().destroy();
       }
       var button = $(event.relatedTarget);
       var download_detail = button.data('download');

       $(".table-body-download-detail").html("");
       download_detail.forEach(detail => {

            if(detail.Address == null) // blm beli
            {
                $(".table-body-download-detail").append(`
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
                        `+detail.Date_request+`
                    </td>
                    <td>
                        No
                    </td>
                   
               </tr>
                `)
            }
            else //allready buy
            {
                $(".table-body-download-detail").append(`
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
                        `+detail.Date_request+`
                    </td>
                    <td>
                        Yes
                        <button class='btn btn-sm btn-info' data-toggle='modal' data-target='#rincian_order' data-order='`+detail.Id_order+`'>Rincian</button>
                        
                    </td>
                   
               </tr>
                `)
            }
           
       });
       $(".table-download-detail").DataTable();
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








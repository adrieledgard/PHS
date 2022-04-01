@extends('layout_frontend.Master')


@push('custom-css')

    {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="{{ asset ('css/register-login/register-login.css') }}" rel="stylesheet" type="text/css">  --}}

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
                                    <td>{{$ebook->Total_didownload}}</td>
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

@endsection


@push('custom-js')

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
</script>

@endpush








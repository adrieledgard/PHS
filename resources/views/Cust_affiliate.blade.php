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
                                                                }
                                                            }
                                                        @endphp
                                                        
                                                        
                                                    @endforeach
                                                    <td>{{ $count }}</td>
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








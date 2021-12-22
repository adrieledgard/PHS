@extends('layout_frontend.Master')


@push('custom-css')

 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

 <link href="{{ asset ('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

 {{-- <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"> --}}
        
 

@endpush




@section('Content')
<!-- shopping-cart-area start -->
<div class="cart-main-area pt-95 pb-100 wishlist">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h4>Jangan lupa buat transaksi poin, keluar masuk poin di catat di database</h4><br>
                <h4>history poin keluar jangan lupa di buat dibawah (IF nya jgn lupa supaya bs muncul description)</h4>
                <h4>history poin cart jangan lupa</h4>
                <div class="row">
                    <div class="col-md-2">
                        <h1 class="cart-heading">Point</h1>
                        <h1 id="showpoint">{{$dtmember[0]->Point}}</h1>
                    </div>

                    <div class="col-md-6">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#history_point">History Point</button>

                        
                        <button class="btn btn-warning"><a href="{!!url('My_voucher')!!}">My Voucher</a></button>
                    </div>
                 
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-12">
                      <table id="table_id" class='table table-striped display'>
                        <thead>
                          <tr>
                            <th>Voucher Name</th>
                            <th>Voucher Type</th>
                            <th>Discount</th>
                            <th>Redeem point</th>
                            <th>Redemption limit</th> 
                            <th>Join Promo</th>
                            <th>Action</th>
                          </tr>
                      </thead>
                    
                      <tbody>
                        @foreach ($dtvoucher as $data)
                            <tr>
                              <td>{{$data->Voucher_name}}</td>

                              <?php
                                if($data->Voucher_type == "Disc Selected Product")
                                {
                                  ?>
                                    <td>{{$data->Voucher_type}}  <button class="btn btn-warning" data-toggle="modal" data-target="#info_product" data-vcr="{{$data->Id_voucher}}"> info </button></td>
                                  <?php
                                }
                                else {
                                  ?>
                                    <td>{{$data->Voucher_type}} </td>
                                  <?php
                                }
                              ?>
                            
                              <td>{{"Rp. ".number_format($data->Discount)}}
                              </td>
                              <td>{{$data->Point}}</td>
                              <td>{{ date("d-m-Y", strtotime($data->Redeem_due_date)) }}</td>
                              <td>
                                  <?php
                                    if($data->Joinpromo==1)
                                    {
                                        ?>
                                        Yes
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        No
                                        <?php
                                    }
                                  ?>
                              
                            
                                </td>
                              <td>
                               
                                {{ Form::button('Claim', ['name'=>'btn_claim','class'=>'btn btn-success btn-sm ','onclick'=>'claim('.$data->Id_voucher.')']) }}
                              
                              </td>
                            </tr>
                        @endforeach
                      </tbody>
                        
                    
                      </table>
                    </div>
                  </div>  
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="history_point">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">History Point</h4>
        {{-- <button style="color:black" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> --}}
      </div>
      <div class="container">
          <div class="row">
            <div class="col-md-12" id="isi_history">
              <table class="table_id_2" class='table table-striped display'>
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>+ / -</th>
                  </tr>
              </thead>
            
              <tbody>
                @foreach ($dtpoint_card as $data)
                    <tr>
                      <td>{{ date("d-m-Y", strtotime($data->Date_card)) }}</td>

                      <?php

                        $txt="";
                        if($data->Type == "Claim voucher")
                        {
                          foreach ($dtvoucher_all as $dtvc) {
                            if($dtvc->Id_voucher == $data->No_reference)
                            {
                              $txt = "Claim voucher - ".$dtvc->Voucher_name;
                            }
                          }
                        }
                        else if($data->Type == "Affiliate Success")
                        {
                          
                          foreach ($dtcustheader as $dtch) {
                            if($dtch->Id_order == $data->No_reference)
                            {
                              $txt = "Affiliate Success - ".$dtch->Name;
                            }
                          }
                        }


                      ?>

                      <td>{{$txt}}</td>

                      <?php
                        $plusmines="";
                        if($data->Debet==0)
                        {
                          ?>
                            <td style="color: red">
                                <b>-{{$data->Credit}}</b>             
                            </td>
                          <?php
                        }
                        else {
                          ?>
                            <td style="color: green">
                                <b>+{{$data->Debet}}</b>             
                            </td>
                          <?php
                        }

                      ?>
                    

                      
                    </tr>
                @endforeach
              </tbody>
                
            
              </table>
            </div>
          </div>

     
      </div>
          <div class="modal-footer">
            {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
          </div>
     
    </div>
  </div>
</div>



<div class="modal fade" id="info_product">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><b>LIST PRODUCT FOR VOUCHER - </b> <b id="isi_voucher_name"></b></h4>
        {{-- <h4 class="modal-title">Info Product</h4> --}}
      
      </div>
      <div class="container">
          <div class="row">
            <div class="col-md-12" id="isi_info_product">
             
              <table class='table table-striped display table_id_3'>
                <thead>
                  <tr>
                    <th>Product Image</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Type</th>
                    <th>Variation</th>
                  </tr>
              </thead>
            
              <tbody>
                
              </tbody>
                
            
              </table>
            </div>
          </div>

     
      </div>
          <div class="modal-footer">
            {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
          </div>
     
    </div>
  </div>
</div>


@endsection


@push('custom-js')


<script src ="{{ asset ('js/jquery.js') }}"></script>
<script src ="{{ asset ('js/bootstrap.js') }}"></script>


<script>
    
    $(document).ready(function(){

      $('.login-info-box').fadeOut();
      $('.login-show').addClass('show-log-panel');



  });
  
  String.prototype.number_format = function(d) {
    var n = this;
    var c = isNaN(d = Math.abs(d)) ? 2 : d;
    var s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + ',' : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + ',');
}


</script>


<script>
  $('#info_product').on('show.bs.modal', function(event){
    
    var button = $(event.relatedTarget);
    var id = button.data('vcr');
    var modal = $(this);
    //modal.find('.modal-body #id_category').val(id);


    var myurl = "<?php echo URL::to('/'); ?>";

      $.get(myurl + '/get_voucher_selected_product',
      {Id_voucher: id},
      function(result){
       
        var cut = result.split("#");

        $('#isi_info_product').html(cut[0]);
        $('.table_id_3').DataTable();
        $('#isi_voucher_name').html(cut[1]);
        

        
      });

  })


  
</script>


<script>
    $(document).ready( function () {
      $('#table_id').DataTable();
      $('.table_id_2').DataTable();
      $('.table_id_3').DataTable();
      
    } );
    </script>
<script src ="{{ asset ('js/register-login/register-login.js') }}"></script>

<script>
    var myurl = "<?php echo URL::to('/'); ?>";
    
    function claim(Id_voucher)
    {
        $.get(myurl + '/claim_voucher',
        {Id_voucher:Id_voucher},
        function(result){
        
        if(result=="ga cukup")
        {
            toastr["error"]("Point no enough", "Failed");
        }
        else if (result=="gagal validasi voucher")
        {
          toastr["error"]("Voucher not available", "Failed");
        }
        else
        {
          var cut = result.split("#");

            $("#showpoint").html(cut[0]);
            $("#isi_history").html(cut[1]);
            $('.table_id_2').DataTable();
            $('.table_id_3').DataTable();
            toastr["success"]("Success to claim voucher", "Success");
            // window.location = myurl + "/point/";
            
        }
        
        });

    }
</script>

 <!-- CDN DATA TABLE -->
 <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
@endpush








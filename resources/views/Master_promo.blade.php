@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('masterpromo_atv')
  active
@endsection

@section('menu_master')
   menu-open
@endsection
{{-- ------------- --}}

@section('title2')
    Master Promo
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Master Promo</li>
@endsection


@section('title')
  Master Promo
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
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Insert', ['class'=>'btn btn-primary','data-toggle'=>'modal','data-target'=>'#add_modal','onclick'=>'resetsession()']) }}
      </div>
        
        <br>
        <br>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <table id="table_id" class='table table-striped display'>
          <thead>
            <tr>
              <th>Status</th>
              <th>Product Name</th>
              <th>Variation</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Action</th>
            </tr>
          </thead>
      
          <tbody>
            @foreach ($dtheaderpromo as $data)
            <tr>
              @php
              if($data->Status ==1) //Active //0 Deleted
              {
                echo "<td><button type='button' class='btn btn-success btn-sm' disabled>Active</button></td>";
              }
              else if($data->Status == 2) //Expire
              {
                echo "<td><button type='button' class='btn btn-danger btn-sm' disabled>Expire</button></td>";
              }
              else if($data->Status == 3) //Coming soon
              {
                echo "<td><button type='button' class='btn btn-primary btn-sm' disabled>Coming soon</button></td>";
              }
            
            

              //  echo "<td> <span class='label label-info'>Info Label</span></td>";
            @endphp 
              <td>{{$data->Name}}</td>
              <td>{{$data->Option_name}}</td>
              <td>{{ date("d-m-Y", strtotime($data->Start_date)) }}</td>
              <td>{{ date("d-m-Y", strtotime($data->End_date)) }}</td>
        
              <td> 
                {{ Form::button('Edit', ['class'=>'btn btn-warning btn-sm ','data-toggle'=>'modal','data-target'=>'#edit_modal','data-id'=>$data->Id_promo]) }}
                {{ Form::button('Delete', ['class'=>'btn btn-danger btn-sm ','data-toggle'=>'modal','onclick'=>'delete_promo('.$data->Id_promo.')']) }}
               {{-- testes --}}
               
                {{-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit_modal" data-id="{{$data->Id_promo}}">Edit</button> --}}
               {{-- <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#edit_modal" data-id="{{$data->Id_category}}">Non-active</button>   --}}
               {{-- {{ Form::button('Edit', ['name'=>'btn_edit','class'=>'btn btn-warning btn-sm ','data-cat'=>$data->Id_bank,'data-toggle'=>'modal','data-target'=>'#edit_modal']) }} --}}
                {{-- {{ Form::button('Delete', ['name'=>'btn_delete','class'=>'btn btn-danger btn-sm ','onclick'=>'deletebank('.$data->Id_bank.')']) }} --}}
               
              </td>
            </tr>
            @endforeach 
          </tbody>
        </table>
      </div>
    </div>    
      
    </div>
  </div>



<!--ADD Modal -->
  <div class="modal fade" id="add_modal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Insert Promo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          {{-- <form class="" method='post' action='add_promo'>
            @csrf --}}
            <div class="modal-body">

            
            <div class="row">
              <div class="col-md-6">
                <div class="col-md-12">
              
                  {{ Form::label('Product :','') }}
                  {{ Form::select('cb_product', $arr_product, 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_product', 'onchange' => 'loadvariation()' ]) }}
                
                </div>
  
                <div class="col-md-12">
                  {{ Form::label('Variation :','') }}
                  {{ Form::select('cb_variation', [], 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_variation' ]) }}
    
                </div>
  
                <div class="col-md-12">
                  <div class="form-group">
                    {{ Form::label('Start Date :','') }} 
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        {{ Form::text('txt_start_date', '', ['id'=>'txt_start_date','class'=>'form-control datetimepicker-input','data-target' => '#reservationdate','readonly' => 'true']) }}
                          {{-- <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"/> --}}
                          <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
                  </div>
                </div>
  
                <div class="col-md-12">
                  <div class="form-group">
                    {{ Form::label('End Date :','') }} 
                      <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                        {{ Form::text('txt_end_date', '', ['id'=>'txt_end_date','class'=>'form-control datetimepicker-input','data-target' => '#reservationdate2','readonly' => 'true']) }}
                          {{-- <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"/> --}}
                          <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 border-left">
                <div class="row">
                  <div class="col-md-3">
                    {{ Form::label('Model promo :','') }} 
                    {{ Form::select('cb_model', ['%','Rp'], 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_model' ]) }}
                  </div>
                
                    <div class="col-md-5 border-left">
                      {{ Form::label('Discount :','') }} 
                      <input type='number' min='1' id='txt_discount' value="1" class="form-control" onchange="validasi()">
                    </div>
                    <div class="col-md-4">
                      {{ Form::label('Min Qty :','') }} 
                      <input type='number' min='1' id='txt_minqty' value="1" class="form-control" onchange="validasi()" >
                    </div>
             
                  <div class="col-md-12">
                    <br>
                    <button type='button' class='btn btn-warning btn-md float-right' onclick="setdiscount('add')" > Set </button>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-12">
                    <table class='table table-dark'>
                      <thead>
                        <tr>
                          <th>Min Qty</th>
                          <th>Discount</th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_promo">
      
                    </tbody>
                    </table>
                  </div>
                </div>
              </div>
              
              
            </div>

            </div>
            <div class="modal-footer">
              {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
              {{ Form::button('Insert', ['name'=>'add_promo', 'class'=>'btn btn-primary', 'onclick'=>'add_promo()']) }}
            </div>
          {{-- </form> --}}
        <div class="container-fluid">
          
        </div>
      </div>
    </div>
  </div>



<!--EDIT Modal -->
<div class="modal fade" id="edit_modal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">EDIT Promo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        {{-- <form class="" method='post' action='add_promo'>
          @csrf --}}
          <div class="modal-body">

          
          <div class="row">
            <div class="col-md-6">
              <div class="col-md-12">
            
                {{ Form::label('Product :','') }}
                {{ Form::select('cb_product_edit', $arr_product, 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_product_edit', 'onchange' => 'loadvariationedit()' ]) }}
              
              </div>

              <div class="col-md-12">
                {{ Form::label('Variation :','') }}
                {{ Form::select('cb_variation_edit', [], 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_variation_edit' ]) }}
  
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  {{ Form::label('Start Date :','') }} 
                    <div class="input-group date" id="reservationdate3" data-target-input="nearest">
                      {{ Form::text('txt_start_date_edit', '', ['id'=>'txt_start_date_edit','class'=>'form-control datetimepicker-input','data-target' => '#reservationdate3','readonly' => 'true']) }}
                        {{-- <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"/> --}}
                        <div class="input-group-append" data-target="#reservationdate3" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  {{ Form::label('End Date :','') }} 
                    <div class="input-group date" id="reservationdate4" data-target-input="nearest">
                      {{ Form::text('txt_end_date_edit', '', ['id'=>'txt_end_date_edit','class'=>'form-control datetimepicker-input','data-target' => '#reservationdate4','readonly' => 'true']) }}
                        {{-- <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"/> --}}
                        <div class="input-group-append" data-target="#reservationdate4" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 border-left">
              <div class="row">
                <div class="col-md-3">
                  {{ Form::label('Model promo :','') }} 
                  {{ Form::select('cb_model_edit', ['%','Rp'], 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_model_edit' ]) }}
                </div>
              
                  <div class="col-md-5 border-left">
                    {{ Form::label('Discount :','') }} 
                    <input type='number' min='1' id='txt_discount_edit' value="1" class="form-control" onchange="validasi()">
                  </div>
                  <div class="col-md-4">
                    {{ Form::label('Min Qty :','') }} 
                    <input type='number' min='1' id='txt_minqty_edit' value="1" class="form-control" onchange="validasi()" >
                  </div>
           
                <div class="col-md-12">
                  <br>
                  <button type='button' class='btn btn-warning btn-md float-right' onclick="setdiscount('edit')" > Set </button>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-12">
                  <table class='table table-dark'>
                    <thead>
                      <tr>
                        <th>Min Qty</th>
                        <th>Discount</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody id="table_promo_edit">
    
                  </tbody>
                  </table>
                </div>
              </div>
            </div>
            
            
          </div>

          </div>
          <div class="modal-footer">
            {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
            {{ Form::button('Edit', ['name'=>'edit_promo', 'class'=>'btn btn-primary', 'onclick'=>'edit_promo()']) }}
          </div>
        {{-- </form> --}}
      <div class="container-fluid">
        
      </div>
    </div>
  </div>
</div>









{{-- 
  <!--EDIT Modal -->
  <div class="modal fade" id="edit_modal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Bank</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form class="" method='post' action='edit_bank'>
            @csrf
            <div class="modal-body">
              <div class="col-md-6">
                {{ Form::hidden('id_bank', '', ['class'=>'form-control','id'=>'id_bank']) }}
                {{ Form::label('Bank Name','') }}
                {{ Form::text('txt_bank_name', '', ['class'=>'form-control','id'=>'txt_bank_name']) }}
              </div>

              <div class="col-md-6">
                {{ Form::label('Account Number','') }}
                {{ Form::number('txt_account_number', '', ['class'=>'form-control','id'=>'txt_account_number']) }}
              </div>

              <div class="col-md-6">
                {{ Form::label('Account Name','') }}
                {{ Form::text('txt_account_name', '', ['class'=>'form-control','id'=>'txt_account_name']) }}
              </div>

              <div class="col-md-6">
                {{ Form::label('Bank Branch','') }}
                {{ Form::text('txt_bank_branch', '', ['class'=>'form-control','id'=>'txt_bank_branch']) }}
              </div>

              
            </div>
            <div class="modal-footer">
              {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
              {{ Form::submit('Edit', ['name'=>'edit_bank', 'class'=>'btn btn-primary']) }}
            </div>
        </form>
        <div class="container-fluid">
          
        </div>
      </div>
    </div>
  </div> --}}





@endsection



@push('custom-script')

<!-- TOASTR Utk ERROR -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- InputMask -->
<script src="{{ asset('assets/plugins/moment/moment.min.js')}} "></script>
<script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js')}} "></script>
<!-- date-range-picker -->
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js')}} "></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}} "></script>
{{-- <!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js')}}"></script> --}}
<!-- CDN DATA TABLE -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
 



   <!-- Bootstrap 4 -->
   <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
   



<script>
  $(document).ready( function () {
    $('#table_id').DataTable();
  } );
  </script>
  
    <script>
      $(function () {
       
        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
        //Money Euro
        $('[data-mask]').inputmask()
    
        //Date picker
        $('#reservationdate').datetimepicker({
          defaultDate: new Date(),
            viewMode: 'days',
            format: 'DD/MM/YYYY'
        });
    
    
        $('#reservationdate2').datetimepicker({
          defaultDate: new Date(),
            viewMode: 'days',
            format: 'DD/MM/YYYY'
        });

        $('#reservationdate3').datetimepicker({
          defaultDate: new Date(),
            viewMode: 'days',
            format: 'DD/MM/YYYY'
        });


        $('#reservationdate4').datetimepicker({
          defaultDate: new Date(),
            viewMode: 'days',
            format: 'DD/MM/YYYY'
        });
    
       
    
        //Date and time picker
        $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });
    
        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
          timePicker: true,
          timePickerIncrement: 30,
          locale: {
            format: 'MM/DD/YYYY hh:mm A'
          }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker(
          {
            ranges   : {
              'Today'       : [moment(), moment()],
              'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month'  : [moment().startOf('month'), moment().endOf('month')],
              'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate  : moment()
          },
          function (start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
          }
        )
     
        //Timepicker
        $('#timepicker').datetimepicker({
          format: 'LT'
        })
      })
    
    
    
      
    </script>
    




    <script>

    var Id_promo_fix ="";
      $('#edit_modal').on('show.bs.modal', function(event){
    
    var button = $(event.relatedTarget);
    var id = button.data('id');
    Id_promo_fix = id;
    var modal = $(this);
    //modal.find('.modal-body #id_category').val(id);


    var myurl = "<?php echo URL::to('/'); ?>";
    // alert(id);

    $.get(myurl + '/get_data_promo',
    {id: id},
    function(result){
      var cut = result.split("#");

      $("#cb_product_edit").val(cut[0]);
      loadvariationedit(cut[1]);
      $("#txt_start_date_edit").val(cut[2]);
      $("#txt_end_date_edit").val(cut[3]);
      if(cut[4]=="RP")
      {
        $("#cb_model_edit").val(1);
      }
      else
      {
        $("#cb_model_edit").val(0);
      }

      // alert(cut[5]);
      $('#table_promo_edit').html(cut[5]);

    });

  })
    
    </script>

<script>
  var myurl = "<?php echo URL::to('/'); ?>";
  

  function loadvariation()
  {
    var myurl = "<?php echo URL::to('/'); ?>";
    var Id_product = $("#cb_product").val();
    
    $.get(myurl + '/get_variation_product',
    {Id_product: Id_product},
    function(result){
       
      var arr = JSON.parse(result);
      // alert(arr);
     var kal ="";
     for(var i =0;i< arr.length;i++)
     {
      // alert(arr[i]['Option_name']);
       kal = kal + "<option value='"+arr[i]['Id_variation']+"'>" + arr[i]['Option_name'] + "</option>";
     }
     $("#cb_variation").html(kal);
    });
  
  }


  function loadvariationedit(temp)
  {
    var myurl = "<?php echo URL::to('/'); ?>";
    var Id_product = $("#cb_product_edit").val();
    
    $.get(myurl + '/get_variation_product',
    {Id_product: Id_product},
    function(result){
       
      var arr = JSON.parse(result);
      // alert(arr);
     var kal ="";
     for(var i =0;i< arr.length;i++)
     {
      // alert(arr[i]['Option_name']);
       kal = kal + "<option value='"+arr[i]['Id_variation']+"'>" + arr[i]['Option_name'] + "</option>";
     }
     $("#cb_variation_edit").html(kal);
     $("#cb_variation_edit").val(temp);
    });
  
  }



  

  function validasi()
  {
    
    if($('#txt_minqty').val() < 1)
    {
      $('#txt_minqty').val(1) ;
    }
    

    if($('#txt_discount').val() < 1)
    {
      $('#txt_discount').val(1) ;
    }

  }

  function resetsession()
  {
    // alert('a');

    var myurl = "<?php echo URL::to('/'); ?>";
      $.get(myurl + '/reset_promo_session',
      {},
      function(result){
          $('#table_promo').html("");

     
     
      });
  }

  function setdiscount(what)
  {
    if(what=="add")
    {
      var discount = $('#txt_discount').val();
      var minqty= $('#txt_minqty').val();
    }
    else
    {
      var discount = $('#txt_discount_edit').val();
      var minqty= $('#txt_minqty_edit').val();
    }
    

      var myurl = "<?php echo URL::to('/'); ?>";
      $.get(myurl + '/add_promo_session',
      {discount: discount,minqty:minqty},
      function(result){
        if(result=="qtysama")
        {
          toastr["error"]("Error, please change min qty", "Error");
        }
        else
        {

          if(what=="add")
          {
            $('#table_promo').html(result);
          }
          else
          {
            $('#table_promo_edit').html(result);
          }
         
        }
      });

     
    
  }

  function deletepromo(x)
  {
    $.get(myurl + '/delete_promo_session',
      {x: x},
      function(result){
       
      try {
        $('#table_promo').html(result);
      } catch (error) {
        
      }


      try {
        $('#table_promo_edit').html(result);
      } catch (error) {
        
      }
      
     
        
         
      });
  }

  function add_promo()
  {
    var myurl = "<?php echo URL::to('/'); ?>";
     var Id_product =  $('#cb_product').val();
     var Id_variation =  $('#cb_variation').val();
     var Start_date =  $('#txt_start_date').val();
     var End_date =  $('#txt_end_date').val();

      var start = Start_date[3]+Start_date[4]+"/"+Start_date[0]+Start_date[1]+"/"+Start_date[6]+Start_date[7]+Start_date[8]+Start_date[9];
      var end = End_date[3]+End_date[4]+"/"+End_date[0]+End_date[1]+"/"+End_date[6]+End_date[7]+End_date[8]+End_date[9];



      var tglfix_start = Start_date[6]+Start_date[7]+Start_date[8]+Start_date[9]+"/"+Start_date[3]+Start_date[4]+"/"+Start_date[0]+Start_date[1];
      var tglfix_end = End_date[6]+End_date[7]+End_date[8]+End_date[9]+"/"+End_date[3]+End_date[4]+"/"+End_date[0]+End_date[1];

      const startdate = new Date(start);
      const enddate = new Date(end);


      var today = new Date();
      var dd = today.getDate();

      var mm = today.getMonth()+1; 
      var yyyy = today.getFullYear();
      if(dd<10) 
      {
          dd='0'+dd;
      } 

      if(mm<10) 
      {
          mm='0'+mm;
      } 

      today = yyyy+'/'+mm+'/'+dd;
      var CurrentDate = new Date(today);

// alert(CurrentDate);



     var ixModel =  $('#cb_model').val();
     var Model= "";
      if(ixModel==1)
      {
        Model="Rp";
      }
      else
      {
        Model="%";
      }

      if(Id_product=="" || Id_product==0)
      { 
        toastr["error"]("Please select product", "Error");
        // alert(CurrentDate);
        // alert(startdate);
      }
      else if(Id_variation=="" || Id_variation==0)
      {
        toastr["error"]("Please select variation", "Error");
      }
      // else if(CurrentDate > startdate )
      // {
      //   toastr["error"]("Start date must bigger than today", "Error");
      // }
      else if(startdate > enddate){
        toastr["error"]("end date must bigger than start date", "Error");
      } 
      else if(startdate >= CurrentDate)
      {
        var Comingsoon = 0;
        if(startdate > CurrentDate)
        {
          Comingsoon=1;
        }

        $.get(myurl + '/add_promo',
        {Id_product:Id_product, Id_variation:Id_variation,Start_date:tglfix_start,End_date:tglfix_end,Model:Model,Comingsoon:Comingsoon},
        function(result){
        //  alert(result);
           if(result=='fail')
           {
            toastr["error"]("Please set discount and min Qty", "Error");
           }
           else if(result=="failperiod")
           {
            toastr["error"]("plaease enter another start date / end date", "Error");
           }
           else if(result=='sukses')
           {
 
              $('#add_modal').modal('toggle'); 
              location.reload();
              // toastr["success"]("Success add promo", "Error");
           }
          
        });

      }
      else
      {
        toastr["error"]("Start date must bigger than today", "Error");
      }


   
  }



  function edit_promo()
  {
    var myurl = "<?php echo URL::to('/'); ?>";
     var Id_product =  $('#cb_product_edit').val();
     var Id_variation =  $('#cb_variation_edit').val();
     var Start_date =  $('#txt_start_date_edit').val();
     var End_date =  $('#txt_end_date_edit').val();

      var start = Start_date[3]+Start_date[4]+"/"+Start_date[0]+Start_date[1]+"/"+Start_date[6]+Start_date[7]+Start_date[8]+Start_date[9];
      var end = End_date[3]+End_date[4]+"/"+End_date[0]+End_date[1]+"/"+End_date[6]+End_date[7]+End_date[8]+End_date[9];



      var tglfix_start = Start_date[6]+Start_date[7]+Start_date[8]+Start_date[9]+"/"+Start_date[3]+Start_date[4]+"/"+Start_date[0]+Start_date[1];
      var tglfix_end = End_date[6]+End_date[7]+End_date[8]+End_date[9]+"/"+End_date[3]+End_date[4]+"/"+End_date[0]+End_date[1];

      const startdate = new Date(start);
      const enddate = new Date(end);


      var today = new Date();
      var dd = today.getDate();

      var mm = today.getMonth()+1; 
      var yyyy = today.getFullYear();
      if(dd<10) 
      {
          dd='0'+dd;
      } 

      if(mm<10) 
      {
          mm='0'+mm;
      } 

      today = yyyy+'/'+mm+'/'+dd;
      var CurrentDate = new Date(today);



     var ixModel =  $('#cb_model_edit').val();
     var Model= "";
      if(ixModel==1)
      {
        Model="Rp";
      }
      else
      {
        Model="%";
      }

      if(Id_product=="" || Id_product==0)
      { 
        toastr["error"]("Please select product", "Error");
      }
      else if(Id_variation=="" || Id_variation==0)
      {
        toastr["error"]("Please select variation", "Error");
      }
      else if(startdate > enddate){
        toastr["error"]("end date must bigger than start date", "Error");
      } 
      else if (startdate >= CurrentDate)
      {

        var Comingsoon = 0;
        if(startdate > CurrentDate)
        {
          Comingsoon=1;
        }
        //UBAH STATUS JADI 0 untuk PROMO HEADER/ DETAIL terlebih dahulu

        //  alert(Id_promo_fix);
        $.get(myurl + '/delete_promo',
        {Id_promo:Id_promo_fix},
        function(result){
          $.get(myurl + '/add_promo',
          {Id_product:Id_product, Id_variation:Id_variation,Start_date:tglfix_start,End_date:tglfix_end,Model:Model,Comingsoon:Comingsoon},
          function(result){
            // alert(result);
            if(result=='fail')
            {
              toastr["error"]("Please set discount and min Qty", "Error");
            }
            else if(result=="failperiod")
            {
              toastr["error"]("plaease enter another start date / end date", "Error");
            }
            else if(result=='sukses')
            {
  
                $('#add_modal').modal('toggle'); 
                location.reload();
                // toastr["success"]("Success add promo", "Error");
            }
            
          });
        });
      }
      else
      {
        toastr["error"]("Start date must bigger than today", "Error");
      }

  }

  function delete_promo(Id_promo)
  {
    swal({
          title: "Are you sure to delete this?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            
            var myurl = "<?php echo URL::to('/'); ?>";
            $.get(myurl + '/delete_promo',
            {Id_promo:Id_promo},
            function(result){
              location.reload();
         
    });

          } else {
          }
        });  


   
  }



  
</script>




@endpush
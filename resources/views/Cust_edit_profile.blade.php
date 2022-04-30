@extends('layout_frontend.Master')


@push('custom-css')

    {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="{{ asset ('css/register-login/register-login.css') }}" rel="stylesheet" type="text/css">  --}}

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

 <link href="{{ asset ('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

 
@endpush




@section('Content')

@php
$msgerror = "";
  if($errors->any()){
    foreach ($errors->all() as $error) {
      $msgerror = $error;
    }
  }
@endphp


<div class="register-area ptb-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-6 col-lg-6 col-xl-6 ms-auto me-auto">
                <div class="login">
                    <div class="login-form-container">
                        <div class="login-form">
                            @csrf
                            <form action="update_profile" method="post">
                                @csrf
                                @php
                                     $user = session()->get('userlogin');
                                @endphp
                                {{-- {!! Form::text($user->Username , [$options]) !!} --}}
                                {{-- {!! Form::hidden($user->Id_member, $user->Id_member) !!} --}}
                                <input type="hidden" name="Id_member" value="{{$user->Id_member}}">
                                <input type="text" value='{{$user->Username}}' name="txt_username" placeholder="Username">
                                <input type="number" value='{{$user->Phone}}' name="txt_phone" placeholder="phone">
                                <input name="txt_email" value='{{$user->Email}}' placeholder="Email" type="email">
                                <div class="button-box">
                                    <button type="submit" name="update_profile" class="default-btn floatright">Update profile</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- address --}}
            <div class="col-md-6 col-6 col-lg-6 col-xl-6 ms-auto me-auto">
                <br><br><br>
                <div class="login">
                    <div class="login-form-container">
                        
                        <div class="login-form">
                            <label>Address</label>
                            <div class="button-box">
                                <button class="default-btn floatright" data-toggle="modal" data-target="#Add_address">Add Address</button>
                                <br><br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class='table table-striped display table_id_3'>
                                            <thead>
                                                <tr>
                                                    <th>Address</th>
                                                    <th>Province</th>
                                                    <th>City</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                @foreach ($dtaddress as $data)
                                                    <tr>
                                                        <td>{{$data->Address}}</td>
                                                        <td>{{$data->Province_name}}</td>
                                                        <td>{{$data->City_name}}</td>
                                                        <td>
                                                            {{-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit_modal" data-cat="{{$data->Id_category}}">Edit</button> --}}
                                                            {{ Form::button('Edit', ['name'=>'btn_edit','class'=>'btn btn-warning btn-sm ','data-address'=>$data->Id_address,'data-toggle'=>'modal','data-target'=>'#edit_modal']) }}
                                                            {{ Form::button('Delete', ['name'=>'btn_delete','class'=>'btn btn-danger btn-sm ','onclick'=>'delete_address('.$data->Id_address.')']) }}
                                                          
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
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="Add_address">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><b>Add Address </b> </h4>
          {{-- <h4 class="modal-title">Info Product</h4> --}}
        
        </div>
        <div class="container">
            <div class="row">
              <div class="col-md-5">
                {{ Form::label('Province :','') }}
                {{ Form::select('cb_province', $arr_province, 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_province', 'onchange' => 'load_city()' ]) }}
              </div>

              <div class="col-md-5">
                {{ Form::label('City :','') }}
                {{ Form::select('cb_city', [], 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_city' ]) }}
  
              </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    {{ Form::label('Full address :','') }}
                    {{ Form::textarea('txt_address', '', ['class'=>'form-control','id'=>'txt_address']) }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="button-box float-right">
                        <button class="default-btn floatright" onclick="submit_address()">Submit</button>
                    </div>
                </div>
            </div>
            <br><br>
  
       
        </div>
            <div class="modal-footer">
              {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
            </div>
       
      </div>
    </div>
  </div>



  <div class="modal fade" id="edit_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><b>EDIT Address </b> </h4>
          {{-- <h4 class="modal-title">Info Product</h4> --}}
        
        </div>
        <div class="container">
            <div class="row">
              <div class="col-md-5">
                {{ Form::hidden('txt_id_address', '', ['class'=>'form-control','id'=>'txt_id_address']) }}
                {{ Form::label('Province :','') }}
                {{ Form::select('cb_province', $arr_province, 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_province_edit', 'onchange' => 'load_city_2()' ]) }}
              </div>

              <div class="col-md-5">
                {{ Form::label('City :','') }}
                {{ Form::select('cb_city', $arr_city, 'Kosong', [ 'class'=>'form-control', 'id'=>'cb_city_edit' ]) }}
  
              </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    {{ Form::label('Full address :','') }}
                    {{ Form::textarea('txt_address', '', ['class'=>'form-control','id'=>'txt_address_edit']) }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="button-box float-right">
                        <button class="default-btn floatright" onclick="Edit_address()">Edit</button>
                    </div>
                </div>
            </div>
            <br><br>
  
       
        </div>
            <div class="modal-footer">
              {{ Form::button('Close', ['class'=>'btn btn-secondary','data-dismiss'=>'modal','aria-label'=>'Close']) }}
            </div>
       
      </div>
    </div>
  </div>
@endsection


@push('custom-js')

<!-- TOASTR Utk ERROR -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script src ="{{ asset ('js/jquery.js') }}"></script>
<script src ="{{ asset ('js/bootstrap.js') }}"></script>


 <!-- CDN DATA TABLE -->
 <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function(){

      $('.login-info-box').fadeOut();
      $('.login-show').addClass('show-log-panel');


  });
  
</script>
<script src ="{{ asset ('js/register-login/register-login.js') }}"></script>

<script>

 var myurl = "<?php echo URL::to('/'); ?>";

 $('#edit_modal').on('show.bs.modal', function(event){
    
    var button = $(event.relatedTarget);
    var Id_address = button.data('address');
    var modal = $(this);
    //modal.find('.modal-body #id_category').val(id);


    var myurl = "<?php echo URL::to('/'); ?>";

      $.get(myurl + '/getaddress',
      {Id_address: Id_address},
      function(result){
        var cut = result.split("#");

      var arr = (JSON.parse(cut[0]));
    
      var Id_province =0;
      var Id_city=0;
      var Address="";
        var kal="";
      for(var i =0;i< arr.length;i++)
      {
        Id_province= arr[i]['Id_province'];
        Id_city= arr[i]['Id_city'];
        Address= arr[i]['Address'];

        // kal = kal + "<option value='"+arr[i]['Id_city']+"'>" +arr[i]['Type']+ " "+arr[i]['City_name'] + "</option>";
      }



      var arr2= JSON.parse(cut[1]);
      for(var i =0;i< arr2.length;i++)
      {
       
        kal = kal + "<option value='"+arr2[i]['Id_city']+"'>" +arr2[i]['Type']+ " "+arr2[i]['City_name'] + "</option>";
      }


      $("#txt_id_address").val(Id_address);
      $("#cb_city_edit").html(kal);
      $("#cb_city_edit").val(Id_city);
      $("#cb_province_edit").val(Id_province);
    
      $("#txt_address_edit").val(Address);


      });

  })



  function load_city()
  {

    var Id_province = $("#cb_province").val();
    
    $.get(myurl + '/get_city',
    {Id_province: Id_province},
    function(result){
      var arr = (result);
     var kal ="";
     for(var i =0;i< arr.length;i++)
     {
      // alert(arr[i]['Option_name']);
       kal = kal + "<option value='"+arr[i]['Id_city']+"'>" +arr[i]['Type']+ " "+arr[i]['City_name'] + "</option>";
     }
     $("#cb_city").html(kal);

    });
  
  }

  function load_city_2()
  {

    var Id_province = $("#cb_province_edit").val();
    
    $.get(myurl + '/get_city',
    {Id_province: Id_province},
    function(result){
      var arr = (result);
     var kal ="";
     for(var i =0;i< arr.length;i++)
     {
      // alert(arr[i]['Option_name']);
       kal = kal + "<option value='"+arr[i]['Id_city']+"'>" +arr[i]['Type']+ " "+arr[i]['City_name'] + "</option>";
     }
     $("#cb_city_edit").html(kal);

    });
  
  }


  function submit_address()
  {
    var myurl = "<?php echo URL::to('/'); ?>";
    $Id_province=0;
    $Id_city=0;
    $address="";


      var Id_province= $("#cb_province").val();
      var Id_city= $("#cb_city").val();
      var address= $("#txt_address").val();

      if(Id_province==0)
      {
        toastr["error"]("Error, Province cannot empty", "Error");
      }
      else if(Id_province==0)
      {
        toastr["error"]("Error, City cannot empty", "Error");
      }
      else if(address=="")
      {
        toastr["error"]("Error, Address cannot empty", "Error");
      }
      else
      {
        $.get(myurl + '/add_address',
        {Id_province: Id_province,Id_city: Id_city,Address:address},
        function(result){
            if(result=="lebih 3")
            {
                toastr["error"]("Error, Address only 3", "Error");
            }
            else
            {
                toastr["success"]("Success to Add", "Success");
                $('#Add_address').modal('toggle'); 
                window.location = myurl + "/edit_profile/";
            }
           

        });
      }
  }

  function Edit_address()
  {
    var myurl = "<?php echo URL::to('/'); ?>";
    $Id_province=0;
    $Id_city=0;
    $address="";

        var Id_address = $("#txt_id_address").val();
      var Id_province= $("#cb_province_edit").val();
      var Id_city= $("#cb_city_edit").val();
      var address= $("#txt_address_edit").val();

      if(Id_province==0)
      {
        toastr["error"]("Error, Province cannot empty", "Error");
      }
      else if(Id_province==0)
      {
        toastr["error"]("Error, City cannot empty", "Error");
      }
      else if(address=="")
      {
        toastr["error"]("Error, Address cannot empty", "Error");
      }
      else
      {
        $.get(myurl + '/edit_address',
        {Id_address:Id_address,Id_province: Id_province,Id_city: Id_city,Address:address},
        function(result){
           
            toastr["success"]("Success to Edit", "Success");
            $('#edit_modal').modal('toggle'); 
            window.location = myurl + "/edit_profile/";

        });
      }
  }


  function delete_address(Id_address)
  {
    var myurl = "<?php echo URL::to('/'); ?>";

    $.get(myurl + '/delete_address',
        {Id_address:Id_address},
        function(result){
           
            toastr["success"]("Success to Delete", "Success");
            window.location = myurl + "/edit_profile/";

        });
  }
</script>

<script>
  var msgerror = "<?php echo $msgerror ?>"; //validate
  if(msgerror != "")
  {
     toastr["error"](msgerror, "Failed");
  }
 

</script>
@endpush








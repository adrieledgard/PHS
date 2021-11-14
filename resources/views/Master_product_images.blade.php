@extends('layout.Master')


{{-- UNTUK SIDEBAR --}}
@section('masterproduct_atv')
  active
@endsection

@section('menu_master')
   menu-open
@endsection
{{-- ------------- --}}


@section('title2')
Product Images
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active"><a href="{{url('master_product')}}">Master Product</a></li>
    <li class="breadcrumb-item active">Product Images</li>
@endsection


@section('title')
  Product Images
@endsection


@push('custom-css')

  {{-- image order --}}
  <link rel="stylesheet" href="{{ asset('assets/imageorder/jquery-ui/jquery-ui.css') }}">
  <style>
  body
  {
    font-family: Arial;
    text:#212121;
  }
  #gallery{
      width:1057px;
      margin: 0 auto;
  }
  #image-list { 
      list-style-type: none; 
      margin: 0; 
      padding: 0; 
  }
  #image-list li { 
      margin: 10px 20px 10px 0px; 
      display: inline-block;
  }
  #image-list li img{
      width: 250px;
      height: 155px;
  }

  #image-container{
      margin-bottom: 14px;
  }

  #txtresponse 
  {
      padding: 10px 20px;
      border-radius: 3px;
      margin-bottom: 10px;
      width: 100%;
      display: none;
      border :#E0E0E0 1px solid;
      color:#212121;
    
  }
  
  .btn-submit {
      padding: 10px 30px;
      background: #333;
      border: #E0E0E0 1px solid;
      color: #FFF;
      font-size: 0.9em;
      width: 100px;
        
      border-radius: 0px;
      cursor:pointer;
      position: absolute;
  }
  </style>

  
@endpush


@section('Content')

<div class="container">
  <h4>Master Product Images</h4><br><br>
{{-- 
  @php
     echo(session()->get('userLogin')->Role);
  @endphp --}}
  @if(count($errors)>0)
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
      @endforeach
    </ul>
  </div>
  @endif


  @if (isset($msg))
    <div class="alert alert-success">
      <p>{{$msg}}</p>
    </div>
  @endif

@if (isset($msg_err))
  <div class="alert alert-danger">
    <p>{{$msg_err}}</p>
  </div>
@endif


  <div class="col-md-12">

    
    {{Form::open(array('url' => 'Insertphoto', 'method' => 'post', 'files' => true))}}
      {{ Form::hidden('id', $id, ['class'=>'form-control ','id'=>'id_product']) }}
      {{ Form::file('foto',['id'=>'foto'])}}
      {!! Form::submit('SAVE', ['name'=>'Save','class'=>'btn btn-info btn-md']) !!}
    {{ Form::close() }}

  </div>
  
  <br>
  <br>
  

  {{ Form::label('lbl_name', 'Product Name :', ['id'=>'id']) }}
  @foreach ($product as $data)

    {{ Form::label('id', $data->Name, ['id'=>'id']) }}
   
  @endforeach

  <div id="image-container">
        <ul id="image-list" >
          @foreach ($product_image as $data)
          <li style="margin-right:2%;">
            <img onmousedown=tekandown({{$data->Image_order}}) src="{{ asset('Uploads/Product/'.$data->Image_name )}}" style="width: 150px; height:150px;"  class="center"> 
            <label onclick=hapus({{ $data->Id_image}},{{ $data->Image_order}}) style='cursor: pointer; color:#000;
              margin:-105% -8% 0px 0px;
              float:right;
              border-radius: 100%;
              background-color : black; 
              color: white;
              padding:5%;'>X</label>
          </li>
              
          
          @endforeach
         
        </ul>

    </div>   


  {{-- {{ Form::label('Product Name',) }} --}}
  {{-- <table id="table_id" class='table table-striped display'>
    <thead>
      <tr>
        <th>Image</th>
        <th>Urutan</th>
        <th>Action</th>
      </tr>
  </thead>

  <tbody>
    @foreach ($product_image as $data)
      <tr>
        <td width="450px">
          <img src="{{ asset('Uploads/Product/'.$data->Image_name )}}" width='450px' height='450px' class="center"> 
        </td>
        <td>
          {{$data->Image_order}}
        </td>
        <td>  
          <a href="{!! url('Master_product_images/' .$data->Id_product); !!}">
            <button name="btn_view" class="btn btn-warning btn-sm">Delete</button>
          </a>
        </td>

      </tr>
    @endforeach
  </tbody>
    

  </table> --}}
</div>


@endsection



@push('custom-script')
 
    <script src="{{ asset('assets/imageorder/jquery-3.2.1.min.js') }}"></script>

    <script src="{{ asset('assets/imageorder/jquery-ui/jquery-ui.js') }}"></script>



<script language="javascript">


</script>

<script>
  var startindex;
  var dropindex;

  function tekandown(no)
  {
    startindex =no;
  }

  function hapus(id,image_order) {
  
    var id_product= $("#id_product").val();
    $.get(myurl + '/deleteproductimage',
    {id: id,id_product:id_product, image_order:image_order},
    function(result){
      window.location = myurl + "/Master_product_images/"+ id_product;
    });
  }

  var myurl = "<?php echo URL::to('/'); ?>";


  $(document).ready(function () {
      $("#image-list").sortable({
            update: function(event, ui) { 
              dropindex = ui.item.index() + 1; //dropindex ditambah 1 , karena startnya index 0
              
              
              var id_product= $("#id_product").val();
              $.get(myurl + '/switch_image_order',
              {startindex:startindex , dropindex:dropindex,id_product:id_product },
              function(result){
                
              });
          }
      });

    });
  

</script>
    
    
@endpush


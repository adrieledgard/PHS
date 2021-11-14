@extends('layout.Nav_dashboard_admin')

@section('isi')

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <script src ="{{ asset ('js/jquery.js') }}"></script>
</head>


<script language="javascript">

var myurl = "<?php echo URL::to('/'); ?>";
var crt = "<?php echo csrf_token(); ?>";

// function loadkategori()
// {
//   $.get(myurl + '/getallkategori',
//   {},
//   function(result){
//     alert(result);
//   })
// }

// loadkategori();




// function loadsubcategory()
// {
//   var kodecategory = $("#cb_category").val();
  
//   $.get(myurl + '/getsubcategoryname',
//   {kodecategory: kodecategory},
//   function(result){
//    var arr = JSON.parse(result);
//    var kal ="";
//    for(var i =0;i< arr.length;i++)
//    {
//      kal = kal + "<option value'"+arr[i]['Id_sub_category']+"'>" + arr[i]['Sub_category_name'] + "</option>";
//    }
//    $("#cb_sub_category").html(kal);
//   });

// }


</script>

<div class="container">
  <h4>Detail Product</h4><br><br>
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


  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Insert data
  </button>
  <br>
  <br>
  <table class='table table-striped'>
    <tr>
      <th>USERNAME</th>
      <th>EMAIL</th>
      <th>PHONE</th>
      <th>ROLE</th>
    </tr>

    
    {{-- @foreach ($dtteam_member as $data)
    <tr>
      <td>{{$data->Username}}</td>
      <td>{{$data->Email}}</td>
      <td>{{$data->Phone}}</td>
      <td>{{$data->Role}}</td>
    </tr>
    @endforeach
     --}}

  </table>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="row g-3" method='post' action='add_team_member'>
        @csrf
        
        <div class="modal-body">
          <div class="col-12">
            {{ Form::label('Name :','') }}
            {{ Form::text('txt_name', '', ['class'=>'form-control']) }}
          </div>
          <div class="col-md-6">
            {{ Form::label('Category :','') }}
            {{-- {{ Form::select('cb_category', $arr_cat, 'Kosong', ['placeholder'=>'Category', 'class'=>'form-control', 'id'=>'cb_category', 'onchange' => 'loadsubcategory()' ]) }} --}}
          </div>
          <div class="col-md-6">
            {{ Form::label('Sub Category :','') }}
            {{ Form::select('cb_sub_category',[], 'Kosong', ['placeholder'=>'Sub-Category', 'class'=>'form-control', 'id'=>'cb_sub_category']) }}
          </div>
          <div class="col-12">
            {{ Form::label('Unit :','') }}
            {{ Form::text('txt_unit', '', ['class'=>'form-control']) }}
          </div>
          <div class="col-md-6">
            <label for="inputCity" class="form-label">City</label>
            <input type="text" class="form-control" id="inputCity">
          </div>
          <div class="col-md-4">
            <label for="inputState" class="form-label">State</label>
            <select id="inputState" class="form-select">
              <option selected>Choose...</option>
              <option>...</option>
            </select>
          </div>
          <div class="col-md-2">
            <label for="inputZip" class="form-label">Zip</label>
            <input type="text" class="form-control" id="inputZip">
          </div>
          <div class="col-12">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck">
              <label class="form-check-label" for="gridCheck">
                Check me out
              </label>
            </div>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary">Sign in</button>
          </div>
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-primary" name="add_team_member" value="Insert">
        </div>
     </form>
    </div>
  </div>
</div>


@endsection






<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<link href="{{ asset ('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">


{{Form::open(array('url'=>'embed_checkout','method'=>'post','class'=>'row g-3'))}}
@csrf
<div class="container">
    <div class="row">
        <b> <h1>Your Order : </h1></b>
        {{ Form::hidden('Random_code', $Random_code, ['class' => 'Random_code']) }}
        <div class="col-md-12">
            {{ Form::label('Name :','') }}
            {{ Form::text('Name', '', ['class'=>'form-control','id'=>'name', 'placeholder' => "Insert your name", 'required' => 'required']) }}
          </div>
          
          <div class="col-md-12">
            {{ Form::label('Phone number :','') }}
            {{ Form::number('Phone', '', ['class'=>'form-control','id'=>'phone', 'placeholder' => "Phone number", 'required' => 'required']) }}
          </div>

          <div class="col-md-12">
            {{ Form::label('Email :','') }}
            {{ Form::text('Email', '', ['class'=>'form-control','id'=>'email', 'placeholder' => "Email", 'required' => 'required']) }}
          </div>

          <br><br><br><br>

          <div class="col-md-12">
           <b>Product : {{$dtproduct[0]->Name}}</b> <br>
           {{ Form::label('Variation :','') }}
           {{ Form::select('cb_variation', $arr_variation, 'kosong', ['class'=>'form-control', 'id'=>'cb_variation' ,'placeholder'=>'Variation']) }}
            {{-- {{ Form::text('Email', '', ['class'=>'form-control','id'=>'email', 'placeholder' => "Email", 'required' => 'required']) }} --}}
          </div>

          <div class="col-md-12">
            {{ Form::label('Qty :','') }}
            {{ Form::number('Qty', '', ['class'=>'form-control','id'=>'Qty', 'placeholder' => "Qty", 'required' => 'required']) }}
          </div>
         
         
        <div class="col-12">
          <br>
          {{-- {{ Form::submit('Buy now', ['name'=>'buy_now', 'class'=>'btn btn-primary btn-lg float-right']) }} --}}
          <button type="submit" class="btn btn-primary btn-lg float-right" name="buy_now" onclick="$('form').attr('target', '_blank');">Buy now</button></div> 
        
        </div>
    </div>  
</div>
    
    
{{Form::close()}}



<script src ="{{ asset ('js/jquery.js') }}"></script>
<script src ="{{ asset ('js/bootstrap.js') }}"></script>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
    <!-- CDN data table -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
</head>
<body onload="window.print()">
  <div class="row">
    <div class="col-md-12">
      <table id="table_populer_product" class='table table-striped display'>
        <thead>
          <tr>
            <th>Product</th>
            <th>Variation</th>
            <th>Qty</th>
          </tr>
        </thead>
    
        <tbody id="">
          @foreach ($products as $product)
              <tr>
                <td>{{ $product->Name}}</td>
                <td>{{ $product->Option_name}}</td>
                <td>{{ $product->qty}}</td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</body>


</html>

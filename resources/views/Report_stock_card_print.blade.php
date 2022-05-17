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
    <div class="col-md-6">
      <h3>Stock Card Report</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table id="table_id" class='table table-striped display'>
        <thead>
          <tr>
            <th>Id</th>
            <th>Date</th>
            <th>Type</th>
            <th>Product</th>
            <th>Variation</th>
            <th>Expire Date</th>
            <th>First Stock</th>
            <th>Debet</th>
            <th>Credit</th>
            <th>Last Stock</th>
            <th>Fifo Stock</th>
            <th>Transaction price</th>
            <th>Capital</th>
          </tr>
        </thead>
    
        <tbody id="stock_card">
          {!! $data_stock_card !!}
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
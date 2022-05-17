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
        <h3>Pembelian Report</h3>
    </div>
    <div class="col-md-6">
      <div class="card-body">
        Total Order : {{count($purchases)}}
        <br>
        Total Pengeluaran : Rp. {{number_format($total_pengeluaran)}}
      </div>
    </div>
  </div>
<br>
  <div class="row">
    <div class="col-md-12">
      <table id="table_populer_product" class='table table-striped display'>
        <thead>
          <tr>
            <th>No. Order</th>
          <th>Date</th>
          <th>Supplier Name</th>
          <th>Supplier Email</th>
          <th>Supplier Phone</th>
          <th>Grand Total</th>
          </tr>
        </thead>
    
        <tbody id="">
          @foreach ($purchases as $purchase)
            <tr>
              <td>{{ $purchase->No_invoice}}</td>
              <td>{{ $purchase->Purchase_date}}</td>
              <td>{{ $purchase->Supplier_name}}</td>
              <td>{{ $purchase->Supplier_email}}</td>
              <td>{{ $purchase->Supplier_phone1}}, {{ $purchase->Supplier_phone2}}</td>
              <td>Rp. {{ number_format($purchase->Grand_total)}}</td>
            </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
</body>


</html>

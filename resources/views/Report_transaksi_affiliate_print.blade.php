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
        <h3>Transaksi Affiliate Report</h3>
    </div>
    <div class="card-body">
      Total Order : {{count($cust_orders)}}
      <br>
      Total Omzet : Rp. {{number_format($total_omzet)}}
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
            <th>Affiliator</th>
            <th>Jenis Affiliate</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Subtotal</th>
            <th>Shipping Cost</th>
            <th>Grand Total</th>
          </tr>
        </thead>
    
        <tbody id="">
          @foreach ($cust_orders as $order)
          <tr>
            <td>{{ $order->Id_order}}</td>
            <td>{{ $order->Date_time}}</td>
            <td>{{ $order->affiliator->Username}}</td>
            <td>{{ $order->jenis_affiliate}}</td>
            <td>{{ $order->Name}}</td>
            <td>{{ $order->Email}}</td>
            <td>{{ $order->Phone}}</td>
            <td>Rp. {{ number_format($order->Gross_total) }}</td>
            <td>Rp. {{ number_format($order->Shipping_cost)}}</td>
            <td>Rp. {{ number_format($order->Grand_total)}}</td>
          </tr>
      @endforeach
        </tbody>
      </table>
    </div>
  </div>
</body>


</html>

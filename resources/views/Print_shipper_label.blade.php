<html lang="en">

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @media print {
            div {
                break-inside: avoid;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <main role="main" class="container">
        @foreach ($arr_order as $order)
            <div class="row mt-3">
                <div class="col-4 border border-dark">
                    <h4>Data Penerima</h4>
                    <p>{{$order->Name}}</p>
                    <p>{{$order->Address}}, {{$order->kota->City_name}}</p>
                    <p>{{$order->kota->Province_name}}</p>
                    <p>Order Number: {{$order->Id_order}}</p>
                    <p>Kurir : {{$order->Courier}} - {{$order->Courier_packet}}</p>
                    <p>Kurir : {{$order->Courier}}</p>
                    <p>Resi : {{$order->Receipt_number}}</p>
                    <p>Ongkos : Rp. {{number_format($order->Shipping_cost)}}</p>
                    <p>Total : Rp. {{number_format($order->Grand_total)}}</p>
                </div>
                <div class="col-8 border border-dark">
                    <h4>Untuk Shipper</h4>
                    <label for="">Keterangan barang yang mau diambil</label>
                    <div id="isi_exp_date">{!!$order->detail!!}</div>
                </div>
            </div>
        @endforeach
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>

</html>
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
        <h3>Penukaran Point Member Report</h3>
    </div>

  </div>
<br>
  <div class="row">
    <div class="col-md-12">
      <table id="table_populer_product" class='table table-striped display'>
        <thead>
          <tr>
            <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Total Point Sisa</th>
          <th>Total Point Ditukar</th>
          </tr>
        </thead>
    
        <tbody id="">
          @foreach ($members as $member)
              <tr>
                <td>{{ $member->Username}}</td>
                <td>{{ $member->Email}}</td>
                <td>{{ $member->Phone}}</td>
                <td>{{ $member->Point}}</td>
                <td>{{$member->total_point_ditukar}}</td>
                
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</body>


</html>

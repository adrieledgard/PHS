<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
</head>
<body onload="window.print()">
    <div class="row">
        <div class="col-md-6"> 
            <h3>Follow Up Report</h3>
            <h5>{{$data['customer_service']->Username}}</h5>
            <label for="">{{$data['period']}}</label>
          </div>
          <div class="col-md-6"> 
            <div class="card">
                <div class="card-body">
                    <h5>Summary</h5>
                    Total Follow Up : <label class="total_followup">{{$data[1][0]}}</label><br>
                    Total Failed Follow Up : <label class="total_failed_followup">{{$data[1][1]}}</label><br>
                    Total Success Follow Up : <label class="total_success_followup">{{$data[1][2]}}</label>
                </div>
            </div>
            
          </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <table id="table_id" class='table table-striped display'>
          <thead>
            <tr>
              <th>Customer Service Name</th>
              <th>Customer Name</th>
              <th>Period</th>
              <th>Status</th>
            </tr>
          </thead>
      
          <tbody id="followup_cs">
            {!! $data[0]!!}
          </tbody>
        </table>
      </div>
    </div>
</body>
</html>
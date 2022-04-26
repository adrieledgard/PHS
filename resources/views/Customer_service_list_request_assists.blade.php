@extends('layout.Master')

{{-- UNTUK SIDEBAR --}}
@section('request_assist_atv')
  active
@endsection

@section('menu_master')
   menu-open
@endsection
{{-- ------------- --}}


@section('title2')
    List Request Assists
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Master</li>
    <li class="breadcrumb-item active">Request Assists</li>
@endsection



@push('custom-css')
 <!-- CDN data table -->
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}">

  <style>
    #chat2 .form-control {
    border-color: transparent;
    }

    #chat2 .form-control:focus {
    border-color: transparent;
    box-shadow: inset 0px 0px 0px 1px transparent;
    }

    .divider:after,
    .divider:before {
    content: "";
    flex: 1;
    height: 1px;
    background: #eee;
    }
  </style>
@endpush


@section('Content')
<input type="hidden" class="csrf_token" value="{{csrf_token()}}">
  <div class="container-fluid" style="height:100%;">
    <div class="row">
      <div class="col-md-12">
        <?php
        if((session()->get('userlogin'))->Role == "CUSTOMER SERVICE"){
          ?>

              <a href="{!! url('request_assist_add'); !!}">
                {{ Form::button('<i class="fa fa-plus" aria-hidden="true"></i> Insert',['class'=>'btn btn-primary','name'=>'btn_add']) }}
                {{-- <button class="btn btn-primary"><i class="fa fa-plus"></i> Insert</button> --}}
              </a>
          <?php
        }
          ?>
         
        </div>
        
        <br>
        <br>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table id="table_id"  class='table table-striped display'>
          <thead>
            <tr>
              <td>Status</td>
              <td>Title</td>
              <td>Description</td>
              <td>Actions</td>
            </tr>
          </thead>
          <tbody>
            @foreach ($tickets as $ticket)
              <tr>
                @php
                    if($ticket->status == "OPEN"){
                      echo "<td><button type='button' class='btn btn-warning btn-sm' disabled>$ticket->status</button></td>";
                    }
                    else if($ticket->status == "CLOSED"){
                      echo "<td><button type='button' class='btn btn-danger btn-sm' disabled>$ticket->status</button></td>";
                    }
                @endphp
                <td>{{$ticket->title}}</td>
                <td>{{$ticket->description}}</td>
                <td>
                  <button type="button" class="btn btn-success btn-sm" data-toggle='modal' data-target='#chat' data-id-ticket="{{$ticket->id}}">Chat</button>
                  <button type="button" class="btn btn-danger btn-sm" onclick="openModal('{{$ticket->id}}')">Closed</button>
                  @php
                    if($ticket->status != "CLOSED"){
                        echo '<button type="button" class="btn btn-warning btn-sm" onclick="onEdit(' . $ticket->id. ')">Edit</button>';
                      }
                      else {
                        echo '<button type="button" class="btn btn-warning btn-sm" disabled onclick="onEdit(' . $ticket->id. ')">Edit</button>';
                      }
                  @endphp
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div id="closedAssist" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Conclusion</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
          {{Form::open(array('url'=>'closed_request_assist/','method'=>'post','class'=>'row g-3'))}}
          <div class="col-md-12">
            Apakah anda yakin ingin menutup tiket ini ?
            {{ Form::hidden('id', '1', ['class' => 'ticket_id']) }}
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          {{ Form::submit('Update', ['name'=>'closed_request_assist', 'class'=>'btn btn-primary btn-md float-right']) }}
        </div>
      </div>
      {{Form::close()}}
    </div>
  </div>
  <div id="chat" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Chat</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div style="overflow: auto; height:500px; max-height:500px;">
            <div class="list_chat">
               
            </div>
          </div>
          <div class="text-muted d-flex justify-content-start align-items-center border-1 pt-2">
            
              <div class="container">
                <form action="post" id="form_data_chat" enctype="multipart/form-data" >
                <div class="row">
                    <input type="hidden" name="id_ticket" id="id_ticket">
                    <input type="file" style="display:none" id="attachment_file" name="attachment_file"/>
                    <div class="col-10">
                      <textarea name="content_pesan" placeholder="Type here" class="form-control " id="content_pesan" cols="10" rows="1"></textarea>
                    </div>
                    <div class="col-1">
                      <button type="button" class="btn btn-sm"  onclick="document.getElementById('attachment_file').click()"><i class="fas fa-paperclip"></i></button>
                    </div>
                    <div class="col-1 justify-content-center">
                      <button type="submit" class="btn btn-sm"><i class="fas fa-paper-plane"></i></button>
                      {{-- <a class="" href="#!" onclick="sendMessage()"><i class="fas fa-paper-plane"></i></a> --}}
                    </div>
                  
                </div>
              </form>
              </div>
            
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
      {{Form::close()}}
    </div>
  </div>
@endsection

@push('custom-script')
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
   <!-- CDN DATA TABLE -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script>
$(document).ready( function () {
$('#table_id').DataTable();
} );
</script>
<!-- ChartJS -->
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('assets/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/dist/js/pages/dashboard.js') }}"></script>

<script>
   var myurl = "<?php echo URL::to('/'); ?>";
function openModal(id){
  $(".ticket_id").val(id);

  $("#closedAssist").modal();
}

$("#chat").on('show.bs.modal', function(event){
  var button = $(event.relatedTarget);
  var id_ticket = button.data('id-ticket');
  var element_id_ticket = document.getElementById("id_ticket");
  element_id_ticket.value = id_ticket;
  var token = $(".csrf_token").val();
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': token
    }
  });
  
  $.post(myurl + '/get_ticket_chat',
  {id_ticket: id_ticket , CSRF: token},
  function(result){
      renderChat(result);
      
  });
    
 });
 
 $('form').submit(function(event) {
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: myurl + '/send_ticket_chat',
        type: 'POST',              
        data: formData,
        processData:false,
        contentType:false,
        success: function(result)
        {
            renderChat(result);
        },
        error: function(data)
        {
            // console.log(data);
        }
    });

});

function renderChat(list_chat){
  $(".list_chat").html("");

  list_chat[0].forEach(chat => {
    var content = chat.Content;
    if(chat.Type == 'file'){
      content = `Click <a href='${myurl + "/download_attachment/" + chat.Content}' target="_blank">here</a> to download the attachment`;
    }
    if(chat.Id_member == list_chat[1]){
      $(".list_chat").append(`
      <div class="d-flex flex-row justify-content-end mb-4">
        <div><p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">${content}</p>
        <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">${chat.Username} (${chat.Role}) ${moment(chat.created_at).format("DD-MM-YYYY HH:mm:ss")}</p>
        </div>
      </div>`);
    }else {
      $(".list_chat").append(`
      <div class="d-flex flex-row justify-content-start mb-4">
        <div>
        <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">${content}</p>
        <p class="small ms-3 mb-3 rounded-3 text-muted">${chat.Username} (${chat.Role}) ${moment(chat.created_at).format("DD-MM-YYYY HH:mm:ss")}</p>
        </div>
      </div>`)
    }
  });
}

function onEdit(id){
  window.location.href= `{!! url('request_assist_update/${id}') !!}`
}
</script>
    
@endpush
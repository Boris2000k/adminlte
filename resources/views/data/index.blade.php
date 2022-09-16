
@extends('layouts.app')

@section('content')



{{--  select necessary data  --}}

<?php

$labels = array();
$permission_names = array();
foreach($config as $perm)
$keys = array_keys($perm);
$keys_amount = sizeof($keys);
// create arrays for config data
for($i=0;$i<$keys_amount;$i++)
{
    // $headers[$i] = array();
    $data[$i] = array();
    array_push($data[$i],($perm[$keys[$i]]["label"]));
    array_push($data[$i],($perm[$keys[$i]]["permission_required"]));
    array_push($data[$i],($perm[$keys[$i]]["files"]["ds_sheet"]["headers_to_db"]));
    // array_push($headers[$i],($perm[$keys[$i]]["files"]["ds_sheet"]["headers_to_db"]));
    
}




?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Import
      </h1>
      @if (Session::has('success'))
          <div class="alert alert-success">
              <ul>
                  <li>{!! \Session::get('success') !!}</li>
              </ul>
          </div>

      @endif

      @if (Session::has('error'))
          <div class="alert alert-danger">
              <ul>
                  <li>{!! \Session::get('error') !!}</li>
              </ul>
          </div>

      @endif

      @if(count($errors->getMessages()) > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
            <strong>Validation Errors:</strong>
            <ul>
                @foreach($errors->getMessages() as $errorMessages)
                    @foreach($errorMessages as $errorMessage)
                        <li>
                            {{ $errorMessage }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </li>
                    @endforeach
                @endforeach
            </ul>
        </div>
      @endif

      

    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      {{-- page content --}}

      

      <div class="box box-primary w-50">
        <form class="form-horizontal" method="POST" action="{{ route('import') }}" enctype="multipart/form-data">
          @csrf
          <div class="box-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label text-muted">Import Type</label>
              <div class="col-sm-10">
                
                  

                <select name="data_index" id="importType" class="form-control select2" style="width: 100%;">
                    <option value="">Select Import Type</option>
                    @for ($i=0;$i<sizeof($labels);$i+=3)
                    <option value="">{{ $labels[$i] }}</option>
                    @endfor
                </select>
                
                {{-- send headers to import --}}
                <input id="headers_input" name="headers_input" type="text" hidden style="width:100%;">
                <input id="import_type" name="import_type" type="text" hidden  style="width:100%;">

              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputFile" class="col-sm-2 control-label text-muted">DS Sheet</label>
              <div class="col-sm-10">
                <input type="file" name="file" class="form-control" id="exampleInputFile">
                {{-- required headers p --}}
                <p id="headers" class="help-block"></p>
                <button type="submit" class="btn btn-primary" style="margin-top:1vh;">Import</button>
              </div>
            </div>
          </div>
        </form>
      </div>
        
</div>
  
  <script>
$( document ).ready(function() {
  // convert php array into json for javascript
  var data = @json($data);
  
  var user_permissions = @json($auth_user->permissions);

  var validation_data = [];

  

  // replace commas with space for easier reading
  user_permissions = user_permissions.replace(',' , ' ');

  
  // console.log('includes permissions!');

  // fill import type dropdown
  for(i=0;i<data.length;i++)
  {
    if(user_permissions.includes(data[i][1]))
    {
      $("#importType").append($('<option>').text(data[i][0]).attr('value',i + '-' + data[i][1]));
    }
   
  }

  var headerData = "";
  // get headers data for first option
  // $.each(data[0][2], function(key, value) {
  // headerData+= key+','});

  // initialize headers data
  headerData = headerData.slice(0,-1);
  $("#headers").text('Required Headers: ' + headerData);
  
  // change required headers text on option change
  $("#importType").change(function(){
    // get array index of current data
    headerData = '';
    // get data index from value
    
    var dataIndex = $("#importType").val().split('-')[0];
    
    
    $("#headers_input").val($("#importType").val().split('-')[1]+'-'+$("#importType").val().split('-')[2]);

    var import_type = $("#importType").val().split('-')[2];
    
    $("#import_type").val(import_type);
    
    
    
    // select headers
    $.each(data[dataIndex][2], function(key, value) {
    
    headerData+= key+','});
    // cut comma from last header
    headerData = headerData.slice(0,-1);
    // set the headers text
    $("#headers").text('Required Headers: ' + headerData);
    var headers_input = $("#importType").val().split('-')[1]+'-'+$("#importType").val().split('-')[2] + ' ' + headerData;
    headers_input = headers_input.replaceAll(',',' ');
    $("#headers_input").val(headers_input);
    // pass js array to php
    

    

    
  });
  
});

  </script>



 

  



@endsection

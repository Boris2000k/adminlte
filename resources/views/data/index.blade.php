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
    $data[$i] = array();
    array_push($data[$i],($perm[$keys[$i]]["label"]));
    array_push($data[$i],($perm[$keys[$i]]["permission_required"]));
    array_push($data[$i],($perm[$keys[$i]]["files"]["ds_sheet"]["headers_to_db"]));
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
      @elseif (Session::has('error'))
          <div class="alert alert-danger">
            <ul>
                <li>{!! \Session::get('error') !!}</li>
            </ul>
          </div>
      @endif
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      {{-- page content --}}

      

      <div class="box box-primary w-50">
        <form class="form-horizontal">
          <div class="box-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label text-muted">Import Type</label>
              <div class="col-sm-10">

                <select id="importType" class="form-control select2" style="width: 100%;">
                    @for ($i=0;$i<sizeof($labels);$i+=3)
                    <option value="">{{ $labels[$i] }}</option>
                    @endfor
                    
                  
                </select>

              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputFile" class="col-sm-2 control-label text-muted">DS Sheet</label>
              <div class="col-sm-10">
                <input type="file" class="form-control" id="exampleInputFile">
                <p id="headers" class="help-block">Example block-level help text here.</p>
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

  // fill import type dropdown
  for(i=0;i<data.length;i++)
  {
    $("#importType").append($('<option>').text(data[i][0]).attr('value',i + '-' + data[i][1]));
  }

  var headerData = "";
  // get headers data for first option
  $.each(data[0][2], function(key, value) {
  headerData+= key+','});

  // initialize headers data
  headerData = headerData.slice(0,-1);
  $("#headers").text('Required Headers: ' + headerData);
  
  // change required headers text on option change
  $("#importType").change(function(){
    // get array index of current data
    headerData = '';
    // get data index from value
    var dataIndex = $("#importType").val().split('-')[0];
    // select headers
    $.each(data[dataIndex][2], function(key, value) {
    headerData+= key+','});
    // cut comma from last header
    headerData = headerData.slice(0,-1);
    // set the headers text
    $("#headers").text('Required Headers: ' + headerData);
  });
});

  </script>



 

  



@endsection
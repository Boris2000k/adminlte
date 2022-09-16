@extends('layouts.app')

@section('content')
<style>
  .dataTables_filter{
   float: left !important;
   padding-right:10px;
}

div.dt-buttons {
  float: left !important;
}

.dataTables_length
{
  float:right !important;
}
</style>

<?php
$perms = config('adminlte_config');
$permission_labels = array();
$permission_names = array();
foreach($perms as $perm)
$keys = array_keys($perm);
$keys_amount = sizeof($keys);
for($i=0;$i<$keys_amount;$i++)
{
    // data for sidebar
    $data[$i] = array();
    array_push($data[$i],($perm[$keys[$i]]["label"]));
    array_push($data[$i],($perm[$keys[$i]]["permission_required"]));
    array_push($data[$i],($perm[$keys[$i]]["files"]["ds_sheet"]["headers_to_db"]));

    array_push($permission_labels,($perm[$keys[$i]]["label"]));
    array_push($permission_names,($perm[$keys[$i]]["permission_required"]));
}
// get table header data
$headers = $data[$data_key][2];

// model name to be sent for dynamic model class
$model = $data[$data_key][1];
$model = explode('-',$model);
$model = $model[1];

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{ $data[$data_key][0] }}
      <small>Delete or Export Data</small>
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
 {{-- page content --}}
 <div class="box">
  <div class="box-header">
  
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="usersTable" class="display" style="width:100%">
      <thead>
          <tr>
           
            @foreach ($headers as $key => $value)
            <th>{{ $key }}</th>
            @endforeach
            
            @if(Str::contains($user_perms,$permission_names[$data_key]))
              <th class="dnr">Delete</th>
            @endif
          </tr>
      </thead>
      <tbody>
          @forelse ($db_data as $data_table)
            <tr>
              @foreach ($headers as $key => $value)
              <td>{{ $data_table->$value }}</td>
              @endforeach
          
              @if(Str::contains($user_perms,$permission_names[$data_key]))
                <td class="dnr">
                  <form style="display:inline;" method="POST" class="fm-inline" action="{{ route('data.destroy', ['data' => $data_table->id, 'model' => $model])  }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this row ?')" style="background-color: transparent;background-repeat: no-repeat;border: none;cursor: pointer;overflow: hidden;outline: none;">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </form>
                </td>
              @endif
            </tr>
          @empty
            
          @endforelse
      </tbody>
      <tfoot>
          <tr>
            @foreach ($headers as $key => $value)
            <th>{{ $key }}</th>
            @endforeach

            @if(Str::contains($user_perms,$permission_names[$data_key]))
              <th class="dnr">Delete</th>
            @endif

          </tr>
      </tfoot>
  </table>
  </div>
  <!-- /.box-body -->
</div>



</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- DataTables -->
    

{{-- initiate datatable + don't export delete row --}}
<script>
  $(document).ready(function () {
    $.noConflict();
    var table = $('#usersTable').DataTable( {
      dom: 'fBlrtip',
        buttons:
          [
            {
              className: 'btn btn-primary',
              extend: 'excelHtml5',
              text: 'Export',
              exportOptions: {
              columns: ":not(.dnr)"
              }
            }
            
          ]
    });
    $('#usersTable tbody').on( 'click', 'tr', function () {
    var d = "";
    d = table.row( this ).data();
    d.pop();
    console.log(d);
} );

$.fn.dataTable.ext.errMode = 'none';
  });

 


  </script>
  



@endsection

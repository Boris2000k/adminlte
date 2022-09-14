@extends('layouts.app')

@section('content')
<style>
  .dataTables_filter{
   float: left !important;
   padding-left:10px;
}

div.dt-buttons {
  float: left !important;
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
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Page Header
      <small>Optional description</small>
    </h1>
  </section>
 
  <!-- Main content -->
  <section class="content container-fluid">

    {{-- page content --}}
 {{-- page content --}}
 <div class="box">
  <div class="box-header">
    <h3 class="box-title">Data Table With Full Features</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="usersTable" class="display" style="width:100%">
      <thead>
          <tr>
           
            @foreach ($headers as $key => $value)
            <th>{{ $key }}</th>
            @endforeach
              
      
              <th class="dnr">Delete</th>
          </tr>
      </thead>
      <tbody>
          @forelse ($db_data as $data_table)
          <tr>
            @foreach ($headers as $key => $value)
            <td>{{ $data_table->$value }}</td>
            @endforeach
          {{--  <td>{{ $data_table->order_num }}</td>
          <td>{{ $data_table->reason }}</td>
          <td>{{ $data_table->status }}</td>  --}}
          
          <td class="dnr">
            <form style="display:inline;" method="POST" class="fm-inline" action="">
              @csrf
              @method('DELETE')
              <button type="submit" style="background-color: transparent;background-repeat: no-repeat;border: none;cursor: pointer;overflow: hidden;outline: none;">
                <i class="fa-solid fa-trash-can"></i>
              </button>
            </form>
          </a>
          </td>
          </tr>
          @empty
            
          @endforelse
      </tbody>
      <tfoot>
          <tr>
            @foreach ($headers as $key => $value)
            <th>{{ $key }}</th>
            @endforeach
            <th class="dnr">Delete</th>
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
    


<script>
  $(document).ready(function () {
    $.noConflict();
    $('#usersTable').DataTable( {
      dom: 'Bfrtip',
        buttons:
          [
            {
              className: 'btn btn-primary',
              extend: 'excelHtml5',
              exportOptions: {
              columns: ":not(.dnr)"
              }
            }
            
          ]
    });
  });

  </script>
  



@endsection

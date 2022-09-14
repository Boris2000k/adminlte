@extends('layouts.app')

@section('content')

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
              <th>ID</th>
              <th>Reason</th>
              <th>Status</th>
              <th class="dnr">Actions</th>
          </tr>
      </thead>
      <tbody>
          @forelse ($db_data as $data_table)
          <tr>
          <td>{{ $data_table->order_num }}</td>
          <td>{{ $data_table->reason }}</td>
          <td>{{ $data_table->status }}</td>
          
          <td class="dnr">
            <a class="btn btn-primary" href="">Edit</a>
            <a>
            <form style="display:inline;" method="POST" class="fm-inline" action="">
              @csrf
              @method('DELETE')
              <input type="submit" value="Delete" class="btn btn-danger"/>
            </form>
          </a>
          </td>
          </tr>
          @empty
            
          @endforelse
      </tbody>
      <tfoot>
          <tr>
            <th>ID</th>
            <th>Reason</th>
            <th>Status</th>
            <th class="dnr">Actions</th>
          </tr>
      </tfoot>
  </table>
  </div>
  <!-- /.box-body -->
</div>
<a class="btn btn-success btn-lg" href="">Create new user</a>


</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- DataTables -->
    



  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $(document).ready(function () {
    $.noConflict();
    $('#usersTable').DataTable( {
      dom: 'Bfrtip',
        buttons:
          [
            {
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

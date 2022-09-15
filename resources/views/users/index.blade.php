@extends('layouts.app')

@section('content')

{{-- moves the search function to the left --}}
<style>
  .dataTables_filter{
   float: right !important;
   padding-right:10px;
   display:inline;
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
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users overview
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
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Data Table With Full Features</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="usersTable" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th class="dnr">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->updated_at }}</td>
                <td class="dnr">
                  <a class="btn btn-primary" href="{{ route('users.edit', ['user' => $user->id]) }}">Edit</a>
                  <a>
                  <form style="display:inline;" method="POST" class="fm-inline" action="{{ route('users.destroy', ['user' => $user->id]) }}">
                    @csrf
                    @method('DELETE')
                    <input onclick="return confirm('Are you sure you want to delete user {{ $user->username }} ?')" type="submit" value="Delete" class="btn btn-danger"/>
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
                  <th>Username</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th class="dnr">Actions</th>
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
      dom: 'fBrtip',
      buttons: [
    {
      text: 'Add New User',
      className: 'btn btn-success',
      action: function ( e, dt, button, config ) {
        window.location = '{{ route('register') }}';
      }        
    }
]
    });
  });

  </script>

  



@endsection

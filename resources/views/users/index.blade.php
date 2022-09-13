@extends('layouts.app')

@section('content')

<?php



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
          <table id="usersTable" class="display" style="width:100%">
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
      <a class="btn btn-success btn-lg" href="">Create new user</a>


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

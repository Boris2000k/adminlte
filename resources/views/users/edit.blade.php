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
        Edit User
      </h1>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      {{-- page content --}}

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">User details</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form method="POST" role="form" action="{{ route('users.update', ['user' => $user->id ]) }}">
            @csrf
            @method('PUT')
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Username</label>
              <input name="username" type="text" class="form-control" id="exampleInputEmail1" placeholder="Username" value="{{ $user->username }}">
                @if ($errors)
                    @foreach ($errors->all() as $error)
                        <span class="text-danger">{{ $error }}</span>
                    @endforeach
                @endif
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>

    </section>

</div>


@endsection
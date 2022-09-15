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

      



    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection

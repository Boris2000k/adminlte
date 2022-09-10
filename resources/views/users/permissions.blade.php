

@extends('layouts.app')

@section('content')


<?php
$permission_labels = array();
$permission_names = array();
foreach($perms as $perm)
$keys = array_keys($perm);
$keys_amount = sizeof($keys);
for($i=0;$i<$keys_amount;$i++)
{
    array_push($permission_labels,($perm[$keys[$i]]["label"]));
    array_push($permission_names,($perm[$keys[$i]]["permission_required"]));
}

// dump($permission_names);

?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <h1>
            Permissions overview
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

        <section class="content container-fluid">
            <div class="box">

                {{-- page content --}}
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">User-Management</th>
                        {{--  add permissions from config  --}}
                        @foreach ($permission_labels as $permission_name)
                        <th scope="col">{{ $permission_name }}</th>
                        @endforeach
                        <th scope="col">Actions</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user )
                        <form style="display:inline;" method="POST" class="fm-inline" action="{{ route('users.updatePermissions', ['user' => $user->id]) }}">
                            @csrf
                            @method('PUT')
                        <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <?php
                            $permissions = $user->permissions;
                            $permissions = explode(",",$permissions);
                            // automatically check checkbox is user has permission
                            // check for user-management
                            if(in_array('user-management',$permissions))
                            {
                                echo'<td><input class="form-check-input" type="checkbox" name="user-management" value="user-management"  style="width:2vw;height:2vh;" checked="checked"></td>';
                            }
                            else
                            {
                                echo'<td><input class="form-check-input" type="checkbox" name="user-management" value="user-management"  style="width:2vw;height:2vh;"></td>';
                            }
                            // check for perms in config
                            foreach($permission_names as $permission_config)
                            {

                                if(in_array($permission_config,$permissions))
                                {
                                    echo"<td><input class='form-check-input' type='checkbox' name=$permission_config value=$permission_config  style='width:2vw;height:2vh;' checked='checked'></td>";
                                }
                                else
                                {
                                    echo"<td><input class='form-check-input' type='checkbox' name=$permission_config value=$permission_config  style='width:2vw;height:2vh;'></td>";
                                }
                            }

                            ?>
                            <td>
                                
                                    <button class="btn btn-primary" type="submit">Apply Changes</button>
                                </form>
                            </td>   

                            
                            
                        
                        @empty
                        @endforelse
                    </tr>
                    </tbody>
                </table>
                <div class="btn">
                    {{ $users->links() }}
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function(){
$(":checkbox").change(function(){
    if(this.checked)
       $(this).val($(this).attr('name'))
    });
});
    </script>
@endsection


<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        @php
          $user_perms = Auth::user()->permissions;
        @endphp
        
        @if(Str::contains($user_perms,'user-management'))
        
          <li class='treeview'>
            <a href='#'><i class='fa fa-group'></i> <span>User Management</span>
              <span class='pull-right-container'>
                  <i class='fa fa-angle-left pull-right'></i>
                </span>
            </a>
            <ul class='treeview-menu'>
              
                
              
              <li><a href="{{ route('users.index') }}">Users</a></li>
             
              <li><a href="{{ route('users.permissions') }}">Permissions</a></li>
            </ul>
          </li>
          
          
        
        
          @endif

        <li><a href="{{ route('data.index') }}"><i class="fa fa-cubes"></i> <span>Data Import</span></a></li>
        <li class="treeview">
          <a href="#"><i class="fa fa-line-chart"></i> <span>Imported Data</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          @extends('helpers.config_helper');
          <ul class="treeview-menu">
            @for($i=0;$i<$keys_amount;$i++)
              <li><a href="{{ route('data.show',['data' => $keys[$i],'key' => $i]) }}">{{ $data[$i][0] }}</a></li>  
            
            @endfor
          </ul>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
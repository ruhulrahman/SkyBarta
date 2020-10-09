<?php
$siteinfo = DB::table('site_infos')->whereIn('user_id', [1,2])->first();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $siteinfo->title }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="{{ $siteinfo->description }}">
  <meta name=”robots” content="index, follow">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand fixed-top navbar-dark navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <router-link to="/home" class="nav-link">Home</router-link>
      </li>
       {{--  <li class="nav-item d-none d-sm-inline-block">
        <router-link to="/timeline" class="nav-link">Timeline</router-link>
      </li>   --}}
      <li class="nav-item d-none d-sm-inline-block">
        <router-link to="/profile/{{ Auth::user()->slug }}" class="nav-link">Profile</router-link>
      </li>
      </li>
      {{--  <li class="nav-item d-none d-sm-inline-block">
        <router-link to="/findFriends" class="nav-link">Find Friends</router-link>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <router-link to="/friendRequest" class="nav-link">Friend Request</router-link>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <router-link to="/friendList" class="nav-link">Friend List</router-link>
      </li>  --}}
    </ul>

    <!-- SEARCH FORM -->
    <div class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" @keyup="searchData" v-model="search" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click.prevent="searchData">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>

    <ul class="navbar-nav">
      
      <li class="nav-item d-none d-sm-inline-block ml-2">
        <router-link to="/conversation-view" class="nav-link">Conversation</router-link>
      </li>
      
      <li class="nav-item d-none d-sm-inline-block">
        <router-link to="/timeline" class="nav-link">Profile Settings</router-link>
      </li>
    </ul>

    <!-- Right navbar links -->
    {{--  <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ asset('img/picture.png') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="fas fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ asset('img/picture.png') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="fas fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ asset('img/picture.png') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="fas fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
    </ul>  --}}
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <router-link to="/home" class="brand-link">
      <img src="{{ asset('img/logo.png') }}" alt="SkyBarta Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ $siteinfo->title }}</span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @if(Auth::user()->photo)
          <img src="{{ asset('img/profile') }}/{{ Auth::user()->photo }}" class="img-circle elevation-2" alt="User Image">
          @else
          <img src="{{ asset('img/boy.png') }}" class="img-circle elevation-2" alt="User Image">
          @endif
          
        </div>
        <div class="info">
          <a href="#" class="d-block green">
            {{ Auth::user()->name }}
            <p class="orange">{{ Auth::user()->type }}</p>
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">



        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt pink"></i>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>

          @canany(['isAdmin', 'isSuperAdmin'])
          <li class="nav-item">
            <router-link to="/siteinfo" class="nav-link">
              <i class="nav-icon fa fa-info-circle"></i>
              <p>
                Site Info
              </p>
            </router-link>
          </li>
          @endcanany

          <li class="nav-item">
            <router-link to="/find-friends" class="nav-link">
              <i class="nav-icon fa fa-user-circle orange"></i>
              <p>
                Find People
              </p>
            </router-link>
          </li>


          <li class="nav-item">
            <router-link to="/find-job" class="nav-link">
              <i class="nav-icon fa fa-briefcase orange"></i>
              <p>
                Find Job
              </p>
            </router-link>
          </li>


          @canany(['isAdmin', 'isSuperAdmin'])
          <li class="nav-item">
            <router-link to="/video-chat" class="nav-link">
              <i class="nav-icon fa fa-video-camera white"></i>
              <p>
                Video Chat
              </p>
            </router-link>
          </li>
          @endcanany


          @canany(['isAdmin', 'isSuperAdmin'])
          <li class="nav-item">
            <router-link to="/developer" class="nav-link">
              <i class="nav-icon fas fa-user orange"></i>
              <p>
                Developer
              </p>
            </router-link>
          </li>
          @endcanany

          @canany(['isAdmin','isSuperAdmin'])
          <li class="nav-item">
            <router-link to="/privacy" class="nav-link">
              <i class="nav-icon fa fa-user-secret red"></i>
              <p>
                Privacy
              </p>
            </router-link>
          </li>
          @endcanany

          @canany(['isAdmin','isSuperAdmin'])
          <li class="nav-item">
            <router-link to="/blood" class="nav-link">
              <i class="nav-icon fas fa-tint red"></i>
              <p>
                Blood
              </p>
            </router-link>
          </li>
          @endcanany

          @canany(['isAdmin','isSuperAdmin'])
          <li class="nav-item">
            <router-link to="/degree" class="nav-link">
              <i class="nav-icon fas fa-book white"></i>
              <p>
                Degree
              </p>
            </router-link>
          </li>
          @endcanany

          @canany(['isAdmin','isSuperAdmin'])
          <li class="nav-item">
            <router-link to="/major" class="nav-link">
              <i class="nav-icon fas fa-book-open green"></i>
              <p>
                Major
              </p>
            </router-link>
          </li>
          @endcanany

          @canany(['isAdmin','isSuperAdmin'])
          <li class="nav-item">
            <router-link to="/profession" class="nav-link">
              <i class="nav-icon fas fa-book-reader orange"></i>
              <p>
                Profession
              </p>
            </router-link>
          </li>
          @endcanany

          @canany(['isAdmin','isAuthor', 'isSuperAdmin'])
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog yellow"></i>
              <p>
                Job Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/add-company" class="nav-link">
                  <i class="fas fa-briefcase nav-icon"></i>
                  <p>Add Company</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/post-job" class="nav-link">
                  <i class="fas fa-briefcase nav-icon"></i>
                  <p>Post Job</p>
                </router-link>
              </li>
            </ul>
          </li>
          @endcanany

          @canany(['isAdmin', 'isSuperAdmin'])
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog blue"></i>
              <p>
                Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <router-link to="/users" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Users</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/skill" class="nav-link">
                  <i class="fas fa-love nav-icon"></i>
                  <p>Skill</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/religion" class="nav-link">
                  <i class="fas fa-religion nav-icon"></i>
                  <p>Religion</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/relation" class="nav-link">
                  <i class="fas fa-love nav-icon"></i>
                  <p>Relation</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/gender" class="nav-link">
                  <i class="fas fa-love nav-icon"></i>
                  <p>Gender</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/role" class="nav-link">
                  <i class="fas fa-love nav-icon"></i>
                  <p>Role</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/user-role" class="nav-link">
                  <i class="fas fa-love nav-icon"></i>
                  <p>User Role</p>
                </router-link>
              </li>

            </ul>
          </li>
          @endcanany

          @canany(['isAdmin', 'isSuperAdmin'])
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-map-marker green"></i>
              <p>
                Location Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <router-link to="/division" class="nav-link">
                  <i class="fas fa-circle text-info nav-icon"></i>
                  <p>Division</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/district" class="nav-link">
                  <i class="fas fa-circle text-success nav-icon"></i>
                  <p>District</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/thana" class="nav-link">
                  <i class="fas fa-circle nav-icon"></i>
                  <p>Thana</p>
                </router-link>
              </li>
            </ul>
          </li>
          @endcanany



          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-power-off text-danger"></i>
                <p>
                    {{ __('Logout') }}
                </p>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
        
  <div class="vue-routers-content">
        <router-view v-bind:user_id="{{ Auth::user()->id }}" pusher-key="{{ config('broadcasting.connections.pusher.key') }}" pusher-cluster="{{ config('broadcasting.connections.pusher.options.cluster') }}"></router-view>
        {{--  <chat-app v-bind:user_id="{{ Auth::user()->id }}"></chat-app>  --}}
        <vue-progress-bar></vue-progress-bar>
  </div>
        

  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; and all rights reserved. by <a href="www.facebook.com/Ruhul.14">Ruhul Amin</a>. Software developer and founder of SkyBarta.</strong>

    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


@auth
<script>
  window.user = @json(auth()->user())
</script>
@endauth


<!-- jQuery -->
<script src="{{ asset('js/app.js')}}"></script>
</body>
</html>

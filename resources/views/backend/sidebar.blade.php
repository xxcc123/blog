
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            @if (auth()->user()->img)
                <img style="width: 40px;height: 40px;" class="img-circle" src="{{asset(auth()->user()->img)}}" alt="User Image">
            @else
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            @endif
        </div>
        <div class="pull-left info">
            <p>{{auth()->user()->name}}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview {{ substr('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],0,32) == route('admin.home') ? 'active' : ''}}">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{ substr('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],0,32) == substr(route('admin.home'),0,32) ? 'active' : ''}}"><a href="{{route('admin.home')}}"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
            </ul>
        </li>
        <li class="{{ substr('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],0,32) == substr(route('user'),0,32) ? 'active' : ''}}">
            <a href="{{route('user')}}">
                <i class="fa fa-user"></i> <span>User</span>
            </a>
        </li>
        <li class="{{ substr('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],0,32) == substr(route('artisan.index'),0,32) ? 'active' : ''}}">
            <a href="{{route('artisan.index')}}">
                <i class="fa fa-th"></i> <span>Article</span>
                <span class="pull-right-container">
                    <small class="label pull-right bg-green">new</small>
                </span>
            </a>
        </li>

        <li class="{{ substr('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],0,32) == substr(route('category.list'),0,32) ? 'active' : ''}}">
            <a href="{{route('category.list')}}">
                <i class="fa fa-pagelines"></i> <span>Category</span>
            </a>
        </li>

        <li class="{{ substr('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],0,32) == substr(route('logs.log'),0,32) ? 'active' : ''}}">
            <a target="_blank" href="{{route('logs.log')}}">
                <i class="fa fa-pagelines"></i> <span>Logs</span>
            </a>
        </li>
    </ul>
</section>
@section('script')
    <script type="application/javascript">

    </script>
@endsection

<nav class="navbar navbar-dark bg-primary flex-sm-nowrap p-0">

    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">{{ config('app.name') }}</a>


    @if (trim($__env->yieldContent('nav-search')))
    <form class="w-100" action="@yield('nav-search-action')" method="GET">
        <input class="nav-search iconfont form-control form-control-dark bg-transparent border-0 w-100 text-light"
            type="text" placeholder="&#xe82e; @yield('nav-search')" name="q" required>
    </form>
    @endif


    <div class="dropdown">
        <button class="btn dropdown-toggle text-light iconfont icon-user-circle"
            type="button" data-toggle="dropdown">
            {{\Auth::user()->name}}
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('admin.profile') }}">个人信息</a>
            <div class="dropdown-divider"></div>
            <form action="{{ route('admin.logout') }}" method="post">
                {{csrf_field()}}
                <button class="dropdown-item" href="#">登出</button>
            </form>
        </div>
    </div>

</nav>

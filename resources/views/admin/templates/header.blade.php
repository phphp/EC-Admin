<nav class="navbar navbar-dark bg-primary flex-sm-nowrap p-0">

    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">{{ config('app.name') }}</a>

    <input class="nav-search iconfont form-control form-control-dark bg-transparent border-0 w-100 text-light" type="text" placeholder="&#xe82e;">

    <div class="dropdown">
        <button class="btn dropdown-toggle text-light iconfont icon-user-circle"
            type="button" data-toggle="dropdown">
            username
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="#">个人信息</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">登出</a>
        </div>
    </div>

</nav>

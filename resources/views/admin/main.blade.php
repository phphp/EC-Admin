<!doctype html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="robots" content="noindex,nofollow">
        <meta name="_token" content="{{ csrf_token() }}">
        <title>@yield('title') - 后台</title>
        <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="https://cdn.staticfile.org/bootswatch/4.3.1/sandstone/bootstrap.min.css"> -->

        <link rel="stylesheet" href="//at.alicdn.com/t/font_1279413_cf3al7mnv3i.css">

        <link rel="stylesheet" href="{{ asset('/css/admin.css') }}">
    </head>
    <body>

        <!-- 加载头 -->
        @include('admin/templates/header')

        <!-- 正文 -->
        <div class="container-fluid">
            <div class="row">

                <!-- 左栏手风琴列表 -->
                <nav class="col-md-2 d-none d-md-block bg-light" id="side-nav">

                    <a class="nav-link active" data-toggle="collapse" href="{{ route('dashboard') }}"><i class="iconfont icon-home"></i> 控制台</a>

                    <a class="nav-link" data-toggle="collapse" href="#nav-admin"><i class="iconfont icon-user-group-fill"></i> 管理员</a>
                    <div id="nav-admin" class="collapse in">
                        <a class="nav-link" href=""><i class="iconfont icon-cc-dot-o"></i> 列表</a>
                        <a class="nav-link" href="#"><i class="iconfont icon-cc-dot-o"></i> 角色</a>
                        <a class="nav-link" href="#"><i class="iconfont icon-cc-dot-o"></i> 权限</a>
                    </div>

                    <a class="nav-link" data-toggle="collapse" href="#nav-image"><i class="iconfont icon-picture-fill"></i> 图片资源</a>
                    <div id="nav-image" class="collapse in">
                        <a class="nav-link" href="#"><i class="iconfont icon-cc-dot-o"></i> 所有图片</a>
                        <a class="nav-link" href="#"><i class="iconfont icon-cc-dot-o"></i> Banner 设定</a>
                    </div>

                    <a class="nav-link" data-toggle="collapse" href="#"><i class="iconfont icon-map-fill"></i> 省市区</a>

                    <a class="nav-link" data-toggle="collapse" href="#"><i class="iconfont icon-cog-fill"></i> 设置</a>

                </nav>

                <!-- 主体 -->
                <main role="main" class="col-md-9 ml-sm-auto col-md-10 pt-3 px-4">

                    <!-- 消息 -->
                    <div class="container">
                        <div>

                            <!-- 异常消息 -->
                            @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <!-- 正常消息 -->
                            @if (Session::has('message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <p>{{ Session::get('message') }}</p>
                            </div>
                            @endif

                        </div>
                    </div>


                    @yield('content')
                </main>

            </div>
        </div>

        <!-- 加载页脚 -->
        @include('admin/templates/footer')

        <script src="https://cdn.staticfile.org/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="{{ asset('/js/admin.js') }}"></script>
        @yield('js')

    </body>
</html>

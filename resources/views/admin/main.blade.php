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
        <?php if (isset($_COOKIE['bs_theme']) && preg_match("/^[a-z]+$/", $_COOKIE['bs_theme'])) { ?>
            <link id="bs-theme" rel="stylesheet" href="https://cdn.staticfile.org/bootswatch/4.3.1/{{ $_COOKIE['bs_theme'] }}/bootstrap.min.css">
        <?php } else { ?>
            <link id="bs-theme" rel="stylesheet">
        <?php } ?>
        <link rel="stylesheet" href="//at.alicdn.com/t/font_1279413_eq0hmox85oc.css">

        <link rel="stylesheet" href="{{ asset('/css/admin.css') }}">

        @yield('css')
    </head>
    <body>

        <!-- 加载头 -->
        @include('admin/templates/header')

        <!-- 正文 -->
        <div class="container-fluid">
            <div class="row">

                <!-- 左栏手风琴列表 -->
                @include('admin/templates/side_nav')

                <!-- 主体 -->
                <main role="main" class="col-md-9 ml-sm-auto col-md-10 pt-3 px-4 pb-4" style="min-height: 800px">

                    <!-- 消息 -->
                    <div class="container">
                        <div>

                            <!-- 异常消息 -->
                            @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <!-- 正常消息 -->
                            @if (Session::has('message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <p class="mb-0">{{ Session::get('message') }}</p>
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
        @yield('js')
        <script src="{{ asset('/js/admin.js') }}"></script>

    </body>
</html>

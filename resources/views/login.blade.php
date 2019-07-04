<!doctype html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <title>欢迎回来</title>
        <link rel="stylesheet" href="https://cdn.staticfile.org/bootswatch/4.3.1/minty/bootstrap.min.css">
        <style>
        :root {
        --input-padding-x: 1.5rem;
        --input-padding-y: 0.75rem;
        }

        .login,
        .image {
        min-height: 100vh;
        }

        .bg-image {
        background-image: url('https://cn.bing.com/th?id=OHR.Montreux_ZH-CN5485205583_1920x1080.jpg&rf=LaDigue_1920x1080.jpg&pid=hp');
        background-size: cover;
        background-position: center;
        }

        .login-heading {
        font-weight: 300;
        }

        .btn-login {
        font-size: 0.9rem;
        letter-spacing: 0.05rem;
        padding: 0.75rem 1rem;
        border-radius: 2rem;
        }

        .form-label-group {
        position: relative;
        margin-bottom: 1rem;
        }

        .form-label-group>input,
        .form-label-group>label {
        padding: var(--input-padding-y) var(--input-padding-x);
        height: auto;
        border-radius: 2rem;
        }

        .form-label-group>label {
        position: absolute;
        top: 0;
        left: 0;
        display: block;
        width: 100%;
        margin-bottom: 0;
        /* Override default `<label>` margin */
        line-height: 1.5;
        color: #495057;
        cursor: text;
        /* Match the input under the label */
        border: 1px solid transparent;
        border-radius: .25rem;
        transition: all .1s ease-in-out;
        }

        .form-label-group input::-webkit-input-placeholder {
        color: transparent;
        }

        .form-label-group input:-ms-input-placeholder {
        color: transparent;
        }

        .form-label-group input::-ms-input-placeholder {
        color: transparent;
        }

        .form-label-group input::-moz-placeholder {
        color: transparent;
        }

        .form-label-group input::placeholder {
        color: transparent;
        }

        .form-label-group input:not(:placeholder-shown) {
        padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
        padding-bottom: calc(var(--input-padding-y) / 3);
        }

        .form-label-group input:not(:placeholder-shown)~label {
        padding-top: calc(var(--input-padding-y) / 3);
        padding-bottom: calc(var(--input-padding-y) / 3);
        font-size: 12px;
        color: #777;
        }

        /* Fallback for Edge
        -------------------------------------------------- */

        @supports (-ms-ime-align: auto) {
        .form-label-group>label {
            display: none;
        }
        .form-label-group input::-ms-input-placeholder {
            color: #777;
        }
        }

        /* Fallback for IE
        -------------------------------------------------- */

        @media all and (-ms-high-contrast: none),
        (-ms-high-contrast: active) {
        .form-label-group>label {
            display: none;
        }
        .form-label-group input:-ms-input-placeholder {
            color: #777;
        }
        }
        </style>
    </head>
    <body>

        <div class="container-fluid">
        <div class="row no-gutter">
            <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
            <div class="col-md-8 col-lg-6">
            <div class="login d-flex align-items-center py-5">
                <div class="container">
                <div class="row">
                    <div class="col-md-9 col-lg-8 mx-auto">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h3 class="login-heading mb-4">欢迎回来！</h3>
                    <form method="POST" action="{{ route('admin.login') }}">
                        {{ csrf_field() }}

                        <div class="form-label-group">
                            <input type="email" name="email" value="{{ old('email') }}" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                            <label for="inputEmail">邮箱</label>
                        </div>

                        <div class="form-label-group">
                            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                            <label for="inputPassword">密码</label>
                        </div>

                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" checked="checked">
                            <label class="custom-control-label" for="customCheck1">记住我</label>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit">登录</button>
                        <div class="text-center">
                    </form>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>

        <script src="https://cdn.staticfile.org/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.staticfile.org/popper.js/1.15.0/popper.min.js"></script>
        <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>

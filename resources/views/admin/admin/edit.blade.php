@extends('admin/main')


@section('title')编辑管理员@stop


@section('content')

    <!-- 工具 -->
    <div class="container mb-1">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-white border-0">
                        <li class="breadcrumb-item"><a href="#">管理员</a></li>
                        <li class="breadcrumb-item"><a href="#">列表</a></li>
                        <li class="breadcrumb-item active" aria-current="page">修改</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- 表单 -->
    <div class="col-md-7">
        <form action="{{ route('admins.update', ['id'=>$admin->id]) }}" method="post" enctype="multipart/form-data" id="ajaxForm">
            {{csrf_field()}}
            {{ method_field('PUT') }}

            <div class="form-group">
                <label>ID</label>
                <input type="text" class="form-control" value="{{ $admin->id }}" disabled>
            </div>
            <div class="form-group">
                <label>名称</label>
                <input type="text" class="form-control" name="name" placeholder="name" value="{{ $admin->name }}" required="required">
            </div>
            <div class="form-group">
                <label>邮箱</label>
                <input type="email" class="form-control" name="email" placeholder="email" value="{{ $admin->email }}" required="required">
            </div>
            <div class="form-group">
                <label>密码</label>
                <input type="password" class="form-control" name="password" placeholder="password">
            </div>

            <hr>
            <div class="form-group">
                <label>头像</label>
            </div>

            <div>
                <div style="max-width: 600px; max-height: 400px">
                    <img src="{{ url($admin->avatar.'/l.jpg') }}" id="target">
                </div>

                <div class="row align-items-center preview-container m-0 mt-1 mb-1 p-1 text-center">
                    <div class="col">
                        <img src="" id="previewL" class="rounded">
                    </div>
                    <div class="col">
                        <img src="" id="previewM" class="rounded">
                    </div>
                    <div class="col">
                        <img src="" id="previewS" class="rounded">
                    </div>
                </div>

                <div class="form-group">
                    <label>选择角色</label>
                    @foreach ( $roles as $v )
                    <label class="checkbox-inline" title="{{ $v['name'] }}" style="display:block">
                        <input
                        @if ( $admin->roles->contains($v->id) )
                            checked="checked"
                        @endif
                        type="checkbox" name="roles[]" value="{{ $v->id }}"> {{ $v->name }}
                    </label>
                    @endforeach
                </div>

                <hr>
                <div class="form-group">
                    <div class="input-group">
                        <input type="file" multiple="multiple" class="custom-file-input" id="selectNewFile">
                        <label class="custom-file-label" for="selectNewFile">上传新头像，或使用原来的头像</label>
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="button" class="btn btn-secondary" id="getCroppedCanvas">预览</button>
                </div>

                {{-- 向 formData 添加的数据必须是表单中存在的 input name --}}
                <input type="hidden" name="avatarL" value="">
                <input type="hidden" name="avatarM" value="">
                <input type="hidden" name="avatarS" value="">

            </div>

            <hr>
            <div id="error-alert" style="display: none" class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                </ul>
            </div>
            <button type="button" id="submit" class="btn btn-primary">修改</button>
        </form>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.staticfile.org/cropperjs/1.5.2/cropper.css">
@stop

@section('js')
    <script src="https://cdn.staticfile.org/cropperjs/1.5.2/cropper.js"></script>
    <script>
            // 当有文件选择
            $('#selectNewFile').change(function(e){
                // 设置 bs 输入框名称
                let fileName = e.target.files[0].name;
                $('.custom-file-label').html(fileName);

                // 判断是否有
                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        cropper.replace(e.target.result); // 换图片
                    }
                    reader.readAsDataURL(this.files[0]); // 读取文件触发 onload
                }
            });

            // 预览图的 id 和尺寸
            const lengthArr = [['#previewL', 200], ['#previewM', 100], ['#previewS', 50]];

            const image = document.getElementById('target');
            const cropper = new Cropper(image, {
                aspectRatio: 1/1,
                viewMode: 1,
                guides: false,
                minCropBoxWidth: 100,
                minCropBoxHeight: 100,
                dragMode: 'move',
            });

            // 进行裁剪
            $("#getCroppedCanvas").on("click", function () {
                // 遍历生成预览
                lengthArr.forEach((v) => {
                    let canvas = cropImage(v[1]);
                    let base64url = canvas.toDataURL('image/jpeg');
                    canvas.toBlob(function (e) {
                        $(v[0]).attr('src', base64url);
                        $(v[0]).css('width', v[1]);
                        $(v[0]).css('height', v[1]);
                    })
                });
            })

            // 进行提交
            $("#submit").on("click", function () {
                $(this).attr("disabled", true); // 禁止重复点击

                let formElement = document.querySelector("#ajaxForm");
                let formData = new FormData(formElement);

                // 判断有没有选择新文件，如果有才会裁剪图片并上传
                if ($('.custom-file-label').html() != new String('上传新头像，或使用原来的头像')) {
                    lengthArr.forEach((v) => {
                        let canvas = cropImage(v[1]);
                        let base64url = canvas.toDataURL('image/jpeg');
                        formData.append('avatar'+v[0][v[0].length -1], base64url);
                    });
                    // formData 只能 entries 遍历
                    // for (var key of formData.entries()) {
                    //     console.log(key[0] + ', ' + key[1]);
                    // }
                }

                var that = this;
                $.ajax('{{ route('admins.update', ['id'=>$admin->id]) }}', {
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                    success: function () {
                        console.log('Upload success');
                        window.location.replace("{{ route('admins.index') }}");
                    },
                    error: function (xhr, status, error) {
                        let err = JSON.parse(xhr.responseText);
                        // 输出错误列表
                        Object.keys(err.errors).forEach((v) => {
                            $('#error-alert ul').append('<li>'+err.errors[v][0]+'</li>');
                        })
                        $('#error-alert').css('display', 'block');
                        $(that).removeAttr("disabled");
                    }
                });
            })

            // 裁剪图片
            function cropImage(length) {
                return cropper.getCroppedCanvas({
                    width: length,
                    height: length,
                    fillColor: '#fff',
                    imageSmoothingQuality: 'high',
                    checkCrossOrigin: false,
                })
            }

    </script>
@stop

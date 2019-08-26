@extends('admin/main')


@section('title')添加图片@stop


@section('content')

    <!-- 工具 -->
    <div class="container mb-1">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-white border-0">
                        <li class="breadcrumb-item"><a href="#">图片资源</a></li>
                        <li class="breadcrumb-item active" aria-current="page">添加</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <!-- 表单 -->
    <div class="col-md-7">
        <form action="{{ route('image.store') }}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <label>title</label>
                <input type="text" class="form-control" name="title" placeholder="title" value="{{old('title')}}">
            </div>
            <div class="form-group">
                <label>alt</label>
                <input type="text" class="form-control" name="alt" placeholder="alt" value="{{old('alt')}}">
            </div>

            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="internal" id="inlineRadio1" value="1" checked autocomplete="off">
                    <label class="form-check-label" for="inlineRadio1">内部图片</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="internal" id="inlineRadio2" value="0" autocomplete="off">
                    <label class="form-check-label" for="inlineRadio2">外部图片</label>
                </div>
            </div>

            <div class="form-group" id="inlineRadio1-content">
                <div class="input-group">
                    <input type="file" name="image" multiple="multiple" class="custom-file-input" id="selectNewFile">
                    <label class="custom-file-label" for="selectNewFile">选择图像</label>
                </div>
            </div>

            <div class="form-group" id="inlineRadio2-content" style="display: none">
                <input type="text" class="form-control" name="src" placeholder="外部图片地址" value="{{old('src')}}">
            </div>

            <button type="submit" id="submit" class="btn btn-primary">添加</button>
        </form>
    </div>

@stop

@section('js')
<script>
    $('#selectNewFile').change(function(e){
        // 设置 bs 输入框名称
        let fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });

    $('#inlineRadio1').click(function(e){
        $('#inlineRadio1-content').css('display', 'block');
        $('#inlineRadio2-content').css('display', 'none');
    });
    $('#inlineRadio2').click(function(e){
        $('#inlineRadio1-content').css('display', 'none');
        $('#inlineRadio2-content').css('display', 'block');
    });
</script>
@stop

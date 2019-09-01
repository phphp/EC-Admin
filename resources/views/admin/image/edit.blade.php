@extends('admin/main')


@section('title')编辑图片@stop


@section('content')

    <!-- 工具 -->
    <div class="container mb-1">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-white border-0">
                        <li class="breadcrumb-item"><a href="#">图片资源</a></li>
                        <li class="breadcrumb-item active" aria-current="page">修改</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- 表单 -->
    <div class="col-md-7">

        <img src="{{ $image->src }}" style="max-height: 400px; max-width: 400px" referrerpolicy="no-referrer">

        <p>{{ $image->src }}</p>

        <form action="{{ route('image.update', ['id'=>$image->id]) }}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            {{ method_field('PUT') }}

            <div class="form-group">
                <label>ID</label>
                <input type="text" class="form-control" value="{{ $image->id }}" disabled>
            </div>
            <div class="form-group">
                <label>title</label>
                <input type="text" name="title" class="form-control" value="{{ $image->title }}">
            </div>
            <div class="form-group">
                <label>alt</label>
                <input type="text" name="alt" class="form-control" value="{{ $image->alt }}">
            </div>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="internal" id="inlineRadio1" value="1" <?php if($image->internal == 1) echo 'checked' ?> autocomplete="off">
                    <label class="form-check-label" for="inlineRadio1">内部图片</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="internal" id="inlineRadio2" value="0" <?php if($image->internal == 0) echo 'checked' ?> autocomplete="off">
                    <label class="form-check-label" for="inlineRadio2">外部图片</label>
                </div>
            </div>
            <div class="form-group" id="inlineRadio1-content" <?php if($image->internal == 0) echo 'style="display: none"' ?>>
                <div class="input-group">
                    <input type="file" name="image" multiple="multiple" class="custom-file-input" id="selectNewFile">
                    <label class="custom-file-label" for="selectNewFile">替换图片</label>
                </div>
            </div>
            <div class="form-group" id="inlineRadio2-content" <?php if($image->internal == 1) echo 'style="display: none"' ?>>
                <input type="text" class="form-control" name="src" <?php if($image->internal == 0) echo 'value="'.$image->src.'"' ?> placeholder="外部图片地址">
            </div>

            <div class="form-group">
                <label>mime_type</label>
                <input type="text" class="form-control" value="{{ $image->mime_type }}" disabled>
            </div>
            <div class="form-group">
                <label>宽</label>
                <input type="text" class="form-control" value="{{ $image->width }}" disabled>
            </div>
            <div class="form-group">
                <label>高</label>
                <input type="text" class="form-control" value="{{ $image->height }}" disabled>
            </div>
            <div class="form-group">
                <label>大小</label>
                <input type="text" class="form-control" value="{{ $image->filesize }}" disabled>
            </div>

            <button type="submit" id="submit" class="btn btn-primary">修改</button>
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

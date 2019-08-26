@extends('admin/main')


@section('title')添加 Banner @stop


@section('content')

    <!-- 工具 -->
    <div class="container mb-1">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-white border-0">
                        <li class="breadcrumb-item"><a href="#">Banner 设定</a></li>
                        <li class="breadcrumb-item active" aria-current="page">添加</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <!-- 表单 -->
    <div class="col-md-7" id="app">
        <form action="{{ route('banner.store') }}" method="post" enctype="multipart/form-data" id="ajaxForm">
            {{csrf_field()}}
            <div class="form-group">
                <label>name</label>
                <input v-model="name" type="text" class="form-control" name="name" placeholder="name" value="{{old('title')}}">
            </div>
            <div class="form-group">
                <label>描述</label>
                <input v-model="description" type="text" class="form-control" name="description" placeholder="description" value="{{old('description')}}">
            </div>

            <div id="sortable">
                <div class="moveable border border-secondary p-3 rounded mb-1" v-for="(image) in images" v-bind:key="image.no" v-bind:id="image.no">
                    <p class="d-flex justify-content-between">
                        <span style="cursor: move;"><i class="iconfont icon-arrows-alt"></i> 图片 @{{ image.no }}</span>
                        <i class="pull-right iconfont icon-times-circle" v-on:click="removeImage(image.no)"></i>
                    </p>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input v-model="image.type" class="form-check-input" type="radio" value="2" checked autocomplete="off">
                                使用已有图片
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input v-model="image.type" class="form-check-input" type="radio" value="1" autocomplete="off">
                                上传内部图片
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input v-model="image.type" class="form-check-input" type="radio" value="0" autocomplete="off">
                                使用外部图片
                            </label>
                        </div>
                    </div>

                    <div class="form-group" v-show="image.type == 2">
                        <input v-model="image.image_id" type="text" class="form-control" placeholder="填写图片 ID">
                    </div>

                    <div v-show="image.type == 1">
                        <div class="form-group">
                            <label>title</label>
                            <input v-model="image.title" type="text" class="form-control" placeholder="title" value="{{old('title')}}">
                        </div>
                        <div class="form-group">
                            <label>alt</label>
                            <input v-model="image.alt" type="text" class="form-control" placeholder="alt" value="{{old('alt')}}">
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="file" multiple="multiple" class="custom-file-input" v-on:change="showFileName(image.no, $event)">
                                <label class="custom-file-label">@{{ image.file_name }}</label>
                            </div>
                        </div>
                    </div>

                    <div v-show="image.type == 0">
                        <div class="form-group">
                            <label>title</label>
                            <input v-model="image.title" type="text" class="form-control" placeholder="title" value="{{old('title')}}">
                        </div>
                        <div class="form-group">
                            <label>alt</label>
                            <input v-model="image.alt" type="text" class="form-control" placeholder="alt" value="{{old('alt')}}">
                        </div>
                        <div class="form-group">
                            <label>src</label>
                            <input v-model="image.src" type="text" class="form-control" placeholder="外部图片地址">
                        </div>
                    </div>
                </div>
            </div>

            <p class="d-flex flex-row-reverse">
                <button type="button" class="btn btn-secondary float-right" v-on:click="addImage">
                    <i class="iconfont icon-plus"></i>
                </button>
            </p>

            <button type="button" id="submit" class="btn btn-primary" v-on:click="submit">提交</button>
        </form>
    </div>

@stop

@section('js')

    @if (config('app.debug'))
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    @else
        <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    @endif
    {{-- https://jqueryui.com/draggable/ --}}
    <script src="https://cdn.staticfile.org/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(function() {
        $( "#sortable" ).sortable({
            cursor: "move",
            items :".moveable",
            opacity: 0.6,
            revert: true,
            delay: 200,
            update : function(event, ui) {
                    // 当排序动作结束时且元素坐标已经发生改变时触发此事件
                    var data = $(this).sortable("toArray");
                    // 按照新顺序排序 vue 中的 images 数组
                    app.sort(data);
                }
        });
        $( "#sortable" ).disableSelection();
    });

    var app = new Vue({
        el: '#app',
        data: {
            name: '',
            description: '',
            images: [
                {
                    'no': 1,
                    'type': 2,
                    'image_id': null,
                    'title': null,
                    'alt': null,
                    'image_file': null,
                    'src': null,
                    'file_name': '选择图像',
                    'fd': {}
                }
            ],
            count: 1,
        },
        methods: {
            addImage() {
                this.count++;
                this.images.push({
                    'no': this.count,
                    'type': 2,
                    'image_id': null,
                    'title': null,
                    'alt': null,
                    'image_file': null,
                    'src': null,
                    'file_name': '选择图像',
                    'fd': {}
                })
            },
            showFileName(no, event) {
                var fileData =  event.target.files[0];
                console.log(fileData)
                console.log(event.file)
                this.images.forEach((image, index) => {
                    if ( image.no == no ) {
                        this.images[index].file_name = fileData.name;
                        this.images[index].fd = fileData;
                    }
                })
            },
            sort(newArray) {
                let newImages = [];
                newArray.forEach(v => {
                    this.images.forEach(image => {
                        if ( image.no == v ) {
                            newImages.push(image);
                        }
                    })
                });
                this.images = newImages;
                console.log(newArray)
            },
            removeImage(no) {
                this.images.forEach((image, index) => {
                    if ( image.no == no ) {
                        this.images.splice(index, 1)
                    }
                })
            },
            submit() {
                // 获取表单数据 formData
                let formElement = document.querySelector("#ajaxForm");
                let fd= new FormData(formElement);
                this.images.forEach((image, index) => {
                    if ( image.type == 1 )
                        fd.append('image' + image.no, image.fd);
                })
                fd.append('images', JSON.stringify(this.images));

                $.ajax('{{ route('banner.store') }}', {
                        method: "POST",
                        data: fd,
                        processData: false,
                        contentType: false,
                    success: function () {
                        console.log('Upload success');
                        window.location.replace("{{ route('banner.index') }}");
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
            },
        },
    })

</script>
@stop

@extends('admin/main')


@section('title')图片列表@stop


@section('content')

    <!-- 工具 -->
    <div class="container mb-1">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-white border-0">
                        <li class="breadcrumb-item"><a href="#">图片资源</a></li>
                        <li class="breadcrumb-item active" aria-current="page">列表</li>
                    </ol>
                </nav>
            </div>
            <div class="col text-right">
                <a class="btn btn-primary btn-sm" href="{{ route('image.create') }}" role="button">
                    <i class="iconfont icon-fileplus-fill"></i> 添加
                </a>
            </div>
        </div>
    </div>

    <!-- 列表 -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">title</th>
                    <th scope="col">alt</th>
                    <th scope="col">内部图片</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($images as $image)
                <tr>
                    <th scope="row">
                        <a href="{{ $image->src }}" target="_blank">
                            <img width=50 height=50 style="object-fit: contain"
                                src="{{ $image->src }}"
                                referrerpolicy="no-referrer" />
                        </a>
                    </th>
                    <td>{{ $image->title }}</td>
                    <td>{{ $image->alt }}</td>
                    <td>{{ $image->internal }}</td>
                    <td>
                        <a href="{{ route('image.edit', ['id'=>$image->id]) }}" class="float-left mr-1">
                            <button class="btn btn-primary btn-sm"><i class="iconfont icon-edit"></i></button>
                        </a>
                        <button class="btn btn-danger btn-sm float-left"
                            data-toggle="modal"
                            data-target="#deleteModal"
                            data-url="{{ route('image.destroy', ['id'=>$image->id]) }}"
                            >
                            <i class="iconfont icon-delete-fill"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {!! $images->render('pagination::bootstrap-4') !!}

@stop

@section('js')
    @include('admin/templates/modal_delete')
@stop

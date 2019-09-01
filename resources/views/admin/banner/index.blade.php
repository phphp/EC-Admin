@extends('admin/main')


@section('title')banner 列表@stop


@section('content')

    <!-- 工具 -->
    <div class="container mb-1">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-white border-0">
                        <li class="breadcrumb-item"><a href="#">Banner 设定</a></li>
                        <li class="breadcrumb-item active" aria-current="page">列表</li>
                    </ol>
                </nav>
            </div>
            <div class="col text-right">
                <a class="btn btn-primary btn-sm" href="{{ route('banner.create') }}" role="button">
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
                    <th scope="col">name</th>
                    <th scope="col">描述</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banners as $banner)
                <tr>
                    <th scope="row">
                        <a href="{{ route('banner.edit', ['id'=>$banner->id]) }}">{{ $banner->id }}</a>
                    </th>
                    <td>{{ $banner->name }}</td>
                    <td>{{ $banner->description }}</td>
                    <td>
                        <a href="{{ route('banner.edit', ['id'=>$banner->id]) }}" class="float-left mr-1">
                            <button class="btn btn-primary btn-sm"><i class="iconfont icon-edit"></i></button>
                        </a>
                        <button class="btn btn-danger btn-sm float-left"
                            data-toggle="modal"
                            data-target="#deleteModal"
                            data-url="{{ route('banner.destroy', ['id'=>$banner->id]) }}"
                            >
                            <i class="iconfont icon-delete-fill"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@stop

@section('js')
    @include('admin/templates/modal_delete')
@stop

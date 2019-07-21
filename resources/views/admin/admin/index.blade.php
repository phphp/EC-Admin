@extends('admin/main')


@section('title')管理员列表@stop


@section('content')

    <!-- 工具 -->
    <div class="container mb-1">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-white border-0">
                        <li class="breadcrumb-item"><a href="#">管理员</a></li>
                        <li class="breadcrumb-item active" aria-current="page">列表</li>
                    </ol>
                </nav>
            </div>
            <div class="col text-right">
                <a class="btn btn-primary btn-sm" href="{{ route('admins.create') }}" role="button">
                    <i class="iconfont icon-fileplus-fill"></i> 新建
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
                    <th scope="col">名称</th>
                    <th scope="col">邮箱</th>
                    <th scope="col">头像</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                <tr>
                    <th scope="row">{{ $admin->id }}</th>
                    <td><a href="{{ route('admins.edit', ['id'=>$admin->id]) }}">{{ $admin->name }}</a></td>
                    <td>{{ $admin->email }}</td>
                    <td><img class="rounded-sm" src="{{ url($admin->avatar.'/s.jpg') }}"></td>
                    <td>
                        <a href="{{ route('admins.edit', ['id'=>$admin->id]) }}" class="float-left mr-1">
                            <button class="btn btn-primary btn-sm"><i class="iconfont icon-edit"></i></button>
                        </a>
                        <button class="btn btn-danger btn-sm float-left"
                            data-toggle="modal"
                            data-target="#deleteModal"
                            data-url="{{ route('admins.destroy', ['id'=>$admin->id]) }}"
                            >
                            <i class="iconfont icon-delete-fill"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {!! $admins->render('pagination::bootstrap-4') !!}

@stop

@section('js')
    @include('admin/templates/modal_delete')
@stop

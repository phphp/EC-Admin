@extends('admin/main')


@section('title')角色列表@stop


@section('content')

    <!-- 工具 -->
    <div class="container mb-1">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-white border-0">
                        <li class="breadcrumb-item"><a href="#">角色</a></li>
                        <li class="breadcrumb-item active" aria-current="page">列表</li>
                    </ol>
                </nav>
            </div>
            <div class="col text-right">
                <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}" role="button">
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
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <th scope="row">{{ $role->id }}</th>
                    <td><a href="{{ route('roles.edit', ['id'=>$role->id]) }}">{{ $role->name }}</a></td>
                    <td>
                        <a href="{{ route('roles.edit', ['id'=>$role->id]) }}" class="float-left mr-1">
                            <button class="btn btn-primary btn-sm"><i class="iconfont icon-edit"></i></button>
                        </a>
                        <button class="btn btn-danger btn-sm float-left"
                            data-toggle="modal"
                            data-target="#deleteModal"
                            data-url="{{ route('roles.destroy', ['id'=>$role->id]) }}"
                            >
                            <i class="iconfont icon-delete-fill"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- 角色权限表 -->
    <hr>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <caption style="caption-side: top;">角色-权限关系表</caption>
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    @foreach ($roles as $role)
                    <th scope="col">{{ $role->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                <tr>
                    <th scope="row">{{ $permission->name }}</th>
                    @foreach ($roles as $role)
                    <td>
                        <?php
                        if( in_array( $permission->id, array_column($role->permissions->toArray(), 'id')) )
                            echo '<i class="iconfont icon-check"></i>';
                        ?>
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@stop

@section('js')
    @include('admin/templates/modal_delete')
@stop

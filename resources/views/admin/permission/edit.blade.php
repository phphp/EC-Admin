@extends('admin/main')


@section('title')编辑权限@stop


@section('content')

    <!-- 工具 -->
    <div class="container mb-1">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-white border-0">
                        <li class="breadcrumb-item"><a href="#">权限</a></li>
                        <li class="breadcrumb-item"><a href="#">列表</a></li>
                        <li class="breadcrumb-item active" aria-current="page">修改</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- 表单 -->
    <div class="col-md-7">
        <form action="{{ route('permissions.update', ['id'=>$permission->id]) }}" method="post">
            {{csrf_field()}}
            {{ method_field('PUT') }}

            <div class="form-group">
                <label>ID</label>
                <input type="text" class="form-control" value="{{ $permission->id }}" disabled>
            </div>
            <div class="form-group">
                <label>名称</label>
                <input type="text" class="form-control" name="name" value="{{ $permission->name }}" required="required">
            </div>
            <div class="form-group">
                <label>action</label>
                <select class="form-control" name="action">
                    @if ($permission->action == 'GET')
                        <option value="GET" selected>GET</option>
                    @else
                        <option value="GET">GET</option>
                    @endif

                    @if ($permission->action == 'POST')
                        <option value="POST" selected>POST</option>
                    @else
                        <option value="POST">POST</option>
                    @endif

                    @if ($permission->action == 'PUT')
                        <option value="PUT" selected>PUT</option>
                    @else
                        <option value="PUT">PUT</option>
                    @endif

                    @if ($permission->action == 'DELETE')
                        <option value="DELETE" selected>DELETE</option>
                    @else
                        <option value="DELETE">DELETE</option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label>uri</label>
                <input type="text" class="form-control" name="uri" value="{{ $permission->uri }}" required="required">
            </div>

            <button type="submit" id="submit" class="btn btn-primary">修改</button>
        </form>
    </div>


@stop

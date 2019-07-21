@extends('admin/main')


@section('title')添加权限@stop


@section('content')

    <!-- 工具 -->
    <div class="container mb-1">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-white border-0">
                        <li class="breadcrumb-item"><a href="#">权限</a></li>
                        <li class="breadcrumb-item"><a href="#">列表</a></li>
                        <li class="breadcrumb-item active" aria-current="page">添加</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- 表单 -->
    <div class="col-md-7">
        <form action="{{ route('permissions.store') }}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label>名称</label>
                <input type="text" class="form-control" name="name" placeholder="name" value="{{old('name')}}" required="required">
            </div>
            <div class="form-group">
                <label>action</label>
                <select class="form-control" name="action">
                    <option value="GET">GET</option>
                    <option value="POST">POST</option>
                    <option value="PUT">PUT</option>
                    <option value="DELETE">DELETE</option>
                </select>
            </div>
            <div class="form-group">
                <label>uri</label>
                <input type="text" class="form-control" name="uri" placeholder="x/y/z" value="{{old('uri')}}" required="required">
            </div>

            <button type="submit" id="submit" class="btn btn-primary">新建</button>
        </form>
    </div>

@stop

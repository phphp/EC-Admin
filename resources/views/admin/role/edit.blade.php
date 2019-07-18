@extends('admin/main')


@section('title')编辑角色@stop


@section('content')

    <!-- 工具 -->
    <div class="container mb-1">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-white border-0">
                        <li class="breadcrumb-item"><a href="#">角色</a></li>
                        <li class="breadcrumb-item"><a href="#">列表</a></li>
                        <li class="breadcrumb-item active" aria-current="page">修改</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- 表单 -->
    <div class="col-md-7">
        <form action="{{ route('roles.update', ['id'=>$role->id]) }}" method="post">
            {{csrf_field()}}
            {{ method_field('PUT') }}

            <div class="form-group">
                <label>ID</label>
                <input type="text" class="form-control" value="{{ $role->id }}" disabled>
            </div>
            <div class="form-group">
                <label>名称</label>
                <input type="text" class="form-control" name="name" value="{{ $role->name }}" required="required">
            </div>

            <div class="form-group">
                <label>选择权限</label>
            </div>

            @foreach ($permissions as $permission)
            <div class="form-check form-group">
                <input class="form-check-input" name="permissions[]" type="checkbox"
                    value="{{ $permission->id }}" id="check{{ $permission->id }}"
                        <?php
                        if( in_array( $permission->id, array_column($role->permissions->toArray(), 'id')) )
                            echo 'checked';
                        ?>
                    >
                <label id="f-container" class="form-check-label" for="check{{ $permission->id }}">
                    <span class="">{{ $permission->name }}</span>
                    <span class="text-white bg-<?php
                        switch ($permission->action) {
                            case 'GET':
                                echo 'primary';
                                break;
                            case 'POST':
                                echo 'success';
                                break;
                            case 'PUT':
                                echo 'info';
                                break;
                            default:
                                echo 'dark';
                                break;
                        }
                        ?> pl-1 pr-1">{{ $permission->action }}</span>
                    <span class="">{{ $permission->uri }}</span>
                </label>
            </div>
            @endforeach



            <button type="submit" id="submit" class="btn btn-primary">修改</button>
        </form>
    </div>


@stop

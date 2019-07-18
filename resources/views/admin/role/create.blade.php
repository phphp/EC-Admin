@extends('admin/main')


@section('title')添加角色@stop


@section('content')

    <!-- 工具 -->
    <div class="container mb-1">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-white border-0">
                        <li class="breadcrumb-item"><a href="#">角色</a></li>
                        <li class="breadcrumb-item"><a href="#">列表</a></li>
                        <li class="breadcrumb-item active" aria-current="page">添加</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- 表单 -->
    <div class="col-md-7">
        <form action="{{ route('roles.store') }}" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label>名称</label>
                <input type="text" class="form-control" name="name" placeholder="name" value="{{old('name')}}" required="required">
            </div>

            <div class="form-group">
                <label>选择权限</label>
            </div>

            @foreach ($permissions as $permission)
            <div class="form-check form-group">
                <input class="form-check-input" name="permissions[]" type="checkbox"
                    value="{{ $permission->id }}" id="check{{ $permission->id }}">
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

            <button type="submit" id="submit" class="btn btn-primary">新建</button>
        </form>
    </div>

@stop

<nav class="col-md-2 d-none d-md-block bg-light" id="side-nav">

<a class="nav-link active" href="{{ route('dashboard') }}"><i class="iconfont icon-home"></i> 控制台</a>

<a class="nav-link" data-toggle="collapse" href="#nav-admin"><i class="iconfont icon-user-group-fill"></i> 管理员</a>
<div id="nav-admin" class="collapse <?php if ( isset($_COOKIE['collapse_checkbox']) && $_COOKIE['collapse_checkbox'] == 'true') echo 'show'; else echo 'in'; ?>">
    <a class="nav-link" href="{{ route('admins.index') }}"><i class="iconfont icon-cc-dot-o"></i> 列表</a>
    <a class="nav-link" href="{{ route('roles.index') }}"><i class="iconfont icon-cc-dot-o"></i> 角色</a>
    <a class="nav-link" href="{{ route('permissions.index') }}"><i class="iconfont icon-cc-dot-o"></i> 权限</a>
</div>

<a class="nav-link" data-toggle="collapse" href="#nav-image"><i class="iconfont icon-picture-fill"></i> 图片资源</a>
<div id="nav-image" class="collapse <?php if ( isset($_COOKIE['collapse_checkbox']) && $_COOKIE['collapse_checkbox'] == 'true') echo 'show'; else echo 'in'; ?>">
    <a class="nav-link" href="{{ route('image.index') }}"><i class="iconfont icon-cc-dot-o"></i> 所有图片</a>
    <a class="nav-link" href="{{ route('banner.index') }}"><i class="iconfont icon-cc-dot-o"></i> Banner 设定</a>
</div>

<a class="nav-link" href="{{ route('regions.index') }}"><i class="iconfont icon-map-fill"></i> 省市区</a>

<a class="nav-link" href="{{ route('setting.index') }}"><i class="iconfont icon-cog-fill"></i> 设置</a>

</nav>

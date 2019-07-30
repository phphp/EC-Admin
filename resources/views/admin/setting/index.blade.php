@extends('admin/main')


@section('title')设置@stop


@section('content')

    <h4>常用设置</h4>

    <div class="form-group col-md-5">
        <label>主题</label>
        <?php
            $themes = ['Default', 'Cerulean', 'Cosmo', 'Cyborg', 'Darkly', 'Flatly',
                'Journal', 'Litera', 'Lumen', 'Lux', 'Materia', 'Minty', 'Pulse',
                'Sandstone', 'Simplex', 'Sketchy', 'Slate', 'Solar', 'Spacelab',
                'Superhero', 'United', 'Yeti'];
            if (isset($_COOKIE['bs_theme']) && preg_match("/^[a-z]+$/", $_COOKIE['bs_theme'])) {
                $theme = $_COOKIE['bs_theme'];
            } else {
                $theme = 'default';
            }
        ?>
        <select id="theme" class="form-control" autocomplete="off">
            @foreach ($themes as $v)
                @if ( $theme == strtolower($v) )
                    <option value="{{ strtolower($v) }}" selected>{{$v}}</option>
                @else
                    <option value="{{ strtolower($v) }}">{{$v}}</option>
                @endif
            @endforeach

        </select>
        <small id="emailHelp" class="form-text text-muted">使用 Bootstarp 主题</small>
    </div>

@stop

@section('js')
<script>
    $('#theme').on('change', function() {
        var href = 'https://cdn.staticfile.org/bootswatch/4.3.1/'+
            this.value.toLowerCase()
            +'/bootstrap.min.css';
        $('#bs-theme').attr('href', href);

        // set or remove cookie
        var date = new Date();
        if (this.value == 'default') {
            date.setTime(date.getTime() - 1000*3600*24*365);
        } else {
            date.setTime(date.getTime() + 1000*3600*24*365);
        }
        var expires = "; expires=" + date.toUTCString();
        document.cookie = "bs_theme=" + this.value.toLowerCase() + expires + "; path=/";
    })
</script>

@stop

@extends('admin/main')


@section('title')设置@stop

@section('css')
<style>
/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
@stop

@section('content')

    <h4>常用设置</h4>

    <div class="form-group col-md-5 mt-2">
        <label class="mt-2">主题</label>
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

    <div class="form-group col-md-5 d-flex justify-content-between align-items-center">
        <label class="mt-2">默认侧栏手风琴打开状态</label>
        <label class="switch form-control border-0">
            <input type="checkbox" id="collapse-checkbox" <?php if ( isset($_COOKIE['collapse_checkbox']) && $_COOKIE['collapse_checkbox'] == 'true') echo 'checked' ?>>
            <span class="slider round"></span>
        </label>
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
    $('#collapse-checkbox').on('change', function() {
        // 打开 collapse
        if (this.checked)
            $('nav .collapse').removeClass('in').addClass('show');
        else
            $('nav .collapse').removeClass('show').addClass('in');

        // 设置 cookie
        document.cookie = "collapse_checkbox=" + this.checked;
    })
</script>

@stop

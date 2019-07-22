@extends('admin/main')


@section('title')省市区列表@stop


@section('content')
    <h4>联动</h4>

    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="inputProvince">省</label>
            <select id="inputProvince" class="form-control" autocomplete="off">
                @foreach ($provinces as $province)
                <option value="{{ $province->id }}">{{ $province->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="inputCity">市</label>
            <select id="inputCity" class="form-control">
                <option value="{{ $bj->id }}">{{ $bj->name }}</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="inputArea">区</label>
            <select id="inputArea" class="form-control">
                @foreach ($bj['children'] as $area)
                <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <p class="text-secondary">更新数据方法：composer update</p>
    <p class="text-secondary">数据来源：<a href="https://github.com/cblink/region">https://github.com/cblink/region</a></p>


@stop


@section('js')
<script>
    var regions;
    // 选择的省
    $('#inputProvince').on('change', function() {
        var provinceId = this.value;
        $('#inputCity').attr('disabled', 'true');
        $('#inputArea').attr('disabled', 'true');
        // 查询列表
        $.get('{{ route('regions.list') }}?id='+provinceId, function(res) {
            regions = res.data;
            // 如果是直辖市，省市相同
            if(res.data.children[0].children.length == 0) {
                // 市选项
                var option = document.createElement('option');
                option.value = res.data.id;
                option.innerHTML = res.data.name;
                $('#inputCity').html(option);
                // 区选项
                $('#inputArea').empty();
                res.data.children.forEach(v => {
                    var areaOption = document.createElement('option');
                    areaOption.value = v.id;
                    areaOption.innerHTML = v.name;
                    $('#inputArea').append(areaOption);
                });
            } else {
                // 市选项
                $('#inputCity').empty();
                res.data.children.forEach(v => {
                    var option = document.createElement('option');
                    option.value = v.id;
                    option.innerHTML = v.name;
                    $('#inputCity').append(option);
                });
                // 区选项
                $('#inputArea').empty();
                res.data.children[0].children.forEach(v => {
                    var areaOption = document.createElement('option');
                    areaOption.value = v.id;
                    areaOption.innerHTML = v.name;
                    $('#inputArea').append(areaOption);
                });

            }
            $('#inputCity').removeAttr('disabled');
            $('#inputArea').removeAttr('disabled');
        });
    });


    // 选择了市
    $('#inputCity').on('change', function() {
        regions.children.forEach(city => {
            if ( city.id == this.value ) {
                $('#inputArea').empty();
                city.children.forEach(area => {
                    var areaOption = document.createElement('option');
                    areaOption.value = area.id;
                    areaOption.innerHTML = area.name;
                    $('#inputArea').append(areaOption);
                })
            }
        });
    });
</script>
@stop

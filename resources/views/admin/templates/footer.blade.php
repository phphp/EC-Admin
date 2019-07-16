<?php
    if (config('app.debug')) {
        $query = \DB::getQueryLog();
    }
?>

<div class="footer" style="border-top:1px solid #CCC; text-align:center">
    <p></p>
    <p>SQL累计：<span style="color: #4e9a06">{{ count($query) }}</span> 次，
        页面消耗时间：<span style="color: #f57900">{{ round( microtime(true) - LARAVEL_START, 3) }}</span> s</p>
</div>

<div style="background-color:#D9E9C4;padding:15px">

    <ol>
    @foreach ($query as $v)
        <li>{{ $v['query'] }} 💥 <?php print_r($v['bindings']) ?> 🔥 {{ $v['time'] }}</li>
    @endforeach
    </ol>
</div>

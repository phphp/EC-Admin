<?php

/**
 * composer.json 的 autoload.files 自动加载了本文件。
 * 本文件自动载入 app/Helpers 下的所有 PHP 文件，达到自动加载帮助函数的目的。
 */

$files = array_filter(glob(__DIR__ . '/*.php'), function($v) {
    return false === strpos($v, 'include.php');
});

foreach ($files as $file) {
    require $file;
}

unset($file, $files);

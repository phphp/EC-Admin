<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 设置认证 blob 图片
        \Validator::extend('image_base64', function ($attribute, $value, $parameters, $validator) {
            try {
                // decode 文本并储存文件到临时目录，文件名为上传字段名
                file_put_contents(getTmpImagePath($attribute), base64_decode( preg_replace('#^data:image/\w+;base64,#i', '', $value) ));
                // 判断临时文件的类型
                if( exif_imagetype(getTmpImagePath($attribute)) != IMAGETYPE_JPEG )
                    throw new \Exception('错误的图片文件');

                return true;
            } catch (\Exception $e) {
                return false;
            }
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

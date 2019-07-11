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
                \App\Models\Avatar::makeTmpImage($value, $attribute);
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

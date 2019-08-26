<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'title', 'alt', 'internal', 'src', 'mime_type', 'extension',
        'width', 'height', 'filesize'
    ];

    /**
     * 外部链接直接返回，内部链接返回拼接域名后的地址
     */
    public function getSrcAttribute($value) {
        if ( 0 === $this->internal ) return $value;
        else return config('app.url') . '/' . $value;
    }

    public function banners() {
        return $this->belongsToMany('App\Models\Banner', 'banner_image', 'image_id', 'banner_id');
    }
}

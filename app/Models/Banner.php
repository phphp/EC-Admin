<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description'
    ];

    public function images() {
        return $this->belongsToMany('App\Models\Image', 'banner_image', 'banner_id', 'image_id')
                    ->withPivot('sort', 'item_type', 'item_id');
    }
}

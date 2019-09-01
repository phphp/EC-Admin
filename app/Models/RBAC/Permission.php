<?php

namespace App\Models\RBAC;

use App\Models\RBAC\Base;
use Illuminate\Database\Eloquent\Model;

class Permission extends Base
{
    protected $fillable = [
        'name', 'action', 'uri'
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Models\RBAC\Role');
    }
}
